<?php


namespace Devise\MotherShip;


use Carbon\Carbon;
use Devise\Models\DvsMigration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class Releases
{
    /**
     * @var Api
     */
    private $api;
    /**
     * @var DvsMigration
     */
    private $dvsMigration;

    /**
     * Releases constructor.
     * @param Api $api
     * @param DvsMigration $dvsMigration
     */
    public function __construct(Api $api, DvsMigration $dvsMigration)
    {
        $this->api = $api;
        $this->dvsMigration = $dvsMigration;
    }

    public function releaseIds()
    {
        return DvsRelease::where('model_name', 'Devise\MotherShip\DvsRelease')
            ->orderBy('created_at')
            ->select('model_id')
            ->pluck('model_id');
    }

    public function initWithMotherShip()
    {
        $config = config('database.connections.' . config('database.default'));

        $dump = shell_exec('mysqldump -u ' . $config['username'] . ' -p' . $config['password'] . ' ' . $config['database']);

        $file = time() . '.sql';

        File::put(storage_path() . '/' . $file, $dump);

        $migrationDate = $this->getCurrentMigrationDate();

        $response = $this->api->init($this->getCurrentCommitHash(), Auth::id() ?: 0, $migrationDate, storage_path() . '/' . $file);

        $newRelease = $this->saveRelease($response);

        unlink(storage_path() . '/' . $file);

        return $newRelease;
    }

    public function getForDeviseFlow()
    {
        $currentRelease = $this->getCurrentRelease();

        if (!$currentRelease) abort(403, 'Mothership releases has not been initiated');

        $rows = $this->getNewRows($currentRelease);

        $grouped = $rows->groupBy(function ($item, $key) {
            return class_basename($item->top_level_model) . '-' . $item->top_level_model->id;
        });

        $results = [];

        foreach ($grouped as $group)
        {
            $first = $group->first();
            $model = $first->top_level_model;
            $model->name = class_basename($model);
            $model->releases = $group;
            $results[] = $model;
        }

        return collect($results);
    }

    public function send($toBeReleased, $message)
    {
        $rows = $this->getAllById($toBeReleased);

        if ($rows->count())
        {
            $migrationDate = $this->getCurrentMigrationDate();

            DependenciesMap::newRelease();

            $rows->each(function ($item, $key) {
                $item->type = ($item->msh_id) ? 'update' : 'create';
                $item->modelRecord->prepRelease();
            });

            $data = [
                'commit'              => trim(shell_exec('git rev-parse --verify HEAD')),
                'environment'         => App::environment(),
                'rows'                => $rows,
                'last_migration_date' => $migrationDate,
                'message'             => $message,
                'user_id'             => Auth::id() ?: 0
            ];

            $responseData = $this->api->store($data);

            $release = $responseData->release;
            $rows = collect($responseData->rows);

            $this->saveRelease($release);

            foreach ($rows as $row)
            {
                $record = DvsRelease::find($row->id);

                $record->modelRecord->saveRelease = false;
                $record->modelRecord->id = $row->msh_id;
                $record->modelRecord->save();

                $record->timestamps = false;
                $record->model_id = $row->msh_id;
                $record->msh_id = $row->msh_id;
                $record->save();

            }
        }
    }

    public function pull($releaseId)
    {
        $releases = $this->api->get([$releaseId]);
        foreach ($releases as $release)
        {
            $this->saveRelease($release);

            DB::unprepared($release->query);
        }
    }

    public function getCurrentRelease()
    {
        return DvsRelease::where('model_name', 'Devise\MotherShip\DvsRelease')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function getByMotherShipId($id)
    {
        return DvsRelease::where('msh_id', $id)->first();
    }

    private function saveRelease($release)
    {
        $r = new DvsRelease();
        $r->model_id = $release->id;
        $r->model_name = 'Devise\MotherShip\DvsRelease';
        $r->msh_id = $release->id;
        $r->created_at = $release->created_at;
        $r->updated_at = $release->updated_at;
        $r->save();

        return $r;
    }

    private function getNewRows($currentRelease)
    {
        $currentReleaseDate = $currentRelease ? $currentRelease->created_at : '00-00-00 00:00:00';

        return DvsRelease
            ::with([
                'changes' => function ($query) use ($currentReleaseDate) {
                    $query->where('created_at', '>', $currentReleaseDate);
                }
            ])
            ->where(function ($query) use ($currentReleaseDate) {
                $query->where('msh_id', 0)
                    ->orWhere('updated_at', '>', $currentReleaseDate)
                    ->orWhere('deleted_at', '>', $currentReleaseDate);
            })
            ->where('model_name', '!=', 'Devise\MotherShip\DvsRelease')
            ->orderBy('created_at')
            ->get();
    }

    private function getAllById($ids)
    {
        $currentRelease = $this->getCurrentRelease();
        $currentReleaseDate = $currentRelease ? $currentRelease->created_at : '00-00-00 00:00:00';

        return DvsRelease::whereIn('id', $ids)
            ->where(function ($query) use ($currentReleaseDate) {
                $query->where('msh_id', 0)
                    ->orWhere('updated_at', '>', $currentReleaseDate)
                    ->orWhere('deleted_at', '>', $currentReleaseDate);
            })
            ->orderBy('updated_at')
            ->get();
    }

    private function getCurrentMigrationDate()
    {
        $newest = $this->dvsMigration
            ->orderBy('migration', 'desc')
            ->first();

        return $newest->date;
    }

    private function getCurrentCommitHash()
    {
        return trim(shell_exec('git rev-parse --verify HEAD'));
    }
}
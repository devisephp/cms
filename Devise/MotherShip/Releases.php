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

  public function initWithMotherShip()
  {
    $congif = config('database.connections.' . config('database.default'));

    $dump = shell_exec('mysqldump -u ' . $congif['username'] . ' -p' . $congif['password'] . ' ' . $congif['database']);

    $file = time() . '.sql';

    File::put(storage_path() . '/' . $file, $dump);

    $migrationDate = $this->getCurrentMigrationDate();

    $response = $this->api->init($this->getCurrentCommitHash(), Auth::id() ?: 0, $migrationDate, storage_path() . '/' . $file);

    $newRelease = new DvsRelease();
    $newRelease->model_id = $response->id;
    $newRelease->model_name = 'Release';
    $newRelease->msh_id = $response->id;
    $newRelease->created_at = $response->created_at;
    $newRelease->updated_at = $response->updated_at;
    $newRelease->save();

    unlink(storage_path() . '/' . $file);

    return $newRelease;
  }

  public function getForDeviseFlow()
  {
    $currentRelease = $this->getCurrentRelease();

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

      $lastRelease = $responseData->release;
      $rows = collect($responseData->rows);

      $newRelease = new DvsRelease();
      $newRelease->model_id = $lastRelease->id;
      $newRelease->model_name = 'Release';
      $newRelease->msh_id = $lastRelease->id;
      $newRelease->created_at = $lastRelease->created_at;
      $newRelease->updated_at = $lastRelease->updated_at;
      $newRelease->save();
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

  public function getCurrentRelease()
  {
    return DvsRelease::where('model_name', 'Release')
      ->orderBy('created_at', 'desc')
      ->first();
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
      ->orderBy('created_at')
      ->get();
  }

  private function getAllById($ids)
  {
    $currentRelease = $this->getCurrentRelease();
    $currentReleaseDate = $currentRelease ? $currentRelease->created_at : '00-00-00 00:00:00';
dd($currentReleaseDate);
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

  private function getNewestReleasedDate()
  {
    $newestOld = DvsRelease::with('model')
      ->where('model_name', '!=', 'Release')
      ->where('msh_id', '!=', 0)
      ->orderBy('created_at', 'desc')
      ->first();

    return $newestOld ? $newestOld->created_at : date('Y-m-d H:i:s', strtotime('now -1 year'));
  }

  private function getCurrentCommitHash()
  {
    return trim(shell_exec('git rev-parse --verify HEAD'));
  }
}
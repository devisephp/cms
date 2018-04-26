<?php


namespace Devise\MotherShip;


use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Releases
{
  /**
   * @var Api
   */
  private $api;
  /**
   * @var Migrations
   */
  private $migrations;

  /**
   * Releases constructor.
   */
  public function __construct(Api $api, Migrations $migrations)
  {
    $this->api = $api;
    $this->migrations = $migrations;
  }

  public function sendAndSync($toBeReleased)
  {
    $currentRelease = DvsRelease::where('model_name', 'Release')->orderBy('created_at', 'desc')->first();

    $rows = $this->getNewRows($currentRelease);

    if ($rows->count())
    {
      $migrations = $this->getPendingMigrations($rows);

      DependenciesMap::newRelease();

      $rows->each(function ($item, $key) {
        $item->type = ($item->msh_id) ? 'update' : 'create';
        $item->model->prepRelease();
      });

      $data = [
        'commit'      => trim(shell_exec('git rev-parse --verify HEAD')),
        'environment' => App::environment(),
        'rows'        => $rows,
        'release_ids' => $toBeReleased,
        'release'     => $currentRelease ? $currentRelease->msh_id : 0,
        'migrations'  => $migrations
      ];

      $responseData = $this->api->store($data);

      $releases = collect($responseData->releases);
      $rows = collect($responseData->rows);

      $releaseIds = $releases->pluck('id')->toArray();
      array_pop($releaseIds);

      dd($responseData);

      /**
       * !!!!!
       * !!!!!
       * !!!!!
       * We should no longer be going back to the api. the sql for each release should come in the server response
       * we need to step through each release run migrations and run through each query
       * !!!!!
       * !!!!!
       * !!!!!
       */
      if ($releaseIds)
      {
        $query = $this->api->store($releaseIds);
      }

      $lastRelease = $releases->last();

      $newRelease = new DvsRelease();
      $newRelease->model_id = $lastRelease->id;
      $newRelease->model_name = 'Release';
      $newRelease->msh_id = $lastRelease->id;
      $newRelease->created_at = $lastRelease->created_at;
      $newRelease->updated_at = $lastRelease->updated_at;
      $newRelease->save();

      shell_exec('git pull');
      shell_exec('git checkout ' . $lastRelease->commit_hash);

      DB::unprepared('UPDATE dvs_releases LEFT JOIN shirts on shirts.id = dvs_releases.model_id SET dvs_releases.model_id = dvs_releases.model_id + 100, shirts.id = shirts.id + 100 WHERE msh_id = 0 and dvs_releases.id NOT IN (' . $rows->pluck('id')->implode(',') . ');');

      foreach ($rows as $row)
      {
        $record = DvsRelease::with('model')
          ->find($row->id);

        $record->modelRecord->saveRelease = false;
        $record->modelRecord->id = $row->msh_id;
        $record->modelRecord->save();

        $record->timestamps = false;
        $record->model_id = $row->msh_id;
        $record->msh_id = $row->msh_id;
        $record->save();

      }

      if ($query)
      {
        $queries = explode("\n", $query);
        foreach ($queries as $query)
        {
          if ($query)
          {
            DB::unprepared($query);
          }
        }
      }

      echo $query;
    }
  }

  private function getNewRows($currentRelease)
  {
    $currentReleaseDate = $currentRelease ? $currentRelease->created_at : '00-00-00 00:00:00';

    return DvsRelease::with('model')
      ->where(function ($query) use ($currentReleaseDate) {
        $query->where('msh_id', 0)
          ->orWhere('updated_at', '>', $currentReleaseDate)
          ->orWhere('deleted_at', '>', $currentReleaseDate);
      })
      ->orderBy('created_at')
      ->get();
  }

  private function getPendingMigrations($newRows)
  {
    $startAtRelease = $this->getNewestReleasedDate();
    $endAtRelease = $newRows->orderBy('created_at', 'desc')->first();

    return $this->migrations
      ->getQueriesBetweenDates($startAtRelease->created_at, $endAtRelease->created_at);
  }

  private function getNewestReleasedDate()
  {
    $newestOld = DvsRelease::with('model')
      ->where('model_name', '!=', 'Release')
      ->where('msh_id', '!=', 0)
      ->orderBy('created_at', 'desc')
      ->first();

    return $newestOld ? $newestOld->created_at : date('Y-m-d', strtotime('now -1 year'));
  }
}
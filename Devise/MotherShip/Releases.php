<?php


namespace Devise\MotherShip;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class Releases
{
  public function sendAndSync($toBeReleased)
  {
    DependenciesMap::newRelease();

    $currentRelease = DvsRelease::where('model_name', 'Release')->orderBy('created_at', 'desc')->first();
    $currentReleaseId = $currentRelease ? $currentRelease->msh_id : 0;
    $currentReleaseDate = $currentRelease ? $currentRelease->created_at : '00-00-00 00:00:00';

    $rows = DvsRelease::with('model')
      ->where(function ($query) use ($currentReleaseDate) {
        $query->where('msh_id', 0)
          ->orWhere('updated_at', '>', $currentReleaseDate)
          ->orWhere('deleted_at', '>', $currentReleaseDate);
      })
      ->get();

    if ($rows->count())
    {
      $rows->each(function ($item, $key) {
        $item->type = ($item->msh_id) ? 'update' : 'create';
        $item->model->prepRelease();
      });

      $data = [
        'commit'          => trim(shell_exec('git rev-parse --verify HEAD')),
        'environment'     => App::environment(),
        'rows'            => $rows,
        'release_ids'     => $toBeReleased,
        'release'         => $currentReleaseId,
      ];

      try
      {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('POST', 'http://c01c2f0a.ngrok.io/api/v1/projects/4/releases', [
          'json' => $data,
        ]);

        $responseData = json_decode($response->getBody());
      } catch (\Exception $e)
      {
        $response = $e->getResponse();
        echo $response->getBody()->getContents();
        exit;
      }

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
        $releaseIds = implode(',', $releaseIds);

        try
        {
          $client = new \GuzzleHttp\Client();
          $response = $client->request('GET', 'http://c01c2f0a.ngrok.io/api/v1/projects/4/releases/' . $releaseIds);
          $query = $response->getBody();
        } catch (\GuzzleHttp\Exception\ClientException $e)
        {
          $response = $e->getResponse();
          echo $response->getBody()->getContents();
          exit;
        }
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

        $record->model->saveRelease = false;
        $record->model->id = $row->msh_id;
        $record->model->save();

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
}
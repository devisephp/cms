<?php

namespace Devise\MotherShip;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

use Illuminate\Support\Facades\App;

class Api
{
  private $mshUrl = 'https://mothership.app/';

  public function init($commitHash, $userId, $lastMigrationDate, $filePath)
  {
    try
    {
      $client = new Client();
      $response = $client->request('POST', $this->mshUrl . 'api/v1/releases/init', [
        'headers' => [
          'Authorization' => 'Bearer ' . config('devise.mothership.api-key')
        ],
        'multipart' => [
          [
            'name'     => 'commit_hash',
            'contents' => $commitHash
          ],
          [
            'name'     => 'user_id',
            'contents' => $userId
          ],
          [
            'name'     => 'last_migration_date',
            'contents' => $lastMigrationDate
          ],
          [
            'name'     => 'environment',
            'contents' => App::environment()
          ],
          [
            'name'     => 'dump',
            'contents' => fopen($filePath, 'r')
          ]
        ]
      ]);

      $responseData = json_decode($response->getBody());
    } catch (\Exception $e)
    {
      $response = $e->getResponse();
      echo $response->getBody()->getContents();
      exit;
    }

    return $responseData;
  }

  public function store($data)
  {
    try
    {
      $client = new Client();
      $response = $client->request('POST', $this->mshUrl . 'api/v1/releases', [
        'headers' => [
          'Authorization' => 'Bearer ' . config('devise.mothership.api-key')
        ],
        'json' => $data,
      ]);

      $responseData = json_decode($response->getBody());
    } catch (\Exception $e)
    {
      $response = $e->getResponse();
      echo $response->getBody()->getContents();
      exit;
    }

    return $responseData;
  }

  public function get($releaseIds)
  {
    $releaseIds = implode(',', $releaseIds);

    try
    {
      $client = new Client();
      $response = $client->request('GET', $this->mshUrl . 'api/v1/releases?ids=' . $releaseIds, [
        'headers' => [
          'Authorization' => 'Bearer ' . config('devise.mothership.api-key')
        ]
      ]);

      $responseData = json_decode($response->getBody());
    } catch (ClientException $e)
    {
      $response = $e->getResponse();
      echo $response->getBody()->getContents();
      exit;
    }

    return $responseData;
  }
}
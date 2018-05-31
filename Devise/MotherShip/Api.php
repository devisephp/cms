<?php

namespace Devise\MotherShip;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Api
{
  private $mshUrl = 'http://mothership.test/';

  public function init($commitHash, $filePath)
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
      $response = $client->request('POST', $this->mshUrl . 'api/v1/projects/4/releases', [
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
      $response = $client->request('GET', $this->mshUrl . 'api/v1/projects/4/releases/' . $releaseIds);
      $query = $response->getBody();
    } catch (ClientException $e)
    {
      $response = $e->getResponse();
      echo $response->getBody()->getContents();
      exit;
    }

    return $query;
  }
}
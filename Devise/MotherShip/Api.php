<?php

namespace Devise\MotherShip;

class Api
{
  public function store($data)
  {
    try
    {
      $client = new \GuzzleHttp\Client();
      $response = $client->request('POST', 'http://mothershipp.test/api/v1/projects/4/releases', [
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
      $client = new \GuzzleHttp\Client();
      $response = $client->request('GET', 'http://mothershipp.test/api/v1/projects/4/releases/' . $releaseIds);
      $query = $response->getBody();
    } catch (\GuzzleHttp\Exception\ClientException $e)
    {
      $response = $e->getResponse();
      echo $response->getBody()->getContents();
      exit;
    }

    return $query;
  }
}
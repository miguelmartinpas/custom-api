<?php

namespace CustomApi\Services;

use CustomApi\Services\BaseService as BaseService;
use GuzzleHttp\Client;

class Adapter extends BaseService {

  protected $url = "http://api.tvmaze.com/search/shows";
  public $client;
  public $result;

  public function __construct(){
    $this->client = new Client();
  }

  public function get() {
    $response = $this->client->request('GET', $this->url, [
        'query' => [
          'q' => 'deadpool'
        ]
    ]);

    return response()->json([
      'data' => json_decode($response->getBody()),
      'status' => $response->getStatusCode()
    ]);
  }
}
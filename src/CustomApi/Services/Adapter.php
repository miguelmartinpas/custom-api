<?php

namespace CustomApi\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class Adapter {

  protected $url = "http://api.tvmaze.com/search/shows";
  protected $client;

  public function __construct(){
    $this->client = new Client();
  }

  public function getResult($query) {

    $response = $this->searchValues($query);

    $parseResponse = $this->parseResponse($response->getBody(), $query);

    return $this->buildResponse(200, $parseResponse ? $parseResponse : ['error' => 'Search without results for "'.$query.'"']);

  }

  /** 
    * build aand run call to external service
    * 
    * @param string $query
    *
    * @return object response
    */
  protected function searchValues($query) {
    $response;
    try {
      $response = $this->client->request('GET', $this->url, [
        'query' => [
          'q' => $query
        ]
      ]);
    } catch (ClientException $e) {
      $response = null;
    }
    return $response;
  }

  /** 
    * parse result from response a return that we have in query parameter
    * 
    * @param string $query
    *
    * @return object response
    */
  protected function parseResponse($response, $query) {
    $newResponse = null;
    $data = json_decode($response);
    if (count($data)) {
      foreach($data as $show){
        if ($show->show->name === $query) {
          $newResponse = $show;
          break;
        }
      }
    } 

    return $newResponse;
  }

  /** 
    * Build the Response Object  
    * 
    * @param int   $code
    * @param mixed $content
    * @param array $header
    * 
    * @return \Symfony\Component\HttpFoundation\Response
    */
  protected function buildResponse($code = null, $content = null, $header = []) {
    return response()->json($content, $code, $header);
  }

}
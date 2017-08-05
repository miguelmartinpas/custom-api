<?php

namespace CustomApi\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;

class Adapter {

  protected $url = "http://api.tvmaze.com/search/shows";
  protected $client;
  protected $expiresAt = 30;

  public function __construct(){
    $this->client = new Client();
  }

  /** 
    * Main method of service
    * 
    * @param string $query
    *
    * @return object response
    */
  public function getResult($query) {

    $response = $this->searchValues($query);

    $parseResponse = $this->parseResponse($response, $query);

    return $this->buildResponse(200, $parseResponse ? $parseResponse : ['error' => 'Search without results for "'.$query.'"']);

  }

  /** 
    * Build and run call to external service
    * if query is storaged in Cache will return an array with only one element
    * 
    * @param string $query
    *
    * @return Array response
    */
  public function searchValues($query) {

    $response;
    
    try {
      if (Cache::has($query)) {
        $response = array(Cache::get($query));
      } else {
        $response = json_decode($this->client->get($this->url, [
            'query' => ['q' => $query]
          ])->getBody()
        );
      }
    } catch (ClientException $e) {
      $response = null;
    }
 
    return $response;
 
  }

  /** 
    * parse result from response a return that we have in query parameter
    * this method will storeage in cache all shows in the search for future access
    * 
    * @param string $query
    *
    * @return object response
    */
  public function parseResponse($json, $query) {

    $parsedJson = null;

    try {
      if (count($json)) {
        // if this method is called after read cached result json only have one element
        foreach($json as $show){
          if ($show->show->name === $query) {
            $parsedJson = $show;
            $parsedJson->cached = Cache::has($show->show->name);
          }
          if (!Cache::has($show->show->name)) {
            Cache::put($show->show->name, $show, $this->expiresAt);
          }
        }
      } 
    } catch (Exception $e) {
      $parsedJson = null;
    }

    return $parsedJson;
  
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
  public function buildResponse($code = null, $content = null, $header = []) {

    return response()->json($content, $code, $header);
  
  }

  /** 
    * Method to clear cache  
    * 
    */
  public function forceClearCache() {
    Cache::flush();
  }

}
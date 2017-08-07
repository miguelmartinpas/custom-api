<?php

namespace CustomApi\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ShowAdapter {

  protected $url = "http://api.tvmaze.com/search/shows";
  protected $client;
  protected $query;

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
  public function getResults($query) {

    $this->query = $query;

    $shows = $this->searchShows();

    $filteredShows = $this->filterShows($shows);

    $parsedShows = $this->parsedShows($filteredShows);

    return $this->buildResponse(200, json_decode($parsedShows->toJson()));

  }

  /** 
    * Build and run call to external service a process data in a collection
    * 
    * @param string $query
    *
    * @return Illuminate\Support\Collection $filteredShows
    */
  public function searchShows() {
    
    $shows = null;
    
    try {
      $shows = collect(json_decode($this->client->get($this->url, [
          'query' => ['q' => $this->query]
        ])->getBody()
      ));
    } catch (ClientException $e) {
      $shows = collect([]);
    }
 
    return $shows;

  }

  /** 
    * Filter shows where name contains query parameter value
    * 
    * @param Illuminate\Support\Collection $shows
    *
    * @return Illuminate\Support\Collection $filteredShows
    */
  public function filterShows($shows) {

    $filteredShows = null;

    try {
      $filteredShows = $shows->filter(function ($show) {
        return strstr($show->show->name, $this->query);
      });
    } catch (Exception $e) {
      $filteredShows = [];
    }

    return $filteredShows;
  
  }

  /** 
    * Parse shows to get a correct output for our API
    * 
    * @param Illuminate\Support\Collection $shows
    *
    * @return Illuminate\Support\Collection $parsedShows
    */
  public function parsedShows($shows) {

    $parsedShows = null;

    try {
      $parsedShows = $shows->map(function ($show) {
        return array(
          'name' => $show->show->name,
          'score' => $show->score
        );
      });
    } catch (Exception $e) {
      $parsedShows = [];
    }

    return $parsedShows;

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

}
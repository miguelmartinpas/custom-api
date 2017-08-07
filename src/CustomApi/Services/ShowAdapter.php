<?php

namespace CustomApi\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;

class ShowAdapter {

  protected $url = "http://api.tvmaze.com/search/shows";
  protected $client;
  protected $query;
  protected $expireAt = 30;
  protected $shows = null;

  public function __construct(){
    $this->client = new Client();
  }

  /** 
    * Main method will set query and return the current class
    * 
    * @param String $query
    *
    * @return CustomApi\Services\ShowAdapter
    */
  public function query($query) {
    $this->query = $query;
    return $this;
  }

  /** 
    * Main method of service. 
    * It should search and process results afterwards it will storage the parsed shows on Cache
    * Logic will be skipped if Cache has the query storaged
    *
    * @return CustomApi\Services\ShowAdapter
    */
  public function search() {

    if (Cache::has($this->query)){

      $this->shows = Cache::get($this->query);
    
    } else {

      $searchedShows = $this->searchShows();

      $filteredShows = $this->filterShows($searchedShows);

      $this->shows = $this->parsedShows($filteredShows);

      Cache::put($this->query, $this->shows, $this->expireAt);

    }

    return $this;

  }

  /** 
    * Return show collection
    * 
    * @return Illuminate\Support\Collection
    */
  public function shows() {
    return $this->shows ? $this->shows : collect([]);
  }

  /** 
    * Return a response object with the shows storaged
    * 
    * @return \Symfony\Component\HttpFoundation\Response
    */
  public function response() {
    return response()->json(json_decode($this->shows()->toJson()), Response::HTTP_OK);
  }

  /** 
    * Build and run call to external service a process data in a collection
    *
    * @return Illuminate\Support\Collection $filteredShows
    */
  protected function searchShows() {
    
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
  protected function filterShows($shows) {

    return $shows->filter(function ($show) {
      return strstr($show->show->name, $this->query);
    });
  
  }

  /** 
    * Parse shows to get a correct output for our API
    * 
    * @param Illuminate\Support\Collection $shows
    *
    * @return Illuminate\Support\Collection $parsedShows
    */
  protected function parsedShows($shows) {

    return $shows->map(function ($show) {
      return (object) array(
        'name' => $show->show->name,
        'score' => $show->score
      );
    });

  }

}
<?php

namespace CustomApi\Controllers;

use \Illuminate\Routing\Controller as BaseController;
use \Illuminate\Http\Request;

use \App;

class Adapter extends BaseController {

  protected $adapterService;

  /**
   * Create a new controller instance.
   *
   * @param  UserRepository  $users
   * @return void
   */
  public function __construct() {
      $this->adaterService = App::make('AdapterService');
  }

  /**
   * get method with serach result
   *
   * @param  Request $request
   * @return json response
   */
  public function get(Request $request) {
    return $this->adaterService->getResult($request->input('q'));
  }

}

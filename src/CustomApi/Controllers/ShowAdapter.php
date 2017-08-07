<?php

namespace CustomApi\Controllers;

use \Illuminate\Routing\Controller as BaseController;
use \Illuminate\Http\Request;

use \App;

class ShowAdapter extends BaseController {

  protected $showAdapterService;

  /**
   * Create a new controller instance.
   *
   * @param  UserRepository  $users
   * @return void
   */
  public function __construct() {
      $this->showAdapterService = App::make('ShowAdapterService');
  }

  /**
   * get method with serach result
   *
   * @param  Request $request
   * @return json response
   */
  public function get(Request $request) {
    return $this->showAdapterService->getResults($request->input('q'));
  }

}

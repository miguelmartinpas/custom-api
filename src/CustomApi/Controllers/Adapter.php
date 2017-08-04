<?php

namespace CustomApi\Controllers;

use \Illuminate\Routing\Controller as BaseController;

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

  public function get() {
    return $this->adaterService->get();
  }

}

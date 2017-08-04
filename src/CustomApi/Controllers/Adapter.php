<?php

namespace CustomApi\Controllers;

use \Illuminate\Routing\Controller as BaseController;

use \Illuminate\Http\Request;
use \App\Http\Requests;

class Adapter extends BaseController {

  public function get() {
    return response()->json([
    'message' => 'generate response from controller for custom JSON Api!',
    'code' => '01'
  ]);
  }

}

<?php

namespace CustomApi\Services;

use CustomApi\Services\BaseService as BaseService;

class Adapter extends BaseService {
  public function get() {
    return response()->json([
      'message' => 'response from service for custom JSON API!',
      'code' => '01'
    ]);
  }
}
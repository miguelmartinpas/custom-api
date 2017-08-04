<?php

namespace CustomApi\Middlewares;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CustomQuery {

  protected $app;

  public function __construct(Application $app) {
      $this->app = $app;
  }

  public function handle($request, Closure $next) {

    if ($request->input('q') === null) {
      return response('q attribute is mandatory', 400)->header('Content-Type', 'text/plain');
    }

    return $next($request);
  }
  
}

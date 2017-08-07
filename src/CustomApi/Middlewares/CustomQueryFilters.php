<?php

namespace CustomApi\Middlewares;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;

class CustomQueryFilters {

  /**
   * Handler to check if q params exists in GET. In other caso it will return 400
   *
   * @param  UserRepository  $users
   * @return void
   */
  public function handle($request, Closure $next) {

    if ($request->input('q') === null) {
      return response()->json(['errors' => 'q param is mandatory'], Response::HTTP_BAD_REQUEST);
    }

    return $next($request);
  }
  
}

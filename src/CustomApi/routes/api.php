<?php

use Illuminate\Http\Request;

Use CustomApi\Middlewares\CustomQuery as CustomQueryMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/resource', 'Adapter@get')->middleware(CustomQueryMiddleware::class);;

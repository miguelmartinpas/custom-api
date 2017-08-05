## Implementation of Custom API

### Structure

I used Laravel 5.4 with PHP 5.6

I have isolated my source from Laravel core in src folder. For that I have add a provider in config/app.php

```
//isolate source folder for my project
CustomApi\Providers\SrcServiceProvider::class,
CustomApi\Providers\RouteServiceProvider::class,
```

The purpose of this is that I want to isolate my source to improve the maintainability (we can move it to other Laravel project easily)

```
|--src
  |-- Controllers
  |-- Middlewares
  |-- Providers
  |-- routes
  |-- Services
tests
  |-- Feature
  |-- Unit
```

### Structure summary

- Providers: I have two; RouteProviders to create new routes and SrcProvider to inject services and middlewares

- routes: file with route for custom api

- Controllers: I have created a controller that is called from api.php and call to Adapter service

- Service: I have created Adapter service where you can find all the logic of custom api. This Service have 4 methods

  - getResult

    Main method that it will use the logic of the others methods.

  - searchValues

    This method should get data from external API. If query exists in cache store it won't call external api.

  - parseResponse

    This method will parse searched values to get the element that will be equals to query. This method should store all results show in an internal cache as well.

  - buildResponse

    Build respone json.

- Middleware: I have created a middlware to avoid call with q parameter. In summary check parameters before to apply logic. If parameters are not correct will return 400 HTTP error.

- test: I have used feature and app UT and I put config to generate coverage.


### Run App

You will need php 5.6 to run it (Laravel 5.4)

- 1.- upload this source with git clone https://github.com/miguelmartinpas/custom-api.git
- 2.- run composer update
- 3.- php artisan serve

You can access to custo-api with

```
localhost:8000/custom-api/resourse
```

You need q param to get results. Example of valid url:

```
localhost:8000/custom-api/resourse?q=Superman
```

To run UT yu should use 

```
./vendor/phpunit/phpunit/phpunit
```

The current output is:

```
PHPUnit 5.7.21 by Sebastian Bergmann and contributors.

..........                                                        10 / 10 (100%)

Time: 4.14 seconds, Memory: 21.00MB

OK (10 tests, 12 assertions)

Generating code coverage report in HTML format ... done
```

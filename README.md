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

- Controllers: I have created a controller that is called from api.php and call ShowAdapter service

- Service: I have created ShowAdapterService where you can find all the logic of custom api. This Service have: 

  - query
    Set query parameter and return the its class instance.
  
  - search
    Main method that it will use the logic of the others methods or used a Cache. it will return its class instance as well.
    
  - shows
    It will return a search collection.

  - response
    It will build a response json from a show collection 

  - searchShows

    This method should return a collection with data from external API.

  - filterShows

    This method will return collection with parsed shows that contains the query value.

  - parsedShows

    It will return a collection with the new format for each show

- Middleware: I have created a middlware to avoid call with q parameter. In summary check parameters before to apply logic. If parameters are not correct will return 400 HTTP error.

- test: I have used feature and app UT and I put config to generate coverage.


### Run App

You will need php 5.6 to run it (Laravel 5.4)

- 1.- upload this source with git clone https://github.com/miguelmartinpas/custom-api.git
- 2.- run composer update
- 3.- php artisan serve

You can access to custo-api with

```
localhost:8000/custom-api/search
```

You need q param to get results. Example of valid url:

```
localhost:8000/custom-api/search?q=Superman
```

To run UT yu should use 

```
./vendor/phpunit/phpunit/phpunit
```

The current output is:

```
> ./vendor/phpunit/phpunit/phpunit                                                               
PHPUnit 5.7.21 by Sebastian Bergmann and contributors.

............                                                      12 / 12 (100%)

Time: 5.63 seconds, Memory: 20.75MB

OK (12 tests, 18 assertions)

Generating code coverage report in HTML format ... done
```

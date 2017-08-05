<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](http://patreon.com/taylorotwell):

- **[Vehikl](http://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Styde](https://styde.net)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).


## Implementation of Custom API

### Structure

I have isolated my source in src folder. For that I have add a provider in config/app.php

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

<?php

namespace CustomApi\Providers;

use Illuminate\Support\ServiceProvider;

use CustomApi\Services\Adapter as AdapterService;
use CustomApi\Middlewares\CustomQuery as CustomQueryMiddleware;

class SrcServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

      // Middlewares
      $this->app->singleton('CustomQueryMiddleware', function($app){
        return new CustomQueryMiddleware($app);
      });

      // Services
      $this->app->singleton('AdapterService', function($app) {
        return new AdapterService();
      });

    }
}


<?php

namespace CustomApi\Providers;

use Illuminate\Support\ServiceProvider;

use CustomApi\Services\Adapter as AdapterService;
use CustomApi\Middlewares\CustomQueryFilters as CustomQueryFiltersMiddleware;

class SrcServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

      // Middlewares
      $this->app->singleton('CustomQueryFiltersMiddleware', function($app){
        return new CustomQueryFiltersMiddleware($app);
      });

      // Services
      $this->app->singleton('AdapterService', function($app) {
        return new AdapterService();
      });

    }
}


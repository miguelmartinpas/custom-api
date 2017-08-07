<?php

namespace CustomApi\Providers;

use Illuminate\Support\ServiceProvider;

use CustomApi\Services\ShowAdapter as ShowAdapterService;
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
      $this->app->singleton('ShowAdapterService', function($app) {
        return new ShowAdapterService();
      });

    }
}


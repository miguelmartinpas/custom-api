<?php

namespace CustomApi\Providers;

use Illuminate\Support\ServiceProvider;

use CustomApi\Services\Adapter as AdapterService;

class SrcServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {

      // Services
      $this->app->singleton('AdapterService', function($app) {
        return new AdapterService();
      });

    }
}


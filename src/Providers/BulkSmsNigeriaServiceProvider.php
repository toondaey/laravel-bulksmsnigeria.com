<?php

namespace Toonday\BulkSMSNigeria;

use Illuminate\Support\ServiceProvider;

class BulkSmsNigeriaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__."/../../config/bulksmsnigeria.php" => config_path("bulksmsnigeria.php"),
        ], "config");
    }

    public function register()
    {
        $this->app->singleton('bulksmsnigeria', function ($app) {
            return new BulkSMSNigeriaChannel;
        });
    }
}

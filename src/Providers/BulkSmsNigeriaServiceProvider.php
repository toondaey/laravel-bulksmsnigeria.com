<?php

namespace Toonday\BulkSMSNigeria;

use Illuminate\Support\ServiceProvider;

class BulkSmsNigeriaServiceProvider extends ServiceProvider
{
    protected $libConfigPath = __DIR__."/../../config";

    public function boot()
    {
        $this->publishes([
            "{$this->libConfigPath}/bulksmsnigeria.php" => config_path("bulksmsnigeria.php"),
        ], "config");
    }

    public function register()
    {
        $this->mergeConfigFrom("{$this->libConfigPath}/base_config.php", "bulksmsnigeria");

        $this->app->singleton('bulksmsnigeria', function ($app) {
            return new BulkSMSNigeriaChannel;
        });
    }
}

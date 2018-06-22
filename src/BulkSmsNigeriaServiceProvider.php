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

        $this->mergeConfigFrom("{$this->libConfigPath}/base_config.php", "bulksmsnigeria");
    }

    public function register()
    {
        $this->app->bind(BulkSMSNigeriaChannel::class, BulkSMSNigeriaChannel::class);

        $this->app->singleton('bulksmsnigeria', function ($app)
        {
            return new BulkSMSNigeriaChannel;
        });
    }
}

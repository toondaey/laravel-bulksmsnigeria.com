<?php

namespace Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected $configKey;

    protected function setUp()
    {
        if (! $this->app) {
            $this->refreshApplication();
        }

        parent::setUp();
    }

    protected function tearDown()
    {
        $this->config = null;
        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Toonday\BulkSMSNigeria\BulkSMSNigeriaServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $config = array_merge(
            require __DIR__.'/../config/bulksmsnigeria.php',
            require __DIR__.'/../config/base_config.php'
        );

        $app['config']->set('bulksmsnigeria', $config);
        $app["config"]->set('app.faker_locale', env('FAKER_LOCALE'));
        $app['config']->set('database.factory_dir', __DIR__."/../".env('FACTORY_PATH'));
    }
}

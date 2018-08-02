<?php

/**
 * @author 'Tunde <aromire.tunde@gmail.com>
 *
 * This file is part of the bulk sms nigeria laravel notification
 * library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Toonday\BulkSMSNigeria;

use Illuminate\Support\ServiceProvider;
use Toonday\BulkSMSNigeria\BulkSMSNigeriaChannel;

/**
 * Service provider.
 *
 * @property string $libConfigPath
 * @method void boot()
 * @method void register()
 */
class BulkSMSNigeriaServiceProvider extends ServiceProvider
{
    /**
     * Path to library config directory.
     * @var string
     */
    protected $libConfigPath = __DIR__.'/../config';

    public function boot()
    {
        $this->publishes([
            "{$this->libConfigPath}/bulksmsnigeria.php" => config_path('bulksmsnigeria.php'),
        ], 'config');

        $this->mergeConfigFrom("{$this->libConfigPath}/base_config.php", 'bulksmsnigeria');

        $this->app->when(BulkSMSNigeriaChannel::class)
             ->needs('$config')
             ->give($this->app["config"]->get('bulksmsnigeria'));
    }

    /**
     * Register method.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

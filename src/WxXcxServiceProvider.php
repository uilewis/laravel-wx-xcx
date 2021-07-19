<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 2017/3/3
 */

namespace UiLewis\WxXcx;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class WxXcxServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if ($this->app->runningInConsole()) {
            if ($this->app instanceof LumenApplication) {
                $this->app->configure('xcx_wx');
            } else {
                $this->publishes([
                    $this->getConfigFile() => config_path('xcx_wx.php'),
                ], 'config');
            }
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getConfigFile(), 'xcx_wx');
        //
        $this->app->bind('xcx_wx', function () {
            return new WxXcx($this->app['config']['xcx_wx']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xcx_wx'];
    }

    /**
     * @return string
     */
    protected function getConfigFile()
    {
        $file = base_path() . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'xcx_wx.php';
        if (file_exists($file)) {
            return $file;
        }
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'xcx_wx.php';
    }

}

<?php

namespace Modules\Goods\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class GoodsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../Resources/views/backend', 'goods');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'goods'
        );
    }
}

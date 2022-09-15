<?php

namespace GhaniniaIR\Interactive;

use Illuminate\Support\ServiceProvider;
use GhaniniaIR\Interactive\Utilies\Cache\Drivers\FileDriver;
use GhaniniaIR\Interactive\Utilies\Cache\Drivers\RedisDriver;
use GhaniniaIR\Interactive\Utilies\Cache\Interfaces\CacheDriverInterface;

class InteractiveServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/configs/interactive.php',
            'interactive'
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishes([
            __DIR__ . '/configs/interactive.php' => config_path('interactive.php'),
        ]);

        /** cache driver facade */
        $this->app->bind(CacheDriverInterface::class , function (){
            return new FileDriver() ;
        });

        $this->app->bind(CacheDriverInterface::class , function (){
            return new RedisDriver() ;
        });

    }
}

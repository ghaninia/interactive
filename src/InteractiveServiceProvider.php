<?php

namespace GhaniniaIR\Interactive;

use Illuminate\Support\ServiceProvider;

use GhaniniaIR\Interactive\Utilies\Cache\Drivers\{
    FileDriver ,
    RedisDriver
};

class InteractiveServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/Utilies/configs/interactive.php',
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
            __DIR__ . '/Utilies/configs/interactive.php' => config_path('interactive.php'),
        ]);

        /** cache driver facade */
        $this->app->bind(FileDriver::driverName() , function (){
            return new FileDriver() ;
        });

        $this->app->bind(RedisDriver::driverName() , function (){
            return new RedisDriver() ;
        });

    }
}

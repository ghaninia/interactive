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

        /**  load routes */
        $this->loadRoutesFrom(__DIR__ . "/Http/routes.php");
        /**  load views */
        $this->loadViewsFrom(__DIR__.'/Gui/resources/views', 'interactive');

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

        $this->publishes([
            __DIR__.'/Gui/resources/views' => resource_path('views/vendor/interactive'),
        ]);

        $this->publishes([
            __DIR__.'/Gui/asset' => public_path('vendor/interactive'),
        ], 'public');

        /** cache driver facade */
        $this->app->bind(FileDriver::driverName() , function (){
            return new FileDriver() ;
        });

        $this->app->bind(RedisDriver::driverName() , function (){
            return new RedisDriver() ;
        });

    }
}

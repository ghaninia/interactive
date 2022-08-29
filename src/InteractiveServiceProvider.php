<?php

namespace GhaniniaIR\Interactive;

use Illuminate\Support\ServiceProvider;

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
        
    }
}

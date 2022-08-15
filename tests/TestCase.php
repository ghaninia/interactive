<?php

namespace GhaniniaIR\Tests ;

use GhaniniaIR\Interactive\InteractiveServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            InteractiveServiceProvider::class,
        ];
    }
}
<?php

namespace GhaniniaIR\Interactive\Utilies\Cache;


class Cache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return config("cache.default", "interactive");
    }
}

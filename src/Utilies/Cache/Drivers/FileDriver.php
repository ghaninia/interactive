<?php

namespace GhaniniaIR\Interactive\Utilies\Cache\Drivers;

use Exception;
use GhaniniaIR\Interactive\Utilies\Cache\Interfaces\CacheDriverInterface;

class FileDriver implements CacheDriverInterface
{

    /**
     * get file path info
     * @param string $path
     * @return \stdClass
     */
    private function info(string $path)
    {
        $information = new \stdClass() ;
        $information->filectime = filectime($path) ;
        $information->filemtime = filemtime($path) ;
        $information->basename  = basename($path) ;
        $information->mime  = mime_content_type($path) ;

        return $information;
    }

    /**
     * get cache directory path
     * @return string
     */
    protected function sysBaseDir(): string
    {
        return config("interactive.driver.file.cache_dir", storage_path("interactive"));
    }

    /**
     * get cache directory path
     * @return string
     */
    protected function sysPrefix(): string
    {
        return config("interactive.driver.file.prefix", "txt") ;
    }

    /**
     * get ttl expire at
     * @return int
     */
    protected function sysTTL(){
        $ttl = config("interactive.cache.drivers.file.ttl", 3600) ;
        return (new \DateTime("+ {$ttl} seconds"))->getTimestamp();
    }
}

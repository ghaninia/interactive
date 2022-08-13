<?php

namespace GhaniniaIR\Interactive\Utilies\Cache\Drivers;

use Exception;
use GhaniniaIR\Interactive\Utilies\Cache\Interfaces\CacheDriverInterface;

class FileDriver implements CacheDriverInterface
{

    /**
     * @param string $key
     * @return false|string
     */
    public function get(string $key)
    {
        $file = $this->has($key);
        return $file ? file_get_contents($file) : false ;
    }

    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function set(string $key, string $value): bool
    {

//        file_put_contents( ,$value) ;
    }

    public function generatePath(string $key)
    {
        $file = $this->has($key) ;

    }

    /**
     * Delete files that have expired
     *
     * @return int
     */
    public function forgetExpired(): int
    {
        $path[] = $this->getBaseDir() ;
        $path[] = "*" ;
        $counter = 0 ;

        $files = implode( DIRECTORY_SEPARATOR , $path);

        foreach ( glob($files , GLOB_BRACE) as $file) {
            if($this->isExpired($file)){
                unlink($file) ;
                $counter++ ;
            }
        }

        return $counter ;
    }

    /**
     * search cache file path by key name
     * @param string $name
     * @return false|string
     */
    protected function has(string $name)
    {
        $path[] = $this->getBaseDir();
        $path[] = $name;
        $path[] = '*';
        $path = implode(DIRECTORY_SEPARATOR, $path);

        $files = glob($path, GLOB_BRACE);
        return count($files) ? $files[0] : false ;
    }

    /**
     * get cache directory path
     * @return string
     */
    protected function getBaseDir(): string
    {
        return config("interactive.driver.file.cache_dir", storage_path("interactive"));
    }

    /**
     * get cache directory path
     * @return string
     */
    protected function getPrefix(): string
    {
        return config("interactive.driver.file.prefix", "txt") ;
    }

    /**
     * get ttl expire at
     * @return int
     */
    protected function getTTL(){
        $ttl = config("interactive.cache.drivers.file.ttl", 3600) ;
        return (new \DateTime("+ {$ttl} seconds"))->getTimestamp();
    }

    /**
     * get path describe
     * @param string $path
     * @return \stdClass
     */
    protected function getDetail(string $path)
    {
        $basePath = basename( $path , $prefix = $this->getPrefix()) ;
        $basePath = explode("_" , $basePath) ;

        $stdClass = new \stdClass() ;
        $stdClass->path = $path ;
        $stdClass->prefix = $prefix ;
        $stdClass->name = $basePath[0] ;
        $stdClass->ttl = $basePath[1] ?? 0 ;

        return $stdClass ;
    }

    /**
     * Do it expire path
     * @param string $path
     * @return bool
     */
    protected function isExpired(string $path):bool
    {
        $detial = $this->getDetail($path) ;
        return $detial->ttl < time() ;
    }

}

<?php

namespace GhaniniaIR\Interactive\Utilies\Cache\Drivers;

use GhaniniaIR\Interactive\Utilies\Cache\Interfaces\CacheDriverInterface;

class FileDriver implements CacheDriverInterface
{

    /**
     * get file content
     * @param string $key
     * @return false|string
     */
    public function get(string $key)
    {
        $result = $this->search($key) ;
        return $result ? file_get_contents($result) : false;
    }

    public function set(string $key, string $value)
    {
        // TODO: Implement set() method.
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key)
    {
        $result = $this->search($key) ;
        return $result && unlink($result);
    }

    /**
     * clear cache history
     * @return bool
     */
    public function clear()
    {
        return rmdir($this->configCacheDir()) &&
            mkdir($this->configCacheDir()) ;
    }

    /**
     * search key through files in storage
     * @param string $key
     * @return false|string
     */
    public function search(string $key)
    {
        $path[] = $this->configCacheDir() ;
        $path[] = sprintf("%s.%s" , $key , $this->configExtension()) ;
        $path   = implode(DIRECTORY_SEPARATOR , $path) ;

        if (file_exists($path)){
            return $this->isExpired($path) ? false : $path;
        }

        return false;
    }

    /**
     * get file path info
     * @param string $path
     * @return \stdClass
     */
    protected function info(string $path)
    {
        $information = new \stdClass() ;
        $information->filectime  = filectime($path) ;
        $information->expiretime = filectime($path) + $this->configTTL() ;
        $information->filemtime  = filemtime($path) ;
        $information->basename   = basename($path) ;
        $information->mime       = mime_content_type($path) ;

        return $information;
    }

    /**
     * append sub
     * @return int
     */
    protected function isExpired(string $path)
    {
        return $this->info($path)->expiretime < (new \DateTime)->getTimestamp() ;
    }

    /**
     * get cache directory path
     * @return string
     */
    protected function configCacheDir()
    {
        return config("interactive.driver.file.cache_dir", storage_path("interactive"));
    }

    /**
     * get cache directory path
     * @return string
     */
    protected function configExtension()
    {
        return config("interactive.driver.file.extension", "txt") ;
    }

    /**
     * get ttl expire at
     * @return int
     */
    protected function configTTL()
    {
        return config("interactive.cache.drivers.file.ttl", 3600) ;
    }
}

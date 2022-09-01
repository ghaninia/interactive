<?php

namespace GhaniniaIR\Interactive\Utilies\Cache\Drivers;

use GhaniniaIR\Interactive\Utilies\Cache\Interfaces\CacheDriverInterface;
use Illuminate\Support\Facades\Redis;

class RedisDriver implements CacheDriverInterface
{
    /**
     * Get the value related to the specified key
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return $this->getConnection()->get($key) ;
    }

    /**
     * Set the string value in argument as value of the key
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function set(string $key, string $value)
    {
        return $this->getConnection()->set($key , $value , $this->configTTL()) ;
    }

    /**
     * Remove specified keys
     * @param string $key
     * @return bool
     */
    public function delete(string $key)
    {
        return (bool) $this->getConnection()->del($key) ;
    }

    /**
     * Remove all keys from all databases
     * @return bool
     */
    public function clear()
    {
        return $this->getConnection()->flushAll() ;
    }

    /**
     * get connection name
     * @return string
     */
    protected function connectionName()
    {
        return config("interactive.driver.redis.connection_name" , "interactive") ;
    }

    /**
     * get ttl expire at
     * @return int
     */
    protected function configTTL()
    {
        return config("interactive.driver.redis.ttl", 3600);
    }

    /**
     * get connection instance
     * @return \Illuminate\Redis\Connections\Connection
     */
    protected function getConnection()
    {
        return Redis::connection($this->connectionName()) ;
    }
}

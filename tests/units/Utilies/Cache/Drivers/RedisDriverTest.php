<?php

namespace GhaniniaIR\Tests\Units\Utilies\Cache\Drivers;

use GhaniniaIR\Tests\TestCase;
use Illuminate\Support\Facades\Redis;
use GhaniniaIR\Interactive\Utilies\Cache\Drivers\RedisDriver;
use GhaniniaIR\Tests\Units\Utilies\Cache\Drivers\Traits\RedisCacheTrait;

class RedisDriverTest extends TestCase
{
    use RedisCacheTrait ;
    /** @test */
    public function getConnectionName()
    {
        config()->set("interactive.driver.redis.connection_name" , $connectionName = "test") ;

        $this->assertSame(
            $this->redisDriver->connectionName() ,
            $connectionName
        );

    }

    /** @test */
    public function getConfigTTL()
    {
        config()->set("interactive.driver.redis.ttl" , $ttl = 5600 );
        $this->assertSame(
            $this->redisDriver->configTTL() ,
            $ttl
        );
    }

    /** @test */
    public function checkConnection()
    {
        $result = $this->redisDriver->getConnection() ;

        $this->assertInstanceOf(
            \Illuminate\Redis\Connections\Connection::class ,
            $result ,
        );

        $this->assertSame(
            $result->getName() ,
            $this->connectionName
        );
    }

    /** @test */
    public function getRedisCacheWhenNotExists()
    {
        $result = $this->redisDriver->get( $this->testKey ) ;
        $this->assertNull($result);
    }

    /** @test */
    public function getRedisCacheWhenExists()
    {
        Redis::connection($this->connectionName)->set($this->testKey , $value = "value");
        $result = $this->redisDriver->get($this->testKey) ;
        $this->assertEquals($result , $value);
    }

    /** @test */
    public function setValueRedisCache()
    {
        $result = $this->redisDriver->set($this->testKey , $value = "test") ;
        $this->assertTrue($result);

        $result = Redis::connection($this->connectionName)->ttl($this->testKey) ;
        $this->assertEquals($result , -1 );
    }

    /** @test */
    public function deleteKeyRedisCache()
    {
        $result = $this->redisDriver->set($this->testKey , $value = "test") ;
        $result = $this->redisDriver->delete($this->testKey) ;

        $this->assertTrue($result) ;
    }
}
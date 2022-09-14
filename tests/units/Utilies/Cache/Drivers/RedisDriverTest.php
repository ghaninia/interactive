<?php

namespace GhaniniaIR\Tests\Units\Utilies\Cache\Drivers;

use GhaniniaIR\Interactive\Utilies\Cache\Drivers\RedisDriver;
use GhaniniaIR\Tests\TestCase;
use Illuminate\Support\Facades\Redis;

class RedisDriverTest extends TestCase
{
    protected $redisDriver ;
    protected string $connectionName , $testKey ;

    protected function setUp(): void
    {
        parent::setUp();

        $this->redisDriver = new class extends RedisDriver {

            public function getConnection()
            {
                return parent::getConnection();
            }

            public function configTTL()
            {
                return parent::configTTL();
            }

            public function connectionName()
            {
                return parent::connectionName();
            }

        };

        /** test key */
        $this->testKey = "test" ;

        /**  config vars */
        $this->connectionName = "interactive" ;
        $this->connectionOption = [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', 6379),
            'database' => env('REDIS_DB', 0),
        ];

        /** config connections */
        config()->set("database.redis." . $this->connectionName , $this->connectionOption) ;
        config()->set("interactive.cache.drivers.redis.connection_name" , $this->connectionName) ;
    }


    protected function tearDown(): void
    {
        Redis::connection($this->connectionName)->del($this->testKey);
        parent::tearDown(); // TODO: Change the autogenerated stub
    }

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
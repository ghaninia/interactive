<?php

namespace GhaniniaIR\Tests\units\Utilies\Cache\Drivers;

use GhaniniaIR\Interactive\Utilies\Cache\Drivers\RedisDriver;
use GhaniniaIR\Tests\TestCase;

class RedisDriverTest extends TestCase
{
    protected $redisDriver ;

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
}
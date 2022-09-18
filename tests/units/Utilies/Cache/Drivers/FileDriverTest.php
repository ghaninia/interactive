<?php

namespace GhaniniaIR\Tests\Units\Utilies\Cache\Drivers;

use GhaniniaIR\Tests\TestCase;
use GhaniniaIR\Interactive\Utilies\Cache\Drivers\FileDriver;
use GhaniniaIR\Tests\Units\Utilies\Cache\Drivers\Traits\FileCacheTrait;

class FileDriverTest extends TestCase
{
    use FileCacheTrait ;

    /** @test */
    public function getFileInformation()
    {
        config()->set("interactive.cache.drivers.file.ttl", 250);
        $this->assertEquals($this->fileDriver->configTTL(), 250);
    }

    /** @test */
    public function getConfigExtension()
    {
        config()->set("interactive.driver.file.extension", "pdf");
        $this->assertEquals($this->fileDriver->configExtension(), "pdf");
    }

    /** @test */
    public function getConfigCacheDir()
    {
        config()->set("interactive.driver.file.cache_dir", "/");
        $this->assertEquals($this->fileDriver->configCacheDir(), "/");
    }

    /** @test */
    public function getFileInfo()
    {
        $result = $this->fileDriver->info($this->fileTempPath);

        $this->assertObjectHasAttribute("filectime", $result);
        $this->assertObjectHasAttribute("expiretime", $result);
        $this->assertObjectHasAttribute("filemtime", $result);

        $this->assertSame($result->basename , $this->fileName . ".txt" );
        $this->assertSame($result->mime, "text/plain");
    }

    /** @test */
    public function ifFileExpired()
    {
        config()->set("interactive.cache.drivers.file.ttl", -10 );
        $result = $this->fileDriver->isExpired($this->fileTempPath);
        $this->assertTrue($result);
    }

    /** @test */
    public function checkFoundFile()
    {
        config()->set("interactive.driver.file.cache_dir", $this->fileTempBasePath);

        $result = $this->fileDriver->search($this->fileName);

        $this->assertEquals($result, $this->fileTempPath);
    }

    /** @test */
    public function checkNotFoundedFile()
    {
        config()->set("interactive.driver.file.cache_dir", $this->fileTempBasePath);

        $result = $this->fileDriver->search("ASgasgasgwqtqwtq");

        $this->assertEquals($result, false);
    }

    /** @test */
    public function getCache()
    {
        $result = $this->fileDriver->get($this->fileName);
        $this->assertEquals($result, "test");
    }

    /** @test */
    public function putCache()
    {
        $result = $this->fileDriver->set($this->fileName , $contents = "test2" ) ;
        $this->assertEquals($result , $contents) ;
    }
}

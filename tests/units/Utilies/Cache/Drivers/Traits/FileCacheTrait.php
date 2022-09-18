<?php

namespace GhaniniaIR\Tests\Units\Utilies\Cache\Drivers\Traits;


use GhaniniaIR\Interactive\Utilies\Cache\Drivers\FileDriver;

trait FileCacheTrait {

    protected $fileName;
    protected $fileDriver;
    protected $fileTempPath;

    protected function setUp(): void
    {

        parent::setUp();
        
        $this->fileDriver = new class extends FileDriver
        {

            public function configTTL()
            {
                return parent::configTTL();
            }

            public function configExtension()
            {
                return parent::configExtension();
            }

            public function configCacheDir()
            {
                return parent::configCacheDir();
            }

            public function info(string $path)
            {
                return parent::info($path);
            }

            public function isExpired(string $path)
            {
                return parent::isExpired($path);
            }
        };

        $this->fileName = uniqid("FILE__");
        $this->fileTempBasePath = str_replace("/" , DIRECTORY_SEPARATOR , __DIR__ . "/stubs/cache");
        $this->fileTempPath = str_replace("/" , DIRECTORY_SEPARATOR , $this->fileTempBasePath . "/" . $this->fileName . ".txt" );

        ### config setting 
        config()->set("interactive.driver.file.cache_dir", $this->fileTempBasePath);
        config()->set("interactive.cache.drivers.file.ttl", 50);

        ### create temp folder and file
        if (!file_exists($this->fileTempBasePath)){
            mkdir($this->fileTempBasePath  , 0777 , true );
        }

        file_put_contents($this->fileTempPath, "test");

    }

    protected function tearDown(): void
    {
        unlink($this->fileTempPath);
    }
    
}
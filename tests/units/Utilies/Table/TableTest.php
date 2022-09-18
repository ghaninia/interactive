<?php

namespace GhaniniaIR\Tests\Units\Utilies\Parser;

use GhaniniaIR\Tests\TestCase;
use GhaniniaIR\Interactive\Utilies\Command\Table;
use GhaniniaIR\Tests\Units\Utilies\Cache\Drivers\Traits\FileCacheTrait;

class TableTest extends TestCase 
{
    use FileCacheTrait ;

    /** @test */
    public function result ()
    {
        $result = (new Table)->setSentence('$name = "hello world";')->setCacheKey("hello")->result();
    
        // $this->assertEquals($result , "hello world") ;
    
    }

}
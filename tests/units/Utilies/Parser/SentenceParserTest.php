<?php

namespace GhaniniaIR\Tests\Units\Utilies\Parser;

use ReflectionProperty;
use GhaniniaIR\Tests\TestCase;
use GhaniniaIR\Interactive\Utilies\Command\Row;
use GhaniniaIR\Interactive\Utilies\Parser\SentenceParser;
use GhaniniaIR\Interactive\Utilies\Parser\Exceptions\InvalidSentenceException;

class SentenceParserTest extends TestCase
{

    /** @test */
    public function input()
    {
        $property = new ReflectionProperty(SentenceParser::class, "sentence");
        $property->setAccessible(true);

        $sentenceParser = new SentenceParser($text = "hello world!");

        $this->assertSame(
            $text,
            $property->getValue($sentenceParser)
        );
    }

    /** @test */
    public function hasDeclareElement()
    {

        $this->assertTrue(
            (new SentenceParser('$to = "ghaninia" ; $from = "amin";'))->hasDeclareElement()
        );

        $this->assertTrue(
            (new SentenceParser('$name++'))->hasDeclareElement()
        );

        $this->assertTrue(
            (new SentenceParser('$name--'))->hasDeclareElement()
        );

        $this->assertTrue(
            (new SentenceParser('$name ++ '))->hasDeclareElement()
        );

        $this->assertFalse(
            (new SentenceParser('echo $name'))->hasDeclareElement()
        );

        $this->assertFalse(
            (new SentenceParser('echo $name'))->hasDeclareElement()
        );

        $this->assertFalse(
            (new SentenceParser('var_dump($name)'))->hasDeclareElement()
        );

        $this->assertTrue(
            (new SentenceParser('print_r($key = "value")'))->hasDeclareElement()
        );

    }

    /** @test */
    public function hasInvalidElement()
    {
        $this->assertTrue(
            (new SentenceParser('if(true){ echo "hello" ;}'))->hasInvalidElement()
        );

        $this->assertTrue(
            (new SentenceParser('$name = "amin" ; echo $name; '))->hasInvalidElement()
        );

        $this->assertTrue(
            (new SentenceParser('$name = "amin" ; echo $name; '))->hasInvalidElement()
        );
        
        $this->assertTrue(
            (new SentenceParser('$name = "amin" ; echo $name; '))->hasInvalidElement()
        );
        
        $this->assertTrue(
            (new SentenceParser('$name = "amin" ; echo $name; '))->hasInvalidElement()
        );

        $this->assertFalse(
            (new SentenceParser('$name = fn($value) => strtolower($value) '))->hasInvalidElement()
        );

    }


    /** @test */
    public function effectiveVars()
    {
        $result = (new SentenceParser( '$name = "hello world" ; echo $name ' ) )->effectiveVars( new Row ) ;
        $this->assertSame( $result[0] , '$name' ) ;
        
        $result = (new SentenceParser( '$name = "hello world" ; echo $sound ' ) )->effectiveVars( new Row ) ;
        $this->assertSame( $result[0] , '$name' ) ;
        $this->assertSame( $result[1] , '$sound' ) ;

        $result = (new SentenceParser( '$name = "hello world" ; echo $sound ' ) )->effectiveVars( new Row ) ;
        $this->assertSame( $result[0] , '$name' ) ;
        $this->assertSame( $result[1] , '$sound' ) ;
    }

    /** @test */
    public function failedMakedRow()
    {
        $this->expectException(InvalidSentenceException::class) ;
        (new SentenceParser('if(true){ echo "hello" ;}'))->makeRow( new Row ) ;
    }

    /** @test */
    public function makeRow()
    {

        $response = (new SentenceParser('$user = "hello world"'))->makeRow( new Row ) ;
        $this->assertEquals( 3 , $response->countColumn() ) ; 
        $this->assertIsArray( $response->getColumns() ) ;
        
    }

}

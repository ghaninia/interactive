<?php

namespace GhaniniaIR\Tests\Units\Utilies\Parser;

use ReflectionProperty;
use GhaniniaIR\Tests\TestCase;
use GhaniniaIR\Interactive\Utilies\Parser\SentenceParser;

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
            (new SentenceParser('$name = "hello world";'))->hasDeclareElement()
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

        $this->assertFalse(
            (new SentenceParser('$name = fn($value) => strtolower($value) '))->hasInvalidElement()
        );

    }

}

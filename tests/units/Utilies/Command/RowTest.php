<?php

namespace GhaniniaIR\Tests\Units\Utilies\Command;

use Mockery;
use ReflectionProperty;
use GhaniniaIR\Tests\TestCase;
use GhaniniaIR\Interactive\Utilies\Command\Row;
use GhaniniaIR\Interactive\Utilies\Command\Columns\Contracts\ColumnContract;

class RowTest extends TestCase
{

    protected $mockColumnContract;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockColumnContract = Mockery::mock(ColumnContract::class);
    }

    /** @test */
    public function addColumnTest()
    {
        $row = (new Row)->addColumn(
            $item = $this->mockColumnContract, true
        );

        $reflection = new ReflectionProperty(Row::class, "columns");
        $reflection->setAccessible(true);
        $result = $reflection->getValue($row);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame($item, $result[0]);
    }

    /** @test */
    public function countColumnTest()
    {
        $row = (new Row)->addColumn(
            $this->mockColumnContract, true
        );
        
        $this->assertSame(1 , $row->countColumn()) ;

        $row->addColumn(
            $this->mockColumnContract, true
        );

        $this->assertSame(2 , $row->countColumn()) ;
    }

}

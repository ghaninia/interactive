<?php

namespace GhaniniaIR\Interactive\Utilies\Command;

use GhaniniaIR\Interactive\Utilies\Command\Interfaces\RowInterface;
use GhaniniaIR\Interactive\Utilies\Command\Columns\Contracts\ColumnContract;

class Row implements RowInterface
{
    private array $columns;

    /**
     * @param ColumnContract $column
     * @return $this
     */
    public function addColumn(ColumnContract $column ){
        $this->columns[] = $column ;
        return $this;
    }

    /**
     * @return int
     */
    public function countColumn(){
        return count($this->columns) ;
    }

}
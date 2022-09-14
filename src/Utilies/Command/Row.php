<?php

namespace GhaniniaIR\Interactive\Utilies\Command;

use GhaniniaIR\Interactive\Utilies\Command\Columns\Contracts\ColumnContract;

final class Row
{
    private array $columns;

    /**
     * @param ColumnContract $column
     * @param \Closure|bool $condition
     * @return $this
     */
    public function addColumn(ColumnContract $column , \Closure|bool $condition = false ){

        $result = is_bool($condition) ? $condition : $condition();

        if ($result) {
            $this->columns[] = $column ;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function countColumn(){
        return count($this->columns) ;
    }

}
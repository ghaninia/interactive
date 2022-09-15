<?php

namespace GhaniniaIR\Interactive\Utilies\Command\Interfaces;

use GhaniniaIR\Interactive\Utilies\Command\Columns\Contracts\ColumnContract;

interface RowInterface
{
    public function addColumn(ColumnContract $column ) ;
    public function countColumn() ;
    public function getColumns() ;
}

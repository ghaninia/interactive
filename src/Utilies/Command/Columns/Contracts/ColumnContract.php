<?php

namespace GhaniniaIR\Interactive\Utilies\Command\Columns\Contracts;

abstract class ColumnContract
{
    protected mixed $value;

    /**
     * @param mixed $value
     */
    public function __construct(mixed $value){
        $this->value = $value;
    }

    /**
     * get value
     * @return mixed
     */
    public function getValue()
    {
        return $this->value ;
    }
}
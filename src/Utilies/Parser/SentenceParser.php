<?php

namespace GhaniniaIR\Interactive\Utilies\Parser;

class SentenceParser
{

    private string $sentence ;
    private array $ignores = [
        "{" ,
        "}" ,
    ];
    private array $declares = [
        "=",
        "++",
        "--"
    ];

    /**
     * get sentence
     * @param string $sentence
     * @return $this
     */
    public function input(string $sentence)
    {
        $this->sentence = $sentence ;

        return $this;
    }

    /**
     * senetence has declare element
     * @return bool
     */
    public function hasDeclareElement()
    {
        foreach ($this->declares as $element) {
            if (str_contains($this->sentence , $element)) {
                return true ;
            }
        }

        return false ;
    }

    /**
     * senetence has invalid element
     * @return bool
     */
    public function hasInvalidElement()
    {
        foreach ($this->ignores as $element) {
            if (str_contains($this->sentence , $element)) {
                return true ;
            }
        }

        return false ;
    }

}
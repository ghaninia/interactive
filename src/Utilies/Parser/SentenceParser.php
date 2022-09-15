<?php

namespace GhaniniaIR\Interactive\Utilies\Parser;

use GhaniniaIR\Interactive\Utilies\Command\Columns\VarsColumn;
use GhaniniaIR\Interactive\Utilies\Command\Columns\SentenceColumn;
use GhaniniaIR\Interactive\Utilies\Command\Columns\IsDeclareColumn;
use GhaniniaIR\Interactive\Utilies\Command\Interfaces\RowInterface;
use GhaniniaIR\Interactive\Utilies\Parser\Exceptions\InvalidSentenceException;

class SentenceParser
{

    /**
     * regular expression var
     * @var string 
     */
    private const VAR_REGEX = '/\$[A-z0-9_]{1,}/' ;

    /**
     * ignored these character in sentence 
     *
     * @var array
     */
    private array $ignores = [
        "{" ,
        "}" ,
    ];

    /**
     * regex supported these sentences : 
     ** $name =  
     ** $name ++ 
     ** $name -- 
     ** $name= 
     * @var array
     */
    private array $declareRegex = [
        '/\$[A-z0-9_]{1,}+[ ]{0,}(?:=|--|\++)/',
    ];

    /**
     * @param string $sentence
     */
    public function __construct(
        protected string $sentence
    ){}

    /**
     * senetence has declare element
     * @return bool
     */
    public function hasDeclareElement()
    {
        foreach ($this->declareRegex as $regex) {
            if(preg_match_all($regex , $this->sentence , $matches )) {
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
        
        foreach ($this->ignores as $character) {
            if (str_contains($this->sentence , $character)) {
                return true ;
            }
        }

        return false ;
    }

    /**
     * get effective vars in sentence 
     * @return array
     */
    public function effectiveVars()
    {

        $variables = [] ;

        if ( preg_match_all(SELF::VAR_REGEX , $this->sentence , $variables ) ){
            $variables = $variables[0] ;
        }

        return array_unique($variables) ;
    }

    /**
     * inital options Row factory 
     * @param RowInterface $row
     * @throws InvalidSentenceException
     * @return RowInterface
     */
    public function makeRow(RowInterface $row)
    {
        
        if($this->hasInvalidElement()) {
            throw new InvalidSentenceException() ;
        }

        $hasDeclareElement = $this->hasDeclareElement() ; 
        $effectiveVars = $this->effectiveVars() ;

        return $row
            ->addColumn( new SentenceColumn($this->sentence) )
            ->addColumn( new IsDeclareColumn($hasDeclareElement) )
            ->addColumn( new VarsColumn($effectiveVars) ) ;
        
    }
}
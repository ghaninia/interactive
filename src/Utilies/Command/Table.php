<?php

namespace GhaniniaIR\Interactive\Utilies\Command;

use Throwable;
use GhaniniaIR\Interactive\Utilies\Cache\Cache;
use GhaniniaIR\Interactive\Utilies\Command\Row;
use GhaniniaIR\Interactive\Utilies\Parser\SentenceParser;
use GhaniniaIR\Interactive\Utilies\Command\Columns\VarsColumn;
use GhaniniaIR\Interactive\Utilies\Command\Columns\SentenceColumn;
use GhaniniaIR\Interactive\Utilies\Command\Contracts\TableContract;
use GhaniniaIR\Interactive\Utilies\Command\Interfaces\RowInterface;

class Table extends TableContract
{ 
    
    private string $cacheKey ;
    private string $sentence ;
    
    /**
     * set cache key 
     *
     * @param string $cacheKey
     * @return self
     */
    public function setCacheKey(string $cacheKey): self
    {
        $this->cacheKey = $cacheKey ;
        return $this ;
    }

    /**
     * get cache key 
     *
     * @return string
     */
    public function getCacheKey(): string
    {
        return $this->cacheKey ;
    }

    /**
     * set query sentence 
     *
     * @param string $sentence
     * @return self
     */
    public function setSentence(string $sentence): self
    {
        $this->sentence = $sentence ;
        return $this ;
    }

    /**
     * get query sentence
     *
     * @return string
     */
    public function getSentence(): string
    {
        return $this->sentence ;
    }

    /**
     * get oldest rows on table 
     *
     * @return array|false 
     */
    protected function oldestRows()  
    {
        $result = Cache::get( $this->cacheKey );
        return $result ? unserialize($result) : false ;
    }

    /**
     * create new Row
     *
     * @return RowInterface
     */
    protected function newRow() : RowInterface
    {
        $result = new SentenceParser( $this->sentence ) ;
        return $result->makeRow(new Row) ;
    }

    /**
     * merge oldest and new 
     *
     * @param array|false $latestRows
     * @param RowInterface $newRow
     * @return array
     */
    protected function mergeRows( array|false $latestRows , RowInterface $newRow) : array 
    {
        $rows = $latestRows ? $latestRows : [] ;
        $rows[] = $newRow ;
        return $rows ;
    }

    /**
     * store multiple rows 
     *
     * @param array $rows
     * @return boolean
     */
    protected function storeRows(array $rows)
    {
        return Cache::set( $this->cacheKey , serialize($rows) );
    }

    /**
     * get results 
     *
     * @return void
     */
    public function result()
    {
        try {

            $newRow = $this->newRow() ;
            $varsColumns = $newRow->getColumn(VarsColumn::class)?->getValue() ;

            $this->oldestRows() ;
            
            $oldestRows = match( true ) {
                !empty($varsColumns) => $this->oldestRows() ,            
                default => false  ,
            };

            $oldestRows = $oldestRows ? $oldestRows : [] ;


            ## get output 

            $rows = $this->mergeRows($oldestRows , $newRow);

            foreach($rows as $row) {
                $sentence = $row->getColumn(SentenceColumn::class)?->getValue() ;

                eval ( $sentence ) ;
            }


            foreach($varsColumns as $variable) {

                $trimVariable = ltrim($variable , "$") ;
                $vars[] = $$trimVariable ;

            }

            return $vars ?? [] ; 

        } catch ( Throwable  $error ) {
            return $error ;
        }

    }   
}


<?php

namespace GhaniniaIR\Interactive\Utilies\Cache\Interfaces;

interface CacheDriverInterface
{

    public static function driverName(): string ;
    public function get(string $key);
    public function set(string $key, string $value);
    public function delete(string $path);
    public function clear();
}

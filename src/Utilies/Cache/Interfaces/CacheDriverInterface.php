<?php

namespace GhaniniaIR\Interactive\Utilies\Cache\Interfaces;

interface CacheDriverInterface
{
    public function get(string $key);
    public function set(string $key, string $value): bool;
    public function delete(string $path);
    public function clear();
}
<?php

namespace GhaniniaIR\Interactive\Utilies\Parser\Exceptions;

use Exception;
use Throwable;

class InvalidSentenceException extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        $this->message = $message ?? "In the sentence used invalid characters!";
        $this->code = $code ?? 422;
    }
}

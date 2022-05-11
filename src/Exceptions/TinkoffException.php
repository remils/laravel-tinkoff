<?php

namespace Remils\LaravelTinkoff\Exceptions;

use Exception;

class TinkoffException extends Exception
{
    public function __construct(string $message, int $code = 0)
    {
        parent::__construct(trans($message), $code);
    }
}

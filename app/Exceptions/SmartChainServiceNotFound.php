<?php

namespace App\Exceptions;

use Exception;

class SmartChainServiceNotFound extends Exception
{
    public function __construct($message = 'Smart chain not found', $code = 422, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

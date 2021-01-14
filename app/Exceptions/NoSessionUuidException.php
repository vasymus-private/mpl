<?php

namespace App\Exceptions;

use LogicException;
use Throwable;

class NoSessionUuidException extends LogicException
{
    public function __construct($message = "No session uuid provided.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}

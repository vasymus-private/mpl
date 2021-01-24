<?php

namespace App\Exceptions;

use LogicException;
use Throwable;

class SessionUuidNotProvidedException extends LogicException
{
    public function __construct($message = "Session uuid not provided.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

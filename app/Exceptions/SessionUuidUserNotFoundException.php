<?php

namespace App\Exceptions;

use LogicException;

class SessionUuidUserNotFoundException extends LogicException
{
    public function __construct($message = "Session uuid user not found.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

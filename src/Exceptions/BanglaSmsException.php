<?php

namespace Smkbd\BanglaSms\Exceptions;

use Throwable;

class BanglaSmsException extends \Exception
{
    public function __construct(string $message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}

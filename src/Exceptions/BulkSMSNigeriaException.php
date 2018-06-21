<?php

namespace Toonday\BulkSMSNigeria\Exceptions;

use Exception;

class BulkSMSNigeriaException extends Exception
{
    public function __construct($message, $code = 500)
    {
        parent::__construct($message, $code);
    }
}

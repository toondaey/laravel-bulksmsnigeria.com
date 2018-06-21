<?php

namespace Toonday\BulkSMSNigeria;

use Illuminate\Support\Facades\Config;

class BulkSMSMessage
{
    protected $from;

    protected $message;

    public function __construct($message = "")
    {
        $this->messaege = $message;
    }

    public function message($message)
    {
        $this->message = $message;

        return $this;
    }

    public function from($from)
    {
        $this->from = $from;

        return $this;
    }
}

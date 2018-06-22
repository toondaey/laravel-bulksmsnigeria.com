<?php

/**
 * @author 'Tunde <aromire.tunde@gmail.com>
 *
 * This file is part of the bulk sms nigeria laravel notification
 * library.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Toonday\BulkSMSNigeria\Exceptions;

use Exception;

/**
 * Exception class.
 */
class BulkSMSNigeriaException extends Exception
{
    /**
     * Simple constructor for exception.
     *
     * @param string  $message Error message.
     * @param int $code    Error code.
     */
    public function __construct($message, $code = 500)
    {
        parent::__construct($message, $code);
    }
}

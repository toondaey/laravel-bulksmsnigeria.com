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
namespace Toonday\BulkSMSNigeria;

use Illuminate\Support\Facades\Config;

/**
 * Generates a message instance for the Toonday\BulkSMSNigeria\BulkSMSNigeriaChannel
 * @property string $from
 * @property string $body
 * @property string $type
 *
 * @method void __constructor(string $body)
 * @method Toonday\BulkSMSNigeria\BulkSMSMessage body(string $body)
 * @method Toonday\BulkSMSNigeria\BulkSMSMessage from(string $from)
 * @method Toonday\BulkSMSNigeria\BulkSMSMessage type(string $type)
 */
class BulkSMSMessage
{
    /**
     * The sender of the text
     * @var string
     */
    public $from;

    /**
     * Body content of the message.
     * @var string
     */
    public $body;

    /**
     * Type of notificaiton.
     * @var string
     */
    public $type = 'sms';

    /**
     * DND option. Defaults to 2.
     * @var integer
     */
    public $dnd = 2;

    public function __construct($body = '')
    {
        $this->body = $body;
    }

    /**
     * Sets the body of the message.
     *
     * @param  string $body
     * @return Toonday\BulkSMSNigeria\BulkSMSMessag
     */
    public function body($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Sets the message sender (Limited to 11 characters).
     *
     * @param  string $from
     * @return Toonday\BulkSMSNigeria\BulkSMSMessage
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Sets the type of notification.
     *
     * @param  string $type
     * @return Toonday\BulkSMSNigeria\BulkSMSMessage
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the dnd option.
     *
     * @param  int $option
     * @return Toonday\BulkSMSNigeria\BulkSMSMessage
     */
    public function dnd($option)
    {
        $this->dnd = $option;

        return $this;
    }

}

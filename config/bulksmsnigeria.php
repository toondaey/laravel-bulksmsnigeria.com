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
return [
    /**
     * This would be the sender of the message.
     * @ The Sender ID is a maximum of 11 Characters.
     */
    "from" => env("BULKSMSNIGERIA_FROM", "BULKSMSNIGERIA"),

    /**
     * This would be the API token generated from the dashboard.
     *
     * @see https://www.bulksmsnigeria.com/app/api-settings
     */
    "api_token" => env("BULKSMSNIGERIA_FROM", "token_from_dashboard"),
];

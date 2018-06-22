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
     * Base URI for the bulk sms nigeria api.
     */
    "base_uri" => "https://www.bulksmsnigeria.com",

    /**
     * Header for api transaction
     */
    "headers" => [
        "Content-Type" => "application/json",
        "Accept"       => "application/json",
    ],

    /**
     * Available API endpoints.
     */
    "endpoints" => [
        "send" => [
            "sms" => "/api/v1/sms/create"
        ],
    ],

    /**
     * The types of API transactions that can be handled.
     */
    "types" => [
        "sms" => "SMS"
    ],
];

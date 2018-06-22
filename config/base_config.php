<?php

return [
    "base_uri" => "https://www.bulksmsnigeria.com",
    "headers" => [
        "Content-Type" => "application/json",
        "Accept"       => "application/json",
    ],
    "endpoints" => [
        "send" => [
            "sms" => "/api/v1/sms/create"
        ],
    ],
    "types" => [
        "sms" => "SMS"
    ],
];

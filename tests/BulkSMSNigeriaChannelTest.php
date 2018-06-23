<?php

namespace Tests;

use GuzzleHttp\Client;
use Toonday\BulkSMSNigeria\BulkSMSNigeriaChannel;

class BulkSMSNigeriaChannelTest extends TestCase
{

    /**
     * @test
     * @return Toonday\BulkSMSNigeria\BulkSMSNigeriaChannel
     */
    function it_initializes()
    {
        $channel = app()->make(BulkSMSNigeriaChannel::class);

        $reflector = new Concerns\Reflector($channel);

        $this->assertInstanceOf(BulkSMSNigeriaChannel::class, $channel);
        $this->assertInstanceOf(Client::class, $reflector->fetchProperty("client")->value);
    }
}

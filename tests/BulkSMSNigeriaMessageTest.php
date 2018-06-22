<?php

namespace Tests;

use Toonday\BulkSMSNigeria\BulkSMSMessage;

class BulkSMSNigeriaMessageTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideBulkSMSMessageData
     * @return Toonday\BulkSMSNigeria\BulkSMSMessage
     */
    function it_initializes($method, $value)
    {
        if ( $method !== "init" ) {
            $bulksmsnigeriaMessage = (new BulkSMSMessage)->{$method}($value);

            $this->assertEquals($value, $bulksmsnigeriaMessage->{$method});
        } else if ($method === "init") {
            $bulksmsnigeriaMessage = new BulkSMSMessage($value);

            $this->assertEquals($value, $bulksmsnigeriaMessage->body);
        }
    }

    /**
     * Provides data for the above.
     * @return [type] [description]
     */
    function provideBulkSMSMessageData()
    {
        return [
            ["init", "Test message."],
            ["body", "Another test message."],
            ["from", "Testing"],
            ["type", "call"]
        ];
    }
}

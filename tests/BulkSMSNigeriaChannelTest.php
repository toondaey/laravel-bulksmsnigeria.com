<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\StubClass\Models\User;
use GuzzleHttp\Handler\MockHandler;
use Toonday\BulkSMSNigeria\BulkSMSMessage;
use Illuminate\Support\Facades\Notification;
use Toonday\BulkSMSNigeria\BulkSMSNigeriaChannel;
use Illuminate\Notifications\AnonymousNotifiable;
use Tests\StubClass\Notifications\TestNotification;
use Illuminate\Support\Facades\Notification as FacadeNotification;

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
        $this->assertInstanceOf(Client::class, $reflector->fetchProperty('client')->value);

        return $reflector;
    }

    /**
     * @test
     * @depends it_initializes
     * @param  Concerns\Reflector $reflector
     * @return void
     */
    function it_sets_from(Concerns\Reflector $reflector)
    {
        $from = $reflector->invokeMethod('from', [new BulkSMSMessage('Test message')]);

        $this->assertEquals(app('config')->get('bulksmsnigeria.from'), $from);
    }

    /**
     * @test
     * @depends it_initializes
     * @expectedException Toonday\BulkSMSNigeria\Exceptions\BulkSMSNigeriaException
     * @param  Concerns\Reflector $reflector
     * @return void
     */
    function it_parses_messaages(Concerns\Reflector $reflector)
    {
        $message1 = $reflector->invokeMethod('parseMessage', ['String message']);
        $message2 = $reflector->invokeMethod('parseMessage',[new BulkSMSMessage('Another string message')]);
        $reflector->invokeMethod('parseMessage', [1]);

        array_walk([$message1, $message2], function ($message){
            $this->assertInstanceOf(BulkSMSMessage::class, $message);
        });
    }

    /**
     * @test
     * @depends it_initializes
     * @param  Concerns\Reflector $reflector
     * @expectedException Toonday\BulkSMSNigeria\Exceptions\BulkSMSNigeriaException
     * @return void
     */
    function it_gets_to(Concerns\Reflector $reflector)
    {
        $user = new User;
        $phone_no = $user->phone_no;
        $to1 = $reflector->invokeMethod('getTo', [$user]);
        $user->phone_no = null;
        $to2 = $reflector->invokeMethod('getTo', [$user]);
        dd($to2);

        $this->assertEquals($to1, $phone_no);
    }

    /**
     * @test
     * @depends it_initializes
     * @param  Concerns\Reflector $reflector
     * @return void
     */
    function it_sends_sms(Concerns\Reflector $reflector)
    {
        $reflector->setProperty('client', $this->mockedClient());

        $response = $reflector->invokeMethod(
            'sendSMS',
            ['2348012345678', (new BulkSMSMessage('testing'))]
        );

        $this->assertInstanceOf(Response::class, $response);
    }

    /**
     * @test
     * @depends it_initializes
     * @param  Concerns\Reflector $reflector
     * @return void
     */
    function it_sends_with_send_method(Concerns\Reflector $reflector)
    {
        $reflector->setProperty('client', $this->mockedClient());

        $reflector->invokeMethod('send', [new User, new TestNotification('1234')]);

        $this->assertTrue(true);
    }

    /**
     * @test
     * @param  Concerns\Reflector $reflector
     * @return void
     */
    public function send_notification_to_notifiable_model()
    {
        Notification::fake();

        $user = new User;
        Notification::send($user, new TestNotification('1234'));

        Notification::assertSentTo([$user], TestNotification::class);
    }

    /**
     * Mocked GuzzleHttp\Client.
     * @return GuzzleHttp\Client
     */
    function mockedClient()
    {
        $response = new Response(
            200,
            ['X-Foo' => 'bar'],
            json_encode([
                'data' => ['status' => 'success','message' => 'Message Sent'],
                ['0' => 200],
            ])
        );

        $mock = new MockHandler([$response]);

        $handler = HandlerStack::create($mock);

        return new Client(['handler' => $handler]);
    }
}

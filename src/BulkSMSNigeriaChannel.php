<?php

namespace Toonday\BulkSMSNigeria;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;

class BulkSMSNigeriaChannel
{
    protected $baseUri = "https://www.bulksmsnigeria.com";

    protected $headers = array(
        "Content-Type" => "application/json",
        "Accept"       => "application/json",
    );

    public $endpoints = [
        "send" => "/api/v1/sms/create"
    ];

    protected $client;

    protected $username;

    protected $password;

    protected $to;

    public function __construct()
    {
        $this->config = Config::get("bulksmsnigeria");

        $this->client = new Client([
            "base_uri" => $this->baseUri,
            "headers"  => $this->headers,
        ]);
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $to = $this->getTo($notifiable, $notification);

        $message = $this->parseMessage( $notification->toBulkSMSNigeria($notifiable) );

        $this->sendSMS($to, $message);
    }

    protected function sendSMS($to, $message)
    {
        $from = $this->from($message);

        $query = "?api_token={$this->config["api_token"]}&from={$from}&to={$to}&body={$message->body}";

        $response = $this->client->get($this->endpoints["send"].$query);

        info((string) $response->getBody());
    }

    protected function getTo($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('bulkSMSNigeria', $notification)) {
            return;
        }

        return $to;
    }

    protected function parseMessage($message)
    {
        if (is_string($message)) {
            return new BulkSMSMessage($message);
        } else if ($message instanceof BulkSMSMessage) {
            return $message;
        }

        throw new BulkSMSNigeriaException("Invalid message format.");
    }

    protected function from($message)
    {
        return $message->from ? $message->from : $this->config["from"];
    }
}

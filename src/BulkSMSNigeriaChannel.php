<?php

namespace Toonday\BulkSMSNigeria;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Toonday\BulkSMSNigeria\Exception\BulkSMSNigeriaException;

class BulkSMSNigeriaChannel
{
    protected $client;

    protected $username;

    protected $password;

    protected $to;

    public function __construct()
    {
        $this->config = Config::get("bulksmsnigeria");

        $this->prepareClient();
    }

    protected function prepareClient()
    {
        $this->client = new Client([
            "base_uri" => $this->config["base_uri"],
            "headers"  => $this->config["headers"],
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

        // if (array_key_exists($message->type, $this->config["types"])){
            $this->{"send".strtoupper($message->type)}($to, $message);
        // } else {
            // throw new BulkSMSNigeriaException("Message type does not exist");
        // }
    }

    protected function sendSMS($to, $message)
    {
        $from = $this->from($message);

        $query = "?api_token={$this->config["api_token"]}&from={$from}&to={$to}&body={$message->body}";

        $response = $this->client->get($this->config["endpoints"]["send"][$message->type].$query);
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

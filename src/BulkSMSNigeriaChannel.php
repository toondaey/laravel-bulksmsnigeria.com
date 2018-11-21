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

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Toonday\BulkSMSNigeria\Exceptions\BulkSMSNigeriaException;

/**
 * The notificaiton channel.
 * @property GuzzleHttp\Client $client
 * @property string $to
 * @property array $config
 *
 * @method void __constructor()
 * @method void prepareClient()
 * @method void send($notifiable, Illuminate\Notifications\Notification $notification)
 * @method Psr7\Response sendSMS(string $to, Toonday\BulkSMSNigeria\BulkSMSMessage $message)
 * @method void getTo($notifiable, Illuminate\Notifications\Notification $notification)
 * @method Toonday\BulkSMSNigeria\BulkSMSMessage parseMessage(string|Toonday\BulkSMSNigeria\BulkSMSMessage $message)
 * @method string from(Toonday\BulkSMSNigeria\BulkSMSMessage $message)
 *
 */
class BulkSMSNigeriaChannel
{
    /**
     * Placeholder for GuzzleHttp\Client.
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * Placeholder for the receiver(s);
     * @var string
     */
    protected $to;

    /**
     * Placeholder for the configurations
     * @var array
     */
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;

        $this->prepareClient();
    }

    /**
     * Prepare GuzzleHttp\Client with base parameters.
     * @return void
     */
    protected function prepareClient()
    {
        $this->client = new Client([
            'base_uri' => $this->config['base_uri'],
            'headers'  => $this->config['headers'],
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

        if (array_key_exists($message->type, $this->config['types'])){
            $this->{'send'.strtoupper($message->type)}($to, $message);
        } else {
            throw new BulkSMSNigeriaException('Message type does not exist');
        }
    }

    /**
     * Send SMS message.
     *
     * @param  string $to
     * @param  Toonday\BulkSMSNigeria\BulkSMSMessage $message
     * @return Psr7\Response
     */
    protected function sendSMS($to, $message)
    {
        $from = $this->from($message);

        return $this->client->get(
            "{$this->config['endpoints']['send'][$message->type]}?",
            [
                'query' => [
                    'api_token' => $this->config['api_token'],
                    'from'      => $from,
                    'to'        => $to,
                    'body'      => $message->body,
                    'dnd'       => $message->dnd,
                ]
            ]
        );
    }

    /**
     * Fetch the receiver(s) of the message.
     *
     * @param  mixed       $notifiable
     * @param  Illuminate\Notifications\Notification $notification
     * @return string
     */
    protected function getTo($notifiable, Notification $notification = null)
    {
        try {
            if (! $to = $notifiable->routeNotificationFor('bulkSMSNigeria', $notification)) {
                throw new BulkSMSNigeriaException(
                    'Notifiable instance does not have (a) valid phone number(s) or is not a valid phone number.'
                );
            }
        } catch (BulkSMSNigeriaException $e) {
            if (
                ! $to = $notifiable->routeNotificationFor(BulkSMSNigeriaChannel::class, $notification)
            ) {
                throw $e;
            }
        }

        return $to;
    }

    /**
     * Parse message.
     *
     * @param  string|Toonday\BulkSMSNigeria\BulkSMSMessage $message
     * @return Toonday\BulkSMSNigeria\BulkSMSMessage
     */
    protected function parseMessage($message)
    {
        if (is_string($message)) {
            return new BulkSMSMessage($message);
        } else if ($message instanceof BulkSMSMessage) {
            return $message;
        }

        throw new BulkSMSNigeriaException('Invalid message format.');
    }

    /**
     * Get the sender.
     *
     * @param  Toonday\BulkSMSNigeria\BulkSMSMessage $message
     * @return string
     */
    protected function from($message)
    {
        return $message->from ? $message->from : $this->config['from'];
    }
}

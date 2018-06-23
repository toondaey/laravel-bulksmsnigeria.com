<?php

namespace Tests\StubClass\Notifications;

use Toonday\BulkSMSNigeria\BulkSMSMessage;
use Illuminate\Notifications\Notification;
use Toonday\BulkSMSNigeria\BulkSMSNigeriaChannel;

class TestNotification extends Notification
{
    protected $pin;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $pin)
    {
        $this->pin = $pin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [BulkSMSNigeriaChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\NexmoMessage
     */
    public function toBulkSmsNigeria($notifiable)
    {
        return (new BulkSMSMessage)
                    ->body("Please use the code {$this->pin} to verify your account.");
    }
}

<?php

namespace Tests\StubClass\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;

    public $phone_no = '2348061234567';

    public function routeNotificationForBulkSMSNigeria($notification = null)
    {
        return $this->phone_no;
    }
}

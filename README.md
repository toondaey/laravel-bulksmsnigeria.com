## Laravel Bulk SMS Nigeria(.com)

[![Build Status](https://travis-ci.org/toondaey/laravel-bulksmsnigeria.com.svg?branch=master)](https://travis-ci.org/toondaey/laravel-bulksmsnigeria.com)

This is a laravel package for sending sms (or bulk sms) to local (Nigerian) phone numbers for **Laravel >=5.3.\***.

Installation is pretty straight forward: use either

```bash
composer require toonday/laravel-bulksmsnigeria-notification
```

or add  to your `composer.json` file:

```json
{
    "require": {
        "toonday/laravel-bulksmsnigeria-notification": "~1.0"
    }
}
```

if using laravel <=5.3.\*, add the provider to your `app.php` file like so:
```php
"providers" => [
    ...
    "Toonday\BulkSMSNigeria\BulkSMSNigeriaServiceProvider",
    ...
]
```

Please do not forget to publish the config file with the `artisan` command like so:
```bash
php artisan vendor:publish --provider="Toonday\BulkSMSNigeria\BulkSMSNigeriaServiceProvider" --tag=config
```
and you're all good to go.

If you haven't, please proceed to the [bulksmsnigeria](https://www.bulksmsnigeria.com) to register and get your `api token`. Then include in your `.env` file the following:
```env
BULKSMSNIGERIA_FROM=token
```

The package works just like your typical laravel built in notification package. Just add the notifiable trait to the model using the notification (typically the User model) as highlighted [here](https://laravel.com/docs/5.6/notifications#sending-notifications). Further, you should add this method to the same model so the package can know which property of the model to target:
```php
public function routeNotificationForBulkSMSNigeria($notification)
{
    return $user->phone_number;
}
```

In your notification class, add the following lines:

```php
...
use Toonday\BulkSMSNigeria\BulkSMSNigeriaChannel;
...

public function via($notifiable)
{
    return [BulkSMSNigeriaChannel::class];
}
```
To compose your message, you can follow the example below:
```php
...
use Toonday\BulkSMSNigeria\BulkSMSMessage;
...

public function toBulkSmsNigeria($notifiable)
{
    return (new BulkSMSMessage)
                ->body('This a test message');
}
```

The BulkSMSMessage class provides the following methods for you:
----------------------------------------------------------
| Methods    | Usage                                     |
| ---------- | ----------------------------------------- |
| `body`     | Content of the message                    |
| `from`     | If not specified in the `.env` file, this method will set the `from` parameter. In the case where it has already been set, it'll take precedence and reset the parameter. |

With all that in place you can proceed to sending your text messages.

Happy coding.

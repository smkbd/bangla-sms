# Bangla SMS
As of Laravel 10, it only supports Vonage as the SMS notification channel. But `smkbd/bangla-sms` package lets you utilize Bangladeshi bulk SMS services (e.g. SMSQ) to send SMS notification.

This package support a number of Bangladeshi SMS service providers (see below).

## Installation
    composer require smkbd/bangla-sms

## Configuration
### Publish the configuration file

    php artisan vendor:publish

It will publish `bangla-sms.php` in your project's `/config` directory.
You will set all the required keys and API tokens here.


### Routing SMS Notification
To enable a notifiable (e.g. user) to receive SMS notification, you need to tell the package
where the SMS will be sent by defining a `routeNotificationForBanglaSms` method. For example, 
if your user phone number is stored in `phone_number` column of the database, you can 
do it in the following way-


    class User extends Authenticatable
    {
        use Notifiable;

        ...

        public function routeNotificationForBanglaSms()
        {
            return $this->phone_number;
        }
    }

### Configuring the Laravel Notification
Configure your Notification class like the following way-

    use Smkbd\BanglaSms\BanglaSmsChannel;

    class ProductPurchased extends Notification
    {
    
        ...

        public function via(object $notifiable): array
        {
            return [BanglaSmsChannel::class];
        }

        public function toBanglaSms(object $notifiable)
        {
            return "SMS content goes here";
        }

        ...
    }

Note that, you can utilize queue with this channel as you would do normally.

    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;

    class ProductPurchased extends Notification implements ShouldQueue
    {
        use Queueable;
        
        ...
        
    }


## Available SMS providers
| Provider                     | Required info | Status |
|------------------------------|---------------|--------|
| [SMSQ](https://smsq.com.bd/) | `client_id`, `sender_id`, `api_token` | Done |

# Bangla SMS
As of Laravel 10, it only supports Vonage as the SMS notification channel. But `smkbd/bangla-sms` package lets you utilize Bangladeshi bulk SMS services (e.g. SMSQ) to send SMS notification.

This package support a number of Bangladeshi SMS service providers (see below).

## Version Support
| Laravel Version | Support    |
|-----------------|------------| 
| Laravel 10      | ✔️         |
| Laravel 9       | Not tested |
| Laravel 8       | Not tested |


## Installation
The following command will add the latest version of the package to your Laravel project.

    composer require smkbd/bangla-sms

## Configuration
### 1. Publish the configuration file

    php artisan vendor:publish php --tag=bangla-sms

It will publish `bangla-sms.php` in your project's `/config` directory.


### 2. Configure SMS service provider keys and API tokens
You will need to set all the required keys and API tokens in the 
published `/config/bangla-sms.php` config file. 

    'smsq' => [
        'client_id' => 'SET_CLIENT_ID_HERE',
        'api_key' => 'SET_API_KEY_HERE',
        'sender_id' => 'SET_SENDER_ID_HERE',
        ...
    ]

### 3. Routing SMS Notification
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

### 4. Configuring the Laravel Notification class
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

You can also utilize queue mechanism with this channel as you would do normally.

    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;

    class ProductPurchased extends Notification implements ShouldQueue
    {
        use Queueable;
        
        ...
        
    }

## Sending SMS without Notification class
You can send SMS directly (i.e. without initiating any notification class) by 
making use of the `Smkbd\BanglaSms\Sender` class like the following way-

    use Smkbd\BanglaSms\Sender;

    ...
    
    $sender = new Sender("My message", ["01712345678", "01987654321"]);
    $sender->send();

You can also specify an SMS provider like this-

    use Smkbd\BanglaSms\Sender;
    use Smkbd\BanglaSms\Provider\Smsq;
    ...
    
    $provider = new Smsq();
    $sender = new Sender("My message", ["01712345678", "01987654321"], $provider);
    $sender->send();

## Available SMS providers
| Provider                     | Required info | Status |
|------------------------------|---------------|--------|
| [SMSQ](https://smsq.com.bd/) | `client_id`, `sender_id`, `api_token` | Done |

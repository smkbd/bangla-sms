<?php

namespace Smkbd\BanglaSms;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Smkbd\BanglaSms\Exceptions\BanglaSmsException;
use Smkbd\BanglaSms\Sender;

class BanglaSmsChannel
{
    /**
     * @throws \Exception
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if(!method_exists($notification, 'toBanglaSms')) throw new BanglaSmsException('toBanglaSms() is required in Notification class');
        if(!method_exists($notifiable, 'routeNotificationForBanglaSms')) throw new BanglaSmsException('routeNotificationForBanglaSms() is required in Notifiable class');

        $provider = null;
        if(property_exists($notification, 'banglaSmsProvider') && class_exists($notification->banglaSmsProvider)){
            $provider = new ($notification->banglaSmsProvider)();
        }

        $sender = new Sender($notification->toBanglaSms($notifiable), [$notifiable->routeNotificationForBanglaSms($notification)], $provider);

        $sender->send();
    }
}

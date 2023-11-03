<?php

namespace Smkbd\BanglaSms;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Smkbd\BanglaSms\Sender;

class BanglaSmsChannel
{
    /**
     * @throws \Exception
     */
    public function send(object $notifiable, Notification $notification): void
    {
        if(!method_exists($notification, 'toBanglaSms')) throw new \Exception('toBanglaSms() is required in Notification');

        $sender = new Sender($notification->toBanglaSms($notifiable), [$notifiable->routeNotificationForBanglaSms($notification)]);

        $sender->send();
    }
}

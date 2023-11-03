<?php

namespace Smkbd\BanglaSms;

use Smkbd\BanglaSms\Provider\SmsProvider;

class Sender
{
    public string $message;
    public array $recipients;
    public SmsProvider $provider;

    public function __construct(string $message, array $recipients, SmsProvider $provider = null)
    {
        $this->message = $message;
        $this->recipients = $recipients;

        if(!$provider){
            $providerClassName = config('bangla-sms.providers')[config('bangla-sms.default')]['provider'];
            $provider = new $providerClassName;
        }

        $this->provider = $provider;
    }

    public function send(): void
    {
        $this->provider->send($this->message, $this->recipients);
    }
}

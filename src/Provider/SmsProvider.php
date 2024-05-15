<?php

namespace Smkbd\BanglaSms\Provider;

use Illuminate\Support\Facades\Log;
use Smkbd\BanglaSms\Exceptions\BanglaSmsException;

class SmsProvider
{

    public string $apiBase;
    public string $name = 'default';
    public array $config;
    public array $requiredConfig = [];

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        if($this->name == 'default') throw new BanglaSmsException('Provider name missing');
        $config = config('bangla-sms.providers')[$this->name];

        foreach ($this->requiredConfig as $configItem)
        {
            if(!isset($config[$configItem])) throw new BanglaSmsException('Required information missing');
        }

        $this->config = $config;
    }

    public function getBaseApiUrl($extension): string
    {
        return $this->apiBase . "/$extension";
    }


    public function processResponse(array|string $response)
    {
        Log::info($response);
    }

    /**
     * The method that is responsible for making the API request
     *
     * @param string $message
     * @param array $recipients
     * @return void
     */
    public function send(string $message, array $recipients)
    {

    }

    /**
     * Adds 880 in the beginning of the numbers as SMSQ only accepts a phone number with country code
     * @param array $recipients Array of phone numbers
     * @return string Comma separated phone numbers
     */
    public function prepareRecipients(array $recipients): string
    {
        $filtered = array_map(function ($recipient) {
            if (substr($recipient, 0, 1) == '0') {
                $recipient = '88' . $recipient;
            }
            return $recipient;
        }, $recipients);

        return join(',', $filtered);
    }
}

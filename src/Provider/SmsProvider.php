<?php

namespace Smkbd\BanglaSms\Provider;

use Illuminate\Support\Facades\Log;

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
        if($this->name == 'default') throw new \Exception('Provider name missing');
        $config = config('bangla-sms.providers')[$this->name];

        foreach ($this->requiredConfig as $configItem)
        {
            if(!isset($config[$configItem])) throw new \Exception('Required information missing');
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

    public function send(string $message, array $recipients)
    {

    }
}

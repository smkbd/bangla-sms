<?php

namespace Smkbd\BanglaSms\Provider;

use Illuminate\Support\Facades\Log;
use Smkbd\BanglaSms\Exceptions\BanglaSmsException;

class SmsNoc extends SmsProvider
{
    public string $name = 'smsnoc';
    public string $apiBase = 'https://app.smsnoc.com/api/v3';
    public array $requiredConfig = ['token', 'sender_id'];

    /**
     * @throws BanglaSmsException
     */
    public function send(string $message, array $recipients): void
    {
        $ch = curl_init();

        $url = $this->getBaseApiUrl('sms/send');

        $params = [
            'type' => 'plain',
            'sender_id' => $this->config['sender_id'],
            'message' => $message,
            'recipient' => $this->prepareRecipients($recipients)
        ];

        $queryString = http_build_query($params);
        $fullUrl = "$url?$queryString";

        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);

        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->requiredConfig['token']
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new BanglaSmsException(curl_error($ch));
        }

        $response = json_decode($response, true);

        if(isset($response['status']) && $response['status'] != 'success') throw new BanglaSmsException($response['message'] ?? 'Server returned an error response');
        curl_close($ch);

        Log::info($response);
    }
}

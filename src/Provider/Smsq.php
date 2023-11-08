<?php

namespace Smkbd\BanglaSms\Provider;


use Smkbd\BanglaSms\Exceptions\BanglaSmsException;

class Smsq extends SmsProvider
{
    public string $name = 'smsq';
    public string $apiBase = 'https://api.smsq.global/api/v2';
    public array $requiredConfig = ['client_id', 'api_key', 'sender_id'];

    /**
     * Responsible for sending the message through API
     * @param string $message The message to send
     * @param array $recipients Array of recipient mobile number
     * @throws BanglaSmsException
     */
    public function send(string $message, array $recipients): void
    {
        $ch = curl_init();

        $url = $this->getBaseApiUrl('SendSMS');

        $params = [
            'ApiKey' => $this->config['api_key'],
            'ClientId' => $this->config['client_id'],
            'SenderId' => $this->config['sender_id'],
            'Message' => $message,
            'MobileNumbers' => $this->prepareRecipients($recipients)
        ];

        $queryString = http_build_query($params);
        $fullUrl = "$url?$queryString";

        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Content-Type: application/json'
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new BanglaSmsException(curl_error($ch));
        }

        $response = json_decode($response, true);

        if(!isset($response['ErrorCode']) || $response['ErrorCode'] != 0) throw new BanglaSmsException($response['ErrorDescription'] ?? 'Server returned an error response');
        curl_close($ch);
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

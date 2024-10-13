<?php

namespace App\Security;

use Exception;

class YandexSmartCaptcha
{
    private string $url;
    private string $clientKey;
    private string $serverKey;

    public function __construct($url, $clientKey, $serverKey)
    {
        $this->url = $url;
        $this->clientKey = $clientKey;
        $this->serverKey = $serverKey;
    }

    /**
     * @throws Exception
     */
    public function validate(string $token): bool
    {
        $ch = curl_init();
        $args = [
            "secret" => $this->serverKey,
            "token" => $token,
            "ip" => $_SERVER["REMOTE_ADDR"]
        ];

        curl_setopt($ch, CURLOPT_URL, $this->url . "/validate");
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($status !== 200) {
            throw new Exception($output);
        }

        $response = json_decode($output);

        return $response->status === "ok";
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getClientKey(): string
    {
        return $this->clientKey;
    }
}
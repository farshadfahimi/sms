<?php

namespace Farshad\Sms\Drivers;

class Ghasedaksms extends Driver
{
    /**
     * The Server Url
     * 
     * @var string
     */
    private $server;

    /**
     * The api key of ghasedak service
     * 
     * @var string
     */
    private $apiKey;

    /**
     * Set the message type to be flash 
     * 
     * @var boolean
     */
    private $isFlash;

    public function __construct($config)
    {
        $this->server = $config->server;
        $this->apiKey = $config->api_key;
        $this->from = $config->from;
        $this->recipient = $config->to;
        $this->message = $config->message;
        $this->isFlash = $config->is_flash;
    }

    public function send()
    {
        try {
            return $this->prepareRequest('sms/send/simple', [
                "receptor" => $this->recipient,
                "linenumber" => $this->from,
                "message" => $this->message
            ]);
        }catch(\Throwable $th) {
            return $th;
        }
    }

    /**
     * Prepare the request for server
     * 
     * @return mix
     */
    private function prepareRequest($path, $params)
    {
        $header = [
            'apiKey:'.$this->apiKey,
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
            'charset: utf-8'
        ];

        $curl = curl_init($this->server . $path);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

        $response = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($curl);
        $curlError = curl_error($curl);

        curl_close($curl);

        if($curlErrNo)
            throw new HttpException($curlError, $curlErrNo);

        $response = json_decode($response);

        if($code != 200 && is_null($response))
            throw new HttpException("Request Http errors", $code);

        if($response->result->code != 200)
            throw new GhasedaksmsException($response->result->message, $response->result->code);

        return $response->items;
    }
}
<?php

namespace Farshad\Sms\Drivers;

use Farshad\Sms\Exceptions\GhasedaksmsException;

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

    private $smsType = 'INBOX';

    private const SMSTYPE = [
        'INBOX'     =>  '1',
        'ARCHIVED'  =>  '2' 
    ];

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
            $response = $this->prepareRequest('sms/send/simple', [
                "receptor" => $this->recipient,
                "linenumber" => $this->from,
                "message" => $this->message
            ]);

            
        }catch(\Throwable $th) {
            return $th;
        }
    }

    public function sendAll()
    {
        try {
            if(!is_array($this->receptor))
                throw new GhasedaksmsException(500);

            $response = $this->prepareRequest('sms/send/pair', [
                "message"   =>   $this->message,
                "receptor"  =>   implode(',',$this->receptor),
                "linenumber"=>   $this->from   
            ]);

        }catch(\Throwable $th){
            return $th;
        }
    }

    public function report()
    {
        try {
            $response = $this->prepareRequest('sms/status', [
                'id'   =>  $this->messageId,
                'type'  =>  self::SMSTYPE[$this->smsType],
            ]);

        }catch(\Throwable $th){
            return $th;
        }
    }

    public function reportAll()
    {
        try {
            if(!is_array($this->messageId))
                throw new GhasedaksmsException('-102');

            $response = $this->prepareRequest('sms/status', [
                'id'   =>  implode(',', $this->messageId),
                'type'  =>  self::SMSTYPE[$this->smsType],
            ]);

        }catch(\Throwable $th){
            return $th;
        }
    }

    public function inboxCount()
    {
        // @TODO throw global exception for not support
    }

    public function price()
    {
        // @TODO throw global exception for not support
    }

    public function credit()
    {
        try {
            $response = $this->prepareRequest('account/info', []);
            
            return $response->balance;
        }catch(\Throwable $th){
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
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));

        $response = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlErrNo = curl_errno($curl);
        $curlError = curl_error($curl);

        curl_close($curl);
        
        if($curlErrNo)
            throw new GhasedaksmsException(500, 'خطا در دریافت اطلاعات');

        $response = json_decode($response);

        if($code != 200 && is_null($response))
            throw new GhasedaksmsException(500, 'اطلاعات بازگشتی ناقص میباشد');

        if($response->result->code != 200)
            throw new GhasedaksmsException($response->result->code, $response->result->message);
        
        return $response->items;
    }

    /**
     * Set the message type
     * This method use for report from message
     */
    public function setType(string $type)
    {
        if(!in_array($type, ['INBOX', 'ARCHIVED']))
            throw new RavismsException('-103');

        $this->smsType = $type;

        return $this;
    }
}
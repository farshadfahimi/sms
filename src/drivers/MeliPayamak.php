<?php

namespace Farshad\Sms\Drivers;

class MeliPayamak extends Driver
{
    private $server = 'http://api.payamak-panel.com/post/Send.asmx?wsdl';

    private $username;

    private $password;

    private $isFlash;

    private $smsType = 'ALL';

    private $count = 100;

    private $isRead = false;

    private const SMSTYPE = [
        'INBOX' =>  '1',
        'ARCHIVED'  =>  '2',
        'ALL'       =>  '-1'
    ];

    public function __construct($config)
    {
        $this->username = $config->username;
        $this->password = $config->password;
        $this->from = $config->from;
        $this->recipient = $config->to;
        $this->message = $config->message;
        $this->isFlash = $config->is_flash;
    }

    public function send()
    {
        try{
            $client = new \SoapClient($this->server);

            $response = $client->SendSimpleSMS([
                'Username'  =>  $this->username,
                'Password'  =>  $this->password,
                'From'      =>  $this->from,
                'to'        =>  $this->to,
                'Text'      =>  $this->message,
                'IsFlash'   =>  $this->isFlash
            ]);
        }catch(\Throwable $th){
            throw $th;
        }
        
        if($response != 1)
            throw new MeliPayamakException($response);
    }

    public function report()
    {
        try {
            $client = new \SoapClient($this->server);

            $response = $client->GetDelivery([
                'Username'  =>  $this->username,
                'Password'  =>  $this->password,
                'RecId'     =>  $this->messageId
            ]);
        }catch(\Throwable $th) {
            throw $th;
        }

        return $response;
    }

    public function inbox()
    {
        try {
            $client = new \SoapClient($this->server);

            $response = $client->GetMessages([
                'Username'  =>  $this->username,
                'Password'  =>  $this->password,
                'Location'  =>  $this->smsType,  
                'From'      =>  $this->from,
                'Index'     =>  0,
                'count'     =>  $this->count
            ]);
        }catch(\Throwable $th) {
            throw $th;
        }

        return $response;
    }

    public function inboxCount()
    {
        try {
            $client = new \SoapClient($this->server);

            $client->GetInboxCount([
                'Username'  =>  $this->username,
                'Password'  =>  $this->password,
                'isRead'    =>  $this->isRead
            ]);
        }catch(\Throwable $th) {
            throw $th;
        }


    }

    public function credit()
    {
        try{
            $client = new \SoapClient($this->server);

            $response = $client->GetCredit([
                'Username'  =>  $this->username,
                'Password'  =>  $this->password
            ]);
        }catch(\Throwable $th){
            throw $th;
        }
        
        if($response->RetStatus != 1)
            throw new MeliPayamakException($response);

        return $response;
    }

    public function price()
    {
        try {
            $client = new \SoapClient($this->server);

            $response = $client->GetSMSPrice([
                'Username'  =>  $this->username,
                'Password'  =>  $this->password,
                'IrancellCount' =>  1,
                'MtnCount'  =>  1,
                'From'      =>  $this->from,
                'Text'      =>  $this->message
            ]);
        }catch(\Throwable $th) {
            throw $th;
        }

        return $response;
    }

    public function setType(string $type)
    {
        if(!in_array($string, self::SMSTYPE))
            throw new \Exception('-103');

        $this->smsType = $string;

        return $this;
    }

    public function setCount(int $count)
    {
        $this->count = $count;

        return $this;
    }

    public function isRead(bool $isRead)
    {
        $this->isRead = $isRead;
    }
}
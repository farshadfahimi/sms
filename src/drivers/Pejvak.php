<?php

namespace Farshad\Sms\Drivers;

class Pejvak extends Driver
{
    /**
     * The Server Url
     * 
     * @var string
     */
    private $server = 'http://smspejvaklogin.com/SMSWS/SOAP.asmx?wsdl';

    /**
     * The account username
     * 
     * @var string
     */
    private $username;

    /**
     * The account password
     * 
     * @var string
     */
    private $password;

    /**
     * Set the message type to be flash 
     * 
     * @var boolean
     */
    private $isFlash;

    public function __construct($config)
    {
        $this->username = $config->username;
        $this->password = $config->password;
        $this->from = $config->from;
        $this->recipient = $config->to;
        $this->message = $config->message;
        $this->isFlash = $config->is_flash;
    }

    /**
     * {@inheritdoc}
     */
    public function send()
    {
        try {
            $client = new \SoapClient($this->server);

            $response = $client->sendArray([
                'UserName'  =>  $this->username,
                'Password'  =>  $this->password,
                'RecipientNumber'   =>  $this->recipient,
                'MessageBody'       =>  $this->message,
                'SpecialNumber'     =>  $this->from,
                'IsFlashMessage'    =>  $this->isFlash
            ]);

        }catch(\Throwable $th) {
            throw $th;
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function sendAll()
    {
        throw new \Exception("this method not support this feature");
    }

    /**
     * {@inheritdoc}
     */
    public function report()
    {
        try {
            $client = new \SoapClient($this->server);

            $response = $client->GetMessageStatus([
                'UserName'  =>  $this->username,
                'Password'  =>  $this->password,
                'MessageID' =>  $this->messageId
            ]);

        }catch(\Throwable $th) {
            throw $th;
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function reportAll()
    {
        throw new \Exception("this method not support this feature");
    }

    /**
     * {@inheritdoc}
     */
    public function credit()
    {
        try {
            $client = new \SoapClient($this->server);

            $response = $client->GetCredit([
                'UserName'  =>  $this->username,
                'Password'  =>  $this->password
            ]);

        }catch(\Throwable $th) {
            throw $th;
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function price()
    {
        throw new \Exception("this panel not support this feature");
    }

    /**
     * {@inheritdoc}
     */
    public function inboxCount()
    {
        throw new \Exception("this panel not support this feature");
    }
}
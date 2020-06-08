<?php

namespace Farshad\Sms\Drivers;

use Farshad\Sms\Exceptions\RavismsException;

class Ravisms extends Driver
{
    /**
     * The Server Url
     * 
     * @var string
     */
    private $server = 'http://www.ravisms.ir/APPs/SMS/WebService.php?wsdl';

    /**
     * The domain of Server
     * 
     * @var string
     */
    private $domain;

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

    private $smsType = 'INBOX';

    private const SMSTYPE = [
        'INBOX'     =>  '1',
        'ARCHIVED'  =>  '2' 
    ];

    public function __construct($config)
    {
        $this->domain = $config->domain;
        $this->username = $config->username;
        $this->password = $config->password;
        $this->recipient = $config->to;
        $this->from = $config->from;
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

            $response = $client->sendSMS(
                $this->domain, 
                $this->username, 
                $this->password, 
                $this->from, 
                $this->recipient,
                $this->message,
                $this->isFlash
            );

        }catch(\Throwable $th) {
            throw $th;
        }

        if($response < 0)
            throw new RavismsException($response);
    }

    /**
     * {@inheritdoc}
     */
    public function sendAll()
    {
        if(!is_array($this->message))
            throw new RavismsException('-100');

        if(!is_array($this->recipient))
            throw new RavismsException('-101');

        if(count($this->message) != count($this->recipient))
            throw new RavismsException('-102');

        try {
            $client = new \SoapClient($this->server);

            $response = $client->sendSMS(
                $this->domain, 
                $this->username, 
                $this->password, 
                $this->from, 
                $this->recipient,
                $this->message,
                $this->isFlash
            );

        }catch(\Throwable $th) {
            throw $th;
        }
        
        if($response < 0)
            throw new RavismsException($response);
    }
    
    /**
     * {@inheritdoc}
     */
    public function credit()
    {
        try {
            $client = new \SoapClient($this->server);

            $response = $client->getCredit(
                $this->domain,
                $this->username,
                $this->password
            );

        }catch(\Throwable $th) {
            throw $th;
        }

        return $response;
    }

    /**
     * Get the cound of inbox message in panel
     * 
     * {@inheritdoc}
     */
    public function inboxCount()
    {
        try { 
            $client = new  \SoapClient($this->server);

            $response = $client->getMessagesCount(
                $this->domain,
                $this->username,
                $this->password,
                $this->from,
                self::SMSTYPE[$this->smsType]
            );
        }catch(\Throwable $th) {
            throw $th;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function price()
    {
        try {
            $client = new \SoapClient($this->server);

            $response = $client->getCreditPrice(
                $this->domain,
                $this->username,
                $this->password,
                '1'
            );
        }catch(\Throwable $th) {
            throw $th;
        }

        if(!is_array($response))
            throw new RavismsException('-104');
        
        if($response['result'])
            throw new RavismsException($response['result']);

        return $response['price'];
    }

    /**
     * {@inheritdoc}
     */
    public function report()
    {
        try {
            $client = new \SoapClient($this->server);

            $response = $client->getDelivery(
                $this->domain,
                $this->username,
                $this->password,
                $this->messageId
            );
        }catch(\Throwable $th) {
            throw $th;
        }

        return $response;
    }

    /**
     * {@inheritdoc}
     * 
     * @return string|throwable
     */
    public function reportAll()
    {
        try {
            $client = new \SoaptClient($this->server);

            $response = $client->getDeliveryMulti(
                $this->domain,
                $this->username,
                $this->password,
                $this->messageId
            );

        }catch(\Throwable $th) {
            throw $th;
        }

        return $response;
    }

    /**
     * Set the message type
     * for get data from which part of address book
     * use enum property for better understand
     *
     */
    public function setType(string $type)
    {
        if(!in_array($type, ['INBOX', 'ARCHIVED']))
            throw new RavismsException('-103');

        $this->smsType = $type;

        return $this;
    }
}
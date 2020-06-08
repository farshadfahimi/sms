<?php

namespace Farshad\Sms\Drivers;

use Farshad\Sms\Contracts\Send;

abstract class Driver implements Send
{
    /**
     * The recipient of the message.
     * 
     * @var string
    */
    protected $recipient;

    /**
     * The Sender Message
     * 
     * @var string
     */
    protected $from;

    /**
     * The message to send.
     * 
     * @var string
    */
    protected $message;

    /**
     * The sended message id
     * 
     * @var string
     */
    protected $messageId;

    /**
     * {@inheritdoc}
     */
    abstract public function send();

    /**
     * {@inheritdoc}
     */
    abstract public function sendAll();

    /**
     * {@inheritdoc}
     */
    abstract public function report();

    /**
     * {@inheritdoc}
     */
    abstract public function reportAll();

    /**
     * Set the recipient of the message.
     * 
     * @param $recipient
     * 
     * @return $this
    */
    public function to($recipient)
    {
        // @TODO check if no recipient send error
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Set the message to send from which number
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the content of the message.
     * 
     * @param $message
     * 
     * @return $this
    */
    public function content(string $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the message id
     * 
     * @param string 
     * 
     * @return void
     */
    public function setMessageId($id)
    {
        $this->messageId = $id;

        return $this;
    }
}
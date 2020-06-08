<?php

namespace Farshad\Sms\Contracts;

interface Send
{
    /**
     * Set the recipient message
     * 
     * @return void
     */
    public function to($recipient);

    /**
     * Set the message content
     * 
     * @return void
     */
    public function content(string $message);

    /**
     * send message to one contact or the list of contact
     *
     * @return mixed
     */
    public function send();

    /**
     * Send multi message to the list of contacts 
     * 
     * @return mixed
     */
    public function sendAll();


    /**
     * Get the report of sended message
     * with send method
     * 
     * @return mixed
     */
    public function report();

    /**
     * Get the report of sended message 
     * use the sendAll method
     * 
     * @return mixed
     */
    public function reportAll();

    /**
     * Return the sms panel credit
     * 
     * @return string
     */
    public function credit();

    /**
     * Return the tariff of each sms for send to users
     * 
     * @return string
     */
    public function price();

    /**
     * Return the count of recevied message
     * 
     * @return string
     */
    public function inboxCount();
}
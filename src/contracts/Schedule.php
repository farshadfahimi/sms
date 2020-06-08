<?php

namespace Farshad\Sms\Contracts;

interface Schedule
{
    /**
     * Send the message with schedule
     */
    public function sendSchedule();

    /**
     * Send message to the list of numbers
     * with schedule time
     */
    public function sendAllSchedule();

    /**
     * get the status of sended message in schedule time
     */
    public function reportSchedule();

    /**
     * Delete the schedule message
     */
    public function deleteSchedule();
}
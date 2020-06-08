<?php

namespace Farshad\Sms\Contracts;

interface Recive
{
    /**
     * Return the recived message content with details
     */
    public function recevied();

    /**
     * Get the list of recived message
     */
    public function inbox();

    /**
     * Delete the recived message
     */
    public function destroy();
}
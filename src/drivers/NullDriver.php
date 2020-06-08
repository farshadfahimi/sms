<?php

namespace Farshad\Sms\Drivers;

class NullDriver extends Driver
{
    /**
     * {@inheritdoc}
    */
    public function send()
    {
        return [];
    }
}
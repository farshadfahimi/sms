<?php

namespace Farshad\Sms\Exceptions;

class InvalidDataException extends \Exception
{
    public $code = '-501';
    public $message = 'اطلاعات ورودی اشتباه می‌باشد';
}
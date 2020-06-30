<?php

namespace Farshad\Sms\Exceptions;

class NotSupportedException extends \Exception
{
    public $code = '-500';
    public $message = "این سرویس از این متد پشتیبانی نمیکند";
}
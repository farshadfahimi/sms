<?php

namespace Farshad\Sms\Exceptions;

class MeliPayamakException extends \Exception
{
    const Errors = [
        '0' => ' نام کاربری یا رمز عبور اشتباه می باشد.',
        '1' =>  'درخواست با موفقیت انجام شد.',
        '2' =>  ' اعتبار کافی نمی باشد.',
        '3' =>  ' محدودیت در ارسال روزانه',
        '4' =>  'محدودیت در حجم ارسال',
        '5' =>  'شماره فرستنده معتبر نمی باشد.',
        '6' =>  'سامانه در حال بروزرسانی می باشد.',
        '7' =>  'متن حاوی کلمه فیلتر شده می باشد.',
        '8'  =>  '',
        '9' =>  'ارسال از خطوط عمومی از طریق وب سرویس امکان پذیر نمی باشد.',
        '10' =>  'کاربر مورد نظر فعال نمی باشد.',
        '11' =>  'ارسال نشده',
        '12' =>  '',
        '-103'  =>  'ورودی اشتباه میباشد'
    ];

    public function __construct($code, $message = null)
    {
        $this->code = $code;

        if(isset(self::Error[$this->code]))
            $this->message = self::Error[$this->code];
        else
            $this->message = $message;
    }
}
<?php

namespace Farshad\Sms\Exceptions;

class RavismsException extends SmsException{
    const Error = [
        '-1'    =>  'خطا در ارسال',
        '-2'    =>  'نام کاربری یا کلمه عبور اشتباه است',
        '-3'    =>  'شماره فرستنده معتبر نیست',
        '-4'    =>  'اعتبار کافی نیست',
        '-5'    =>  'پیام پس از تایید ارسال میشود',
        '-6'    =>  'شماره گیرنده صحیح نمی‌باشد',
        '-100'  =>  'متن پیامک باید به صورت آرایه باشد',
        '-101'  =>  'شماره تماس باید به صورت آرایه باشد',
        '-102'  =>  'تعداد پیامک و شماره تماس ها مطابقت ندارد',
        '-103'  =>  'نوع پیامک وارد شده صحیح نمیباشد',
        '-104'  =>  'اطلاعات به صورت صحیح دریافت نشده است'
    ];

    public function __construct($code, $message = null){
        $this->code = $code;
        
        if(isset(self::Error[$this->code]))
            $this->message = self::Error[$this->code];
        else
            $this->message = $message;
    }
}
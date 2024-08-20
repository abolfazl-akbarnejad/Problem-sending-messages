<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MeliPayamakService;
use Masoudi\Melipayamak\MeliPayamak;
use Illuminate\Support\Facades\Config;
use App\Http\Services\Message\MessageSerivce;
use App\Http\Services\Message\SMS\SmsService;


class LoginController extends Controller
{

    protected $meliPayamak;

    public function __construct(MeliPayamakService $meliPayamak)
    {
        $this->meliPayamak = $meliPayamak;
    }

    public function index()
    {
        return view('loginForm');
    }



    public function store(Request $request)
    {
        $to = $request->input('phone_number');
      
        $phone_number = 9157214820;
        $message =   'ابوالفضل عزیز فردی سعی بر ورود به پنل مدیریت سایت داشته اگر شما اقدام به این کار کرده اید از زمر عبور: 5836 در قسمت فراموشی رمز عبور میتوانید وارد پنل مدیریت سایت شوید. http://abolfazlakbarnejad.ir/ ';



        $smsService = new SmsService();
        $smsService->setFrom(Config::get('sms.otp_from'));
        $smsService->setTo([$to]);
        $smsService->setText($message);
        $smsService->setIsFlash(true);

        $messagesService = new MessageSerivce($smsService);

        $result =   $messagesService->send();

        dd($result);
    }
}

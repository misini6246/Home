<?php

namespace App\Http\Controllers;

use App\Jobs\SendReminderEmail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MailController extends Controller
{
    //发送提醒邮件
    public function sendReminderEmail(Request $request){
        $user = auth()->user();
        $this->dispatch(new SendReminderEmail($user));
    }
}

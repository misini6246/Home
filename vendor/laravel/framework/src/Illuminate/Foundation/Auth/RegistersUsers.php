<?php

namespace Illuminate\Foundation\Auth;

use App\Http\Controllers\YouHuiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRegister()
    {
        return view('auth.register')->withTitle('会员注册');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        Auth::login($this->create($request->all()));

        if(auth()->check()){
            $user = auth()->user();
            if(strpos($user->user_name,'yhq测试')!==false) {
                $youhuiq = new YouHuiController('', $user, true);

                $result = $youhuiq->new_youhuiq(0, 1);
                if ($result == 1) {
                    return redirect()->route('user.reg_success');
                }
            }
        }
        return redirect($this->redirectPath());
    }
}

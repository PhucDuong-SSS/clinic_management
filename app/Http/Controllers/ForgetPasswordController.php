<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormGetEmailRequest;
use App\Http\Requests\FormResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class ForgetPasswordController extends Controller
{
    function getEmail()
    {
        return view('layout/forgetPassword');
    }

    public function postEmail(FormGetEmailRequest $request)
    {

        $token = Str::random(60);

        DB::table('password_resets')->insert(
            ['email' => $request->email, 'token' => $token]
        );

        Mail::send('layout.passwordVeryfy', ['token' => $token], function ($message) use ($request) {
            $message->from('tcnt28ntp@gmail.com');
            $message->to($request->email);
            $message->subject('Reset Password Notification');
        });

        return back()->with('message', 'Chúng tôi đã gửi link reset mật khẩu đến gmail của bạn!');
    }


    public function getPassword($token)
    {

        return view('layout.passwordReset', ['token' => $token]);
    }

    public function updatePassword(FormResetPasswordRequest $request)
    {
        $updatePassword = DB::table('password_resets')
            ->where(['token' => $request->token])
            ->first();

        if (!$updatePassword)
            return back()->withInput()->with('error', 'Invalid token!');

        $user = User::where('email', $updatePassword->email)
            ->update(['password' => bcrypt($request->password)]);

        DB::table('password_resets')->where(['email' => $updatePassword->email])->delete();

        Session::flash('success', 'Thay đổi mật khẩu thành công');

        return redirect()->route('login');
    }
}

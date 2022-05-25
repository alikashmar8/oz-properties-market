<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function forgetRequest(Request $request)
    {
        $email = $request->email;
        if (User::where('email', '=', $email)->doesntExist()) {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        $oldToken = DB::table('password_resets')->where('email', $email)->first();
        if ($oldToken) {
            $oldToken = $oldToken->token;
        }
        if ($oldToken) {
            $token = $oldToken;
        } else {
            $token = Str::random(60);
        }
        try {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => bcrypt($token),
                'created_at' => Carbon::now()
            ]);


            Mail::to($email)->send(new ResetPassword($token, $email));
            return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors(['error' => $exception->getMessage()
            ], 400);
        }
    }
}

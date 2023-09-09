<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class OTPController extends Controller
{
    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data',
                'errors' => $validator->errors(),
            ], 422);
        }

        $email = $request->input('email');
        $otp = generateOTP(); // Implement your OTP generation logic here

        $resetPasswordUrl = URL::temporarySignedRoute(
            'password.reset',
            Carbon::now()->addMinutes(60),
            ['email' => $email]
        );

        Mail::send([], [], function ($message) use ($email, $otp, $resetPasswordUrl) {
            $message->to($email)
                ->subject('Password Reset OTP')
                ->setBody(
                    "Your OTP for password reset is: {$otp}<br><br>" .
                    "Please click <a href=\"{$resetPasswordUrl}\">here</a> to reset your password."
                , 'text/html');
        });

        return response()->json([
            'message' => 'OTP sent successfully',
        ]);
    }
}

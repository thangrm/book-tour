<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailVerifyCodeJob;
use App\Models\User;
use Exception;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    /**
     * Verify code
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|string|regex:/^[a-z][a-z0-9_\.]{3,}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/|exists:users|max:255',
            'type' => 'required|integer|between:1,2',
            'code' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->otp == $request->code && $user->type_otp == $request->type) {
            $user->otp = null;
            $user->save();
            if ($request->type == 2) {
                $token = Password::broker('users')->createToken($user);

                return response()->json([
                    "token" => $token,
                    "email" => $request->email,
                    "message" => "Verification code forgot password success",
                    "success" => true,
                    "type" => $request->type
                ]);
            }

            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
            }

            return response()->json([
                "message" => "Your email has been verified",
                "success" => true,
                "type" => $request->type
            ]);
        }

        return response()->json([
            "message" => "The verification code is incorrect",
            "success" => false,
            "type" => $request->type
        ], 400);
    }

    /**
     * Send code via mail
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|string|regex:/^[a-z][a-z0-9_\.]{3,}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/|exists:users|max:255',
            'type' => 'required|integer|between:1,2'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($request->type == 1 && $user->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 400);
        }

        try {
            $code = rand(1000, 9999);
            $user->otp = $code;
            $user->type_otp = $request->type;
            $user->save();
            dispatch(new SendMailVerifyCodeJob($user, $code));

            return response()->json([
                "message" => "Code verification sent on your email",
                "success" => true,
                "type" => $request->type
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => $e->getMessage(),
                "success" => false,
                "code" => $e->getCode(),
                "type" => $request->type
            ]);
        }

    }
}

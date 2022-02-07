<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailVerifyCodeJob;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /**
     * @param $user_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify($user_id, Request $request)
    {
        $request->validate([
            'type' => 'required|integer|between:1,2',
            'code' => 'required',
        ]);

        $user = User::findOrFail($user_id);
        if ($user->otp == $request->code && $user->type_otp == $request->type) {
            $user->otp = null;
            $user->save();
            if ($request->type == 2) {
                return response()->json([
                    "message" => "Verification Code Success",
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
        ]);
    }

    /**
     * @param $userId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendCode($userId, Request $request)
    {
        $request->validate(['type' => 'required|integer|between:1,2']);

        $user = User::find($userId);
        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }

        if ($request->type == 1 && $user->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 400);
        }

        try {
            $code = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
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

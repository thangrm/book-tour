<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendMailVerifyCodeJob;
use App\Models\PasswordReset;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Login user and create token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|regex:/^[a-z][a-z0-9_\.]{3,}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/|max:255',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                "success" => false,
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized'
                ]
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();

        return response()->json([
            'data' => [
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()
            ]
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out',
            "success" => true
        ]);
    }

    /**
     * Change password for user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|regex:/^[a-z][a-z0-9_\.]{3,}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/|exists:users|max:255',
            'old_password' => 'required|string|max:255',
            'password' => 'required|string|max:255|confirmed'
        ]);

        $current_password = Auth::user()->password;
        if (Hash::check($request->old_password, $current_password)) {
            $user = Auth::user();
            $user->password = bcrypt($request->password);
            $user->save();

            return response()->json([
                'message' => 'Change password successfully!',
                "success" => true,
            ]);
        }

        return response()->json(
            [
                'message' => 'The given data was invalid.',
                "success" => false,
                'errors' => ['password' => 'Old password is invalid.']
            ]);
    }

    /**
     * Change password for user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|regex:/^[a-z][a-z0-9_\.]{3,}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/|exists:users|max:255',
            'password' => 'required|string|max:255|confirmed',
            'token' => 'required|string',
        ]);

        $status = Password::broker('users')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new \Illuminate\Auth\Events\PasswordReset($user));
            }
        );

        return response()->json(['message' => __($status)]);
    }

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
            dispatch(new SendMailVerifyCodeJob($user));

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

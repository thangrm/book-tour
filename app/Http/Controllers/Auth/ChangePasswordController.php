<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use function redirect;
use function view;

class ChangePasswordController extends Controller
{
    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function broker(): \Illuminate\Contracts\Auth\PasswordBroker
    {
        return Password::broker('admins');
    }

    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.auth.change-password');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    /**
     * Handle an incoming password reset link request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8|max:32',
        ]);

        $current_password = Auth::User()->password;
        if (Hash::check($request->old_password, $current_password)) {
            $user_id = Auth::User()->id;
            $obj_user = Admin::find($user_id);
            $obj_user->password = Hash::make($request->password);
            $obj_user->save();

            $notification = array(
                'message' => 'Changed password successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('admin.dashboard')->with($notification);
        }

        return redirect()->back()->withErrors(['old_password' => 'Incorrect Password']);
    }

}

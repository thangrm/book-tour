<?php

namespace App\Models;

use App\Jobs\SendMailVerifyCodeJob;
use App\Libraries\Utilities;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $path = 'public/images/users/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'avatar',
        'first_name',
        'last_name',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Validate rules for user
     *
     * @param $id
     * @return string[]
     */
    public function rules($id = null)
    {
        $rule = [
            'username' => 'required|string|alpha_dash|max:255|unique:users',
            'email' => 'required|string|regex:/^[a-z][a-z0-9_\.]{3,}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/|unique:users|max:255',
            'password' => 'required|string|max:255|confirmed',
            'avatar' => 'image|mimes:jpeg,jpg,png,gif|max:5000|nullable',
            'first_name' => 'string|max:50|nullable',
            'last_name' => 'string|max:50|nullable',
            'address' => 'string|max:255|nullable',
        ];

        if ($id != null) {
            $rule = [
                'avatar' => 'image|mimes:jpeg,jpg,png,gif|max:5000|nullable',
                'first_name' => 'string|max:50|nullable',
                'last_name' => 'string|max:50|nullable',
                'address' => 'string|max:255|nullable',
            ];
        }

        return $rule;
    }

    /**
     * Store a new user in database.
     *
     * @param Request $request
     * @param int $id
     * @return integer
     */
    public function saveUser(Request $request, int $id = 0)
    {
        $input = Utilities::clearAllXSS($request->all());

        $user = $this->findOrNew($id);
        $oldImage = $user->avatar;

        if ($request->hasFile('avatar')) {
            $input['avatar'] = Utilities::storeImage($request->file('avatar'), $this->path);
        }

        if (!empty($request->password)) {
            $input['password'] = bcrypt($request->password);
        }

        $user->fill($input);
        $code = rand(1000, 9999);
        if (!$user->hasVerifiedEmail()) {
            $user->otp = $code;
            $user->type_otp = 1;
        }

        if ($user->save()) {
            if ($request->hasFile('avatar')) {
                Storage::delete($this->path . $oldImage);
            }

            if (!$user->hasVerifiedEmail()) {
                dispatch(new SendMailVerifyCodeJob($user));
            }
        } else {
            Storage::delete($this->path . $user->image);
        }

        return 1;
    }
}

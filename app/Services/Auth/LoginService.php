<?php

namespace App\Services\Auth;

use App\Enums\Deleted;
use App\Enums\Status;
use App\Models\User;
use App\Traits\ThrottleLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginService
{
    use ThrottleLogins;

    public function login(Request $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            throw new \Exception('Too many login attempts. Please try again later.');
        }
        $user = User::where('email', $request->email)
            ->where('deleted', Deleted::NO->value)
            ->first();
        if (empty($user)) {
            $this->incrementLoginAttempts($request);
            throw new \Exception('Invalid Credentials');
        }

        if (!Hash::check($request->password, $user->password)) {
            $this->incrementLoginAttempts($request);
            throw new \Exception('Invalid Credentials');
        }
        if ($user->status != Status::ACTIVE->value) {
            $this->incrementLoginAttempts($request);
            throw new \Exception('Your account is inactive');
        }

        Auth::login($user,$request->remember_me ?? 0);
        $this->clearLoginAttempts($request);

        if ($user->role == User::ROLE_ADMIN) {
            return route('admin.dashboard');
        } elseif ($user->role == User::ROLE_USER) {
            return route('user.dashboard');
        } else {
            Auth::logout();
            throw new \Exception('Invalid Role');
        }
    }

}

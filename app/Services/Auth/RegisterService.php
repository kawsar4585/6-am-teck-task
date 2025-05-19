<?php

namespace App\Services\Auth;

use App\Enums\Deleted;
use App\Enums\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegisterService
{
    public function register(Request $request)
    {

        $user = User::where('email', $request->email)
            ->where('deleted', Deleted::NO->value)
            ->first();
        if (!empty($user)) {
            throw new \Exception('Email already exists');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = User::ROLE_USER;
        $user->status = Status::ACTIVE->value;
        $user->deleted = Deleted::NO->value;
        $user->created_at = Carbon::now();
        $user->save();

        return route('login');
    }

}

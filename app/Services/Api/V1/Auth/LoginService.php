<?php

namespace App\Services\Api\V1\Auth;

use App\Enums\Deleted;
use App\Enums\Status;
use App\Http\Resources\Api\V1\Auth\LoginResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginService
{
    public function login(array $credentials):LoginResource | array
    {
        $user = User::where('email', $credentials['email'])
            ->where('deleted', Deleted::NO->value)
            ->first();

        if (empty($user)) {
            return ['error' => 'Invalid credentials.'];
        }
        if (!Hash::check($credentials['password'], $user->password)) {
            return ['error' => 'Invalid credentials.'];
        }
        if ($user->status != Status::ACTIVE->value) {
            return ['error' => 'Your account is inactive.'];
        }

        $token = JWTAuth::fromUser($user);

        return new LoginResource([
            'user' => $user,
            'token' => $token,
        ]);
    }
}

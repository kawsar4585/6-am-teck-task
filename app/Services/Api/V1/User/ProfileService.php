<?php

namespace App\Services\Api\V1\User;

use App\Http\Resources\Api\V1\UserProfileResource;

class ProfileService
{
    public function getProfile()
    {
        $user = auth('api')->user();

        return new UserProfileResource($user);
    }
}

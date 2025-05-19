<?php

namespace App\Http\Resources\Api\V1\Auth;

use App\Http\Resources\Api\V1\UserProfileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'token' => $this['token'],
            'user' => new UserProfileResource($this['user']),
        ];
    }
}

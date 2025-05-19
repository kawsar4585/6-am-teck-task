<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Api\V1\V1ResponseController;
use App\Services\Api\V1\User\ProfileService;

class ProfileController extends V1ResponseController
{
    private $service;
    public function __construct()
    {
        $this->service = new ProfileService();
    }

    public function profile():\Illuminate\Http\JsonResponse
    {
        $data = $this->service->getProfile();
        return $this->successResponse($data, 'Profile retrieved successfully');
    }
}

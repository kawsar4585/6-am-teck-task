<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\V1ResponseController;
use App\Services\Api\V1\Auth\LoginService;
use App\Traits\ThrottleLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends V1ResponseController
{
    use ThrottleLogins;

    private $service;
    public function __construct()
    {
        $this->service = new LoginService();
    }
    public function login(Request $request)
    {
        try {
            if ($this->hasTooManyLoginAttempts($request)) {
                return response()->json([
                    'message' => 'Too many attempts. Please try again later.',
                ], 429);
            }
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->validationError($validator->errors());
            }

            $response = $this->service->login($request->only('email', 'password'));

            if (isset($response['error'])) {
                $this->incrementLoginAttempts($request);
                return $this->unauthorizedResponse($response['error']);
            }
            $this->clearLoginAttempts($request);
            return $this->successResponse($response, 'Login successful');
        } catch (\Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }
}

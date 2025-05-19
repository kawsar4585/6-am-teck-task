<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseControllers\AuthController;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\RegisterService;

class RegisterController extends AuthController
{
    public function showRegister()
    {
        $this->setPageTitle("Register");
        return $this->view('auth.register');
    }

    public function register(RegisterRequest $request, RegisterService $registerService)
    {
        try {
            $redirectUri = $registerService->register($request);

        } catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([
            'register' => 'success',
            'redirectUri' => $redirectUri,
        ], "Registration Success. Please login to continue.");
    }
}

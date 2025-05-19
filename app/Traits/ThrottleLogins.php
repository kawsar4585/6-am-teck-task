<?php

namespace App\Traits;

use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

trait ThrottleLogins
{
    protected function hasTooManyLoginAttempts($request): bool
    {
        return RateLimiter::tooManyAttempts($this->throttleKey($request), 5); // 5 attempts
    }

    protected function incrementLoginAttempts($request): void
    {
        RateLimiter::hit($this->throttleKey($request), 60); // Lockout time in seconds
    }

    protected function clearLoginAttempts($request): void
    {
        RateLimiter::clear($this->throttleKey($request));
    }

    protected function throttleKey($request): string
    {
        return Str::lower($request->email) . '|' . $request->ip();
    }
}

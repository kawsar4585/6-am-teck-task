<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiCheckUserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = auth('api')->user();

        $roleMap = [
            'admin' => User::ROLE_ADMIN,
            'user' => User::ROLE_USER,
        ];

        if (!isset($roleMap[$role]) || $user->role !== $roleMap[$role]) {
            $response = [
                'message' => 'ERROR',
                'description' => "Unauthorized Request!",
                'errors' => [
                    'detail' => ['You do not have permission to access this resource.']
                ]
            ];
            return response()->json($response, 403);
        }

        return $next($request);
    }
}

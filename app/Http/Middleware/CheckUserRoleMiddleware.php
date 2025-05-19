<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $roleMap = [
            'admin' => User::ROLE_ADMIN,
            'user' => User::ROLE_USER,
        ];

        if (!isset($roleMap[$role]) || $user->role !== $roleMap[$role]) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 403,
                    'message' => 'You do not have permission to access this page.'
                ]);
            }
            return redirect()->back()->with(['failed' => 'You do not have permission to access this page.']);
        }

        return $next($request);
    }
}

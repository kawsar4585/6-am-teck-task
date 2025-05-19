<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiV1AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ((request()->header('ApiAccessToken') === null) || (request()->header('ApiAccessToken') !== config('app.api_access_token'))) {
            $response = [
                'message' => 'ERROR',
                'description' => "Unauthorized!",
                'errors' => [
                    'detail' => ['Access Token Mismatched!']
                ]
            ];
            return response()->json($response, 403);
        }
        return $next($request);
    }
}

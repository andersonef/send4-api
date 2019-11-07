<?php

namespace App\Http\Middleware;

use Closure;
use App\Classes\ApiResponse;

class ApiResponseFormatMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $response = $next($request);
            return new ApiResponse($response->getOriginalContent());
            // return $response;
        } catch (\Exception $e) {
            return new ApiResponse(json_decode($e->getMessage()), false);
        }
    }
}

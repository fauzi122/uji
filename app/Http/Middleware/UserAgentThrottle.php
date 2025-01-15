<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class UserAgentThrottle
{
    public function handle($request, Closure $next)
    {
        $userAgent = $request->header('User-Agent') ?? 'unknown-agent';
        $key = Str::slug($userAgent) . '|' . $request->ip();
        // dd($key);
        // Throttle logic
        if (RateLimiter::tooManyAttempts($key, 500)) {
            return response()->json(['message' => 'Too many requests'], 429);
        }

        RateLimiter::hit($key, 60); // 60 seconds

        return $next($request);
    }
}

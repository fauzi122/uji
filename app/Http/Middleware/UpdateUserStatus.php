<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class UpdateUserStatus
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (!$user->is_online || optional($user->last_seen)->diffInSeconds(now()) > 60) {
                $user->update([
                    'is_online' => true,
                    'last_seen' => now()
                ]);
            }

            // atau pakai Cache:
            // Cache::put('user-is-online-' . $user->id, true, now()->addMinutes(5));
        }
        return $next($request);
    }
}

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
            $userId = Auth::id();

            // Kalau cache user online sudah expired, berarti user "baru aktif lagi"
            if (!Cache::has('user-is-online-' . $userId)) {
                // Update status online di database (opsional)
                Auth::user()->update([
                    'is_online' => true,
                    'last_seen' => now()
                ]);
            }

            // Refresh status online di cache
            Cache::put('user-is-online-' . $userId, true, now()->addMinutes(5));
        }


        return $next($request);
    }
}

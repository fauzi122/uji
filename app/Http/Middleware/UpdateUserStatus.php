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
        $user = Auth::user();
        if (!$user->is_online || $user->last_seen->diffInSeconds(now()) > 60) {
            $user->update([
                'is_online' => true,
                'last_seen' => now()
            ]);
        }

        return $next($request);
    }
}

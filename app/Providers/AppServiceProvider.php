<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use App\Models\ThrottledIp;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('user-agent-based', function (Request $request) {
            $identifier = $request->user()
                ? $request->user()->id . '|' . $request->ip() . '|' . $request->header('User-Agent')
                : $request->ip() . '|' . $request->header('User-Agent');

            // Tentukan limit rate limiter
            $limit = Limit::perMinute(1000)->by($identifier);

            // Tambahkan percobaan untuk hitungan rate limit
            RateLimiter::hit($identifier);

            // Cek apakah sudah melebihi batas
            if (RateLimiter::tooManyAttempts($identifier, 1000)) {
                Log::info('IP melebihi batas: ' . $request->ip());

                ThrottledIp::firstOrCreate(
                    ['ip_address' => $request->ip()], // Cek berdasarkan IP
                    [
                        'user_id' => $request->user() ? $request->user()->id : null,
                        'user_agent' => $request->header('User-Agent'),
                        'throttled_at' => now(),
                    ]
                );
            }

            return $limit;
        });



        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
    }
}

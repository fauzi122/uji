<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use \App\Models\User;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $offlineUsers = User::where('is_online', true)
                ->where('last_seen', '<', now()->subMinutes(5))
                ->get();

            if ($offlineUsers->count() > 0) {
                // Update status
                User::whereIn('id', $offlineUsers->pluck('id'))->update(['is_online' => false]);

                // Tulis log
                Log::info('Scheduler: Menandai user offline', [
                    'waktu' => now()->toDateTimeString(),
                    'jumlah' => $offlineUsers->count(),
                    'user_ids' => $offlineUsers->pluck('id')->toArray()
                ]);
            } else {
                Log::info('Scheduler: Tidak ada user yang perlu di-set offline.', [
                    'waktu' => now()->toDateTimeString()
                ]);
            }
        })->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

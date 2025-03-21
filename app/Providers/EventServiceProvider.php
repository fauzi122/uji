<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\User;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();

        // Saat user login, update status is_online menjadi true
        Event::listen(Login::class, function ($event) {
            if ($event->user) {
                $event->user->update([
                    'is_online' => true,
                    'last_seen' => now()
                ]);

                broadcast(new \App\Events\UserOnlineStatus($event->user));
            }
        });

        // Saat user logout, update status is_online menjadi false
        Event::listen(Logout::class, function ($event) {
            if ($event->user) {
                $event->user->update([
                    'is_online' => false,
                    'last_seen' => now()
                ]);

                broadcast(new \App\Events\UserOnlineStatus($event->user));
            }
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}

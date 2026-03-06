<?php

namespace App\Providers;

use App\Models\User;
use App\Notifications\PasswordResetNotification;
use App\Observers\UserObserver;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;

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
        // Register the UserObserver: auto-creates preferences & sends welcome email
        User::observe(UserObserver::class);

        // Override Laravel's default reset password notification with our Brevo-powered one
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return env('MOBILE_APP_URL_SCHEME', 'yitte://') . 'reset-password?token=' . $token . '&email=' . urlencode($notifiable->getEmailForPasswordReset());
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            return (new PasswordResetNotification($token, $notifiable->getEmailForPasswordReset()))
                ->toMail($notifiable);
        });
    }
}

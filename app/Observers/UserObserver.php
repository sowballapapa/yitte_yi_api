<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserPreference;
use App\Notifications\WelcomeNotification;

class UserObserver
{
    /**
     * Auto-create default preferences when a new user is created.
     */
    public function created(User $user): void
    {
        UserPreference::create([
            'user_id'            => $user->id,
            'theme'              => 'system',
            'language'           => 'fr',
            'timezone'           => 'Africa/Dakar',
            'notification_delay' => 1,
            'notification_unit'  => 'hours',
        ]);

        // Send the welcome notification via Brevo (SMTP)
        $user->notify(new WelcomeNotification($user));
    }
}

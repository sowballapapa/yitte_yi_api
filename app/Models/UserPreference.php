<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPreference extends Model
{
    /** @use HasFactory<\Database\Factories\UserPreferenceFactory> */
    use HasFactory;

    protected $fillable = [
        'theme',
        'language',
        'timezone',
        'notification_delay',
        'notification_unit',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'notification_delay' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns the notification delay converted to minutes.
     */
    public function getDelayInMinutes(): int
    {
        return match ($this->notification_unit) {
            'hours' => $this->notification_delay * 60,
            'days'  => $this->notification_delay * 1440,
            default => $this->notification_delay,
        };
    }
}

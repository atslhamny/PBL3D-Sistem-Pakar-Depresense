<?php

namespace App\Models;

use App\Enums\SessionStatus;
use App\Enums\DepressionLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class ScreeningSession extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'status' => SessionStatus::class,
            'depression_level' => DepressionLevel::class,
            'informed_consent_at' => 'datetime',
            'completed_at' => 'datetime',
            'emergency_triggered' => 'boolean',
            'fuzzy_centroid_value' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(SessionAnswer::class, 'session_id');
    }

    public function scopeForUser(Builder $query, $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', SessionStatus::Completed);
    }

    public function scopeEmergency(Builder $query): Builder
    {
        return $query->where('status', SessionStatus::EmergencyStopped);
    }
}

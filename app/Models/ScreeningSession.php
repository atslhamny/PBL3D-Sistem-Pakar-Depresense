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
            'status'             => SessionStatus::class,
            'depression_level'   => DepressionLevel::class,
            'informed_consent_at'=> 'datetime',
            'expires_at'         => 'datetime',
            'completed_at'       => 'datetime',
            'emergency_triggered'=> 'boolean',
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

    // ── Scopes ───────────────────────────────────────────────────────────────

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

    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('status', SessionStatus::Expired);
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    /**
     * Apakah sesi ini sudah melewati batas waktu 30 menit?
     * Berlaku untuk sesi in_progress yang belum selesai.
     */
    public function isExpired(): bool
    {
        if ($this->status !== SessionStatus::InProgress) {
            return false;
        }

        if (is_null($this->expires_at) || is_null($this->informed_consent_at)) {
            return false; // Data lama tanpa expires_at — tidak dibatasi
        }

        // Kalkulasi berdasarkan selisih waktu mutlak dari informed_consent_at
        // Ini menghindari bug pergeseran zona waktu saat menyimpan/membaca kolom timestamp dari MySQL
        return now()->diffInMinutes($this->informed_consent_at, true) >= 30;
    }

    /**
     * Sisa waktu dalam detik sebelum sesi kadaluarsa.
     * Mengembalikan 0 jika sudah expired.
     */
    public function remainingSeconds(): int
    {
        if (is_null($this->expires_at) || is_null($this->informed_consent_at) || $this->isExpired()) {
            return 0;
        }

        $elapsedSeconds = (int) now()->diffInSeconds($this->informed_consent_at, true);
        $remaining = (30 * 60) - $elapsedSeconds;

        return (int) max(0, $remaining);
    }
}


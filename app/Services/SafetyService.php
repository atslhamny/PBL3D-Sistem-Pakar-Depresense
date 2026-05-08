<?php

namespace App\Services;

use App\Models\ScreeningSession;
use App\Enums\SessionStatus;

class SafetyService
{
    public const SAFETY_ITEM = 9;
    public const EMERGENCY_THRESHOLD = 2;

    public function check(int $itemNumber, int $answerValue): bool
    {
        $safetyItem = config('depresense.safety.item_number', self::SAFETY_ITEM);
        $threshold = config('depresense.safety.threshold', self::EMERGENCY_THRESHOLD);

        if ($itemNumber == $safetyItem && $answerValue >= $threshold) {
            return true;
        }

        return false;
    }

    public function triggerEmergency(ScreeningSession $session): void
    {
        $session->update([
            'status' => SessionStatus::EmergencyStopped,
            'emergency_triggered' => true,
            'emergency_item' => config('depresense.safety.item_number', self::SAFETY_ITEM),
            'completed_at' => now(),
        ]);
    }
}

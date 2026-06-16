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

        return ($itemNumber == $safetyItem && $answerValue >= $threshold);
    }

    /**
     * Flag the session as having triggered a safety alert,
     * but do NOT stop the screening. The user continues answering
     * all questions and sees the full result + emergency banner.
     */
    public function flagSafetyAlert(ScreeningSession $session): void
    {
        // Only flag once — don't override if already flagged
        if (!$session->emergency_triggered) {
            $session->update([
                'emergency_triggered' => true,
                'emergency_item' => config('depresense.safety.item_number', self::SAFETY_ITEM),
            ]);
        }
    }
}

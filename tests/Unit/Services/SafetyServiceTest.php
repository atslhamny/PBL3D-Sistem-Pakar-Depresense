<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\SafetyService;
use App\Models\ScreeningSession;
use App\Enums\SessionStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SafetyServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_returns_true_for_emergency()
    {
        $service = new SafetyService();
        $this->assertTrue($service->check(9, 2));
    }

    public function test_check_returns_false_for_normal_answers()
    {
        $service = new SafetyService();
        $this->assertFalse($service->check(9, 0));
        $this->assertFalse($service->check(9, 1));
        $this->assertFalse($service->check(1, 2));
    }

    public function test_flag_safety_alert_updates_session()
    {
        $service = new SafetyService();
        $session = ScreeningSession::create(['informed_consent_at' => now(), 'status' => SessionStatus::InProgress]);
        
        $service->flagSafetyAlert($session);

        $session->refresh();
        $this->assertEquals(SessionStatus::InProgress, $session->status);
        $this->assertTrue((bool) $session->emergency_triggered);
        $this->assertEquals(9, $session->emergency_item);
        $this->assertNull($session->completed_at);
    }
}

<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_with_complete_data(): void
    {
        $response = $this->post('/register', [
            'full_name' => 'Test User Lengkap',
            'email' => 'test_lengkap@depresense.id',
            'university' => 'Universitas Indonesia',
            'study_program' => 'Sistem Informasi',
            'semester' => 4,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertAuthenticated();
        
        // Cek redirect (skenario pengalihan)
        $response->assertRedirect(route('user.dashboard', absolute: false));
        
        // Cek data tersimpan di DB (skenario penyimpanan data)
        $this->assertDatabaseHas('users', [
            'email' => 'test_lengkap@depresense.id',
            'university' => 'Universitas Indonesia',
            'study_program' => 'Sistem Informasi',
            'semester' => 4,
        ]);
    }

    public function test_registration_fails_if_form_is_empty(): void
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors(['full_name', 'email', 'password']);
    }

    public function test_registration_fails_if_password_mismatched(): void
    {
        $response = $this->post('/register', [
            'full_name' => 'Test User',
            'email' => 'test@depresense.id',
            'password' => 'password123',
            'password_confirmation' => 'salah123',
        ]);

        $response->assertSessionHasErrors(['password']);
    }

    public function test_registration_fails_if_email_is_duplicate(): void
    {
        // Buat user pertama
        \App\Models\User::factory()->create([
            'email' => 'ganda@depresense.id'
        ]);

        // Coba daftar dengan email yang sama
        $response = $this->post('/register', [
            'full_name' => 'Test Ganda',
            'email' => 'ganda@depresense.id',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
    }
}

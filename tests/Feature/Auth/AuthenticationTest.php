<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        // Cek redirect (skenario redirect yang benar)
        $response->assertRedirect(route('user.dashboard', absolute: false));
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email'); // Skenario error pesan login
    }

    public function test_users_can_not_authenticate_with_unregistered_email(): void
    {
        // Skenario Akun Belum Terdaftar
        $response = $this->post('/login', [
            'email' => 'tidakada@depresense.id',
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_authenticated_users_are_redirected_from_login_page(): void
    {
        // Skenario Pencegahan Akses (Guest Middleware)
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        // Akan di-redirect ke /dashboard sesuai RouteServiceProvider/breeze
        $response->assertRedirect('/dashboard');
    }

    public function test_unauthenticated_users_cannot_access_dashboard(): void
    {
        // Skenario Keamanan (Auth Middleware)
        $response = $this->get(route('user.dashboard'));

        // Harus dilempar ke login
        $response->assertRedirect('/login');
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}

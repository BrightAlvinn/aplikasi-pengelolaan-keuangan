<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test landing page is accessible at the root URL with all wireframe elements.
     */
    public function test_landing_page_is_accessible_at_root_url(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertViewIs('landing');
        $response->assertSee('FinTrack');
        $response->assertSee('Kendalikan Keuangan');
        $response->assertSee('Anda Mulai Hari Ini');
        $response->assertSee('Daftar Gratis');
        $response->assertSee('Masuk ke Akun Anda');
        $response->assertSee('Daftar Akun Baru');
        $response->assertSee('Sepertinya anda tertarik dengan web kami');
        $response->assertDontSee('Harga & Lisensi');
        $response->assertDontSee('Daftar dengan Google');
        $response->assertDontSee('Akses FinTrack');
        $response->assertDontSee('FinTrack Security');
    }

    /**
     * Test landing page is accessible via /landing route.
     */
    public function test_landing_page_is_accessible_at_landing_url(): void
    {
        $response = $this->get('/landing');

        $response->assertOk();
        $response->assertViewIs('landing');
    }

    /**
     * Test user can log in with valid credentials.
     */
    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'alvin@fintrack.test',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'alvin@fintrack.test',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test user can register a new account.
     */
    public function test_user_can_register_new_account(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@fintrack.test',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'budi@fintrack.test',
        ]);
        $this->assertAuthenticated();
    }

    /**
     * Test Google demo login connects directly.
     */
    public function test_google_demo_login_authenticates_user(): void
    {
        $response = $this->get(route('auth.google'));

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticated();
    }

    /**
     * Test unauthenticated user cannot access dashboard and is redirected to login.
     */
    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect('/?action=login');
    }

    /**
     * Test authenticated user can access dashboard.
     */
    public function test_authenticated_user_can_access_dashboard(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewIs('dashboard');
    }
}

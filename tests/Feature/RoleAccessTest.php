<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_welcome_page_is_public(): void
    {
        $this->get('/')->assertOk()->assertSee('Belanja nyaman');
    }

    public function test_admin_can_sign_in_and_cannot_open_cashier_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->get('/dashboard')->assertRedirect(route('admin.dashboard'));
        $this->withoutVite();
        $this->get('/admin')->assertOk()->assertSee('Dashboard');
        $this->get('/kasir')->assertForbidden();
    }

    public function test_cashier_can_sign_in_and_cannot_open_admin_page(): void
    {
        $cashier = User::factory()->create(['role' => 'kasir']);

        $this->post('/login', [
            'email' => $cashier->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->get('/dashboard')->assertRedirect(route('cashier.dashboard'));
        $this->get('/kasir')->assertOk()->assertSee('Buat transaksi');
        $this->get('/admin')->assertForbidden();
    }

    public function test_guest_is_redirected_to_login_from_protected_page(): void
    {
        $this->get('/admin')->assertRedirect(route('filament.admin.auth.login'));
    }
}

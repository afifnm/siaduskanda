<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Portal Masuk SIADU');
        $response->assertSee('Khusus Administrator');
        $response->assertDontSee('Akses Cepat');
    }

    public function test_admin_user_can_login_and_is_redirected_to_admin_dashboard(): void
    {
        $admin = User::create([
            'name' => 'Admin Haryanto',
            'email' => 'admin@smkn2kra.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'email' => 'admin@smkn2kra.sch.id',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_non_admin_user_cannot_login(): void
    {
        User::create([
            'name' => 'Petugas Percobaan',
            'email' => 'petugas@smkn2kra.sch.id',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        $response = $this->post('/login', [
            'email' => 'petugas@smkn2kra.sch.id',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('login'));
    }
}

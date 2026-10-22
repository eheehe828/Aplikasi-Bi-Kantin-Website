<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_log_in_with_the_seeded_credentials(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->post(route('login.store'), [
            'username' => 'admin_kantin',
            'password' => 'admin123',
        ]);

        $response->assertRedirectToRoute('admin.dashboard');
        $this->assertAuthenticatedAs(User::query()->where('email', 'admin_kantin')->first());
        $this->get(route('admin.dashboard'))->assertOk()->assertSee('Admin Kantin');
    }

    public function test_student_can_log_in_with_the_seeded_credentials(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->post(route('login.store'), [
            'username' => 'budi_siswa',
            'password' => '123',
        ]);

        $response->assertRedirectToRoute('siswa.dashboard');
        $this->assertAuthenticatedAs(User::query()->where('email', 'budi_siswa')->first());
        $this->get(route('siswa.dashboard'))->assertOk()->assertSee('Budi Siswa');
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->from(route('login'))
            ->post(route('login.store'), [
                'username' => 'admin_kantin',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('username');

        $this->assertGuest();
    }

    public function test_student_cannot_open_the_admin_dashboard(): void
    {
        $student = User::factory()->create(['role' => 'siswa']);

        $this->actingAs($student)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_logout_ends_the_authenticated_session(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->post(route('login.store'), [
            'username' => 'budi_siswa',
            'password' => '123',
        ]);

        $this->post(route('logout'))->assertRedirectToRoute('login');

        $this->assertGuest();
    }
}

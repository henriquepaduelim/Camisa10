<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthContaTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_e_acesso_conta(): void
    {
        $this->seed(DemoSeeder::class);
        $user = User::where('role', 'cliente')->first();

        $login = $this->post('/login', [
            'email' => $user->email,
            'password' => 'Cliente123',
        ]);

        $login->assertRedirect('/conta');

        $res = $this->actingAs($user)->get('/conta');
        $res->assertOk()->assertSee($user->name);
    }
}

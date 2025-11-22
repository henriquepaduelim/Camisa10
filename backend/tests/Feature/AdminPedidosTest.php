<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPedidosTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSeeder::class);
    }

    public function test_admin_atualiza_status_pedido(): void
    {
        $admin = User::where('role', 'admin')->first();
        $pedido = Order::first();

        $response = $this->actingAs($admin, 'sanctum')->patchJson('/api/admin/pedidos/' . $pedido->id . '/status', [
            'status' => 'enviado',
            'comentario' => 'Saiu para entrega',
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('orders', [
            'id' => $pedido->id,
            'status' => 'enviado',
        ]);
    }
}

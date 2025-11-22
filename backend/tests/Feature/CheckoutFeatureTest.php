<?php

namespace Tests\Feature;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\User;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSeeder::class);
    }

    public function test_checkout_com_cupom_e_tamanho(): void
    {
        $user = User::where('role', 'cliente')->first();
        $produto = Product::first();
        $size = ProductSize::where('product_id', $produto->id)->first();
        $cupom = Coupon::where('codigo', 'BEMVINDO10')->first();

        // adiciona item ao carrinho autenticado
        $this->actingAs($user, 'sanctum')->postJson('/api/carrinho', [
            'product_id' => $produto->id,
            'product_size_id' => $size->id,
            'quantidade' => 1,
        ])->assertCreated();

        // aplica cupom
        $this->actingAs($user, 'sanctum')->postJson('/api/carrinho/cupom', ['codigo' => $cupom->codigo]);

        $payload = [
            'cliente' => [
                'nome' => $user->name,
                'email' => $user->email,
                'telefone' => $user->telefone,
            ],
            'endereco' => [
                'nome' => $user->name,
                'cep' => '01000-000',
                'rua' => 'Rua Teste',
                'numero' => '123',
                'cidade' => 'São Paulo',
                'estado' => 'SP',
            ],
            'pagamento' => [
                'metodo' => 'pix',
            ],
        ];

        $res = $this->actingAs($user, 'sanctum')->postJson('/api/checkout', $payload);
        $res->assertCreated();

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'status' => 'pago',
        ]);
    }
}

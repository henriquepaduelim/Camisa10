<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductSize;
use App\Services\CartService;
use App\Services\CheckoutService;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CartService $cartService;
    protected CheckoutService $checkoutService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSeeder::class);
        $this->cartService = app(CartService::class);
        $this->checkoutService = app(CheckoutService::class);
    }

    public function test_checkout_cria_pedido(): void
    {
        $cart = Cart::first();
        $produto = Product::first();
        $size = ProductSize::where('product_id', $produto->id)->first();
        $this->cartService->addItem($cart, $produto->id, $size->id, 1);

        $order = $this->checkoutService->checkout($cart, [
            'nome' => 'Teste',
            'email' => 'teste@example.com',
        ], [
            'nome' => 'Teste',
            'cep' => '01000-000',
            'rua' => 'Rua',
            'cidade' => 'SP',
            'estado' => 'SP',
        ], 'pix');

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => $order->status,
        ]);
    }
}

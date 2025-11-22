<?php

namespace Tests\Unit;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductSize;
use App\Services\CartService;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CartService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSeeder::class);
        $this->service = app(CartService::class);
    }

    public function test_adiciona_item_com_tamanho(): void
    {
        $cart = Cart::create(['subtotal' => 0, 'desconto' => 0, 'total' => 0]);
        $produto = Product::first();
        $size = ProductSize::where('product_id', $produto->id)->first();

        $cart = $this->service->addItem($cart, $produto->id, $size->id, 2);

        $this->assertEquals(2, $cart->items->first()->quantidade);
        $this->assertGreaterThan(0, $cart->total);
    }

    public function test_aplica_cupom_valido(): void
    {
        $cart = Cart::first();
        $produto = Product::first();
        $size = ProductSize::where('product_id', $produto->id)->first();
        $cupom = Coupon::where('codigo', 'BEMVINDO10')->first();

        $this->service->addItem($cart, $produto->id, $size->id, 1);
        $cart = $this->service->applyCoupon($cart, $cupom->codigo);

        $this->assertEquals($cupom->id, $cart->coupon_id);
        $this->assertGreaterThan(0, $cart->desconto);
    }
}

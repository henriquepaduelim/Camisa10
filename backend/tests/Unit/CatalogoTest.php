<?php

namespace Tests\Unit;

use App\Services\ProductService;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogoTest extends TestCase
{
    use RefreshDatabase;

    public function test_listagem_produtos_filtra_por_categoria(): void
    {
        $this->seed(DemoSeeder::class);
        $service = app(ProductService::class);

        $result = $service->list(['categoria' => 'clubes'], 10);

        $this->assertGreaterThan(0, $result->count());
    }
}

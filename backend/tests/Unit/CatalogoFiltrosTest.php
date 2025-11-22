<?php

namespace Tests\Unit;

use App\Services\ProductService;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogoFiltrosTest extends TestCase
{
    use RefreshDatabase;

    protected ProductService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DemoSeeder::class);
        $this->service = app(ProductService::class);
    }

    public function test_filtra_por_clube(): void
    {
        $result = $this->service->list(['clube' => 'flamengo'], 10);
        $this->assertGreaterThan(0, $result->count());
        $this->assertTrue($result->every(fn ($p) => $p->club?->slug === 'flamengo'));
    }

    public function test_filtra_por_liga(): void
    {
        $result = $this->service->list(['liga' => 'la-liga'], 10);
        $this->assertGreaterThan(0, $result->count());
        $this->assertTrue($result->every(fn ($p) => $p->league?->slug === 'la-liga'));
    }

    public function test_filtra_por_categoria(): void
    {
        $result = $this->service->list(['categoria' => 'clubes'], 10);
        $this->assertGreaterThan(0, $result->count());
        $this->assertTrue($result->every(fn ($p) => $p->category?->slug === 'clubes'));
    }

    public function test_filtra_por_preco_minimo(): void
    {
        $result = $this->service->list(['preco_min' => 400], 10);
        $this->assertGreaterThan(0, $result->count());
        $this->assertTrue($result->every(fn ($p) => $p->preco >= 400));
    }
}

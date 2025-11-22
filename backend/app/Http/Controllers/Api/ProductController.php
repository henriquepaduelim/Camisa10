<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $service) {}

    public function index(Request $request)
    {
        $produtos = $this->service->list($request->all(), $request->integer('per_page', 12));

        return response()->json([
            'data' => $produtos->items(),
            'meta' => [
                'current_page' => $produtos->currentPage(),
                'last_page' => $produtos->lastPage(),
                'total' => $produtos->total(),
            ],
        ]);
    }

    public function show(string $slug)
    {
        $produto = Product::with(['images', 'sizes', 'club', 'league', 'category'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json(['data' => $produto]);
    }
}

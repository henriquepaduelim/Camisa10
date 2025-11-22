<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $produtos = Product::with(['images', 'sizes', 'club', 'league', 'category'])
            ->latest()
            ->paginate(20);

        return response()->json(['data' => $produtos]);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);
        $this->syncRelations($product, $data);

        return response()->json(['data' => $product->load('images', 'sizes')], 201);
    }

    public function show(Product $produto)
    {
        return response()->json(['data' => $produto->load('images', 'sizes', 'club', 'league', 'category')]);
    }

    public function update(ProductRequest $request, Product $produto)
    {
        $data = $request->validated();
        $produto->update($data);
        $this->syncRelations($produto, $data);

        return response()->json(['data' => $produto->load('images', 'sizes')]);
    }

    public function destroy(Product $produto)
    {
        $produto->delete();

        return response()->json(status: 204);
    }

    protected function syncRelations(Product $product, array $data): void
    {
        if (isset($data['imagens'])) {
            $product->images()->delete();
            foreach ($data['imagens'] as $imagem) {
                $product->images()->create($imagem);
            }
        }

        if (isset($data['tamanhos'])) {
            $product->sizes()->delete();
            foreach ($data['tamanhos'] as $tamanho) {
                $product->sizes()->create($tamanho);
            }
        }
    }
}

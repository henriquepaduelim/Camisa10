<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Club;
use App\Models\League;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $produtos = Product::with('category', 'club', 'league')->latest()->paginate(15);
        $categorias = Category::all();
        $clubes = Club::all();
        $ligas = League::all();

        return view('admin.products', compact('produtos', 'categorias', 'clubes', 'ligas'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $product = Product::create($data);
        $this->syncRelations($product, $request);

        return back()->with('success', 'Produto criado.');
    }

    public function update(Request $request, Product $produto)
    {
        $data = $this->validateData($request, $produto->id);
        $produto->update($data);
        $this->syncRelations($produto, $request);

        return back()->with('success', 'Produto atualizado.');
    }

    public function edit(Product $produto)
    {
        $produto->load('sizes', 'images');
        $categorias = Category::all();
        $clubes = Club::all();
        $ligas = League::all();

        return view('admin.product_edit', compact('produto', 'categorias', 'clubes', 'ligas'));
    }

    public function destroy(Product $produto)
    {
        $produto->delete();
        return back()->with('success', 'Produto removido.');
    }

    protected function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . ($id ?? 'NULL'),
            'preco' => 'required|numeric|min:0',
            'preco_promocional' => 'nullable|numeric|min:0',
            'descricao' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'club_id' => 'nullable|exists:clubs,id',
            'league_id' => 'nullable|exists:leagues,id',
            'ativo' => 'nullable|boolean',
            'destaque' => 'nullable|boolean',
            'mais_vendido' => 'nullable|boolean',
            'imagens_url' => 'nullable|array',
            'imagens_url.*' => 'nullable|url',
            'imagens_alt' => 'nullable|array',
            'tamanho_nome' => 'nullable|array',
            'tamanho_preco' => 'nullable|array',
            'tamanho_estoque' => 'nullable|array',
        ], [
            'required' => 'Campo obrigatório.',
            'unique' => 'Valor já utilizado.',
        ]);
    }

    protected function syncRelations(Product $product, Request $request): void
    {
        // Imagens
        $urls = $request->input('imagens_url', []);
        $alts = $request->input('imagens_alt', []);
        if (!empty($urls)) {
            $product->images()->delete();
            foreach ($urls as $idx => $url) {
                if (!$url) {
                    continue;
                }
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => $url,
                    'alt' => $alts[$idx] ?? null,
                    'principal' => $idx === 0,
                    'ordem' => $idx + 1,
                ]);
            }
        }

        // Tamanhos
        $nomes = $request->input('tamanho_nome', []);
        $precos = $request->input('tamanho_preco', []);
        $estoques = $request->input('tamanho_estoque', []);
        if (!empty($nomes)) {
            $product->sizes()->delete();
            foreach ($nomes as $i => $nome) {
                if (!$nome) {
                    continue;
                }
                ProductSize::create([
                    'product_id' => $product->id,
                    'tamanho' => $nome,
                    'preco' => $precos[$i] ?? null,
                    'estoque' => $estoques[$i] ?? 0,
                ]);
            }
        }
    }
}

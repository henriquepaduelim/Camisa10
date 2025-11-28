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
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'club', 'league')->latest();

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('nome', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }
        if ($category = $request->input('category_id')) {
            $query->where('category_id', $category);
        }
        if ($club = $request->input('club_id')) {
            $query->where('club_id', $club);
        }
        if ($league = $request->input('league_id')) {
            $query->where('league_id', $league);
        }
        if ($status = $request->input('status')) {
            if ($status === 'ativo') {
                $query->where('ativo', true);
            } elseif ($status === 'inativo') {
                $query->where('ativo', false);
            }
        }

        $produtos = $query->paginate(15)->withQueryString();
        $categorias = Category::all();
        $clubes = Club::all();
        $ligas = League::all();

        return view('admin.products', [
            'produtos' => $produtos,
            'categorias' => $categorias,
            'clubes' => $clubes,
            'ligas' => $ligas,
            'filtros' => $request->only(['q', 'category_id', 'club_id', 'league_id', 'status']),
        ]);
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
        try {
            $produto->delete();
            return back()->with('success', 'Produto removido.');
        } catch (QueryException $e) {
            // FK constraint (produtos vinculados a pedidos/carrinhos) gera erro 23503 no Postgres.
            if ($e->getCode() === '23503') {
                return back()->with('error', 'Não é possível remover: produto ligado a pedidos ou carrinhos.');
            }
            return back()->with('error', 'Erro ao remover produto.');
        }
    }

    public function toggleStatus(Request $request, Product $produto)
    {
        $data = $request->validate([
            'ativo' => 'required|boolean',
        ]);
        $produto->update(['ativo' => $data['ativo']]);

        return back()->with('success', 'Status atualizado.');
    }

    protected function validateData(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . ($id ?? 'NULL'),
            'preco' => 'required|numeric|min:0',
            'preco_promocional' => 'nullable|numeric|min:0',
            'descricao' => 'nullable|string',
            'descricao_curta' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'club_id' => 'nullable|exists:clubs,id',
            'league_id' => 'nullable|exists:leagues,id',
            'ativo' => 'nullable|boolean',
            'destaque' => 'nullable|boolean',
            'hero' => 'nullable|boolean',
            'hero_order' => 'nullable|integer|min:1|max:10',
            'mais_vendido' => 'nullable|boolean',
            'imagens_url' => 'nullable|array',
            'imagens_url.*' => 'nullable|url',
            'imagens_alt' => 'nullable|array',
            'imagens_upload' => 'nullable|array',
            'imagens_upload.*' => 'file|image|max:2048',
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
        $uploads = $request->file('imagens_upload', []);
        $principalIdx = is_numeric($request->input('imagens_principal')) ? (int)$request->input('imagens_principal') : 0;
        $seq = 0;
        if (!empty($urls) || !empty($uploads)) {
            $product->images()->delete();
            foreach ($urls as $idx => $url) {
                if (!$url) {
                    continue;
                }
                $isPrincipal = $seq === $principalIdx;
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => $url,
                    'alt' => $alts[$idx] ?? null,
                    'principal' => $isPrincipal,
                    'ordem' => $seq + 1,
                ]);
                $seq++;
            }
            foreach ($uploads as $i => $file) {
                if (!$file) {
                    continue;
                }
                $path = $file->store('products', 'public');
                $isPrincipal = $seq === $principalIdx;
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => Storage::url($path),
                    'alt' => $alts[$i] ?? null,
                    'principal' => $isPrincipal,
                    'ordem' => $seq + 1,
                ]);
                $seq++;
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

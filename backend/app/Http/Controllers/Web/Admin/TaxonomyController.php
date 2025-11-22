<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Club;
use App\Models\League;
use Illuminate\Http\Request;

class TaxonomyController extends Controller
{
    public function index()
    {
        $categorias = Category::all();
        $clubes = Club::all();
        $ligas = League::all();

        return view('admin.taxonomies', compact('categorias', 'clubes', 'ligas'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
        ]);
        Category::create($data);
        return back()->with('success', 'Categoria criada.');
    }

    public function storeClub(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:clubs,slug',
            'pais' => 'nullable|string|max:100',
        ]);
        Club::create($data);
        return back()->with('success', 'Clube criado.');
    }

    public function storeLeague(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:leagues,slug',
            'pais' => 'nullable|string|max:100',
        ]);
        League::create($data);
        return back()->with('success', 'Liga criada.');
    }

    public function destroyCategory(Category $categoria)
    {
        $categoria->delete();
        return back()->with('success', 'Categoria removida.');
    }

    public function destroyClub(Club $clube)
    {
        $clube->delete();
        return back()->with('success', 'Clube removido.');
    }

    public function destroyLeague(League $liga)
    {
        $liga->delete();
        return back()->with('success', 'Liga removida.');
    }
}

<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TaxonomyRequest;
use App\Models\Category;
use App\Models\Club;
use App\Models\League;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class TaxonomyController extends Controller
{
    protected array $map = [
        'categorias' => Category::class,
        'clubes' => Club::class,
        'ligas' => League::class,
    ];

    public function index(Request $request)
    {
        $model = $this->resolveModel($request);
        return response()->json(['data' => $model::paginate(50)]);
    }

    public function store(TaxonomyRequest $request)
    {
        $model = $this->resolveModel($request);
        $created = $model::create($request->validated());

        return response()->json(['data' => $created], 201);
    }

    public function show(Request $request, $id)
    {
        $model = $this->resolveModel($request);
        $item = $model::findOrFail($id);

        return response()->json(['data' => $item]);
    }

    public function update(TaxonomyRequest $request, $id)
    {
        $model = $this->resolveModel($request);
        $item = $model::findOrFail($id);
        $item->update($request->validated());

        return response()->json(['data' => $item]);
    }

    public function destroy(Request $request, $id)
    {
        $model = $this->resolveModel($request);
        $item = $model::findOrFail($id);
        $item->delete();

        return response()->json(status: 204);
    }

    protected function resolveModel(Request $request): string
    {
        $tipo = $request->segment(3);
        return $this->map[$tipo] ?? abort(404, 'Recurso não encontrado.');
    }
}

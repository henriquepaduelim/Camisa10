<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TaxonomyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $table = match ($this->segment(3)) {
            'clubes' => 'clubs',
            'ligas' => 'leagues',
            default => 'categories',
        };

        $routeKey = match ($table) {
            'clubs' => 'clube',
            'leagues' => 'liga',
            default => 'categoria',
        };

        $id = $this->route($routeKey)?->id ?? null;

        return [
            'nome' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:' . $table . ',slug,' . $id,
            'parent_id' => 'nullable|integer',
            'pais' => 'nullable|string|max:100',
            'logo' => 'nullable|string|max:255',
        ];
    }
}

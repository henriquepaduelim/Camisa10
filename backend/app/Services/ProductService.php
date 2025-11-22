<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function list(array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::with(['images', 'sizes', 'club', 'league', 'category'])->ativos();

        if (!empty($filters['clube'])) {
            $query->whereHas('club', fn ($q) => $q->where('slug', $filters['clube']));
        }

        if (!empty($filters['liga'])) {
            $query->whereHas('league', fn ($q) => $q->where('slug', $filters['liga']));
        }

        if (!empty($filters['categoria'])) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $filters['categoria']));
        }

        if (!empty($filters['tamanho'])) {
            $query->whereHas('sizes', fn ($q) => $q->where('tamanho', $filters['tamanho']));
        }

        if (!empty($filters['preco_min'])) {
            $query->where('preco', '>=', $filters['preco_min']);
        }

        if (!empty($filters['preco_max'])) {
            $query->where('preco', '<=', $filters['preco_max']);
        }

        if (!empty($filters['ordem'])) {
            $this->applySorting($query, $filters['ordem']);
        } else {
            $query->latest();
        }

        return $query->paginate($perPage);
    }

    protected function applySorting($query, string $ordem): void
    {
        match ($ordem) {
            'preco_asc' => $query->orderBy('preco', 'asc'),
            'preco_desc' => $query->orderBy('preco', 'desc'),
            'recentes' => $query->latest(),
            'populares' => $query->orderByDesc('mais_vendido'),
            default => $query->latest(),
        };
    }
}

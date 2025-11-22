<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'slug',
        'category_id',
        'club_id',
        'league_id',
        'descricao',
        'preco',
        'preco_promocional',
        'moeda',
        'ativo',
        'destaque',
        'mais_vendido',
        'lancamento',
        'sku',
        'tags',
        'estoque_total',
    ];

    protected $casts = [
        'tags' => 'array',
        'ativo' => 'boolean',
        'destaque' => 'boolean',
        'mais_vendido' => 'boolean',
        'lancamento' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function scopeAtivos($query)
    {
        return $query->where('ativo', true);
    }
}

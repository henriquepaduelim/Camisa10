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
        'descricao_curta',
        'preco',
        'preco_promocional',
        'moeda',
        'ativo',
        'destaque',
        'hero',
        'hero_order',
        'mais_vendido',
        'lancamento',
        'sku',
        'meta_title',
        'meta_description',
        'tags',
        'estoque_total',
    ];

    protected $casts = [
        'tags' => 'array',
        'ativo' => 'boolean',
        'destaque' => 'boolean',
        'hero' => 'boolean',
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

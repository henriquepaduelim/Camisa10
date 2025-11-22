<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'slug',
        'pais',
        'logo',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

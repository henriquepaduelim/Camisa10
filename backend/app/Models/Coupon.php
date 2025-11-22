<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'tipo',
        'valor',
        'valor_minimo',
        'limite_uso',
        'usos',
        'expira_em',
        'ativo',
    ];

    protected $casts = [
        'expira_em' => 'datetime',
        'ativo' => 'boolean',
    ];

    public function isValidForTotal(float $total): bool
    {
        $notExpired = !$this->expira_em || $this->expira_em->isFuture();
        $underLimit = !$this->limite_uso || $this->usos < $this->limite_uso;
        $meetsMin = !$this->valor_minimo || $total >= $this->valor_minimo;

        return $this->ativo && $notExpired && $underLimit && $meetsMin;
    }
}

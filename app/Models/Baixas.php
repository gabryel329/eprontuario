<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baixas extends Model
{
    use HasFactory;

    protected $fillable = [
        'conta_financeira_id',
        'user_id',
        'tipo_pagamento',
        'valor_pagamento',
        'banco_id',
        'forma_pagamento',
        'numero_documento',
        'observacao',
        'motivo_glosa',
    ];

    public function contaFinanceira()
    {
        return $this->belongsTo(ContasFinanceiras::class);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function banco()
    {
        return $this->belongsTo(Bancos::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaGuia extends Model
{
    use HasFactory;

    protected $fillable = [
        'conta_financeira_id',
        'guia_id',
        'tipo_guia',
        'lote',
    ];

    public function guia()
    {
        if ($this->tipo_guia === 'Consulta') {
            return $this->belongsTo(GuiaConsulta::class, 'guia_id');
        } elseif ($this->tipo_guia === 'SP') {
            return $this->belongsTo(GuiaSp::class, 'guia_id');
        }

        return null; // Caso não seja nenhuma das opções
    }

    public function contaFinanceira()
    {
        return $this->belongsTo(ContasFinanceiras::class, 'conta_financeira_id');
    }
}

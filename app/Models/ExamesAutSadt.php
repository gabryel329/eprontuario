<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamesAutSadt extends Model
{
    use HasFactory;

    // Nome da tabela
    protected $table = 'exames_aut_sadt';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'guia_sps_id',
        'data_real',
        'hora_inicio_atendimento',
        'hora_fim_atendimento',
        'tabela',
        'codigo_procedimento_realizado',
        'descricao_procedimento_realizado',
        'quantidade_autorizada',
        'via',
        'tecnica',
        'fator_red_acres',
        'valor_unitario',
        'valor_total',
    ];

    // Relacionamento com GuiaSps
    public function guiaSps()
    {
        return $this->belongsTo(GuiaSp::class, 'guia_sps_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuiaHonorario extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'convenio_id',
        'registro_ans',
        'numero_guia_solicitacao',
        'numero_guia_prestador',
        'senha',
        'numero_guia_operadora',
        'numero_carteira',
        'nome_social',
        'atendimento_rn',
        'nome_beneficiario', 
        'codigo_operadora_contratado', 
        'nome_hospital_local', 
        'codigo_cnes_contratado',
        'nome_contratado', 
        'codigo_operadora_executante', 
        'codigo_cnes_executante', 
        'data_inicio_faturamento', 
        'data_fim_faturamento', 
        'observacoes', 
        'valor_total_honorarios',
        'data_emissao',
        'assinatura_profissional_executante',
    ];
public function convenio()
{
    return $this->belongsTo(Convenio::class, 'convenio_id');
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
}

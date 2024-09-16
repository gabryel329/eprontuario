<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuiaHonorario extends Model
{
    use HasFactory;

    protected $table = 'guia_honorarios';

    protected $fillable = [
        'registro_ans',
        'num_guia_solicitacao_internacao',
        'senha',
        'num_guia_atribuido_operadora',
        'numero_carteira',
        'nome_social',
        'atendimento_rn',
        'nome',
        'codigo_operadora',
        'nome_hospital',
        'codigo_operadora_contratado',
        'nome_contratado',
        'codigo_cnes',
        'data_inicio_faturamento',
        'data_fim_faturamento',
        'data',
        'hora_inicial',
        'hora_final',
        'tabela',
        'codigo_procedimento',
        'descricao',
        'quantidade',
        'via',
        'tecnica',
        'fator_reducao',
        'valor_unitario',
        'valor_total',
        'seq_ref',
        'grau_part',
        'codigo_operadora_profissional',
        'cpf_profissional',
        'nome_profissional',
        'conselho',
        'numero_conselho',
        'uf_conselho',
        'codigo_cbo',
        'observacoes',
        'valor_total_honorarios',
        'data_emissao',
        'assinatura_profissional'
    ];
}

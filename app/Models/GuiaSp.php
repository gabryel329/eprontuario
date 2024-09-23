<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuiaSp extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guia_sps';

    protected $fillable = [
        'user_id',
        'convenio_id',
        'registro_ans',
        'numero_guia_prestador',
        'numero_carteira',
        'nome_beneficiario',
        'data_atendimento',
        'hora_inicio_atendimento',
        'tipo_consulta',
        'indicacao_acidente',
        'codigo_tabela',
        'codigo_procedimento',
        'valor_procedimento',
        'nome_profissional',
        'sigla_conselho',
        'numero_conselho',
        'uf_conselho',
        'cbo',
        'observacao',
        'hash',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    }
}

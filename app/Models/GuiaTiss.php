<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuiaTiss extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'guia_consulta';

    protected $fillable = [
        'user_id',
        'convenio_id',
        'registro_ans', // 1 - Registro ANS
        'numero_guia_operadora', // 3 - Número da Guia Atribuído pela Operadora
        'numero_carteira', // 4 - Número da Carteira
        'validade_carteira', // 5 - Validade da Carteira
        'atendimento_rn', // 6 - Atendimento a RN (Sim ou Não)
        'nome_social', // 26 - Nome Social
        'nome_beneficiario', // 7 - Nome do Beneficiário
        'codigo_operadora', // 9 - Código na Operadora
        'nome_contratado', // 10 - Nome do Contratado
        'codigo_cnes', // 11 - Código CNES
        'nome_profissional_executante', // 12 - Nome do Profissional Executante
        'conselho_profissional', // 13 - Conselho Profissional
        'numero_conselho', // 14 - Número no Conselho
        'uf_conselho', // 15 - UF do Conselho
        'codigo_cbo', // 16 - Código CBO
        'indicacao_acidente', // 17 - Indicação de Acidente
        'indicacao_cobertura_especial', // 27 - Indicação de Cobertura Especial
        'regime_atendimento', // 28 - Regime de Atendimento
        'saude_ocupacional', // 29 - Saúde Ocupacional
        'data_atendimento', // 18 - Data do Atendimento
        'tipo_consulta', // 19 - Tipo de Consulta
        'codigo_tabela', // 20 - Código da Tabela
        'codigo_procedimento', // 21 - Código do Procedimento
        'valor_procedimento', // 22 - Valor do Procedimento
        'observacao', // 23 - Observação
        'assinatura_profissional_executante', // 24 - Assinatura do Profissional Executante
        'assinatura_beneficiario', // 25 - Assinatura do Beneficiário ou Responsável
        'hash', // Hash para validação de integridade
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

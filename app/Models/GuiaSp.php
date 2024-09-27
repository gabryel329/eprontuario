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
        'registro_ans',                  // 1 - Registro ANS
        'numero_guia_prestador',          // 3 - Nº da Guia do Prestador
        'data_autorizacao',               // 4 - Data da autorização
        'senha',                          // 5 - Senha
        'validade_senha',                 // 6 - Data de Validade da Senha
        'numero_guia_op',                 // 7 - Nº da Guia Atribuído pela Operadora
        'numero_carteira',                // 8 - Nº da Carteira
        'validade_carteira',              // 9 - Validade da Carteira
        'nome_beneficiario',              // 10 - Nome Beneficiário
        'atendimento_rn',                 // 12 - Atendimento a RN
        'codigo_operadora',               // 13 - Código na Operadora
        'nome_contratado',                // 14 - Nome do Contratado
        'nome_profissional_solicitante',  // 15 - Nome do Profissional Solicitante
        'conselho_profissional',          // 16 - Conselho Profissional
        'numero_conselho',                // 17 - Número do Conselho
        'uf_conselho',                    // 18 - UF do Conselho
        'codigo_cbo',                     // 19 - Código CBO
        'assinatura_profissional',        // 20 - Assinatura do Profissional Solicitante
        'carater_atendimento',            // 21 - Caráter do Atendimento
        'data_solicitacao',               // 22 - Data da Solicitação
        'indicacao_clinica',              // 23 - Indicação Clínica
        'codigo_procedimento_solicitado', // 25 - Código do Procedimento Solicitado
        'descricao_procedimento',         // 26 - Descrição do Procedimento
        'codigo_operadora_executante',    // 29 - Código da Operadora Executante
        'nome_contratado_executante',     // 30 - Nome do Contratado Executante
        'codigo_cnes',                    // 31 - Código CNES
        'tipo_atendimento',               // 32 - Tipo de Atendimento
        'indicacao_acidente',             // 33 - Indicação de Acidente
        'tipo_consulta',                  // 34 - Tipo de Consulta
        'motivo_encerramento',            // 35 - Motivo de Encerramento
        'regime_atendimento',             // 91 - Regime de Atendimento
        'saude_ocupacional',              // 92 - Saúde Ocupacional
        'tabela',                         // 36 - Tabela
        'hora_inicio_atendimento',        // 37 - Hora Início Atendimento
        'hora_fim_atendimento',           // 38 - Hora Fim Atendimento
        'codigo_procedimento_realizado',  // 39 - Código do Procedimento Realizado
        'descricao_procedimento_realizado',// 41 - Descrição do Procedimento Realizado
        'quantidade_solicitada',          // 42 - Quantidade Solicitada
        'quantidade_autorizada',          // 28 - Quantidade Autorizada
        'via',                            // 43 - Via
        'tecnica',                        // 44 - Técnica
        'valor_unitario',                 // 46 - Valor Unitário
        'valor_total',                    // 47 - Valor Total
        'codigo_operadora_profissional',  // 50 - Código da Operadora/CPF
        'nome_profissional',              // 51 - Nome do Profissional
        'sigla_conselho',                 // 52 - Sigla do Conselho
        'numero_conselho_profissional',   // 53 - Número do Conselho Profissional
        'uf_profissional',                // 54 - UF do Conselho Profissional
        'codigo_cbo_profissional',        // 55 - Código CBO Profissional
        'data_realizacao',                // 56 - Data de Realização do Procedimento
        'assinatura_beneficiario',        // 57 - Assinatura do Beneficiário ou Responsável
        'observacao',                     // 58 - Observação / Justificativa
        'hash',                           // Hash para validação de integridade
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

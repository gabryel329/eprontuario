<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia de SP/SADT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            border: 1px solid black;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .small-text {
            font-size: 10px;
        }

        .large-text {
            font-size: 18px;
        }

        .right-text {
            text-align: right;
        }

        .no-border {
            border: none !important;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <h2>SB SAÚDE</h2>
            <h3>GUIA DE SERVIÇO PROFISSIONAL / SERVIÇO AUXILIAR DE DIAGNÓSTICO E TERAPIA - SP/SADT</h3>
            <h3 style="text-align: right;">2 - Nº Guia no Prestador: {{ $guia->numero_guia_prestador }}</h3>
        </div>

        <!-- Primeira parte da tabela -->
        <table>
            <tr>
                <td>1 - Registro ANS: {{ $guia->registro_ans }}</td>
                <td>3 - Número da Guia Principal: {{ $guia->numero_guia_principal }}</td>
                <td>4 - Data da Autorização: {{ $guia->data_autorizacao }}</td>
            </tr>
            <tr>
                <td>5 - Senha: {{ $guia->senha }}</td>
                <td>6 - Data de Validade da Senha: {{ $guia->data_validade_senha }}</td>
                <td>7 - Número da Guia Atribuído pela Operadora: {{ $guia->numero_guia_operadora }}</td>
            </tr>
        </table>

        <!-- Dados do Beneficiário -->
        <table>
            <tr>
                <td>8 - Número da Carteira: {{ $guia->numero_carteira }}</td>
                <td>9 - Validade da Carteira: {{ $guia->validade_carteira }}</td>
                <td>89 - Nome Social: {{ $guia->nome_social }}</td>
            </tr>
            <tr>
                <td>12 - Atendimento a RN: {{ $guia->atendimento_rn ? 'Sim' : 'Não' }}</td>
                <td colspan="2">10 - Nome: {{ $guia->nome_beneficiario }}</td>
            </tr>
        </table>

        <!-- Dados do Solicitante -->
        <table>
            <tr>
                <td>13 - Código da Operadora: {{ $guia->codigo_operadora_solicitante }}</td>
                <td>14 - Nome do Contratado: {{ $guia->nome_contratado_solicitante }}</td>
            </tr>
            <tr>
                <td>15 - Nome do Profissional Solicitante: {{ $guia->nome_profissional_solicitante }}</td>
                <td>16 - Conselho Profissional: {{ $guia->conselho_profissional }}</td>
                <td>17 - Número do Conselho: {{ $guia->numero_conselho }}</td>
            </tr>
            <tr>
                <td>18 - UF: {{ $guia->uf_conselho }}</td>
                <td>19 - Código CBO: {{ $guia->codigo_cbo }}</td>
                <td>20 - Assinatura do Profissional Solicitante</td>
            </tr>
        </table>

        <!-- Procedimentos ou Itens Assistenciais Solicitados -->
        <table>
            <tr>
                <td>21 - Carteira de Atendimento: {{ $guia->carteira_atendimento }}</td>
                <td>22 - Data da Solicitação: {{ $guia->data_solicitacao }}</td>
                <td>23 - Indicação Clínica: {{ $guia->indicacao_clinica }}</td>
            </tr>
        </table>

        <!-- Dados do Contratante Executante -->
        <table>
            <tr>
                <td>29 - Código na Operadora: {{ $guia->codigo_operadora_executante }}</td>
                <td>30 - Nome do Contratado: {{ $guia->nome_contratado_executante }}</td>
                <td>31 - Código CNES: {{ $guia->codigo_cnes }}</td>
            </tr>
        </table>

        <!-- Dados do Atendimento -->
        <table>
            <tr>
                <td>32 - Tipo de Atendimento: {{ $guia->tipo_atendimento }}</td>
                <td>33 - Indicação de Acidente (acidente ou doença relacionada): {{ $guia->indicacao_acidente }}</td>
                <td>34 - Tipo de Consulta: {{ $guia->tipo_consulta }}</td>
                <td>35 - Motivo de Encerramento do Atendimento: {{ $guia->motivo_encerramento }}</td>
                <td>91 - Regime de Atendimento: {{ $guia->regime_atendimento }}</td>
                <td>92 - Saúde Ocupacional: {{ $guia->saude_ocupacional }}</td>
            </tr>
        </table>

        <!-- Procedimentos e Exames Realizados -->
        <table>
            <tr>
                <th>Data</th>
                <th>Hora Inicial</th>
                <th>Hora Final</th>
                <th>Tabela</th>
                <th>Código do Procedimento</th>
                <th>Descrição</th>
                <th>Qtd</th>
                <th>Via</th>
                <th>Téc.</th>
                <th>Fator Red.</th>
                <th>Valor Unitário-R$</th>
                <th>Valor Total-R$</th>
            </tr>
            <!-- Exemplo de linhas -->
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <!-- Identificação do(s) Profissional(is) Executante(s) -->
        <table>
            <tr>
                <td>48 - Seq. Ref.: </td>
                <td>49 - Grau Part.: </td>
                <td>50 - Código da Operadora/CPF: </td>
                <td>51 - Nome do Profissional: </td>
                <td>52 - Conselho Profissional: </td>
                <td>53 - Número do Conselho:</td>
                <td>54 - UF: </td>
                <td>55 - Código CBO:</td>
            </tr>
        </table>

        <!-- Observação/Justificativa -->
        <table>
            <tr>
                <td>58 - Observação/Justificativa: {{ $guia->observacoes }}</td>
            </tr>
        </table>

        <!-- Rodapé -->
        <table>
            <tr>
                <td>59 - Total Procedimento R$: {{ $guia->total_procedimento }}</td>
                <td>66 - Assinatura do Responsável pela Autorização: {{ $guia->assinatura_responsavel }}</td>
            </tr>
            <tr>
                <td>67 - Assinatura do Beneficiário ou Responsável: {{ $guia->assinatura_beneficiario }}</td>
                <td>68 - Assinatura do Contratado: {{ $guia->assinatura_contratado }}</td>
            </tr>
        </table>
    </div>

</body>

</html>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia de Consulta</title>
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
            <h3>GUIA DE CONSULTA</h3>
            <h3 style="text-align: right;">2 - Nº Guia no Prestador: {{ $guia->numero_guia_prestador }}</h3>
        </div>

        <!-- Primeira parte da tabela -->
        <table>
            <tr>
                <td>1 - Registro ANS: {{ $guia->registro_ans }}</td>
                <td>3 - Número da Guia Atribuída pela Operadora: {{ $guia->numero_guia_operadora }}</td>
            </tr>
        </table>

        <!-- Dados do Beneficiário -->
        <table>
            <tr>
                <td>4 - Número da Carteira: {{ $guia->numero_carteira }}</td>
                <td>5 - Validade da Carteira: {{ $guia->validade_carteira }}</td>
                <td>6 - Atendimento a RN (Sim ou Não): {{ $guia->atendimento_rn }}</td>
            </tr>
            <tr>
                <td>26 - Nome Social: {{ $guia->nome_social }}</td>
                <td colspan="2">7 - Nome: {{ $guia->nome_beneficiario }}</td>
            </tr>
        </table>

        <!-- Dados do Contratado -->
        <table>
            <tr>
                <td>9 - Código na Operadora: {{ $guia->codigo_operadora_contratado }}</td>
                <td colspan="2">10 - Nome do Contratado: {{ $guia->nome_contratado }}</td>
            </tr>
            <tr>
                <td>11 - Código CNES: {{ $guia->codigo_cnes }}</td>
                <td>12 - Nome do Profissional Executante: {{ $guia->nome_profissional_executante }}</td>
            </tr>
            <tr>
                <td>13 - Conselho Profissional: {{ $guia->conselho_profissional }}</td>
                <td>14 - Número no Conselho: {{ $guia->numero_conselho }}</td>
                <td>15 - UF: {{ $guia->uf }}</td>
                <td>16 - Código CBO: {{ $guia->codigo_cbo }}</td>
            </tr>
        </table>

        <!-- Dados do Atendimento / Procedimento Realizado -->
        <table>
            <tr>
                <td>17 - Indicação de Acidente (acidente ou doença relacionada): {{ $guia->indicacao_acidente }}</td>
                <td>27 - Indicação de Cobertura Especial: {{ $guia->indicacao_cobertura_especial }}</td>
                <td>28 - Regime de Atendimento: {{ $guia->regime_atendimento }}</td>
                <td>29 - Saúde Ocupacional: {{ $guia->saude_ocupacional }}</td>
            </tr>
            <tr>
                <td>18 - Data do Atendimento: {{ $guia->data_atendimento }}</td>
                <td>19 - Tipo de Consulta: {{ $guia->tipo_consulta }}</td>
                <td>20 - Tabela: {{ $guia->tabela }}</td>
                <td>21 - Código do Procedimento: {{ $guia->codigo_procedimento }}</td>
                <td>22 - Valor do Procedimento: {{ $guia->valor_procedimento }}</td>
            </tr>
        </table>

        <!-- Observação / Justificativa -->
        <table>
            <tr>
                <td>23 - Observação/Justificativa: {{ $guia->observacoes }}</td>
            </tr>
        </table>

        <!-- Assinaturas -->
        <table>
            <tr>
                <td>24 - Assinatura do Profissional Executante: {{ $guia->assinatura_profissional_executante }}</td>
                <td>25 - Assinatura do Beneficiário ou Responsável: {{ $guia->assinatura_beneficiario }}</td>
            </tr>
        </table>
    </div>

</body>

</html>

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
            <h3 style="text-align: right;">2 - Nº Guia no Prestador: - </h3>
        </div>

        <!-- Primeira parte da tabela -->
        <table>
            <tr>
                <td>1 - Registro ANS: {{ $convenio->ans }}</td>
                <td>3 - Número da Guia Atribuída pela Operadora: - </td>
            </tr>
        </table>

        <!-- Dados do Beneficiário -->
        <table>
            <tr>
                <td>4 - Número da Carteira: {{ $paciente->matricula }}</td>
                <td>5 - Validade da Carteira: {{ $paciente->validade }}</td>
                <td>6 - Atendimento a RN (Sim ou Não): - </td>
            </tr>
            <tr>
                <td>26 - Nome Social: {{ $paciente->nome_social }}</td>
                <td colspan="2">7 - Nome: {{ $paciente->name }}</td>
            </tr>
        </table>

        <!-- Dados do Contratado -->
        <table>
            <tr>
                <td>9 - Código na Operadora: {{ $convenio->ans }} </td>
                <td colspan="2">10 - Nome do Contratado: {{ $convenio->nome }} </td>
            </tr>
            <tr>
                <td>11 - Código CNES: - </td>
                <td>12 - Nome do Profissional Executante: {{ $profissional->name }}</td>
            </tr>
            <tr>
                <td>13 - Conselho Profissional: {{ $profissional->conselho_profissional }}</td>
                <td>14 - Número no Conselho: {{ $profissional->conselho }}</td>
                <td>15 - UF: {{ $profissional->uf }}</td>
                <td>16 - Código CBO: - </td>
            </tr>
        </table>

        <!-- Dados do Atendimento / Procedimento Realizado -->
        <table>
            <tr>
                <td>17 - Indicação de Acidente (acidente ou doença relacionada): - </td>
                <td>27 - Indicação de Cobertura Especial: - </td>
                <td>28 - Regime de Atendimento: - </td>
                <td>29 - Saúde Ocupacional: - </td>
            </tr>
            <tr>
                <td>18 - Data do Atendimento: {{ $agenda->data }}</td>
                <td>19 - Tipo de Consulta: - </td>
                <td>20 - Tabela: - </td>
                <td>21 - Código do Procedimento: {{ $agenda->codigo }}</td>
                <td>22 - Valor do Procedimento: - </td>
            </tr>
        </table>

        <!-- Observação / Justificativa -->
        <table>
            <tr>
                <td>23 - Observação/Justificativa: - </td>
            </tr>
        </table>

        <!-- Assinaturas -->
        <table>
            <tr>
                <td>24 - Assinatura do Profissional Executante: </td>
                <td>25 - Assinatura do Beneficiário ou Responsável: </td>
            </tr>
        </table>
    </div>

</body>

</html>

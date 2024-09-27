<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia de Honorários</title>
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
            <h2>{{ $empresa->name }}</h2>
            <h3>GUIA DE HONORÁRIOS</h3>
            <h3 style="text-align: right;">2 - Nº Guia do prestador: {{ $guia->numero_guia_prestador }}</h3>
        </div>

        <!-- Primeira parte da tabela -->
        <table>
            <tr>
                <td>1 - Registro ANS: {{ $guia->registro_ans }}</td>
                <td>3 - Nº Guia de solicitação de internação: {{ $guia->numero_guia_solicitacao }}</td>
            </tr>
            <tr>
                <td>4 - Senha: {{ $guia->senha }}</td>
                <td>5 - Número da Guia Atribuída pela Operadora: {{ $guia->numero_guia_operadora }}</td>
            </tr>
        </table>

        <!-- Dados do Beneficiário -->
        <table>
            <tr>
                <td colspan="2">6 - Número da Carteira: {{ $guia->numero_carteira }}</td>
                <td colspan="3">41 - Nome Social: {{ $guia->nome_social }}</td>
            </tr>
            <tr>
                <td>8 - Atendimento a RN: {{ $guia->atendimento_rn ? 'Sim' : 'Não' }}</td>
                <td colspan="3">7 - Nome do Beneficiário: {{ $guia->nome_beneficiario }}</td>
            </tr>
        </table>

        <!-- Dados do Contratado -->
        <table>
            <tr>
                <td>9 - Código da Operadora: {{ $guia->codigo_operadora_contratado }}</td>
                <td colspan="2">10 - Nome do Hospital/Local: {{ $guia->nome_hospital_local }}</td>
            </tr>
            <tr>
                <td>12 - Código na Operadora: {{ $guia->codigo_operadora_executante }}</td>
                <td colspan="2">13 - Nome do Contratado: {{ $guia->nome_contratado }}</td>
            </tr>
            <tr>
                <td>14 - Código CNES: {{ $guia->codigo_cnes_executante }}</td>
                <td></td>
            </tr>
        </table>

        <!-- Procedimentos Realizados -->
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
            <!-- Repetir essas linhas conforme necessário -->
            <tr>
                <td>01</td>
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

        <!-- Identificação do(s) Profissional(is) -->
        <table>
            <tr>
                <td>Seq. Ref.</td>
                <td>Grau Part.</td>
                <td>Código na Operadora/CPF</td>
                <td>Nome do Profissional</td>
                <td>Conselho Profissional</td>
                <td>Número do Conselho</td>
                <td>UF</td>
                <td>Código CBO</td>
            </tr>
        </table>

        <!-- Observações/Justificativa -->
        <table>
            <tr>
                <td>Observações/Justificativa: {{ $guia->observacoes }}</td>
            </tr>
            <tr>
                <td style="height: 100px;"></td>
            </tr>
        </table>

        <!-- Rodapé -->
        <table>
            <tr>
                <td>Data de emissão: {{ $guia->data_emissao }}</td>
                <td>Assinatura do profissional Executante: {{ $guia->assinatura_profissional_executante }}</td>
            </tr>
        </table>
    </div>

</body>

</html>

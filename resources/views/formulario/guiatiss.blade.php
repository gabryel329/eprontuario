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
            background-color: #fff;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #000;
            box-sizing: border-box;
            /* Garante que a borda seja considerada no cálculo de largura */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-section .empresa-info {
            display: flex;
            align-items: center;
        }

        .header-section .empresa-info img {
            max-width: 50px;
            margin-right: 10px;
            /* Espaço entre a imagem e o nome */
        }

        .header-section .empresa-info .name {
            margin: 0;
        }

        .header-section .address {
            text-align: right;
        }

        /* Para células sem bordas */
        .no-border {
            border: none !important;
        }

        .section-title {
            background-color: #eae7d3;
            /* Cor de fundo semelhante ao modelo fornecido */
            font-weight: bold;
            text-align: left;
            padding: 5px;
        }

        .table-heading {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .signature {
            height: 50px;
        }

        .right-align {
            text-align: right;
        }

        .block {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .block>div {
            flex: 1;
            border: 1px solid #000;
            padding: 5px;
            margin-right: 5px;
        }

        .block>div:last-child {
            margin-right: 0;
        }

        /* Estilo para impressão */
        @media print {
            @page {
                size: A4 landscape;
                /* Define a orientação da página como paisagem */
                margin: 20mm;
                /* Define margens para a impressão */
            }

            body {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                /* Garante que o conteúdo use a folha inteira */
            }

            .container {
                width: 100%;
                border: none;
                /* Remove borda ao imprimir */
                padding: 0;
                /* Remove padding no modo de impressão */
                margin: 0;
                box-sizing: border-box;
            }
        }
    </style>

    <script>
        window.onload = function() {
            window.print(); // Dispara o diálogo de impressão quando a página carrega
        }
    </script>
</head>

<body>

    <div class="container">
        <!-- Cabeçalho -->
        @if ($empresa)
            <div class="header-section">
                <div class="empresa-info">
                    <img src="{{ asset('images/' . $empresa->imagem) }}" alt="{{ $empresa->nome }}">
                    <div class="name">
                        <h4>{{ $empresa->name }}</h4>
                    </div>
                </div>

                <div class="text-center flex-grow">
                    <h3>GUIA DE CONSULTA</h3>
                </div>

                <div class="address">
                    <p>{{ $empresa->rua }}</p>
                    <p>{{ $empresa->bairro }}, {{ $empresa->cep }}</p>
                </div>
            </div>
        @else
            <p style="text-align: center;">Nenhuma empresa encontrada.</p>
        @endif
        <h3 class="right-align">2 - Nº Guia no Prestador: ____________</h3>

        <!-- Primeira Parte: Registro ANS e Número da Guia -->
        <div class="block">
            <div>1 - Registro ANS: <strong>{{ $convenio->ans }}</strong></div>
            <div>3 - Número da Guia Atribuída pela Operadora: ___________________</div>
        </div>

        <!-- Seção: Dados do Beneficiário -->
        <div class="section-title">Dados do Beneficiário</div>
        <div class="block">
            <div>4 - Número da Carteira: <strong>{{ $paciente->matricula }}</strong></div>
            <div>5 - Validade da Carteira: <strong>{{ $paciente->validade }}</strong></div>
            <div>6 - Atendimento a RN (Sim ou Não):  
                <strong>
                    @if (\Carbon\Carbon::parse($paciente->nasc)->year == \Carbon\Carbon::now()->year)
                        Sim
                    @else
                        Não
                    @endif
                </strong>
            </div>
        </div>
        <div class="block">
            <div>26 - Nome Social: <strong>{{$paciente->nome_social}}</strong> </div>
            <div>7 - Nome: <strong>{{$paciente->name}}</strong> </div>
        </div>

        <!-- Seção: Dados do Contratado -->
        <div class="section-title">Dados do Contratado</div>
        <div class="block">
            <div>9 - Código na Operadora: ___________________</div>
            <div>10 - Nome do Contratado:  <strong>{{$empresa->name}}</strong> </div>
        </div>
        <div class="block">
            <div>11 - Código CNES: ___________________</div>
            <div>12 - Nome do Profissional Executante:  <strong>{{$profissional->name}}</strong> </div>
        </div>
        <div class="block">
            <div>13 - Conselho Profissional: ___________________</div>
            <div>14 - Número no Conselho: ___________________</div>
            <div>15 - UF: ______</div>
            <div>16 - Código CBO: ___________________</div>
        </div>

        <!-- Seção: Dados do Atendimento -->
        <div class="section-title">Dados do Atendimento / Procedimento Realizado</div>
        <div class="block">
            <div>17 - Indicação de Acidente (acidente ou doença relacionada): ______</div>
            <div>27 - Indicação de Cobertura Especial: ______</div>
            <div>28 - Regime de Atendimento: ______</div>
            <div>29 - Saúde Ocupacional: ______</div>
        </div>
        <div class="block">
            <div>18 - Data do Atendimento: ___/___/___</div>
            <div>19 - Tipo de Consulta: ___________________</div>
            <div>20 - Tabela: ___________________</div>
            <div>21 - Código do Procedimento: ___________________</div>
            <div>22 - Valor do Procedimento: ___________________</div>
        </div>

        <!-- Observação / Justificativa -->
        <div class="section-title">Observação / Justificativa</div>
        <div class="block">
            <div>23 - Observação/Justificativa: ___________________</div>
        </div>

        <!-- Assinaturas -->
        <div class="block">
            <div class="signature">24 - Assinatura do Profissional Executante: ___________________</div>
            <div class="signature">25 - Assinatura do Beneficiário ou Responsável: ___________________</div>
        </div>

    </div>

</body>

</html>

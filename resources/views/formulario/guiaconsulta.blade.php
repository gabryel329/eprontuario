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
        <h3 class="right-align">2 - Nº Guia no Prestador: {{ $guia->numero_guia_operadora }}</h3>

        <!-- Primeira Parte: Registro ANS e Número da Guia -->
        <div class="block">
            <div>1 - Registro ANS: <strong>{{ $guia->registro_ans }}</strong></div>
            <div>3 - Número da Guia Atribuída pela Operadora: <strong>{{ $guia->numero_guia_operadora }}</strong></div>
        </div>

        <!-- Seção: Dados do Beneficiário -->
        <div class="section-title">Dados do Beneficiário</div>
        <div class="block">
            <div>4 - Número da Carteira: <strong>{{ $guia->numero_carteira ?? ''}}</strong></div>
            <div>5 - Validade da Carteira:
                <strong>{{ \Carbon\Carbon::parse($guia->validade_carteira ?? '')->format('d/m/Y') }}</strong>
            </div>
            <div>6 - Atendimento a RN (Sim ou Não):
                <strong>
                    @if ($guia->atendimento_rn == 'S')
                        Sim
                    @else
                        Não
                    @endif
                </strong>
            </div>
        </div>
        <div class="block">
            <div>26 - Nome Social: <strong>{{$guia->nome_social ?? ''}}</strong> </div>
            <div>7 - Nome: <strong>{{$guia->nome_beneficiario ?? ''}}</strong> </div>
        </div>

        <!-- Seção: Dados do Contratado -->
        <div class="section-title">Dados do Contratado</div>
        <div class="block">
            <div>9 - Código na Operadora: <strong>{{ $guia->codigo_operadora ?? ''}}</strong></div>
            <div>10 - Nome do Contratado:  <strong>{{$empresa->name}}</strong> </div>
        </div>
        <div class="block">
            <div>11 - Código CNES: <strong>{{ $guia->codigo_cnes ?? ''}}</strong></div>
            <div>12 - Nome do Profissional Executante: <strong>{{$guia->nome_profissional_executante ?? ''}}</strong> </div>
        </div>
        <div class="block">
            <div>13 - Conselho Profissional: <strong>{{$guia->conselho_profissional ?? ''}}</strong> </div>
            <div>14 - Número no Conselho: <strong>{{$guia->numero_conselho ?? ''}}</strong> </div>
            <div>15 - UF: <strong>{{$guia->uf_conselho ?? ''}}</strong> </div>
            <div>16 - Código CBO: <strong>{{$guia->codigo_cbo ?? ''}}</strong></div>
        </div>

        <!-- Seção: Dados do Atendimento -->
        <div class="section-title">Dados do Atendimento / Procedimento Realizado</div>
        <div class="block">
            <div>17 - Indicação de Acidente (acidente ou doença relacionada):
                <strong>
                   {{$guia->indicacao_acidente}}
                </strong>
            </div>
            <div>27 - Indicação de Cobertura Especial
                <strong>
                    {{$guia->indicacao_cobertura_especial}}
                </strong>
            </div>
            <div>28 - Regime de Atendimento
                <strong>
                    {{$guia->regime_atendimento}}
                </strong>
            </div>
            <div>29 - Saúde Ocupacional
                <strong>
                   {{$guia->saude_ocupacional}}
                </strong>
            </div>
        </div>
        <div class="block">
            <div>18 - Data do Atendimento:<strong>{{ \Carbon\Carbon::parse($guia->data_atendimento ?? '')->format('d/m/Y')}}</strong></div>
            <div>19 - Tipo de Consulta
                <strong>
                    {{$guia->tipo_consulta}}
                </strong>
            </div>
            <div>20 - Tabela <strong>{{$guia->codigo_tabela ?? ''}}</strong></div>
            <div>21 - Código do Procedimento: <strong>{{$guia->codigo_procedimento ?? ''}}</strong> </div>
            <div>22 - Valor do Procedimento <strong>{{$guia->valor_procedimento ?? ''}}</strong></div>
        </div>

        <!-- Observação / Justificativa -->
        <div class="section-title">Observação / Justificativa</div>
        <div class="block">
            <div>23 - Observação/Justificativa <strong>{{$guia->observacao ?? ''}}</strong></div>
        </div>

        <!-- Assinaturas -->
        <div class="block">
            <div class="signature">24 - Assinatura do Profissional Executante: ___________________</div>
            <div class="signature">25 - Assinatura do Beneficiário ou Responsável: ___________________</div>
        </div>

    </div>

</body>

</html>

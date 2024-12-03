<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia de Impressão</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            background-color: #fff;
        }

        @media print {
            .page-break {
                page-break-before: always;
                break-before: page;
            }
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #000;
            box-sizing: border-box;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            font-size: 12px;
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
        }

        .section-title {
            background-color: #eae7d3;
            font-weight: bold;
            text-align: left;
            padding: 5px;
        }

        .signature {
            height: 50px;
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

        .procedimento-table,
        .despesas-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 10px;
        }

        .line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 10px;
        }

        .input-block {
            display: inline-block;
            padding: 0 5px;
            border-bottom: 1px solid #000;
        }

        .small-field {
            width: 50px;
        }

        .medium-field {
            width: 120px;
        }

        .large-field {
            width: 500px;
        }

        .center {
            text-align: center;
        }
    </style>
    <script>
        window.onload = function() {
            window.print(); // Dispara o diálogo de impressão quando a página carrega
        }
    </script>
</head>
@php
    $totalValorTotal2 = 0; // Inicialize a variável

    foreach ($medicamentos as $medicamento) {
        $totalValorTotal2 += $medicamento->valor_total; // Acumula os valores totais
    }

    $totalValorTotal3 = 0; // Inicialize a variável

    foreach ($materiais as $material) {
        $totalValorTotal3 += $material->valor_total; // Acumula os valores totais
    }
@endphp

<body>
    <!-- Início da Guia SADT-->
    <div class="container">
        <!-- Cabeçalho da Guia SADT-->
        <div class="header-section">
            <div class="empresa-info">
                <img src="{{ asset('images/' . $empresa->imagem) }}" alt="{{ $empresa->nome }}">
                <div class="name">
                    <h4>{{ $empresa->nome }}</h4>
                </div>
            </div>
            <div class="text-center flex-grow">
                <h3>GUIA DE SERVIÇO PROFISSIONAL- SP/SADT</h3>
            </div>
            <div class="address">
                <p>2- Nº Guia no Prestador <br> <strong>{{ $guia->numero_guia_op ?? '' }}</strong></p>
            </div>
        </div>

        <!-- Primeira Seção: Registro ANS e Guia-->
        <div class="block">
            <div class="small-field">1- Registro ANS: <br> <strong>{{ $guia->registro_ans ?? '' }}</strong></div>
            <div class="large-field">3- Nº Guia Principal: <br>
                <strong>{{ $guia->numero_guia_prestador ?? '' }}</strong>
            </div>
        </div>
        <div class="block">
            <div class="medium-field">4- Data da autorização: <br>
                <strong>{{ isset($guia->data_autorizacao) ? \Carbon\Carbon::parse($guia->data_autorizacao)->format('d/m/Y') : '__/__/____' }}</strong>
            </div>
            <div class="medium-field">5- Senha: <br> <strong>{{ $guia->senha ?? '' }}</strong></div>
            <div class="medium-field">6- Validade da Senha: <br>
                <strong>{{ isset($guia->validade_senha) ? \Carbon\Carbon::parse($guia->validade_senha)->format('d/m/Y') : '__/__/____' }}</strong>
            </div>
            <div class="large-field">7- Nº Guia Operadora: <br> <strong>{{ $guia->numero_guia_op ?? '' }}</strong>
            </div>
        </div>

        <!-- Dados do Beneficiário-->
        <div class="section-title">Dados do Beneficiário</div>
        <div class="block">
            <div class="small-field">8- Nº da Carteira: <br> <strong>{{ $guia->numero_carteira ?? '' }}</strong></div>
            <div class="small-field">9- Validade da Carteira: <br>
                <strong>{{ isset($guia->validade_senha) ? \Carbon\Carbon::parse($guia->validade_carteira)->format('d/m/Y') : '__/__/____' }}</strong>
            </div>
            <div class="small-field">10- Nome: <br> <strong>{{ $guia->nome_beneficiario ?? '' }}</strong></div>
            <div class="small-field">11- Cartão Nacional de Saúde: <br> <strong>{{ $guia->cns ?? '' }}</strong></div>
            <div class="small-field center">12- Atendimento RN: <br>
                <strong>{{ $guia->atendimento_rn === 1 ? 'Sim' : 'Não' }} </strong>
            </div>
        </div>

        <!-- Dados do Solicitante-->
        <div class="section-title">Dados do Solicitante</div>
        <div class="block">
            <div>13- Código na Operadora: <strong>{{ $guia->codigo_operadora ?? '' }}</strong></div>
            <div>14- Nome do Contratado: <strong>{{ $guia->nome_contratado ?? '' }}</strong></div>
        </div>

        <div class="block">
            <div class="small-field">15- Nome Prof. Solicitante: <br>
                <strong>{{ $guia->nome_profissional_solicitante ?? '' }}</strong></div>
            <div class="small-field center">16- Conselho: <br>
                <strong>{{ $guia->conselho_profissional ?? '' }}</strong> </div>
            <div class="small-field center">17- Nº Conselho: <br> <strong>{{ $guia->numero_conselho ?? '' }}</strong>
            </div>
            <div class="small-field center">18- UF: <br> <strong>{{ $guia->uf_conselho ?? '' }}</strong></div>
            <div class="small-field center">19- CBO: <br> <strong>{{ $guia->codigo_cbo ?? '' }}</strong></div>
            <div class="small-field">20- Assinatura Prof. Solicitante: <br>
                <strong>{{ $guia->assinatura ?? '' }}</strong></div>
        </div>

        <!-- Dados do Procedimento Solicitado-->
        <div class="section-title">Dados da Solicitação / Procedimentos e Exames Solicitados</div>
        <div class="block">
            <div class="small-field center">21- Caráter de Atendimento: <br>
                (<strong>{{ $guia->carater_atendimento ?? '' }}</strong>)</div>
            <div class="small-field center">22- Data da Solicitação: <br>
                <strong>{{ isset($guia->validade_senha) ? \Carbon\Carbon::parse($guia->data_solicitacao)->format('d/m/Y') : '__/__/____' }}</strong>
            </div>
            <div class="small-field">23- Indicação Clínica: <br> <strong>{{ $guia->indicacao_clinica ?? '' }}</strong>
            </div>
            <div class="small-field">90- Indicador de Cobertura Especial: <br>
                <strong>{{ $guia->indicacao_cob_especial ?? '' }}</strong>
            </div>
        </div>

        <!-- Procedimentos-->
        <div class="block">
            <div class="container">
                <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>24- Tabela</th>
                            <th>25- Código do Procedimento</th>
                            <th>26- Descrição</th>
                            <th>27- Qtde. Sol.</th>
                            <th>28- Qtde. Aut.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ExameSolis as $ExameSoli)
                            <tr>
                                <td>{{ $ExameSoli->tabela ?? '' }}</td>
                                <td>{{ $ExameSoli->codigo_procedimento_solicitado ?? '' }}</td>
                                <td>{{ $ExameSoli->descricao_procedimento ?? '' }}</td>
                                <td>{{ $ExameSoli->qtd_sol ?? '' }}</td>
                                <td>{{ $ExameSoli->qtd_aut ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Dados do Executante-->
        <div class="section-title">Dados do Contratado Executante</div>
        <div class="block">
            <div>29- Código Operadora: <br> <strong>{{ $guia->codigo_operadora ?? '' }}</strong></div>
            <div>30- Nome Contratado: <br> <strong>{{ $guia->nome_contratado ?? '' }}</strong></div>
            <div>31- CNES: <br> <strong>{{ $guia->codigo_cnes ?? '' }}</strong></div>
        </div>

        <!-- Dados do Atendimento-->
        <div class="section-title">Dados do Atendimento</div>
        <div class="block center">
            <div>32- Tipo de Atendimento: <br> (<strong>{{ $guia->tipo_atendimento ?? '(  )' }}</strong>)</div>
            <div>33- Indicação de Acidente: <br> (<strong>{{ $guia->indicacao_acidente ?? '(  )' }}</strong>)</div>
            <div>34- Tipo de Consulta: <br> (<strong>{{ $guia->tipo_consulta ?? '(  )' }}</strong>)</div>
            <div>35- Motivo de Encerramento: <br> (<strong>{{ $guia->motivo_encerramento ?? '(  )' }}</strong>)</div>
            <div>91- Regime Atendimento: <br> (<strong>{{ $guia->regime_atendimento ?? '(  )' }}</strong>)</div>
            <div>92- Saúde Ocupacional: <br> (<strong>{{ $guia->saude_ocupacional ?? '(  )' }}</strong>)</div>
        </div>
        <!-- Procedimentos e Exames Realizados-->
        <div class="section-title">Dados da Execução / Procedimentos e Exames Realizados</div>
        <div class="container">
            <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th>36- Data</th>
                        <th>37- Hora Inicial</th>
                        <th>38- Hora Final</th>
                        <th>39- Tabela</th>
                        <th>40- Código do Procedimento</th>
                        <th>41- Descrição</th>
                        <th>42- Qtde.</th>
                        <th>43- Via</th>
                        <th>44- Téc.</th>
                        <th>45- Fator Red./Acre.</th>
                        <th>46- Valor Unitário (R$)</th>
                        <th>47- Valor Total (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalValorTotal = 0;
                    @endphp

                    @foreach ($ExameAuts as $ExameAut)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($ExameAut->data_real)->format('d/m/Y') ?? '____/____/____' }}
                            </td>
                            <td>{{ $ExameAut->hora_inicio_atendimento ?? '____:____' }}</td>
                            <td>{{ $ExameAut->hora_fim_atendimento ?? '____:____' }}</td>
                            <td>{{ $ExameAut->tabela ?? '|__|__|' }}</td>
                            <td>{{ $ExameAut->codigo_procedimento_realizado ?? '|__|__|__|__|__|__|__|__|' }}</td>
                            <td>{{ $ExameAut->descricao_procedimento_realizado ?? '_________________________________________' }}
                            </td>
                            <td>{{ $ExameAut->quantidade_autorizada ?? '|__|__|__|' }}</td>
                            <td>{{ $ExameAut->via ?? '|__|' }}</td>
                            <td>{{ $ExameAut->tecnica ?? '|__|' }}</td>
                            <td>{{ $ExameAut->fator_red_acres ?? '|__|__|__|,|__|__|' }}</td>
                            <td>{{ number_format($ExameAut->valor_unitario, 2, ',', '.') ?? '|__|__|__|__|,|__|__|' }}
                            </td>
                            <td>
                                {{ number_format($ExameAut->valor_total, 2, ',', '.') ?? '|__|__|__|__|,|__|__|' }}
                            </td>
                        </tr>
                        @php
                            $totalValorTotal += $ExameAut->valor_total;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section-title">Identificação do(s) Profissional(is) Executante(s)</div>
        <div class="block center">
            <div>48- Seq.Ref: <br> <strong>{{ $guia->sequencia ?? '  ' }}</strong></div>
            <div>49- Grau Part: <br> <strong>{{ $guia->grua ?? '  ' }}</strong></div>
            <div>50- Códigoo na Operadora/CPF: <br> <strong>{{ $guia->codigo_operadora_profissional ?? '  ' }}</strong>
            </div>
            <div>51- Nome do Profissional: <br> <strong>{{ $guia->nome_profissional ?? '  ' }}</strong></div>
            <div>52- Conselho: <br> <strong>{{ $guia->sigla_conselho ?? '  ' }}</strong></div>
            <div>53- Nº do Conselho: <br> <strong>{{ $guia->numero_conselho_profissional ?? '  ' }}</strong></div>
            <div>54- UF: <br> <strong>{{ $guia->uf_profissional ?? '  ' }}</strong></div>
            <div>55- CBO: <br> <strong>{{ $guia->codigo_cbo_profissional ?? '  ' }}</strong></div>
        </div>

        <!-- Assinaturas-->
        <div class="section-title">56- Data de Realização de Procedimentos em Série // 57- Assinatura do Beneficiário ou
            Responsável</div>
        <div class="block">
            <div>1- <strong> ____/____/______ ______________________________</strong></div>
            <div>2- <strong>____/____/______ _______________________________</strong></div>
            <div>3- <strong> ____/____/______ ______________________________</strong></div>
            <div>4- <strong> ____/____/______ ______________________________</strong></div>
            <div>5- <strong> ____/____/______ ______________________________</strong></div>
        </div>
        <div class="block">
            <div>6- <strong> ____/____/______ ______________________________</strong></div>
            <div>7- <strong> ____/____/______ ______________________________</strong></div>
            <div>8- <strong> ____/____/______ ______________________________</strong></div>
            <div>9- <strong> ____/____/______ ______________________________</strong></div>
            <div>10- <strong> ____/____/______ ______________________________</strong></div>
        </div>

        <!-- Observação / Justificativa-->
        <div class="block">
            <div>58- Observação / Justificativa: <br> <strong>{{ $guia->observacao ?? '' }}</strong></div>
        </div>
        <div class="block">
            <div>
                <span>59- Total Proc.</span><br>
                <strong>R$ {{ number_format($totalValorTotal, 2, ',', '.') }}</strong>
            </div>
            <div>
                <span>60- Total Taxas</span><br>
                <strong>R$0,00</strong>
            </div>
            <div>
                <span>61- Total Mat.</span><br>
                <strong>R$ {{ number_format($totalValorTotal3, 2, ',', '.') }}</strong>
            </div>
            <div>
                <span>62- Total de OPME</span><br>
                <strong>R$0,00</strong>
            </div>
            <div>
                <span>63- Total de Med.</span><br>
                <strong>R$ {{ number_format($totalValorTotal2, 2, ',', '.') }}</strong>
            </div>
            <div>
                <span>64- Total Gases Medi.</span><br>
                <strong>R$0,00</strong>
            </div>
            <div>
                @php
                    // Garantir que as variáveis estejam definidas antes de usar
                    $totalValorTotal = $totalValorTotal ?? 0;
                    $totalValorTotal2 = $totalValorTotal2 ?? 0;
                    $totalValorTotal3 = $totalValorTotal3 ?? 0;

                    // Calcular o total geral
                    $totalGeral = $totalValorTotal + $totalValorTotal2 + $totalValorTotal3;
                @endphp
                <span>65- Total Geral</span><br>
                <strong>R$ {{ number_format($totalGeral, 2, ',', '.') }}</strong>
            </div>
        </div>
        <div class="block">
            <div>
                <span>66- Assinatura Resp. Autorização:</span>
            </div>
            <div>
                <span>67- Assinatura do Beneficiário:</span>
            </div>
            <div>
                <span>68- Assinatura do Contratado</span>
            </div>
        </div>
    </div>
    <!-- Fim da Guia SADT-->

    <!-- Quebra de página para a próxima guia-->
    <div class="page-break"></div>

    <!-- Início da Guia de OD-->
    <div class="container">
        <div class="header-section">
            <div class="empresa-info">
                <img src="{{ asset('images/' . $empresa->imagem) }}" alt="{{ $empresa->nome }}">
                <div class="name">
                    <h4>{{ $empresa->nome }}</h4>
                </div>
            </div>
            <div class="text-center flex-grow">
                <h3>GUIA DE OUTRAS DESPESAS</h3>
            </div>
            <div class="address">
                <p>{{ $empresa->endereco ?? 'Endereço da Empresa' }}</p>
                <p>Bairro, CEP</p>
            </div>
        </div>

        <!-- Conteúdo da Guia de OD-->
        <div class="section-title">Informações Básicas</div>
        <div class="block">
            <div class="small-field">1- Registro ANS: <br> <strong>{{ $guia->registro_ans ?? '' }}</strong></div>
            <div class="medium-field">2- Nº Guia Referenciada: <br>
                <strong>{{ $guia->numero_guia_op ?? '' }}</strong>
            </div>
            <div class="medium-field">3- Código na Operadora: <br>
                <strong>{{ $guia->codigo_operadora ?? '' }}</strong>
            </div>
            <div class="large-field">4- Nome do Contratado: <br> <strong>{{ $guia->nome_contratado ?? '' }}</strong>
            </div>
            <div class="medium-field">5- Código CNES: <br> <strong>{{ $guia->codigo_cnes ?? '' }}</strong></div>
        </div>

        <div class="section-title">Despesas Realizadas</div>
        <table class="despesas-table">
            <thead>
                <tr>
                    <th>6 - CD</th>
                    <th>7 - Data</th>
                    <th>8 - Hora inicial</th>
                    <th>9 - Hora Final</th>
                    <th>10 - Tabela</th>
                    <th>17 - Descrição</th>
                    <th>11 - Código do Ítem</th>
                    <th>12 - Qtd</th>
                    <th>13 - Unid de Medida </th>
                    <th>14 - Fator Red./Acresc.</th>
                    <th>15 - Valor Unitário</th>
                    <th>16 - Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemplo de despesas-->
                <tr>
                    @php
                        $totalValorTotal2 = 0;
                    @endphp

                    @foreach ($medicamentos as $medicamento)
                <tr>
                    <td><strong>{{ $medicamento->cd ?? '' }}</strong></td>
                    <td>{{ $medicamento->created_at ? \Carbon\Carbon::parse($medicamento->created_at)->format('d/m/Y') : '' }}
                    </td>
                    <td>{{ $medicamento->created_at ? \Carbon\Carbon::parse($medicamento->created_at)->format('H:i') : '' }}
                    </td>
                    <td>{{ $medicamento->created_at ? \Carbon\Carbon::parse($medicamento->created_at)->format('H:i') : '' }}
                    </td>
                    <td>{{ $medicamento->tabela ?? '' }}</td>
                    <td>{{ $medicamento->nome_medicamento ?? '' }}</td>
                    <td>{{ $medicamento->codigo ?? '' }}</td>
                    <td>{{ $medicamento->quantidade ?? '' }}</td>
                    <td>{{ $medicamento->unidade_medida ?? '' }}</td>
                    <td>{{ $medicamento->fator ?? '' }}</td>
                    <td>{{ number_format($medicamento->valor, 2, ',', '.') ?? '' }}</td>
                    <td>{{ number_format($medicamento->valor_total, 2, ',', '.') ?? '' }}</td>
                </tr>
                @php
                    $totalValorTotal2 += $medicamento->valor_total;
                @endphp
                @endforeach
                </tr>

                <tr>
                    @php
                        $totalValorTotal3 = 0;
                    @endphp

                    @foreach ($materiais as $material)
                <tr>
                    <td><strong>{{ $material->cd ?? '' }}</strong></td>
                    <td>{{ $material->created_at ? \Carbon\Carbon::parse($material->created_at)->format('d/m/Y') : '' }}
                    </td>
                    <td>{{ $material->created_at ? \Carbon\Carbon::parse($material->created_at)->format('H:i') : '' }}
                    </td>
                    <td>{{ $material->created_at ? \Carbon\Carbon::parse($material->created_at)->format('H:i') : '' }}
                    </td>
                    <td>{{ $material->tabela ?? '' }}</td>
                    <td>{{ $material->nome_material ?? '' }}</td>
                    <td>{{ $material->codigo ?? '' }}</td>
                    <td>{{ $material->quantidade ?? '' }}</td>
                    <td>{{ $material->unidade_medida ?? '' }}</td>
                    <td>{{ $material->fator ?? '' }}</td>
                    <td>{{ number_format($material->valor, 2, ',', '.') ?? '' }}</td>
                    <td>{{ number_format($material->valor_total, 2, ',', '.') ?? '' }}</td>
                </tr>
                @php
                    $totalValorTotal3 += $material->valor_total;
                @endphp
                @endforeach
                </tr>
                <!-- Outras despesas podem ser adicionadas aqui-->
            </tbody>
        </table>

        <!-- Totais da Guia OD-->
        <div class="section-title">Totais</div>
        <div class="block">
            <div>Total Gases Medicinais (R$): <br> <strong>0,00</strong></div>
            <div>Total Medicamentos (R$): <br> <strong>{{ number_format($totalValorTotal2, 2, ',', '.') }}</strong></div>
            <div>Total Materiais (R$): <br> <strong>{{ number_format($totalValorTotal3, 2, ',', '.') }}</strong></div>
        </div>
        <div class="block">
            <div>Total de OPME (R$): <br> <strong>0,00</strong></div>
            <div>Total Taxas e Aluguéis (R$): <br> <strong>0,00</strong></div>
            <div>Total Diárias (R$): <br> <strong>0,00</strong></div>
            @php
                // Garantir que as variáveis estejam definidas antes de usar
                $totalValorTotal2 = $totalValorTotal2 ?? 0;
                $totalValorTotal3 = $totalValorTotal3 ?? 0;

                // Calcular o total geral
                $totalGeral = $totalValorTotal2 + $totalValorTotal3;
            @endphp

            <div>
                Total Geral (R$): <br>
                <strong>{{ number_format($totalGeral, 2, ',', '.') }}</strong>
            </div>
        </div>

        <!-- Assinaturas-->
        <div class="block">
            <div class="signature">Assinatura do Profissional Executante: __</div>
            <div class="signature">Assinatura do Beneficiário ou Responsável: __</div>
        </div>
    </div>
    <!-- Fim da Guia OD-->
</body>

</html>

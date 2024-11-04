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

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
            border: 1px solid #000;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
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

        .procedimento-table, .despesas-table {
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

        /* Força a quebra de página */
        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>
    <!-- Início da Guia SADT -->
    <div class="container">
        <!-- Cabeçalho da Guia SADT -->
        <div class="header-section">
            <div class="empresa-info">
                <img src="{{ asset('images/' . $empresa->imagem) }}" alt="{{ $empresa->nome }}">
                <div class="name">
                    <h4>{{ $empresa->nome }}</h4>
                </div>
            </div>
            <div class="text-center flex-grow">
                <h3>GUIA DE SERVIÇO PROFISSIONAL / SERVIÇO AUXILIAR</h3>
            </div>
            <div class="address">
                <p>{{ $empresa->endereco ?? 'Endereço da Empresa' }}</p>
                <p>Bairro, CEP</p>
            </div>
        </div>

        <!-- Primeira Seção: Registro ANS e Guia -->
        <div class="block">
            <div class="small-field">1 - Registro ANS: <strong>{{ $guia->registro_ans ?? '' }}</strong></div>
            <div class="large-field">3 - Número da Guia no Prestador: <strong>{{ $guia->numero_guia_prestador ?? '' }}</strong></div>
            <div class="medium-field">4 - Data da autorização: <strong>{{ $guia->data_autorizacao ?? '__/__/____' }}</strong></div>
            <div class="medium-field">5 - Senha: <strong>{{ $guia->senha ?? '' }}</strong></div>
            <div class="medium-field">6 - Validade da Senha: <strong>{{ $guia->validade_senha ?? '__/__/____' }}</strong></div>
            <div class="large-field">7 - Nº Guia Operadora: <strong>{{ $guia->numero_guia_op ?? '' }}</strong></div>
        </div>

        <!-- Dados do Beneficiário -->
        <div class="section-title">Dados do Beneficiário</div>
        <div class="block">
            <div class="small-field">8 - Nº da Carteira: <strong>{{ $guia->numero_carteira ?? '' }}</strong></div>
            <div class="small-field">9 - Validade da Carteira: <strong>{{ $guia->validade_carteira ?? '__/__/____' }}</strong></div>
            <div class="small-field">10 - Nome Social: <strong>{{ $guia->nome_social ?? '' }}</strong></div>
            <div class="small-field">12 - Atendimento RN: <strong>{{ $guia->atendimento_rn ?? 'Não' }}</strong></div>
            <div class="small-field">10 - Nome Beneficiário: <strong>{{ $guia->nome_beneficiario ?? '' }}</strong></div>
        </div>

        <!-- Dados do Solicitante -->
        <div class="section-title">Dados do Solicitante</div>
        <div class="block">
            <div>13 - Código na Operadora: <strong>{{ $guia->codigo_operadora ?? '' }}</strong></div>
            <div>14 - Nome do Contratado: <strong>{{ $guia->nome_contratado ?? '' }}</strong></div>
        </div>

        <div class="block">
            <div class="small-field">15 - Nome do Profissional Solicitante: <strong>{{ $guia->nome_profissional_solicitante ?? '' }}</strong></div>
            <div class="small-field">16 - Conselho Profissional: <strong>{{ $guia->conselho_profissional ?? '' }}</strong></div>
            <div class="small-field">17 - Número Conselho: <strong>{{ $guia->numero_conselho ?? '' }}</strong></div>
            <div class="small-field">18 - UF Conselho: <strong>{{ $guia->uf_conselho ?? '' }}</strong></div>
            <div class="small-field">19 - Código CBO: <strong>{{ $guia->codigo_cbo ?? '' }}</strong></div>
            <div class="small-field">20 - Assinatura do Profissional Solicitante: <strong>{{ $guia->assinatura ?? '' }}</strong></div>
        </div>

        <!-- Dados do Procedimento Solicitado -->
        <div class="section-title">Dados do Procedimento Solicitado</div>
        <div class="block">
            <div class="small-field">21 - Caráter de Atendimento: <strong>{{ $guia->carater_atendimento ?? '' }}</strong></div>
            <div class="small-field">22 - Data da Solicitação: <strong>{{ $guia->data_solicitacao ?? '__/__/____' }}</strong></div>
            <div class="small-field">23 - Indicação Clínica: <strong>{{ $guia->indicacao_clinica ?? '' }}</strong></div>
        </div>

        <!-- Procedimentos -->
        <div class="container">
            <div class="line">
                <span>24 - Tabela</span>
                <span>25 - Código do Procedimento ou Item Assistencial</span>
                <span>26 - Descrição</span>
                <span>27 - Qtde. Solic.</span>
                <span>28 - Qtde. Aut.</span>
            </div>

            @for($i = 1; $i <= 5; $i++)
            <div class="line">
                <span class="input-block small-field">|__|__|</span>
                <span class="input-block medium-field">|__|__|__|__|__|__|__|__|</span>
                <span class="input-block large-field">_________________________________________________________________________________________________________________________</span>
                <span class="input-block small-field">|__|__|__|</span>
                <span class="input-block small-field">|__|__|__|</span>
            </div>
            @endfor
        </div>

        <!-- Dados do Executante -->
        <div class="section-title">Dados do Executante</div>
        <div class="block">
            <div>29 - Código Operadora: <strong>{{ $guia->codigo_operadora ?? '' }}</strong></div>
            <div>30 - Nome Contratado: <strong>{{ $guia->nome_contratado ?? '' }}</strong></div>
            <div>31 - Código CNES: <strong>{{ $guia->codigo_cnes ?? '' }}</strong></div>
        </div>

        <!-- Dados do Atendimento -->
        <div class="section-title">Dados do Atendimento</div>
        <div class="block">
            <div>32 - Tipo de Atendimento: <strong>{{ $guia->tipo_atendimento ?? '' }}</strong></div>
            <div>33 - Indicação de Acidente: <strong>{{ $guia->indicacao_acidente ?? '' }}</strong></div>
            <div>34 - Tipo de Consulta: <strong>{{ $guia->tipo_consulta ?? '' }}</strong></div>
            <div>35 - Motivo de Encerramento: <strong>{{ $guia->motivo_encerramento ?? '' }}</strong></div>
            <div>91 - Regime Atendimento: <strong>{{ $guia->regime_atendimento ?? '' }}</strong></div>
            <div>92 - Saúde Ocupacional: <strong>{{ $guia->saude_ocupacional ?? '' }}</strong></div>
        </div>

        <!-- Procedimentos e Exames Realizados -->
        <div class="section-title">Procedimentos e Exames Realizados</div>
        <div class="container">
            <div class="line">
                <span>36 - Data</span>
                <span>37 - Hora Inicial</span>
                <span>38 - Hora Final</span>
                <span>39 - Tabela</span>
                <span>40 - Código do Procedimento</span>
                <span>41 - Descrição</span>
                <span>42 - Qtde.</span>
                <span>43 - Via</span>
                <span>44 - Téc.</span>
                <span>45 - Fator Red./Acre.</span>
                <span>46 - Valor Unitário (R$)</span>
                <span>47 - Valor Total (R$)</span>
            </div>

            @for($i = 1; $i <= 5; $i++)
            <div class="line">
                <span class="input-block small-field">____/____/____</span>
                <span class="input-block small-field">____:____</span>
                <span class="input-block small-field">____:____</span>
                <span class="input-block small-field">|__|__|</span>
                <span class="input-block large-field">|__|__|__|__|__|__|__|__|</span>
                <span class="input-block extra-large-field">_________________________________________</span>
                <span class="input-block small-field">|__|__|__|</span>
                <span class="input-block small-field">|__|</span>
                <span class="input-block small-field">|__|</span>
                <span class="input-block large-field">|__|__|__|,|__|__|</span>
                <span class="input-block large-field">|__|__|__|__|,|__|__|</span>
                <span class="input-block large-field">|__|__|__|__|,|__|__|</span>
            </div>
            @endfor
        </div>

        <!-- Observação / Justificativa -->
        <div class="section-title">Observação / Justificativa</div>
        <div class="block">
            <div>58 - Observação: <strong>{{ $guia->observacao ?? '' }}</strong></div>
        </div>

        <!-- Assinaturas -->
        <div class="block">
            <div class="signature">20 - Assinatura do Profissional Solicitante: __</div>
            <div class="signature">57 - Assinatura do Beneficiário ou Responsável: __</div>
        </div>

    </div>
    <!-- Fim da Guia SADT -->

    <!-- Quebra de página para a próxima guia -->
    <div class="page-break"></div>

    <!-- Início da Guia de OD -->
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

        <!-- Conteúdo da Guia de OD -->
        <div class="section-title">Informações Básicas</div>
        <div class="block">
            <div class="small-field">1 - Registro ANS: <strong>{{ $guia->registro_ans ?? '' }}</strong></div>
            <div class="medium-field">2 - Nº Guia Referenciada: <strong>{{ $guia->numero_guia_referenciada ?? '' }}</strong></div>
            <div class="medium-field">3 - Código na Operadora: <strong>{{ $guia->codigo_operadora ?? '' }}</strong></div>
            <div class="large-field">4 - Nome do Contratado: <strong>{{ $guia->nome_contratado ?? '' }}</strong></div>
            <div class="medium-field">5 - Código CNES: <strong>{{ $guia->codigo_cnes ?? '' }}</strong></div>
        </div>

        <div class="section-title">Despesas Realizadas</div>
        <table class="despesas-table">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Hora Inicial</th>
                    <th>Hora Final</th>
                    <th>Tabela</th>
                    <th>Código do Item</th>
                    <th>Qtd</th>
                    <th>Unidade</th>
                    <th>Fator Red./Acre.</th>
                    <th>Valor Unitário (R$)</th>
                    <th>Valor Total (R$)</th>
                </tr>
            </thead>
            <tbody>
                <!-- Exemplo de despesas -->
                <tr>
                    <td>DIPROSPAN</td>
                    <td>31/07/2024</td>
                    <td>11:57</td>
                    <td>11:57</td>
                    <td>20</td>
                    <td>90148142</td>
                    <td>2,000</td>
                    <td>AMP</td>
                    <td>2,0002</td>
                    <td>45,80</td>
                    <td>22,90</td>
                </tr>
                <!-- Outras despesas podem ser adicionadas aqui -->
            </tbody>
        </table>

        <!-- Totais da Guia OD -->
        <div class="section-title">Totais</div>
        <div class="block">
            <div>Total Gases Medicinais (R$): <strong>70,35</strong></div>
            <div>Total Medicamentos (R$): <strong>173,88</strong></div>
            <div>Total Materiais (R$): <strong>18.124,23</strong></div>
        </div>
        <div class="block">
            <div>Total de OPME (R$): <strong>0,00</strong></div>
            <div>Total Taxas e Aluguéis (R$): <strong>0,00</strong></div>
            <div>Total Diárias (R$): <strong>0,00</strong></div>
            <div>Total Geral (R$): <strong>18.124,23</strong></div>
        </div>

        <!-- Assinaturas -->
        <div class="block">
            <div class="signature">Assinatura do Profissional Executante: __</div>
            <div class="signature">Assinatura do Beneficiário ou Responsável: __</div>
        </div>
    </div>
    <!-- Fim da Guia OD -->
</body>
</html>

@extends('layouts.app')

@section('content')
<main class="app-content">
    <div class="app-title">
        <h1><i class="bi bi-pencil"></i> Editar Guia de SADT</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('guias-sadt.update', $guiaSadt->id) }}">
                @csrf
                @method('PUT')

                {{-- SADT Form --}}
                <div>
                    <h5 class="modal-title">Guia SADT</h5>
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <label for="registro_ans" class="form-label"><strong>1- Registro ANS</strong></label>
                            <input class="form-control" id="registro_ans" name="registro_ans" type="text"
                                value="{{ old('registro_ans', $guiaSadt->registro_ans) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="numero_guia_prestador" class="form-label">3- Nº Guia Principal</label>
                            <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador"
                                type="text" value="{{ old('numero_guia_prestador') }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="data_autorizacao" class="form-label">4- Data da Autorização</label>
                            <input class="form-control" id="data_autorizacao" name="data_autorizacao"
                                type="date" value="{{ old('data_autorizacao') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="senha" class="form-label">5- Senha</label>
                            <input class="form-control" id="senha" name="senha" type="text"
                                value="{{ old('senha') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="validade_senha" class="form-label">6- Data de Validade da Senha</label>
                            <input class="form-control" id="validade_senha" name="validade_senha" type="date"
                                value="{{ old('validade_senha') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="numero_guia_op" class="form-label">7- Nº da Guia Atribuído pela
                                Operadora</label>
                            <input class="form-control" id="numero_guia_op" name="numero_guia_op" type="text"
                                value="{{ old('numero_guia_op') }}">
                        </div>
                    </div>
                    <hr>
                    <h5>Dados do Beneficiário</h5>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="numero_carteira" class="form-label">8 - Nº da Carteira</label>
                            <input class="form-control" id="numero_carteira" name="numero_carteira"
                                type="text" value="{{ old('numero_carteira') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="validade_carteira" class="form-label">9 - Validade da Carteira</label>
                            <input class="form-control" id="validade_carteira" name="validade_carteira"
                                type="date" value="{{ old('validade_carteira') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="nome_beneficiario" class="form-label">10 - Nome</label>
                            <input class="form-control" id="nome_beneficiario" name="nome_beneficiario"
                                type="text" value="{{ old('nome_beneficiario') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="nome_social" class="form-label">11 - CNS</label>
                            <input class="form-control" id="cns" name="cns" type="text"
                                value="{{ old('cns') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="atendimento_rn" class="form-label">12 - Atendimento RN</label>
                            <select class="form-select" id="atendimento_rn" name="atendimento_rn">
                                <option value="N" {{ old('atendimento_rn') == '1' ? 'selected' : '' }}>Não
                                </option>
                                <option value="S" {{ old('atendimento_rn') == '2' ? 'selected' : '' }}>Sim
                                </option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h5>Dados do Solicitante</h5>
                    <div class="row md-3">
                        <div class="col-md-3">
                            <label for="codigo_operadora" class="form-label">13 - Código Operadora</label>
                            <input class="form-control" id="codigo_operadora" name="codigo_operadora"
                                type="text" value="{{ old('codigo_operadora') }}">
                        </div>
                        <div class="col-md-9">
                            <label for="nome_contratado" class="form-label">14 - Nome Contratado</label>
                            <input class="form-control" id="nome_contratado" name="nome_contratado"
                                type="text" value="{{ old('nome_contratado') }}">
                        </div>
                    </div>
                    <div class="row md-3">
                        <div class="col-md-5">
                            <label for="nome_profissional_solicitante" class="form-label">15- Nome do Profissional
                                Solicitante</label>
                            <input class="form-control" id="nome_profissional_solicitante"
                                name="nome_profissional_solicitante" type="text"
                                value="{{ old('nome_profissional_solicitante') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="conselho_profissional" class="form-label">16- Conselho</label>
                            <input class="form-control" id="conselho_profissional" name="conselho_profissional"
                                type="text" value="{{ old('conselho_profissional') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="numero_conselho" class="form-label">17- Nº Conselho</label>
                            <input class="form-control" id="numero_conselho" name="numero_conselho"
                                type="text" value="{{ old('numero_conselho') }}">
                        </div>
                        <div class="col-md-1">
                            <label for="uf_conselho" class="form-label">18- UF</label>
                            <input class="form-control" id="uf_conselho" name="uf_conselho" type="text"
                                value="{{ old('uf_conselho') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="codigo_cbo" class="form-label">19- Código CBO</label>
                            <input class="form-control" id="codigo_cbo" name="codigo_cbo" type="text"
                                value="{{ old('codigo_cbo') }}">
                        </div>
                    </div>
                    <hr>
                    <h5>Dados da Solicitação / Procedimentos e Exames Solicitados</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="carater_atendimento" class="form-label">21 - Caráter de
                                Atendimento</label>
                            <select class="form-select" id="carater_atendimento" name="carater_atendimento">
                                <option value="">Selecione</option>
                                <option value="1" {{ old('carater_atendimento') == '1' ? 'selected' : '' }}>
                                    Eletivo
                                </option>
                                <option value="2" {{ old('carater_atendimento') == '2' ? 'selected' : '' }}>
                                    Urgência/Emergência
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="data_solicitacao" class="form-label">22 - Data/Hora Solicitação</label>
                            <input class="form-control" id="data_solicitacao" name="data_solicitacao"
                                type="date" value="{{ old('data_solicitacao') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="indicacao_clinica" class="form-label">23 - Indicação Clínica</label>
                            <select class="form-select" id="indicacao_clinica" name="indicacao_clinica">
                                <option value="">{{ old('indicacao_clinica') ? 'selected' : 'Selecione' }}
                                </option>
                                <option value="DOR ABDOMINAL">Dor Abdominal</option>
                                <option value="DOR DE CABEÇA FREQUENTE">Dor de Cabeça Frequente</option>
                                <option value="FADIGA">Fadiga</option>
                                <option value="SINTOMAS RESPIRATORIOS">Sintomas Respiratórios</option>
                                <option value="HIPERTENSÃO">Hipertensão</option>
                                <option value="DIABETES">Diabetes</option>
                                <option value="SUSPEITA DE FRATURA">Suspeita de Fratura</option>
                                <option value="AVALIAÇÃO DE FUNÇÃO HEPÁTICA">Avaliação de Função Hepática</option>
                                <option value="ANEMIA">Anemia</option>
                                <option value="PERDA DE PESO INEXPLICADA">Perda de Peso Inexplicada</option>
                                <option value="INFECÇÕES RECORRENTES">Infecções Recorrentes</option>
                                <option value="SINTOMAS GASTROINTESTINAIS">Sintomas Gastrointestinais</option>
                                <option value="SINTOMAS CARDIOVASCULARES">Sintomas Cardiovasculares</option>
                                <option value="DOR ARTICULAR">Dor Articular</option>
                                <option value="OUTROS">Outros</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="indicacao_cob_especial" class="form-label">90 - Indicação de Cobertura
                                Especial</label>
                            <select class="form-select" id="indicacao_cob_especial"
                                name="indicacao_cob_especial">
                                <option value="">Selecione</option>
                                <option value="0"
                                    {{ old('indicacao_cob_especial') == '0' ? 'selected' : '' }}>Não
                                </option>
                                <option value="1"
                                    {{ old('indicacao_cob_especial') == '1' ? 'selected' : '' }}>Sim
                                </option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="space">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>24 - Tabela</th>
                                        <th>25 - Código</th>
                                        <th>26 - Descrição</th>
                                        <th>27 - Qtde Sol.</th>
                                        <th>28 - Qtde Aut.</th>
                                        <th>Excluir</th>
                                    </tr>
                                </thead>
                                <tbody id="exame-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h5>Dados do Contratado Executante</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="codigo_operadora_executante" class="form-label">29 - Código na
                                Operadora</label>
                            <input class="form-control" id="codigo_operadora_executante"
                                name="codigo_operadora_executante" type="text"
                                value="{{ old('codigo_operadora_executante') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="nome_contratado_executante" class="form-label">30 - Nome do
                                Contratado</label>
                            <input class="form-control" id="nome_contratado_executante"
                                name="nome_contratado_executante" type="text"
                                value="{{ old('nome_contratado_executante') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="codigo_cnes" class="form-label">31 - Código CNES</label>
                            <input class="form-control" id="codigo_cnes" name="codigo_cnes" type="text"
                                value="{{ old('codigo_cnes') }}">
                        </div>
                    </div>
                    <hr>
                    <h5>Dados do Atendimento</h5>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="tipo_atendimento" class="form-label">32 - Tipo de Atendimento</label>
                            <select class="form-select" id="tipo_atendimento" name="tipo_atendimento">
                                <option value="">{{ old('tipo_atendimento') ? 'selected' : 'Selecione' }}
                                </option>
                                <option value="01">Remoção</option>
                                <option value="02">Pequena Cirurgia</option>
                                <option value="03">Outras Terapias</option>
                                <option value="04">Consulta</option>
                                <option value="05">Exame Ambulatorial</option>
                                <option value="06">Atendimento Domiciliar</option>
                                <option value="07">Internação</option>
                                <option value="08">Quimioterapia</option>
                                <option value="09">Radioterapia</option>
                                <option value="10">Terapia Renal Substitutiva (TRS)</option>
                                <option value="11">Pronto Socorro</option>
                                <option value="13">Pequeno atendimento (sutura, gesso e outros)</option>
                                <option value="14">Saúde Ocupacional - Admissional</option>
                                <option value="15">Saúde Ocupacional - Demissional</option>
                                <option value="16">Saúde Ocupacional - Periódico</option>
                                <option value="17">Saúde Ocupacional - Retorno ao trabalho</option>
                                <option value="18">Saúde Ocupacional - Mudança de função</option>
                                <option value="19">Saúde Ocupacional - Promoção à saúde</option>
                                <option value="20">Saúde Ocupacional - Beneficiário novo</option>
                                <option value="21">Saúde Ocupacional - Assistência a demitidos</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="indicacao_acidente" class="form-label">33 - Indicação de Acidente</label>
                            <select class="form-select" id="indicacao_acidente" name="indicacao_acidente">
                                <option value="">{{ old('indicacao_acidente') ? 'selected' : 'Selecione' }}
                                </option>
                                <option value="1">Sim</option>
                                <option value="2">Não</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="tipo_consulta" class="form-label">34 - Tipo de Consulta</label>
                            <select class="form-select" id="tipo_consulta" name="tipo_consulta">
                                <option value="">{{ old('tipo_consulta') ? 'selected' : 'Selecione' }}
                                <option value="1">Primeira Consulta</option>
                                <option value="2">Retorno</option>
                                <option value="3">Pré-natal</option>
                                <option value="4">Por encaminhamento</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="motivo_encerramento" class="form-label">35 - Encerramento Atend.</label>
                            <select class="form-select" id="motivo_encerramento" name="motivo_encerramento">
                                <option value="">
                                    {{ old('motivo_encerramento') ? 'selected' : 'Selecione' }}
                                <option value="11">Alta Curado</option>
                                <option value="12">Alta Melhorado</option>
                                <option value="14">Alta a pedido</option>
                                <option value="15">Alta com previsão de retorno para acompanhamento do paciente
                                </option>
                                <option value="16">Alta por Evasão</option>
                                <option value="18">Alta por outros motivos</option>
                                <option value="21">Permanência, por características próprias da doença</option>
                                <option value="22">Permanência, por intercorrência</option>
                                <option value="23">Permanência, por impossibilidade sócio-familiar</option>
                                <option value="24">Permanência, por processo de doação de órgãos, tecidos e
                                    células - doador vivo</option>
                                <option value="25">Permanência, por processo de doação de órgãos, tecidos e
                                    células - doador morto</option>
                                <option value="26">Permanência, por mudança de procedimento</option>
                                <option value="27">Permanência, por reoperação</option>
                                <option value="28">Permanência, outros motivos</option>
                                <option value="31">Transferido para outro estabelecimento</option>
                                <option value="32">Transferência para internação domiciliar</option>
                                <option value="41">Óbito com declaração de óbito fornecida pelo médico
                                    assistente</option>
                                <option value="42">Óbito com declaração de óbito fornecida pelo Instituto
                                    Médico Legal (IML)</option>
                                <option value="43">Óbito com declaração de óbito fornecida pelo Serviço de
                                    Verificação de Óbito (SVO)</option>
                                <option value="51">Encerramento Administrativo</option>
                                <option value="61">Alta da mãe/puérpera e do recém-nascido</option>
                                <option value="62">Alta da mãe/puérpera e permanência do recém-nascido</option>
                                <option value="63">Alta da mãe/puérpera e óbito do recém-nascido</option>
                                <option value="64">Alta da mãe/puérpera com óbito fetal</option>
                                <option value="65">Óbito da gestante e do concepto</option>
                                <option value="66">Óbito da mãe/puérpera e alta do recém-nascido</option>
                                <option value="67">Óbito da mãe/puérpera e permanência do recém-nascido
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="regime_atendimento" class="form-label">91 - Regime Atendimento</label>
                            <select class="form-select" id="regime_atendimento" name="regime_atendimento">
                                <option value="">{{ old('regime_atendimento') ? 'selected' : 'Selecione' }}
                                <option value="01">Ambulatórial</option>
                                <option value="02">Emergência</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="saude_ocupacional" class="form-label">92 - Saúde Ocupacional</label>
                            <select class="form-select" id="saude_ocupacional" name="saude_ocupacional">
                                <option selected disabled>Escolha</option>
                                <option value="1">Sim</option>
                                <option value="2">Não</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <h5>Dados da Execução/Procedimentos e Exames Realizados</h5>
                    <div class="row">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-striped"
                                style="text-align: center; white-space: nowrap; font-size: 12px; min-width: 1800px; vertical-align: middle;">
                                <thead>
                                    <tr>
                                        <th>36 - Data</th>
                                        <th>37 - Hora Inicial</th>
                                        <th>38 - Hora Final</th>
                                        <th>39 - Tab.</th>
                                        <th>40 - Código</th>
                                        <th>41 - Descrição</th>
                                        <th>42 - Qtd.</th>
                                        <th>43 - Via</th>
                                        <th>44 - Tec.</th>
                                        <th>45 - Fator Red./ Acrés</th>
                                        <th>46 - Valor Unit.</th>
                                        <th>47 - Valor Total</th>
                                    </tr>
                                </thead>
                                <tbody id="procedimento-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h5>Identificação do(s) profissional(is) Executante(s)</h5>
                    <div class="row">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-striped"
                                style="text-align: center; white-space: nowrap; font-size: 12px; min-width: 1800px; vertical-align: middle;">
                                <thead>
                                    <tr>
                                        <th>48 - Seq. Ref</th>
                                        <th>49 - Grau Part</th>
                                        <th>Selecione o Profissional</th>
                                        <th>50 - Cód. Operadora/CPF</th>
                                        <th>51 - Profissional</th>
                                        <th>52 - Conselho</th>
                                        <th>53 - Nº Conselho</th>
                                        <th>54 - UF</th>
                                        <th>55 - CBO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input class="form-control" name="sequencia" type="text"
                                                value="1" readonly></< /td>
                                        <td>
                                            <select id="grau" name="grau" class="form-control">
                                                <option value="">
                                                    {{ old('grau') ? 'selected' : 'Selecione' }}
                                                <option value="12">Médico principal ou responsável pelo
                                                    procedimento</option>
                                                <option value="13">Assistente</option>
                                                <option value="14">Anestesista</option>
                                                <option value="15">Cirurgião Auxiliar</option>
                                                <option value="16">Técnico em Enfermagem</option>
                                                <option value="17">Fisioterapeuta</option>
                                                <option value="18">Outro Profissional</option>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary form-control"
                                                data-bs-toggle="modal" data-bs-target="#modalProfissional1">
                                                <i class="bi bi-list"></i>
                                            </button>
                                        </td>
                                        <td><input class="form-control" name="codigo_operadora_profissional"
                                                id="codigo_operadora_profissional" type="text" value=""
                                                readonly></< /td>
                                        <td><input class="form-control" id="nome_profissional"
                                                name="nome_profissional" type="text" value="" readonly>
                                            </< /td>
                                        <td><input class="form-control" name="sigla_conselho" id="sigla_conselho"
                                                type="text" value="" readonly></< /td>
                                        <td><input class="form-control" name="numero_conselho_profissional"
                                                id="numero_conselho_profissional" type="text" value=""
                                                readonly></< /td>
                                        <td><input class="form-control" name="uf_profissional"
                                                id="uf_profissional" type="text" value="" readonly></<
                                                /td>
                                        <td><input class="form-control" name="codigo_cbo_profissional"
                                                id="codigo_cbo_profissional" type="text" value=""
                                                readonly></< /td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <h5>Despesas Realizadas</h5>
                    <div class="row">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-striped"
                                style="text-align: center; white-space: nowrap; font-size: 12px; min-width: 1800px; vertical-align: middle;">
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
                                <tbody id="medicamentos-table-body">
                                </tbody>
                                <tbody id="materiais-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="observacao" class="form-label">58- Observação / Justificativa</label>
                            <textarea class="form-control" id="observacao" name="observacao">{{ old('observacao') }}</textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="saveButton" class="btn btn-primary" type="submit">
                            <i class="bi bi-check-circle-fill me-2"></i>Salvar
                        </button>
                    </div>
                </div>

                <button id="gerarGuiaSADTButton" class="btn btn-danger d-none">
                    <i class="bi bi-file-earmark-break"></i> Gerar Guia SADT
                </button>
            </form>
        </div>
    </div>
</main>
@endsection

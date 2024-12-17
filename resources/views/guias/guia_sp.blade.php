@extends('layouts.app')
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Lista de Guias SP/SADT</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Faturamento</li>
                <li class="breadcrumb-item"><a href="#">Guia SP/SADT</a></li>
            </ul>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-warning">
                {!! session('error') !!}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-title">
                        <label class="form-label">Selecione o Convênio</label>
                        <select name="convenio_id" id="convenio_id" class="form-select" required>
                            <option value="">Escolha o Convênio</option>
                            @foreach ($convenios as $convenio)
                                <option value="{{ $convenio->id }}">
                                    {{ $convenio->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="tile">
                    <div class="timeline-post">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs user-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#dados" data-bs-toggle="tab"
                                        data-identificador="PENDENTE">Guias Pendentes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#honorario" data-bs-toggle="tab"
                                        data-identificador="GERADO">Guias Geradas</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tile-title d-flex justify-content-between align-items-center">
                        <label class="form-label"></label>
                        <button type="button" class="btn btn-success" id="btnGerarGuias" disabled>
                            <i class="bi bi-file-earmark-zip"></i> Gerar Guias Selecionadas
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll" /></th>
                                    <th>#</th>
                                    <th>Paciente</th>
                                    <th>Lote</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="listaGuias">
                                <!-- Dados dinâmicos serão carregados aqui -->
                            </tbody>
                        </table>
                        <div id="paginacao" class="mt-3 text-center">
                            <!-- Botões de paginação serão gerados dinamicamente aqui -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="visualizarGuiaModal" tabindex="-1" aria-labelledby="visualizarGuiaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visualizarGuiaModalLabel">Detalhes da Guia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formVisualizarGuia">
                        @csrf
                        <input type="hidden" id="user_id" name="user_id">
                        <input type="hidden" id="convenio_id" name="convenio_id">
                        <div class="row">
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>1- Registro ANS</strong></label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">2- Nº da guia no prestador</label>
                                <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">4- Nº da carteira do beneficiário</label>
                                <input class="form-control" id="numero_carteira" name="numero_carteira" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-8">
                                <label class="form-label">7- Nome do beneficiário</label>
                                <input class="form-control" id="nome_beneficiario" name="nome_beneficiario" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">18- Data da realização</label>
                                <input class="form-control" id="data_atendimento" name="data_atendimento" type="date"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Hora Início do Atendimento</label>
                                <input class="form-control" id="hora_inicio_atendimento" name="hora_inicio_atendimento"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">19- Tipo de consulta</label>
                                <input class="form-control" id="tipo_consulta" name="tipo_consulta" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">17- Indicação de acidente</label>
                                <input class="form-control" id="indicacao_acidente" name="indicacao_acidente"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">20- Código da Tabela</label>
                                <input class="form-control" id="codigo_tabela" name="codigo_tabela" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">21- Código do procedimento</label>
                                <input class="form-control" id="codigo_procedimento" name="codigo_procedimento"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">22- Valor do procedimento</label>
                                <input class="form-control" id="valor_procedimento" name="valor_procedimento"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">12- Nome do profissional</label>
                                <input class="form-control" id="nome_profissional" name="nome_profissional"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">13- Sigla do conselho</label>
                                <input class="form-control" id="sigla_conselho" name="sigla_conselho" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">14- Nº do conselho</label>
                                <input class="form-control" id="numero_conselho" name="numero_conselho" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">15- UF do conselho</label>
                                <input class="form-control" id="uf_conselho" name="uf_conselho" type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">16- CBO</label>
                                <input class="form-control" id="cbo" name="cbo" type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">23- Observação / Justificativa</label>
                                <input class="form-control" id="observacao" name="observacao" type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Hash</label>
                                <input class="form-control" id="hash" name="hash" type="text" readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- GUIA GLOSSA --}}
    <div class="modal fade" id="editarGuiaModal" tabindex="-1" aria-labelledby="editarGuiaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarGuiaModalLabel">Editar Guia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="guiaForm2">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <input type="hidden" id="convenio_id" name="convenio_id"
                            value="{{ $agendas->convenio_id ?? '' }}">
                        <input type="hidden" id="agenda_id" name="agenda_id" value="{{ old('agenda_id') }}">
                        <input type="hidden" id="guia_id" name="guia_id">

                        <div class="row">
                            <div class="col-md-3">
                                <label for="registro_ans" class="form-label"><strong>1- Registro ANS</strong></label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text"
                                    value="{{ old('registro_ans') }}">
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
                            {{-- <div class="col-md-2">
                                <label class="form-label">Selecione o Profissional</label>
                                <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                                    data-bs-target="#modalProfissional">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div> --}}
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
                                    <option value="">Selecione</option>
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
                                    <option value="">Selecione</option>
                                    <option value="1">Sim</option>
                                    <option value="2">Não</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="tipo_consulta" class="form-label">34 - Tipo de Consulta</label>
                                <select class="form-select" id="tipo_consulta" name="tipo_consulta">
                                    <option value="">Selecione</option>
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
                                        {{-- <tr>
                                            <td><input class="form-control" name="sequencia1" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="grau1" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="codigo_operadora_profissional1" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="nome_profissional1" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="sigla_conselho1" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="numero_conselho_profissional1" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="uf_profissional1" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="codigo_cbo_profissional1" type="text" value="" readonly></</td>
                                        </tr>
                                        <tr>
                                            <td><input class="form-control" name="sequencia2" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="grau2" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="codigo_operadora_profissional2" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="nome_profissional2" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="sigla_conselho2" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="numero_conselho_profissional2" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="uf_profissional2" type="text" value="" readonly></</td>
                                            <td><input class="form-control" name="codigo_cbo_profissional2" type="text" value="" readonly></</td>
                                        </tr> --}}
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
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            // Mascara para o campo de horário
            $('#hora_inicio_atendimento').mask('00:00');

            // Selecionar todas as guias
            $('#selectAll').on('change', function() {
                $('input[name="guiaCheckbox"]').prop('checked', $(this).is(':checked'));
                toggleMassActionButton();
            });

            // Atualizar botão de ação em massa quando um checkbox individual é clicado
            $(document).on('change', 'input[name="guiaCheckbox"]', function() {
                toggleMassActionButton();
            });

            // Função para habilitar/desabilitar o botão de gerar guias em massa
            function toggleMassActionButton() {
                const anyChecked = $('input[name="guiaCheckbox"]:checked').length > 0;
                $('#btnGerarGuias').prop('disabled', !anyChecked);
            }

            // Função para gerar guias em massa
            $('#btnGerarGuias').on('click', function() {
                const selectedIds = $('input[name="guiaCheckbox"]:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    gerarLoteGuiasadt(selectedIds);
                } else {
                    alert('Nenhuma guia selecionada.');
                }
            });

    // Função para listar guias com base no convênio selecionado e na aba ativa
    $(document).ready(function() {
    var registrosPorPagina = 100; // Número de registros por página
    var paginaAtual = 1; // Página inicial
    var totalRegistros = 0; // Total de registros retornados
    var registros = []; // Armazena os registros retornados pela API

    function listarGuias() {
        var convenio_id = $('#convenio_id').val(); // ID do convênio selecionado
        var identificador = $('.nav-link.active').data('identificador'); // Identificador da aba ativa

        if (convenio_id && identificador) {
            $.ajax({
                url: '/guia-sp/listar', // Verifique se essa rota está correta no Laravel
                type: 'GET',
                data: {
                    convenio_id: convenio_id,
                    identificador: identificador // Envia o identificador da aba ativa
                },
                success: function(response) {
                    if (response.guias && response.guias.length > 0) {
                        registros = response.guias; // Armazena os registros retornados
                        totalRegistros = registros.length;
                        renderizarPagina(paginaAtual); // Renderiza a primeira página
                        criarPaginacao(); // Cria os botões de paginação
                    } else {
                        $('#listaGuias').html(
                            '<tr><td colspan="4">Nenhuma guia encontrada para este convênio e aba selecionados.</td></tr>'
                        );
                        $('#paginacao').html(''); // Limpa a paginação
                    }
                },
                error: function() {
                    alert('Erro ao buscar as guias.');
                }
            });
        } else {
            $('#listaGuias').html(
                '<tr><td colspan="4">Por favor, selecione um convênio e uma aba para ver as guias.</td></tr>'
            );
        }
    }

    function renderizarPagina(pagina) {
        var inicio = (pagina - 1) * registrosPorPagina;
        var fim = inicio + registrosPorPagina;
        var registrosPagina = registros.slice(inicio, fim);

        var html = '';
        $.each(registrosPagina, function(index, guia) {
            var data = new Date(guia.created_at);
            var dataFormatada = data.toLocaleDateString('pt-BR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });

            html += '<tr>';
            html += '<td><input type="checkbox" name="guiaCheckbox" value="' + guia.id + '" /></td>';
            html += '<td>' + guia.id + '</td>';
            html += '<td>' + guia.nome_beneficiario + '</td>';
            html += '<td>' + guia.numeracao + '</td>';
            html += '<td>' + dataFormatada + '</td>';
            html += '<td>';
            html +=
                '<button type="button" class="btn btn-success btnVisualizarImprimir" data-id="' +
                guia.id + '" title="Visualizar">';
            html += '<i class="bi bi-eye"></i></button>';

            if (guia.identificador === 'GERADO') {
                html +=
                    '<button type="button" class="btn btn-warning ms-2 btn-editar-guia" data-id="' +
                    guia.id + '" title="Editar">';
                html += '<i class="bi bi-pencil-square"></i></button>';
            }
            html +=
                '<button type="button" class="btn btn-danger ms-2" title="Gerar XML e ZIP" onclick="baixarArquivosSadt(' +
                guia.id + ')">';
            html += '<i class="bi bi-filetype-xml"></i></button>';
            html += '</td>';
            html += '</tr>';
        });

        $('#listaGuias').html(html);
    }

    function criarPaginacao() {
        var totalPaginas = Math.ceil(totalRegistros / registrosPorPagina);
        var html = '';

        for (var i = 1; i <= totalPaginas; i++) {
            html += '<button class="btn btn-primary mx-1 paginacao-btn" data-pagina="' + i + '">' + i + '</button>';
        }

        $('#paginacao').html(html);

        // Adiciona evento de clique nos botões de paginação
        $('.paginacao-btn').click(function() {
            paginaAtual = $(this).data('pagina');
            renderizarPagina(paginaAtual);
        });
    }

    // Evento para carregar guias ao trocar de convênio
    $('#convenio_id').change(function() {
        listarGuias();
    });

    // Evento para carregar guias ao mudar de aba
    $('.nav-link').click(function() {
        $('.nav-link').removeClass('active'); // Remove a classe ativa de outras abas
        $(this).addClass('active'); // Adiciona a classe ativa à aba clicada
        listarGuias(); // Carrega os dados para a aba selecionada
    });

    // Carregar guias iniciais com a primeira aba ativa
    listarGuias();
});
        });

        $(document).on('click', '.btnVisualizarImprimir', function() {
            // Capturar o ID da guia a partir do botão
            var guiaId = $(this).data('id');

            // Substituir ':id' na rota com o ID da guia
            var url = "{{ route('guia.sp', '/id') }}".replace('/id', guiaId);

            // Abrir a URL em uma nova janela popup e iniciar a impressão
            var newWindow = window.open(url, '_blank',
                'toolbar=no,scrollbars=yes,resizable=yes,width=1000,height=800');

            newWindow.onload = function() {
                newWindow.print();
            };
        });

        $(document).ready(function () {
        $(document).on('click', '.btn-editar-guia', function () {
        const guiaId = $(this).data('id'); // Captura o ID da guia do atributo data-id

        $.ajax({
        url: `/guia-sp/${guiaId}/editar`,
        method: 'GET',
        success: function (response) {
            if (response.success) {
                const guia = response.guia;
                const profissional = response.profissional;

                // Preencher os campos gerais
                $('#editarGuiaModal #guia_id').val(guia.id || '');
                $('#editarGuiaModal #registro_ans').val(guia.registro_ans || '');
                $('#editarGuiaModal #numero_guia_prestador').val(guia.numero_guia_prestador || '');
                $('#editarGuiaModal #nome_beneficiario').val(guia.nome_beneficiario || '');
                $('#editarGuiaModal #data_autorizacao').val(guia.data_autorizacao || '');
                $('#editarGuiaModal #senha').val(guia.senha || '');
                $('#editarGuiaModal #validade_senha').val(guia.validade_senha || '');
                $('#editarGuiaModal #numero_carteira').val(guia.numero_carteira || '');
                $('#editarGuiaModal #validade_carteira').val(guia.validade_carteira || '');
                $('#editarGuiaModal #nome_social').val(guia.nome_social || '');
                $('#editarGuiaModal #uf_conselho').val(guia.uf_conselho || '');
                $('#editarGuiaModal #codigo_cbo').val(guia.codigo_cbo || '');
                $('#editarGuiaModal #observacao').val(guia.observacao || '');

                // Preenche os campos relacionados ao profissional
                $('#editarGuiaModal #nome_profissional_solicitante').val(guia?.nome_profissional_solicitante  || '');
                $('#editarGuiaModal #conselho_profissional').val(guia?.conselho_profissional || '');
                $('#editarGuiaModal #numero_conselho').val(guia?.numero_conselho_profissional || '');
                $('#editarGuiaModal #uf_conselho').val(guia?.uf_conselho || '');
                $('#editarGuiaModal #codigo_cbo_profissional').val(profissional?.cbo || '');

                // Preencher campos relacionados ao contratado
                $('#editarGuiaModal #codigo_operadora').val(guia.codigo_operadora || '');
                $('#editarGuiaModal #nome_contratado').val(guia.nome_contratado || '');
                $('#editarGuiaModal #codigo_operadora_executante').val(guia.codigo_operadora_executante || '');
                $('#editarGuiaModal #nome_contratado_executante').val(guia.nome_contratado_executante || '');
                $('#editarGuiaModal #codigo_cnes').val(guia.codigo_cnes || '');

                // Preenche os campos da seção "Dados da Solicitação / Procedimentos e Exames Solicitados"
                $('#editarGuiaModal #carater_atendimento').val(guia?.carater_atendimento || ''); // Define o valor correto no select
                $('#editarGuiaModal #data_solicitacao').val(guia?.data_solicitacao || '');
                $('#editarGuiaModal #indicacao_clinica').val(guia?.indicacao_clinica || ''); // Define o valor correto no select
                $('#editarGuiaModal #indicacao_cob_especial').val(guia?.indicacao_cob_especial || ''); // Define o valor correto no sele

                // Preenche outros campos do modal
                $('#editarGuiaModal #tipo_atendimento').val(guia?.tipo_atendimento || ''); // Tipo de Atendimento
                $('#editarGuiaModal #indicacao_acidente').val(guia?.indicacao_acidente || ''); // Indicação de Acidente
                $('#editarGuiaModal #tipo_consulta').val(guia?.tipo_consulta || ''); // Tipo de Consulta
                $('#editarGuiaModal #motivo_encerramento').val(guia?.motivo_encerramento || ''); // Motivo de Encerramento
                $('#editarGuiaModal #regime_atendimento').val(guia?.regime_atendimento || ''); // Regime de Atendimento
                $('#editarGuiaModal s#saude_ocupacional').val(guia?.saude_ocupacional || ''); // Saúde Ocupacional

                // Preenche outros campos do modal com base nos dados retornados
                $('#editarGuiaModal #grau').val(guia?.grua || ''); // Grau de participação
                $('#editarGuiaModal #codigo_operadora_profissional').val(guia?.codigo_operadora_profissional || ''); // Código Operadora/CPF do profissional
                $('#editarGuiaModal #nome_profissional').val(guia?.nome_profissional || ''); // Nome do profissional
                $('#editarGuiaModal #sigla_conselho').val(guia?.sigla_conselho || ''); // Sigla do conselho profissional
                $('#editarGuiaModal #numero_conselho_profissional').val(guia?.numero_conselho_profissional || ''); // Número do conselho
                $('#editarGuiaModal #uf_profissional').val(guia?.uf_profissional || ''); // UF do conselho
                $('#editarGuiaModal #codigo_cbo_profissional').val(guia?.codigo_cbo_profissional || ''); // Código CBO do profissional


                // Preencher campos de procedimentos/exames realizados
                if (response.procedimentos) {
                    $('#procedimento-table-body').empty();
                    response.procedimentos.forEach(function (procedimento) {
                        const procedimentoRow = `
                            <tr>
                                <td><input class="form-control" id="data_real" name="data_real[]" type="date" readonly value="${procedimento.dataproc || ''}"></td>
                                <td><input class="form-control" id="hora_inicio_atendimento" name="hora_inicio_atendimento[]" type="text" readonly value="${procedimento.hora_inicio || ''}"></td>
                                <td><input class="form-control" id="hora_fim_atendimento" name="hora_fim_atendimento[]" type="text" readonly value="${procedimento.hora_fim || ''}"></td>
                                <td><input class="form-control" id="tabela" name="tabela[]" type="text" readonly value="${procedimento.tabela || ''}"></td>
                                <td><input class="form-control" id="codigo_procedimento_realizado" name="codigo_procedimento_realizado[]" readonly type="text" value="${procedimento.codigo || ''}"></td>
                                <td><input class="form-control" id="descricao_procedimento_realizado" name="descricao_procedimento_realizado[]" readonly type="text" value="${procedimento.procedimento_nome || ''}"></td>
                                <td><input class="form-control quantidade_autorizada" id="quantidade_autorizada" name="quantidade_autorizada[]" type="number" value="${procedimento.quantidade || ''}"></td>
                            </tr>
                        `;
                        $('#procedimento-table-body').append(procedimentoRow);
                    });
                }

                // Preencher medicamentos
                if (response.medicamentos) {
                    $('#medicamentos-table-body').empty();
                    response.medicamentos.forEach(function (medicamento) {
                        const medicamentoRow = `
                            <tr>
                                <td><input class="form-control" type="text" value="${medicamento.codigo || ''}" readonly></td>
                                <td><input class="form-control" type="text" value="${medicamento.nome_medicamento || ''}" readonly></td>
                                <td><input class="form-control" type="text" value="${medicamento.quantidade || ''}" readonly></td>
                            </tr>
                        `;
                        $('#medicamentos-table-body').append(medicamentoRow);
                    });
                }

                // Preencher materiais
                if (response.materiais) {
                    $('#materiais-table-body').empty();
                    response.materiais.forEach(function (material) {
                        const materialRow = `
                            <tr>
                                <td><input class="form-control" type="text" value="${material.codigo || ''}" readonly></td>
                                <td><input class="form-control" type="text" value="${material.nome_material || ''}" readonly></td>
                                <td><input class="form-control" type="text" value="${material.quantidade || ''}" readonly></td>
                            </tr>
                        `;
                        $('#materiais-table-body').append(materialRow);
                    });
                }

                // Exibir o modal após preencher os dados
                $('#editarGuiaModal').modal('show');
            } else {
                alert('Erro ao carregar os dados da guia.');
            }
        },
        error: function () {
            alert('Erro ao carregar os dados da guia.');
        },
    });

    });

    $(document).on('submit', '#guiaForm2', function (e) {
    e.preventDefault(); // Impede o comportamento padrão do formulário

    const guiaId = $('#guia_id').val(); // Captura o ID da guia
    const formData = $(this).serialize(); // Serializa os dados do formulário

    $.ajax({
        url: `/guia-sp/${guiaId}/atualizar`, // URL da rota
        method: 'POST',
        data: formData, // Dados do formulário
        success: function (response) {
            if (response.success) {
                alert(response.message); // Exibe mensagem de sucesso
                $('#editarGuiaModal').modal('hide'); // Fecha o modal
                location.reload(); // Recarrega a página
            } else {
                alert(response.message || 'Erro ao atualizar a guia.');
            }
        },
        error: function (xhr) {
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;
                let errorMessages = Object.values(errors).flat().join('\n');
                alert(errorMessages);
            } else {
                alert('Ocorreu um erro. Tente novamente.');
            }
        },
    });
});
});



        function gerarLoteGuiasadt(ids) {
            let numeracao = null;

            function verificarNumeracao() {
                return fetch(`/verificar-numeracao-sadt`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            guia_ids: ids
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.numeracao) {
                            numeracao = data.numeracao;
                            return true;
                        } else {
                            numeracao = prompt("Numeração não encontrada. Por favor, insira a numeração para o lote:");
                            return numeracao ? true : false;
                        }
                    })
                    .catch(error => {
                        alert("Erro ao verificar a numeração: " + error.message);
                        return false;
                    });
            }

            function gerarXmlGuiasadt() {
                return fetch("{{ route('guias.gerarXmlEmLote') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            guia_ids: ids,
                            numeracao: numeracao
                        })
                    })
                    .then(response => {
                        if (response.status === 422) return response.json();
                        else if (response.ok) return response.blob();
                        else throw new Error('Erro ao gerar XML.');
                    })
                    .then(data => {
                        if (data && data.error) {
                            alert("Erro: " + data.error);
                            return false;
                        } else if (data instanceof Blob) {
                            const url = window.URL.createObjectURL(data);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = `lote_guias_sadt.xml`;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            return true;
                        }
                    })
                    .catch(error => alert("Erro ao gerar XML em lote: " + error.message));
            }

            function gerarZipGuiasadt() {
                return fetch("{{ route('guias.gerarZipEmLote') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            guia_ids: ids,
                            numeracao: numeracao
                        })
                    })
                    .then(response => {
                        if (response.status === 422) return response.json();
                        else if (response.ok) return response.blob();
                        else throw new Error('Erro ao gerar ZIP.');
                    })
                    .then(data => {
                        if (data && data.error) {
                            alert("Erro: " + data.error);
                            return false;
                        } else if (data instanceof Blob) {
                            const url = window.URL.createObjectURL(data);
                            const a = document.createElement('a');
                            a.href = url;
                            a.download = `lote_guias_sadt.zip`;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            return true;
                        }
                    })
                    .catch(error => alert("Erro ao gerar ZIP em lote: " + error.message));
            }

            verificarNumeracao().then(result => {
                if (result) {
                    gerarXmlGuiasadt().then(result => {
                        if (result !== false) {
                            return gerarZipGuiasadt();
                        }
                    });
                }
            });
        }

        function baixarArquivosSadt(guiaId) {
            let numGuia = null;

            // Função `verificarNumeracao` movida para dentro de `baixarArquivosSadt`
            function verificarNumeracao(ids) {
                return fetch(`/verificar-numeracao-sadt`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            guia_ids: ids
                        })
                    })
                    .then(response => response.json())
                    .then(data => data.numeracao || null)
                    .catch(error => {
                        alert("Erro ao verificar a numeração: " + error.message);
                        return null;
                    });
            }

            verificarNumeracao([guiaId]).then(numeracao => {
                if (numeracao) {
                    numGuia = numeracao;
                } else {
                    numGuia = prompt("Numeração não encontrada para esta guia. Por favor, insira a numeração:");
                    if (!numGuia) {
                        alert("A numeração é necessária para gerar os arquivos.");
                        return;
                    }
                }

                gerarXmlGuiaSadt(guiaId, numGuia);
                gerarZipGuiaSadt(guiaId, numGuia);
            }).catch(error => alert("Erro ao verificar a numeração: " + error.message));
        }

        function gerarXmlGuiaSadt(id, numGuia) {
            fetch(`/gerar-xml-guia-sadt/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        numeracao: numGuia
                    })
                })
                .then(response => response.blob())
                .then(blob => downloadBlob(blob, `guia_sadt_${id}.xml`))
                .catch(error => alert("Erro ao gerar XML: " + error.message));
        }

        function gerarZipGuiaSadt(id, numGuia) {
            fetch(`/gerar-zip-guia-sadt/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        numeracao: numGuia
                    })
                })
                .then(response => response.blob())
                .then(blob => downloadBlob(blob, `guia_sadt_${id}.zip`))
                .catch(error => alert("Erro ao gerar ZIP: " + error.message));
        }

        function downloadBlob(blob, filename) {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            a.remove();
        }
    </script>
@endsection

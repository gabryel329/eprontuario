@extends('layouts.app')

<style>
    .selected-info {
        margin-left: 15px;
        font-size: 1rem;
        color: #666;
    }

    .table-scroll-wrapper {
        position: relative;
    }

    .table-scroll {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 15px;
        overflow-x: auto;
    }

    .table-scroll div {
        height: 15px;
    }

    /* Estilo para o hover */
    .hoverable-td {
        cursor: pointer;
        /* Indica que é clicável */
    }

    /* Quando o mouse passar por cima */
    .hoverable-td:hover {
        background-color: #17a2b8;
        /* Cor de fundo da classe btn-info */
        color: white;
        /* Cor do texto quando o mouse passar por cima */
    }

    .table td,
    .table th {
        vertical-align: middle;
        /* Alinha o conteúdo verticalmente no centro */
        padding-top: 4px;
        /* Ajusta o espaçamento superior */
        padding-bottom: 4px;
        /* Ajusta o espaçamento inferior */
        font-size: 13px;
        /* Define o tamanho da fonte */
    }
</style>

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Consultar Marcação</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Marcação</li>
                <li class="breadcrumb-item"><a href="#">Consultar</a></li>
            </ul>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-warning">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form method="GET" action="{{ route('agenda.index1') }}" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label"><Strong>Data:</Strong></label>
                                    <input name="data" id="data" class="form-control" type="date"
                                        value="{{ session('data', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><Strong>Médico:</Strong></label>
                                    <select class="form-control" id="profissional_id" name="profissional_id">
                                        <option disabled selected style="font-size:18px;color: black;">Escolha</option>
                                        @foreach ($profissionals as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="tile-footer">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-3">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="bi bi-check-circle-fill me-2"
                                                onclick="showAdditionalFields()"></i>Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Lista das Consultas</h3>
                    <span class="selected-info">
                        @if (session('data') || session('profissional_id'))
                            @php
                                $data = session('data');
                                $formattedDate = $data ? \Carbon\Carbon::parse($data)->format('d/m/Y') : 'N/A';
                            @endphp
                            Data: {{ $formattedDate }} -
                            Dr(a):
                            @if (session('profissional_id'))
                                @php
                                    $profissional = $profissionals->firstWhere('id', session('profissional_id'));
                                @endphp
                                {{ $profissional ? $profissional->name : 'N/A' }}
                            @else
                                N/A
                            @endif
                            <input type="hidden" id="dataSessao" name="dataSessao"
                                value="{{ $data ? \Carbon\Carbon::parse($data)->format('Y-m-d') : '' }}">
                        @else
                            Nenhum filtro aplicado.
                        @endif
                    </span>
                    {{-- <iframe id="detalhesConsultaIframe" style="width:100%; height:400px; display:none;"
                        frameborder="0"></iframe> --}}
                    <div class="table-scroll-wrapper">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-striped"
                                style="text-align: center; white-space: nowrap; font-size: 12px; min-width: 1800px; vertical-align: middle;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Hora</th>
                                        <th>Nome</th>
                                        <th>Consulta</th>
                                        <th>Medico</th>
                                        <th>Guias</th>
                                        <th>Status</th>
                                        <th>Editar</th>
                                        <th>Chamar</th>
                                        <th>CPF</th>
                                        <th>Contato</th>
                                        <th>Excluir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agendas as $item)
                                        <tr>
                                            <td @if (empty($item->paciente_id)) style="pointer-events: none; opacity: 0.5;"
                                                @else
                                                    onclick="abrirNovaJanela({{ $item->id }});" @endif
                                                title="Detalhes" class="hoverable-td" style="color: red;">
                                                {{ $item->id }}
                                            </td>
                                            <td>{{ $item->hora }}</td>
                                            <td>{{ optional($item->paciente)->name ?? $item->name }}</td>
                                            <td>{{ $item->procedimento_id }}</td>
                                            <td>{{ optional($item->profissional)->name ?? '-' }}</td>
                                            <td>
                                                <select class="form-control guia-select" data-id="{{ $item->id }}"
                                                    data-paciente-id="{{ $item->paciente_id }}"
                                                    {{ is_null($item->paciente_id) ? 'disabled' : '' }}>
                                                    <option selected disabled>Selecione a Guia</option>
                                                    <option value="consulta">Guia de Consulta</option>
                                                    <option value="sadt">Guia SADT</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control status-select" data-id="{{ $item->id }}"
                                                    data-paciente-id="{{ $item->paciente_id }}"
                                                    {{ $item->status == 'FINALIZADO' ? 'disabled' : '' }}>
                                                    <option value="MARCADO"
                                                        {{ $item->status == 'MARCADO' ? 'selected' : '' }}>MARCADO</option>
                                                    <option value="CHEGOU"
                                                        {{ $item->status == 'CHEGOU' ? 'selected' : '' }}>CHEGOU</option>
                                                    <option value="CANCELADO"
                                                        {{ $item->status == 'CANCELADO' ? 'selected' : '' }}>CANCELADO
                                                    </option>
                                                    <option value="EVADIO"
                                                        {{ $item->status == 'EVADIO' ? 'selected' : '' }}>EVADIO</option>
                                                    <option value="FINALIZADO"
                                                        {{ $item->status == 'FINALIZADO' ? 'selected' : '' }}>FINALIZADO
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <button {{ $item->status == 'FINALIZADO' ? 'disabled' : '' }}
                                                    type="button" class="btn btn-info"
                                                    onclick="openEditModal('{{ $item->id }}')"><i
                                                        class="bi bi-pencil-square"></i></button>
                                            </td>
                                            <td>
                                                <a type="submit"
                                                    class="btn btn-warning form-control chamar-btn {{ $item->paciente_id ? '' : 'disabled' }}"
                                                    data-paciente-id="{{ $item->paciente_id ?? null }}"
                                                    data-agenda-id="{{ $item->id ?? null }}"
                                                    data-paciente-nome="{{ $item->paciente->nome ?? null }}">
                                                    <i class="bi bi-volume-up"></i>
                                                </a>
                                            </td>
                                            <td>{{ optional($item->paciente)->cpf ?? 'PACIENTE SEM CPF' }}</td>
                                            <td>{{ $item->celular ?? optional($item->paciente)->celular }}</td>
                                            <td>
                                                <button {{ $item->status == 'FINALIZADO' ? 'disabled' : '' }}
                                                    type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $item->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <!-- Modals -->
    @foreach ($agendas as $item)
        <!-- Modal for Editing -->
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Editar Consulta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('agenda.update', $item->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-6" id="selecionarPaciente">
                                    <label class="form-label">Selecione o Paciente</label>
                                    <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                                        data-bs-target="#pacienteModal-{{ $item->id }}">
                                        <i class="bi bi-list"></i>
                                    </button>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Novo Paciente</label>
                                    <a href="{{ route('paciente.index') }}" class="btn btn-primary form-control"><i
                                            class="bi bi-person-add"></i></a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-12" id="nomeCompleto">
                                    <label class="form-label"><strong>Nome Completo:</strong></label>
                                    <input type="hidden" id="paciente_id{{ $item->id }}" name="paciente_id"
                                        value="{{ $item->paciente_id }}">
                                    <input type="hidden" id="convenio_id{{ $item->id }}" name="convenio_id"
                                        value="{{ $item->convenio_id }}">
                                    <input type="hidden" id="matricula{{ $item->id }}" name="matricula"
                                        value="{{ $item->matricula }}">
                                    <input class="form-control" id="edit-name-{{ $item->id }}" name="name"
                                        type="text" value="{{ $item->name }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Médico</label>
                                    <select class="form-control" id="edit-profissional-id-{{ $item->id }}"
                                        name="profissional_id">
                                        @foreach ($profissionals as $profissional)
                                            <option value="{{ $profissional->id }}"
                                                {{ $item->profissional_id == $profissional->id ? 'selected' : '' }}>
                                                {{ $profissional->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Data</label>
                                    <input type="date" class="form-control" name="data"
                                        value="{{ $item->data }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Hora</label>
                                    <input type="time" class="form-control" name="hora"
                                        value="{{ $item->hora }}">
                                </div>
                            </div>
                            <div class="row" {{ $item->paciente_id ? '' : 'hidden' }}>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Procedimento</label>
                                    <select class="form-control" id="edit-procedimento-id-{{ $item->id }}" name="procedimento_id" {{ $item->paciente_id ? '' : 'disabled' }}>
                                        @foreach ($item->procedimento_lista as $procedimento)
                                            <option value="{{ $procedimento }}"
                                                {{ $item->procedimento_id == $procedimento ? 'selected' : '' }}>
                                                {{ $procedimento }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Selecting Paciente -->
        <div class="modal fade" id="pacienteModal-{{ $item->id }}" tabindex="-1"
            aria-labelledby="pacienteModalLabel-{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pacienteModalLabel-{{ $item->id }}">Selecione o Paciente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <input class="form-control" id="pacienteSearch-{{ $item->id }}" type="text"
                                placeholder="Pesquisar por nome ou CPF...">
                        </div>
                        <table class="table table-hover" id="pacienteTable-{{ $item->id }}">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Nome Social</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pacientes as $p)
                                    <tr>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->cpf }}</td>
                                        <td>{{ $p->nome_social }}</td>
                                        <td>
                                            <button class="btn btn-primary" type="button"
                                                onclick="selectPaciente('{{ $item->id }}', '{{ $p->id }}', '{{ $p->name }}', '{{ $p->convenio_id }}', '{{ $p->matricula }}')">Selecionar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal para excluir --}}
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza de que deseja excluir?<strong> {{ $item->name }} </strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('agenda.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODALS DE GUIAS --}}
        <!-- Modal para Guia de Consulta -->
        <div class="modal fade" id="modalConsulta" tabindex="-1" role="dialog" aria-labelledby="modalConsultaLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalConsultaLabel">Guia de Consulta</h5>
                    </div>
                    <form id="guiaForm">
                        @csrf
                        <div class="modal-body">
                            <input class="form-control" id="convenio_id" name="convenio_id" type="hidden">
                            <input class="form-control" id="paciente_id" value="{{ $item->paciente_id }}"
                                name="paciente_id" type="hidden">
                            <input class="form-control" id="profissional_id" value="{{ $item->profissional_id }}"
                                name="profissional_id" type="hidden">
                            <input class="form-control" id="agenda_id" name="agenda_id" value="{{ $item->id }}" type="hidden">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="registro_ans" class="form-label">Registro ANS</label>
                                    <input class="form-control" id="registro_ans" name="registro_ans" type="text">
                                </div>
                                <div class="col-md-5">
                                    <label for="numero_guia_operadora" class="form-label">Nº Guia Atribuído pela
                                        Operadora</label>
                                    <input class="form-control" id="numero_guia_operadora" name="numero_guia_operadora"
                                        type="text">
                                </div>
                            </div>
                            <hr>
                            <h5>Dados do Beneficiário</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="numero_carteira" class="form-label">Número da Carteira</label>
                                    <input class="form-control" id="numero_carteira" name="numero_carteira"
                                        type="text">
                                </div>
                                <div class="col-md-4">
                                    <label for="validade_carteira" class="form-label">Validade da Carteira</label>
                                    <input class="form-control" id="validade_carteira" name="validade_carteira"
                                        type="date">
                                </div>
                                <div class="col-md-4">
                                    <label for="atendimento_rn" class="form-label">Atendimento RN</label>
                                    <select class="form-select" id="atendimento_rn" name="atendimento_rn">
                                        <option selected disabled>Escolha</option>
                                        <option value="S">Sim</option>
                                        <option value="N">Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nome_social" class="form-label">Nome Social</label>
                                    <input class="form-control" id="nome_social" name="nome_social" type="text">
                                </div>
                                <div class="col-md-6">
                                    <label for="nome_beneficiario" class="form-label">Nome do Beneficiário</label>
                                    <input class="form-control" id="nome_beneficiario" name="nome_beneficiario"
                                        type="text">
                                </div>
                            </div>
                            <hr>
                            <h5>Dados do Contratado</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="codigo_operadora" class="form-label">Código na Operadora</label>
                                    <input class="form-control" id="codigo_operadora" name="codigo_operadora"
                                        type="text">
                                </div>
                                <div class="col-md-6">
                                    <label for="nome_contratado" class="form-label">Nome do Contratado</label>
                                    <input class="form-control" id="nome_contratado" name="nome_contratado"
                                        type="text">
                                </div>
                                <div class="col-md-3">
                                    <label for="cnes" class="form-label">Código CNES</label>
                                    <input class="form-control" id="cnes" name="cnes" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="nome_profissional_executante" class="form-label">Nome do Profissional
                                        Executante</label>
                                    <input class="form-control" id="nome_profissional_executante"
                                        name="nome_profissional_executante" type="text">
                                </div>
                                <div class="col-md-1">
                                    <label for="conselho_profissional" class="form-label">Conselho</label>
                                    <input class="form-control" id="conselho_profissional" name="conselho_profissional"
                                        type="text">
                                </div>
                                <div class="col-md-2">
                                    <label for="conselho_1" class="form-label">Nº Conselho</label>
                                    <input class="form-control" id="conselho_1" name="conselho_1"
                                        type="text">
                                </div>
                                <div class="col-md-1">
                                    <label for="uf_conselho" class="form-label">UF</label>
                                    <input class="form-control" id="uf_conselho" name="uf_conselho" type="text">
                                </div>
                                <div class="col-md-2">
                                    <label for="codigo_cbo" class="form-label">Código CBO</label>
                                    <input class="form-control" id="codigo_cbo" name="codigo_cbo" type="text">
                                </div>
                            </div>
                            <hr>
                            <h5>Dados do Atendimento / Procedimento Realizado</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="indicacao_acidente" class="form-label">Indicação de Acidente</label>
                                    <select class="form-select" id="indicacao_acidente" name="indicacao_acidente">
                                        <option selected disabled>Escolha</option>
                                        <option value="1">Sim</option>
                                        <option value="2">Não</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="indicacao_cobertura_especial" class="form-label">Indicação de Cobertura
                                        Especial</label>
                                    <select class="form-select" id="indicacao_cobertura_especial"
                                        name="indicacao_cobertura_especial">
                                        <option selected disabled>Escolha</option>
                                        <option value="1">Sim</option>
                                        <option value="2">Não</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="regime_atendimento" class="form-label">Regime de Atendimento</label>
                                    <select class="form-select" id="regime_atendimento" name="regime_atendimento">
                                        <option selected disabled>Escolha</option>
                                        <option value="1">Ambulatórial</option>
                                        <option value="2">Emergência</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="saude_ocupacional" class="form-label">Saúde Ocupacional</label>
                                    <select class="form-select" id="saude_ocupacional" name="saude_ocupacional">
                                        <option selected disabled>Escolha</option>
                                        <option value="1">Sim</option>
                                        <option value="2">Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="data_atendimento" class="form-label">Data do Atendimento</label>
                                    <input class="form-control" id="data_atendimento" name="data_atendimento"
                                        type="date">
                                </div>
                                <div class="col-md-3">
                                    <label for="tipo_consulta" class="form-label">Tipo de Consulta</label>
                                    <select class="form-select" id="tipo_consulta" name="tipo_consulta">
                                        <option selected disabled>Escolha</option>
                                        @foreach ($tiposConsultas as $tipo)
                                            <option value="{{ $tipo->id }}">{{ $tipo->atendimento }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="codigo_tabela" class="form-label">Código da Tabela</label>
                                    <input class="form-control" id="codigo_tabela" name="codigo_tabela" type="text">
                                </div>
                                <div class="col-md-3">
                                    <label for="codigo_procedimento" class="form-label">Código do Procedimento</label>
                                    <input class="form-control" id="codigo_procedimento" name="codigo_procedimento"
                                        type="text">
                                </div>
                                <div class="col-md-2">
                                    <label for="valor_procedimento" class="form-label">Valor do Procedimento</label>
                                    <input class="form-control" id="valor_procedimento" name="valor_procedimento"
                                        type="text">
                                </div>
                            </div>
                            <hr>
                            <h5>Observações</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <textarea class="form-control" id="observacao" name="observacao"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="saveButton" class="btn btn-primary" type="submit">
                                <i class="bi bi-check-circle-fill me-2"></i>Salvar
                            </button>
                        </div>
                    </form>
                    <button id="extraButton" class="btn btn-danger d-none guia-consulta"
                        data-id="{{ $item->id }}">Gerar Guia<i class="icon bi bi-file-earmark-break"></i></button>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalSADT" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Guia SADT</h5>
                    </div>
                    <div class="modal-body">
                        <form id="guiaForm2">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" id="convenio_id" name="convenio_id" value="{{ $item->convenio_id ?? '' }}">
                            <input type="hidden" id="agenda_id" name="agenda_id" value="{{ $item->id }}">
                            <input type="hidden" id="paciente_id" name="paciente_id" value="{{ $item->paciente_id }}">
                            <input type="hidden" id="profissional_id" name="profissional_id" value="{{ $item->profissional_id }}">

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
                                        <option value="0" {{ old('atendimento_rn') == '0' ? 'selected' : '' }}>Não
                                        </option>
                                        <option value="1" {{ old('atendimento_rn') == '1' ? 'selected' : '' }}>Sim
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <h5>Dados do Solicitante</h5>
                            <div class="row md-3">
                                <div class="col-md-3">
                                    <label for="codigo_operadora" class="form-label">13 - Código Operadora</label>
                                    <input class="form-control" id="codigo_operadora" name="codigo_operadora" type="text" value="{{ old('codigo_operadora') }}">
                                </div>
                                <div class="col-md-9">
                                    <label for="nome_contratado" class="form-label">14 - Nome Contratado</label>
                                    <input class="form-control" id="nome_contratado" name="nome_contratado" type="text" value="{{ old('nome_contratado') }}">
                                </div>
                            </div>
                            <div class="row md-3">
                                <div class="col-md-5">
                                    <label for="nome_profissional_solicitante" class="form-label">15- Nome do Profissional Solicitante</label>
                                    <input class="form-control" id="nome_profissional_solicitante" name="nome_profissional_solicitante" type="text" value="{{ old('nome_profissional_solicitante') }}">
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
                                    <label for="carater_atendimento" class="form-label">21 - Caráter de Atendimento</label>
                                    <input class="form-control" id="carater_atendimento" name="carater_atendimento" type="text" value="{{ old('carater_atendimento') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="data_solicitacao" class="form-label">22 - Data/Hora Solicitação</label>
                                    <input class="form-control" id="data_solicitacao" name="data_solicitacao" type="date" value="{{ old('data_solicitacao') }}">
                                </div>
                                <div class="col-md-4">
                                    <label for="indicacao_clinica" class="form-label">23 - Indicação Clínica</label>
                                    <input class="form-control" id="indicacao_clinica" name="indicacao_clinica" type="text" value="{{ old('indicacao_clinica') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="indicacao_cob_especial" class="form-label">90 - Indicação de Cobertura Especial</label>
                                    <input class="form-control" id="indicacao_cob_especial" name="indicacao_cob_especial" type="text" value="{{ old('indicacao_cob_especial') }}">
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
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <h5>Dados do Contratado Executante</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="codigo_operadora_executante" class="form-label">29 - Código na Operadora</label>
                                    <input class="form-control" id="codigo_operadora_executante" name="codigo_operadora_executante"
                                        type="text" value="{{ old('codigo_operadora_executante') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="nome_contratado_executante" class="form-label">30 - Nome do Contratado</label>
                                    <input class="form-control" id="nome_contratado_executante" name="nome_contratado_executante"
                                    type="text" value="{{ old('nome_contratado_executante') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="codigo_cnes" class="form-label">31 - Código CNES</label>
                                    <input class="form-control" id="codigo_cnes" name="codigo_cnes"
                                    type="text" value="{{ old('codigo_cnes') }}">
                                </div>
                            </div>
                            <hr>
                            <h5>Dados do Atendimento</h5>
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="tipo_atendimento" class="form-label">32 - Tipo de Atendimento</label>
                                    <input class="form-control" id="tipo_atendimento" name="tipo_atendimento"
                                        type="text" value="{{ old('tipo_atendimento') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="indicacao_acidente" class="form-label">33 - Indicação de Acidente</label>
                                    <input class="form-control" id="indicacao_acidente" name="indicacao_acidente"
                                        type="text" value="{{ old('indicacao_acidente') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="tipo_consulta" class="form-label">34 - Tipo de Consulta</label>
                                    <input class="form-control" id="tipo_consulta" name="tipo_consulta" type="text"
                                        value="{{ old('tipo_consulta') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="motivo_encerramento" class="form-label">35 - Encerramento Atend.</label>
                                    <input class="form-control" id="motivo_encerramento" name="motivo_encerramento"
                                        type="text" value="{{ old('motivo_encerramento') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="regime_atendimento" class="form-label">91 - Regime Atendimento</label>
                                    <input class="form-control" id="regime_atendimento" name="regime_atendimento"
                                        type="text" value="{{ old('regime_atendimento') }}">
                                </div>
                                <div class="col-md-2">
                                    <label for="saude_ocupacional" class="form-label">92 - Saúde Ocupacional</label>
                                    <input class="form-control" id="saude_ocupacional" name="saude_ocupacional"
                                        type="text" value="{{ old('saude_ocupacional') }}">
                                </div>
                            </div>
                            <hr>
                            <h5>Dados da Execução/Procedimentos e Exames Realizados</h5>
                            <div class="row">
                                <div class="space">
                                    <table class="table table-striped">
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
                                        <tbody>
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <h5>Identificação do(s) profissional(is) Executante(s)</h5>
                            <div class="row">
                                <div class="space">
                                    <table class="table table-striped">
                                        <thead>
                                          <tr>
                                            <th>48 - Seq. Ref</th>
                                            <th>49 - Grau Part</th>
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
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
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
                        </form>
                    </div>
                    <button id="gerarGuiaSADTButton" class="btn btn-danger d-none">
                        <i class="bi bi-file-earmark-break"></i> Gerar Guia SADT
                    </button>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function abrirNovaJanela(id) {
            // Abrir uma nova janela popup com o ID da consulta
            window.open('/detalhesConsulta/' + id, '_blank',
                'toolbar=no,scrollbars=yes,resizable=yes,width=1000,height=800');
        }
        // $(document).ready(function() {
        //     var pacienteId = $('#paciente_id{{ $item->id }}').val(); // Obtém o valor do paciente_id

        //     if (!pacienteId) { // Verifica se o paciente_id está nulo ou vazio
        //         // Ajusta o tamanho da div "Selecionar Paciente"
        //         $('#selecionarPaciente').removeClass('col-md-12').addClass('col-md-6');

        //         // Exibe o botão "Novo Paciente"
        //         $('#novoPaciente').show();
        //     } else {
        //         // Garante que o botão "Novo Paciente" esteja escondido se o paciente_id não estiver nulo
        //         $('#novoPaciente').hide();
        //     }
        // });


        $(document).ready(function() {
            $('.guia-select').on('change', function() {
                var selectedValue = $(this).val();
                var agendaId = $(this).data('id'); // Pegar o ID da agenda a partir do atributo data-id

                // Fechar qualquer modal aberto anteriormente
                $('.modal').modal('hide');

                // Se for a guia de consulta, fazer a requisição AJAX
                if (selectedValue === 'consulta') {
                    $.ajax({
                        url: '/gerar-guia-consulta/' + agendaId, // URL para fazer a requisição
                        type: 'GET',
                        success: function(response) {
                            if (response.error) {
                                alert('Erro: ' + response.error);
                                return;
                            }

                            // Preencher os inputs no modal com os dados retornados
                            $('#modalConsulta #agenda_id').val(agendaId);
                            $('#modalConsulta #nome_beneficiario').val(response.paciente ?
                                response.paciente.name : '');
                            $('#modalConsulta #numero_carteira').val(response.paciente ?
                                response.paciente.matricula : '');
                            $('#modalConsulta #validade_carteira').val(response.paciente ?
                                response.paciente.validade : '');
                            $('#modalConsulta #nome_social').val(response.paciente ? response
                                .paciente.nome_social : '');
                            $('#modalConsulta #convenio_id').val(response.paciente ? response
                                .paciente.convenio_id : '');
                            $('#modalConsulta #nome_profissional_executante').val(response
                                .profissional ? response.profissional.name : '');
                            $('#modalConsulta #conselho_profissional').val(response
                                .profissional ? response.profissional
                                .conselho_profissional : '');
                            $('#modalConsulta #conselho_1').val(response.profissional ?
                                response.profissional.conselho_1 : '');
                            $('#modalConsulta #uf_conselho').val(response.profissional ?
                                response.profissional.uf_conselho_1 : '');
                            $('#modalConsulta #registro_ans').val(response.convenio ? response
                                .convenio.ans : '');
                            $('#modalConsulta #codigo_operadora').val(response.convenio ?
                                response.convenio.operadora : '');
                            $('#modalConsulta #nome_contratado').val(response.empresa ? response
                                .empresa.name : '');
                            $('#modalConsulta #cnes').val(response.empresa ? response
                                .empresa.cnes : '');
                            $('#modalConsulta #data_atendimento').val(response.agenda ? response
                                .agenda.data : '');
                            $('#modalConsulta #codigo_procedimento').val(response.agenda ?
                                response.agenda.codigo : '');
                            $('#modalConsulta #codigo_cbo').val(response.profissional ?
                                response.profissional.cbo : '');


                            $('#modalConsulta #numero_guia_operadora').val(response.guia ?
                                response.guia.numero_guia_operadora : '');
                            $('#modalConsulta #atendimento_rn').val(response.guia ?
                                response.guia.atendimento_rn : '');
                            $('#modalConsulta #indicacao_acidente').val(response.guia ?
                                response.guia.indicacao_acidente : '');
                            $('#modalConsulta #indicacao_cobertura_especial').val(response
                                .guia ?
                                response.guia.indicacao_cobertura_especial : '');
                            $('#modalConsulta #regime_atendimento').val(response.guia ?
                                response.guia.regime_atendimento : '');
                            $('#modalConsulta #saude_ocupacional').val(response.guia ?
                                response.guia.saude_ocupacional : '');
                            $('#modalConsulta #tipo_consulta').val(response.guia ?
                                response.guia.tipo_consulta : '');
                            $('#modalConsulta #codigo_tabela').val(response.guia ?
                                response.guia.codigo_tabela : '');
                            $('#modalConsulta #valor_procedimento').val(response.agenda ?
                                response.agenda.valor_proc : '');
                            $('#modalConsulta #observacao').val(response.guia ?
                                response.guia.observacao : '');

                            // Abrir o modal após preencher os campos
                            $('#modalConsulta').modal('show');
                        },
                        error: function(xhr) {
                            console.error('Erro ao buscar os dados da guia:', xhr);
                        }
                    });
                } else if (selectedValue === 'sadt') {
                    // Exibir o modal SADT (você pode também fazer uma requisição aqui se precisar)
                    $('#modalSADT').modal('show');
                } else if (selectedValue === 'tiss') {
                    // Exibir o modal TISS
                    $('#modalTISS').modal('show');
                }
            });
        });

        $(document).ready(function() {
            // Quando o modal for exibido, verificar se o campo "numero_guia_operadora" está preenchido
            $('#modalConsulta').on('shown.bs.modal', function() {
                var numeroGuiaOperadora = $('#numero_guia_operadora').val(); // Obter o valor do campo

                // Se o campo "numero_guia_operadora" não estiver vazio, exibir o botão
                if (numeroGuiaOperadora) {
                    $('#extraButton').removeClass('d-none');
                } else {
                    $('#extraButton').addClass('d-none'); // Ocultar o botão se o campo estiver vazio
                }
            });

            // Adicionando listener ao campo "numero_guia_operadora" para monitorar alterações
            $('#numero_guia_operadora').on('input', function() {
                var numeroGuiaOperadora = $(this).val(); // Obter o valor atualizado

                // Se o campo "numero_guia_operadora" não estiver vazio, exibir o botão
                if (numeroGuiaOperadora) {
                    $('#extraButton').removeClass('d-none');
                } else {
                    $('#extraButton').addClass('d-none'); // Ocultar o botão se o campo estiver vazio
                }
            });

            // Envio do formulário
            $('#guiaForm').on('submit', function(event) {
                event.preventDefault(); // Impedir o envio padrão do formulário

                // Serializar os dados do formulário
                var formData = $(this).serialize();

                // Fazer a requisição AJAX para enviar os dados
                $.ajax({
                    url: '/salvar-guia-consulta',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Incluindo o token CSRF no cabeçalho
                    },
                    success: function(response) {
                        if (response.success) {
                            // Exibir o botão após o sucesso
                            $('#extraButton').removeClass('d-none');
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error('Erro ao salvar os dados:', xhr);
                        alert('Ocorreu um erro ao salvar os dados.');
                    }
                });
            });
        });

        $(document).ready(function() {
            // Ação ao alterar a seleção para 'sadt'
            $('.guia-select').on('change', function() {
                var selectedValue = $(this).val();
                var agendaId = $(this).data('id');

                if (selectedValue === 'sadt') {
                    $.ajax({
                        url: `/gerar-guia-sadt/${agendaId}`,
                        type: 'GET',
                        success: function(response) {
                            console.log('Dados recebidos:', response);

                            if (!response) {
                                alert('Erro: Não foi possível carregar os dados.');
                                return;
                            }

                            // Preencher campos do modal com os dados recebidos
                            $('#modalSADT #nome_profissional_solicitante').val(response
                                .profissional?.name || '');
                            $('#modalSADT #conselho_profissional').val(response.profissional
                                ?.conselho_profissional || '');
                            $('#modalSADT #conselho_1').val(response.profissional
                                ?.conselho_1 || '');
                            $('#modalSADT #nome_contratado').val(response.empresa ? response
                                .empresa.name : '');
                            $('#modalSADT #cnes').val(response.empresa ? response
                                .empresa.cnes : '');
                            $('#modalSADT #data_atendimento').val(response.agenda ? response
                                .agenda.data : '');
                            $('#modalSADT #codigo_procedimento').val(response.agenda ?
                                response.agenda.codigo : '');
                            $('#modalSADT #codigo_cbo').val(response.profissional ?
                                response.profissional.cbo : '');
                            $('#modalSADT #validade_carteira').val(response.paciente ?
                            response.paciente.validade : '');
                            $('#modalSADT #codigo_operadora').val(response.convenio ?
                            response.convenio.operadora : '');
                            $('#modalSADT #nome_social').val(response.paciente ? response
                            .paciente.nome_social : '');
                            $('#modalSADT #uf_conselho').val(response.profissional?.uf || '');
                            $('#modalSADT #codigo_cbo').val(response.profissional?.cbo || '');

                            $('#modalSADT #registro_ans').val(response.convenio?.ans || '');
                            $('#modalSADT #numero_carteira').val(response.paciente?.matricula ||
                                '');
                            $('#modalSADT #nome_beneficiario').val(response.paciente?.name ||
                                '');

                            // Exibir o modal após preencher os dados
                            $('#modalSADT').modal('show');
                        },
                        error: function(xhr) {
                            console.error('Erro ao buscar os dados da guia SADT:', xhr
                                .responseText);
                            alert('Erro ao buscar os dados da guia SADT.');
                        }
                    });
                }
            });

            // Envio do formulário Guia SADT via AJAX
            $('#guiaForm2').on('submit', function(event) {
                event.preventDefault(); // Previne envio padrão

                var formData = $(this).serialize(); // Serializa os dados do formulário

                $.ajax({
                    url: '{{ route('guia.sadt.salvar') }}', // Rota para salvar guia SADT
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message); // Exibe mensagem de sucesso

                            // Exibir o botão de "Gerar Guia"
                            $('#gerarGuiaSADTButton').removeClass('d-none');
                        } else {
                            alert('Erro ao salvar a guia SADT: ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Erro ao salvar a guia SADT.');
                        console.error('Erro:', xhr.responseText);
                    }
                });
            });

            $(document).ready(function() {
                // Escutar o evento de clique no botão de gerar Guia SADT
                $('#gerarGuiaSADTButton').on('click', function() {
                    // Capturar o ID da agenda a partir do campo hidden
                    var agendaId = $('#agenda_id').val();

                    // Substituir ':id' na rota com o ID da agenda
                    var url = "{{ route('guia.sadt', ':id') }}".replace(':id', agendaId);

                    // Abrir a URL em uma nova janela popup
                    window.open(url, '_blank',
                        'toolbar=no,scrollbars=yes,resizable=yes,width=1000,height=800');
                });

                // Mostrar ou ocultar o botão de gerar Guia SADT baseado na entrada
                $('#numero_guia_prestador').on('input', function() {
                    var numeroGuia = $(this).val();
                    if (numeroGuia) {
                        $('#gerarGuiaSADTButton').removeClass('d-none'); // Mostrar botão
                    } else {
                        $('#gerarGuiaSADTButton').addClass('d-none'); // Ocultar botão
                    }
                });
            });

            // Exibir ou ocultar o botão de gerar guia baseado no campo "Número da Guia"
            $('#numero_guia_prestador').on('input', function() {
                var numeroGuia = $(this).val();

                if (numeroGuia) {
                    $('#gerarGuiaSADTButton').removeClass('d-none');
                } else {
                    $('#gerarGuiaSADTButton').addClass('d-none');
                }
            });

            // Quando o modal SADT for exibido, verificar se o campo "numero_guia_prestador" está preenchido
            $('#modalSADT').on('shown.bs.modal', function() {
                var numeroGuiaPrestador = $('#numero_guia_prestador').val(); // Obter o valor do campo

                // Se o campo "numero_guia_prestador" não estiver vazio, exibir o botão
                if (numeroGuiaPrestador) {
                    $('#gerarGuiaSADTButton').removeClass('d-none');
                } else {
                    $('#gerarGuiaSADTButton').addClass(
                    'd-none'); // Ocultar o botão se o campo estiver vazio
                }
            });

            // Adicionando listener ao campo "numero_guia_prestador" para monitorar alterações
            $('#numero_guia_prestador').on('input', function() {
                var numeroGuiaPrestador = $(this).val(); // Obter o valor atualizado

                // Se o campo "numero_guia_prestador" não estiver vazio, exibir o botão
                if (numeroGuiaPrestador) {
                    $('#gerarGuiaSADTButton').removeClass('d-none');
                } else {
                    $('#gerarGuiaSADTButton').addClass(
                    'd-none'); // Ocultar o botão se o campo estiver vazio
                }
            });

        });

        $(document).ready(function() {
            // Escutar o evento de clique no botão de gerar guia de consulta
            $('.guia-consulta').on('click', function() {
                // Capturar o ID da agenda a partir do input com id 'agenda_id'
                var agendaId = $('#agenda_id').val();

                // Substituir ':id' na rota com o ID da agenda
                var url = "{{ route('guia.consulta2', '/id') }}".replace('/id', agendaId);

                // Abrir a URL em uma nova janela popup
                window.open(url, '_blank',
                    'toolbar=no,scrollbars=yes,resizable=yes,width=1000,height=800');
            });
        });





        $(document).ready(function() {
            var dataSessao = $('#dataSessao').val();
            $('.status-select').change(function() {
                var status = $(this).val();
                var dataAgenda = dataSessao; // Data da agenda vinda do atributo data
                var id = $(this).data('id');
                var pacienteId = $(this).data('paciente-id');

                // Verificar a data atual
                var dataAtual = new Date();
                var dataAtualFormatada = dataAtual.toISOString().split('T')[0]; // Formato YYYY-MM-DD

                // Verificar se o status é "CHEGOU" e se não há paciente vinculado
                if (status === 'CHEGOU') {
                    if (!pacienteId) {
                        if (confirm(
                                'Paciente não tem cadastro ou não vinculado. Deseja criar um novo paciente?'
                            )) {
                            window.location.href = "{{ route('paciente.index') }}";
                        } else {
                            $(this).val($(this).data('original-status'));
                            return;
                        }
                    }

                    // Verificar se a data da agenda é diferente da data atual
                    if (dataAgenda !== dataAtualFormatada) {
                        alert(
                            'A data da agenda não coincide com a data atual. Não é possível marcar como CHEGOU.'
                        );
                        $(this).val($(this).data('original-status'));
                        return;
                    }
                }

                // Caso passe nas verificações, continuar com a atualização via AJAX
                $.ajax({
                    url: "{{ route('agenda.updateStatus') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        alert(response.success);
                    },
                    error: function(xhr) {
                        alert('Erro ao atualizar o status.');
                    }
                });
            });

            $('.status-select').focus(function() {
                $(this).data('original-status', $(this).val());
            });
        });


        function openEditModal(id) {
            $('#editModal' + id).modal('show');
        }

        function selectPaciente(itemId, id, name, convenio_id, matricula) {
            $('#paciente_id' + itemId).val(id);
            $('#edit-name-' + itemId).val(name);
            $('#convenio_id' + itemId).val(convenio_id);
            $('#matricula' + itemId).val(matricula);
            var pacienteModal = bootstrap.Modal.getInstance(document.getElementById('pacienteModal-' + itemId));
            pacienteModal.hide();
        }

        $(document).ready(function() {
            $('[id^="pacienteModal"]').on('hidden.bs.modal', function() {
                var itemId = $(this).attr('id').split('-')[1];
                $('#editModal' + itemId).modal('show');
            });
        });

        $('[id^=pacienteSearch]').on('keyup', function() {
            var inputId = $(this).attr('id');
            var inputValue = $(this).val().toLowerCase();
            var tableId = inputId.replace('Search', 'Table');
            var rows = $('#' + tableId + ' tbody tr');

            rows.each(function() {
                var name = $(this).find('td').eq(0).text().toLowerCase();
                var cpf = $(this).find('td').eq(2).text().toLowerCase();
                if (name.indexOf(inputValue) > -1 || cpf.indexOf(inputValue) > -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        document.querySelectorAll('.chamar-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Impede o comportamento padrão do botão

                let pacienteId = this.getAttribute('data-paciente-id');
                let agendaId = this.getAttribute('data-agenda-id');
                let pacienteNome = this.getAttribute('data-paciente-nome');

                // Envia os dados via AJAX para o servidor
                fetch('{{ route('consultorioPainel.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            paciente_id: pacienteId,
                            agenda_id: agendaId,
                            nome: pacienteNome
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Paciente chamado!');
                        } else {
                            alert('Erro ao salvar os dados');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Erro ao salvar os dados');
                    });
            });
        });

        function showAdditionalFields() {
            var data = document.getElementById('data').value;
            var profissionalId = document.getElementById('profissional_id').value;
            var profissionalName = document.getElementById('profissional_id').options[document.getElementById(
                'profissional_id').selectedIndex].text;

            if (!data) {
                alert('Por favor, selecione uma data.');
                return;
            }

            if (!profissionalId || profissionalId === "Escolha") {
                alert('Por favor, selecione um médico.');
                return;
            }

            document.getElementById('selectedData').value = data;
            document.getElementById('selectedProfissionalId').value = profissionalId;

            document.getElementById('displaySelectedData').innerText = data;
            document.getElementById('displaySelectedProfissional').innerText = profissionalName;

            document.getElementById('initial-form').style.display = 'none';
            document.getElementById('additional-fields').style.display = 'block';
            document.getElementById('agenda-table').style.display = 'block';

            fetchAgenda(data, profissionalId);
        }
    </script>
@endsection

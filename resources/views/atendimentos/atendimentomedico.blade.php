@extends('layouts.app')
<style>
    .actions {
        display: flex;
        gap: 5px;
    }
</style>
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-receipt"></i> Atendimento</h1>
                <div class="actions">
                    <label class="form-label"><strong>Paciente:</strong></label>
                    <p>{{ $paciente->name }}</p>
                </div>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item"><a href="#">Atendimento</a></li>
            </ul>
        </div>
        <div class="row user">
            <div class="col-md-2">
                <div class="tile p-0">
                    <ul class="nav flex-column nav-tabs user-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#atendimento-anamnese"
                                data-bs-toggle="tab">Anamnese</a></li>
                        <li class="nav-item"><a class="nav-link" href="#atendimento-atendimento"
                                data-bs-toggle="tab">Atendimento</a></li>
                        <li class="nav-item"><a class="nav-link" href="#atendimento-prescricao"
                                data-bs-toggle="tab">Prescrição</a></li>
                        <hr>
                        <form id="printForm" action="{{ route('processarFormulario') }}" target="_blank" method="POST">
                            @csrf
                            <input class="form-control" id="agenda_id1" name="agenda_id1" type="text" value="{{ $agenda->id }}" hidden>
                            <li class="nav-item" style="text-align: center;">
                                <button type="button" class="btn btn-primary" id="enviarBtn">Imprimir <i class="bi bi-printer"></i></button>
                            </li>
                        </form>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmModalLabel">Confirmar Impressão</h5>
                                    </div>
                                    <div class="modal-body">
                                        Você tem certeza de que deseja imprimir? Após a impressão, o atendimento será finalizado e não poderá mais ser atualizado.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" id="confirmPrintBtn">Confirmar <i class="bi bi-check-circle"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <li class="nav-item"><a class="nav-link" href="#atendimento-historico"
                                data-bs-toggle="tab">Histórico</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10">
                <form id="fichaatendimento">
                    @csrf
                    <div class="tab-content">
                        <div class="tab-pane active" id="atendimento-anamnese">
                            <div class="timeline-post">
                                <h4 class="line-head">Anamnese</h4>
                                <div class="row mb-12">
                                    <div class="col-md-12">
                                        <div class="tile">
                                            <div class="tile-body">
                                                <form id="anamneseForm">
                                                    @csrf
                                                    <input class="form-control" id="paciente_id" name="paciente_id"
                                                        type="text" value="{{ $paciente->id }}" hidden>
                                                    <input class="form-control" id="profissional_id" name="profissional_id"
                                                        type="text" value="{{ $agenda->profissional_id }}" hidden>
                                                    <input class="form-control" id="agenda_id" name="agenda_id"
                                                        type="text" value="{{ $agenda->id }}" hidden>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label"><strong>Peso (Kg):</strong></label>
                                                            <input class="form-control" id="peso" name="peso"
                                                                type="text" oninput="calcularIMC()">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label"><strong>Altura (m):</strong></label>
                                                            <input class="form-control" id="altura" name="altura"
                                                                type="text" oninput="calcularIMC()">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label"><strong>IMC:</strong></label>
                                                            <input class="form-control" id="imc" name="imc"
                                                                type="text" readonly>
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label
                                                                class="form-label"><strong>Classificação:</strong></label>
                                                            <input class="form-control" id="classificacao"
                                                                name="classificacao" type="text" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label"><strong>PA mmHg:</strong></label>
                                                            <input class="form-control" id="pa" name="pa"
                                                                type="text">
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label class="form-label"><strong>Temp(ºC):</strong></label>
                                                            <input class="form-control" id="temp" name="temp"
                                                                type="text">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-2">
                                                            <label class="form-label"><strong>Gestante:</strong></label>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="gestante" value="S">Sim
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="gestante" value="N">Não
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label"><strong>Dextro
                                                                    (mg/dL):</strong></label>
                                                            <input class="form-control" id="dextro" name="dextro"
                                                                type="text">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label"><strong>SpO2:</strong></label>
                                                            <input class="form-control" id="spo2" name="spo2"
                                                                type="text">
                                                        </div>
                                                        <div class="mb-3 col-md-2">
                                                            <label class="form-label"><strong>F.C.:</strong></label>
                                                            <input class="form-control" id="fc" name="fc"
                                                                type="text">
                                                        </div>
                                                        <div class="mb-3 col-md-2">
                                                            <label class="form-label"><strong>F.R.:</strong></label>
                                                            <input class="form-control" id="fr" name="fr"
                                                                type="text">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row" style="text-align: center">
                                                        <div class="mb-3 col-md-12">
                                                            <label class="form-label"><strong>Acolhimento</strong></label>
                                                            <input class="form-control" id="acolhimento"
                                                                name="acolhimento" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="row" style="text-align: center">
                                                        <div class="mb-3 col-md-12">
                                                            <label class="form-label"><strong>Queixas Principais do
                                                                    Acolhimento</strong></label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-3">
                                                            <input class="form-control" id="acolhimento1"
                                                                name="acolhimento1" type="text">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <input class="form-control" id="acolhimento2"
                                                                name="acolhimento2" type="text">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <input class="form-control" id="acolhimento3"
                                                                name="acolhimento3" type="text">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <input class="form-control" id="acolhimento4"
                                                                name="acolhimento4" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="row" style="text-align: center">
                                                        <div class="mb-3 col-md-12">
                                                            <label class="form-label"><strong>Alergias</strong></label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-4">
                                                            <input class="form-control" id="alergia1" name="alergia1"
                                                                type="text">
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <input class="form-control" id="alergia2" name="alergia2"
                                                                type="text">
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <input class="form-control" id="alergia3" name="alergia3"
                                                                type="text">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3">
                                                            <label class="form-label"><strong>Anamnese / Exame
                                                                    Fisico:</strong></label>
                                                            <textarea class="form-control" rows="5" id="anamnese" name="anamnese"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="tile-footer">
                                                        @if ($agenda->status === 'FINALIZADO')
                                                            <button id="saveAnamneseButton" class="btn btn-danger"
                                                                type="button" disabled>
                                                                <i
                                                                    class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar
                                                            </button>
                                                        @else
                                                            <button id="saveAnamneseButton" class="btn btn-danger"
                                                                type="button">
                                                                <i
                                                                    class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar
                                                            </button>
                                                        @endif
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="atendimento-atendimento">
                            <div class="timeline-post">
                                <h4 class="line-head">Atendimento</h4>
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs user-tabs">
                                        <li class="nav-item"><a class="nav-link active" href="#atendimento-queixa"
                                                data-bs-toggle="tab">Queixa Principal</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#atendimento-evolucao"
                                                data-bs-toggle="tab">Evolução</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#atendimento-condicao"
                                                data-bs-toggle="tab">Condição Fisica</a></li>
                                    </ul>
                                </div>
                                <form id="atendimentoForm">
                                    @csrf
                                    <input type="hidden" id="atendimento_id" name="atendimento_id" value="">
                                    <input class="form-control" id="paciente_id" name="paciente_id" type="text"
                                        value="{{ $paciente->id }}" hidden>
                                    <input class="form-control" id="agenda_id" name="agenda_id" type="text"
                                        value="{{ $agenda->id }}" hidden>
                                    <input class="form-control" id="profissional_id" name="profissional_id"
                                        type="text" value="{{ $agenda->profissional_id }}" hidden>
                                    <div class="col-md-12">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="atendimento-queixa">
                                                <div class="timeline-post">
                                                    <h4 class="line-head">Queixa Principal</h4>
                                                    <div class="row mb-12">
                                                        <div class="col-md-12">
                                                            <textarea class="form-control" rows="15" id="queixas" name="queixas"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="atendimento-evolucao">
                                                <div class="timeline-post">
                                                    <h4 class="line-head">Evolução</h4>
                                                    <div class="row mb-12">
                                                        <div class="col-md-12">
                                                            <textarea class="form-control" rows="15" id="evolucao" name="evolucao"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="atendimento-condicao">
                                                <div class="timeline-post">
                                                    <h4 class="line-head">Condição Fisica</h4>
                                                    <div class="row mb-12">
                                                        <div class="col-md-12">
                                                            <textarea class="form-control" rows="15" id="condicao" name="condicao"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tile-footer">
                                        @if ($agenda->status === 'FINALIZADO')
                                            <button class="btn btn-danger" type="button" id="saveButton" disabled><i
                                                    class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar</button>
                                        @else
                                            <button class="btn btn-danger" type="button" id="saveButton"><i
                                                    class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="atendimento-prescricao">
                            <div class="timeline-post">
                                <h4 class="line-head">Prescrição</h4>
                                <div class="row">
                                    <input class="form-control" id="paciente_id" name="paciente_id" type="text" value="{{ $agenda->paciente_id }}" hidden>
                                    <input class="form-control" id="agenda_id" name="agenda_id" type="text" value="{{ $agenda->id }}" hidden>
                                    <input class="form-control" id="profissional_id" name="profissional_id" type="text" value="{{ $agenda->profissional_id }}" hidden>
                                
                                    <input class="form-control" id="paciente_id1" name="paciente_id" type="text" value="{{ $agenda->paciente->name }}" hidden>
                                    <input class="form-control" id="agenda_id1" name="agenda_id" type="text" value="{{ $agenda->id }}" hidden>
                                    <input class="form-control" id="profissional_id1" name="profissional_id" type="text" value="{{ $agenda->profissional->name }}" hidden>
                                    
                                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                                        <div class="d-flex flex-row">
                                            <div class="form-check mr-3" style="margin-right: 5px">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="receita">
                                                <label class="form-check-label" for="flexRadioDefault2">Receita</label>
                                            </div>
                                            <div class="form-check mr-3" style="margin-right: 5px">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="solicitacao_exame">
                                                <label class="form-check-label" for="flexRadioDefault3">Solicitação de Exame</label>
                                            </div>
                                            <div class="form-check mr-3" id="atestadoCheck" style="margin-right: 5px">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="atestado">
                                                <label class="form-check-label" for="flexRadioDefault1">Atestado</label>
                                            </div>
                                            <div id="diasInput" style="display: none;">
                                                <input type="number" name="dia_id" id="dia_id" placeholder="Dias">
                                                <input type="text" name="obs_id" id="obs_id" placeholder="Observação">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" title="Imprimir" id="enviarAtes">
                                            <i class="bi bi-printer"></i>
                                        </button>
                                    </div>
                                </div>
                                

                                <div class="col-md-12">
                                    <ul class="nav nav-tabs user-tabs">
                                        <li class="nav-item"><a class="nav-link active" href="#prescricao-exame"
                                                data-bs-toggle="tab">Exame</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#prescricao-remedio"
                                                data-bs-toggle="tab">Remedio</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="prescricao-exame">
                                            <form id="exameForm" method="POST" action="{{ route('exames.store') }}">
                                                @csrf
                                                <input type="hidden" id="paciente_id" name="paciente_id"
                                                    value="{{ $paciente->id }}">
                                                <input type="hidden" id="agenda_id" name="agenda_id"
                                                    value="{{ $agenda->id }}">
                                                <input type="hidden" id="profissional_id" name="profissional_id"
                                                    value="{{ $agenda->profissional_id }}">
                                                <div class="timeline-post">
                                                    <div id="exame-container">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Procedimento</th>
                                                                    <th>Ações</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="exame-table-body">
                                                                <tr class="exame-row">
                                                                    <td>
                                                                        <select class="form-control procedimento_id"
                                                                            name="procedimento_id[]" id="procedimento_id">
                                                                            <option value="">Selecione o Procedimento
                                                                            </option>
                                                                            @foreach ($procedimento as $item)
                                                                                <option value="{{ $item->id }}">
                                                                                    {{ $item->procedimento }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td class="actions">
                                                                        <button type="button"
                                                                            class="btn btn-success plus-row">+</button>
                                                                        <button type="button"
                                                                            class="btn btn-danger delete-row">-</button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tile-footer">
                                                    @if ($agenda->status === 'FINALIZADO')
                                                        <button class="btn btn-danger" id="saveExameButton"
                                                            type="submit" disabled>
                                                            <i class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar
                                                        </button>
                                                    @else
                                                        <button class="btn btn-danger" id="saveExameButton"
                                                            type="submit">
                                                            <i class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar
                                                        </button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane fade" id="prescricao-remedio">
                                            <form id="remedioForm" method="POST" action="#">
                                                @csrf
                                                <input class="form-control" id="paciente_id" name="paciente_id"
                                                    type="text" value="{{ $paciente->id }}" hidden>
                                                <input class="form-control" id="agenda_id" name="agenda_id"
                                                    type="text" value="{{ $agenda->id }}" hidden>
                                                <input class="form-control" id="profissional_id" name="profissional_id"
                                                    type="text" value="{{ $agenda->profissional_id }}" hidden>
                                                <div class="timeline-post">
                                                    <div id="prescricao-container">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Remédio</th>
                                                                    <th>Dose</th>
                                                                    <th>Horas</th>
                                                                    <th>Ações</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="prescricao-table-body">
                                                                <tr class="prescricao-row">
                                                                    <td>
                                                                        <select class="form-control medicamento_id"
                                                                            name="medicamento_id[]" id="medicamento_id">
                                                                            <option value="">Selecione o remédio
                                                                            </option>
                                                                            @foreach ($medicamento as $item)
                                                                                <option value="{{ $item->id }}">
                                                                                    {{ $item->nome }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control dose"
                                                                            name="dose[]" placeholder="Dose"
                                                                            id="dose">
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control horas"
                                                                            name="horas[]" placeholder="Horas"
                                                                            id="horas">
                                                                    </td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-success add-row">+</button>
                                                                        <button type="button"
                                                                            class="btn btn-danger remove-row">-</button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="tile-footer">
                                                    @if ($agenda->status === 'FINALIZADO')
                                                        <button class="btn btn-danger" id="saveRemedioButton"
                                                            type="button" disabled><i
                                                                class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar</button>
                                                    @else
                                                        <button class="btn btn-danger" id="saveRemedioButton"
                                                            type="button"><i
                                                                class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar</button>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="atendimento-historico">
                            <div class="timeline-post">
                                <h4 class="line-head">Histórico</h4>
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs user-tabs">
                                        @foreach ($historico as $index => $registro)
                                            <li class="nav-item">
                                                <a class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                                    href="#data-{{ $index }}" data-bs-toggle="tab">
                                                    {{ \Carbon\Carbon::parse($registro->data)->format('d/m/Y') }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    @foreach ($historico as $index => $registro)
                                        <div class="tab-pane {{ $index === 0 ? 'active' : '' }}"
                                            id="data-{{ $index }}">
                                            <div><strong>Profissional ID:</strong> {{ $registro->an_profissional_id }}
                                            </div>
                                            <div class="row user">
                                                <div class="col-md-2">
                                                    <div class="tile p-0">
                                                        <ul class="nav flex-column nav-tabs user-tabs">
                                                            <li class="nav-item"><a class="nav-link active"
                                                                    href="#historico-anamnese-{{ $index }}"
                                                                    data-bs-toggle="tab">Anamnese</a></li>
                                                            <li class="nav-item"><a class="nav-link"
                                                                    href="#historico-atendimento-{{ $index }}"
                                                                    data-bs-toggle="tab">Atendimento</a></li>
                                                            <li class="nav-item"><a class="nav-link"
                                                                    href="#historico-prescricao-{{ $index }}"
                                                                    data-bs-toggle="tab">Prescrição</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active"
                                                            id="historico-anamnese-{{ $index }}">
                                                            <div class="timeline-post">
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label"><strong>Peso
                                                                                (Kg)
                                                                                :</strong></label>
                                                                        <input class="form-control" id="peso"
                                                                            name="peso" type="text"
                                                                            value="{{ $registro->an_peso }}"
                                                                            oninput="calcularIMC()">
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label"><strong>Altura
                                                                                (m):</strong></label>
                                                                        <input class="form-control" id="altura"
                                                                            name="altura" type="text"
                                                                            value="{{ $registro->an_altura }}"
                                                                            oninput="calcularIMC()">
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <label
                                                                            class="form-label"><strong>IMC:</strong></label>
                                                                        <input class="form-control" id="imc"
                                                                            name="imc" type="text"
                                                                            value="{{ $registro->imc }}" readonly>
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <label
                                                                            class="form-label"><strong>Classificação:</strong></label>
                                                                        <input class="form-control" id="classificacao"
                                                                            name="classificacao" type="text"
                                                                            value="{{ $registro->classificacao }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label"><strong>PA
                                                                                mmHg:</strong></label>
                                                                        <input class="form-control" id="pa"
                                                                            name="pa" type="text" readonly
                                                                            value="{{ $registro->an_pa }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-6">
                                                                        <label
                                                                            class="form-label"><strong>Temp(ºC):</strong></label>
                                                                        <input class="form-control" id="temp"
                                                                            name="temp" type="text" readonly
                                                                            value="{{ $registro->an_temp }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-2">
                                                                        <label
                                                                            class="form-label"><strong>Gestante:</strong></label>
                                                                        <input class="form-check-input" type="text"
                                                                            readonly name="gestante"
                                                                            value="{{ $registro->an_gestante }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label"><strong>Dextro
                                                                                (mg/dL):</strong></label>
                                                                        <input class="form-control" id="dextro"
                                                                            name="dextro" type="text" readonly
                                                                            value="{{ $registro->an_dextro }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <label
                                                                            class="form-label"><strong>SpO2:</strong></label>
                                                                        <input class="form-control" id="spo2"
                                                                            name="spo2" type="text" readonly
                                                                            value="{{ $registro->an_spo2 }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-2">
                                                                        <label
                                                                            class="form-label"><strong>F.C.:</strong></label>
                                                                        <input class="form-control" id="fc"
                                                                            name="fc" type="text" readonly
                                                                            value="{{ $registro->an_fc }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-2">
                                                                        <label
                                                                            class="form-label"><strong>F.R.:</strong></label>
                                                                        <input class="form-control" id="fr"
                                                                            name="fr" type="text" readonly
                                                                            value="{{ $registro->an_fr }}">
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="row" style="text-align: center">
                                                                    <div class="mb-3 col-md-12">
                                                                        <label
                                                                            class="form-label"><strong>Acolhimento</strong></label>
                                                                        <input class="form-control" id="acolhimento"
                                                                            name="acolhimento" type="text" readonly
                                                                            value="{{ $registro->an_acolhimento }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="text-align: center">
                                                                    <div class="mb-3 col-md-12">
                                                                        <label class="form-label"><strong>Queixas
                                                                                Principais do
                                                                                Acolhimento</strong></label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-3">
                                                                        <input class="form-control" id="acolhimento1"
                                                                            name="acolhimento1" type="text" readonly
                                                                            value="{{ $registro->an_acolhimento1 }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <input class="form-control" id="acolhimento2"
                                                                            name="acolhimento2" type="text" readonly
                                                                            value="{{ $registro->an_acolhimento2 }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <input class="form-control" id="acolhimento3"
                                                                            name="acolhimento3" type="text" readonly
                                                                            value="{{ $registro->an_acolhimento3 }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <input class="form-control" id="acolhimento4"
                                                                            name="acolhimento4" type="text" readonly
                                                                            value="{{ $registro->an_acolhimento4 }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row" style="text-align: center">
                                                                    <div class="mb-3 col-md-12">
                                                                        <label
                                                                            class="form-label"><strong>Alergias</strong></label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-4">
                                                                        <input class="form-control" id="alergia1"
                                                                            name="alergia1" type="text" readonly
                                                                            value="{{ $registro->an_alergia1 }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-4">
                                                                        <input class="form-control" id="alergia2"
                                                                            name="alergia2" type="text" readonly
                                                                            value="{{ $registro->an_alergia2 }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-4">
                                                                        <input class="form-control" id="alergia3"
                                                                            name="alergia3" type="text" readonly
                                                                            value="{{ $registro->an_alergia3 }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3">
                                                                        <label class="form-label"><strong>Anamnese / Exame
                                                                                Fisico:</strong></label>
                                                                        <textarea class="form-control" rows="5" id="anamnese" name="anamnese" readonly>{{ $registro->an_anamnese }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade"
                                                            id="historico-atendimento-{{ $index }}">
                                                            <div class="timeline-post">
                                                                <div class="col-md-12">
                                                                    <ul class="nav nav-tabs user-tabs">
                                                                        <li class="nav-item"><a class="nav-link active"
                                                                                href="#historico-queixa-{{ $index }}"
                                                                                data-bs-toggle="tab">Queixa Principal</a>
                                                                        </li>
                                                                        <li class="nav-item"><a class="nav-link"
                                                                                href="#historico-evolucao-{{ $index }}"
                                                                                data-bs-toggle="tab">Evolução</a></li>
                                                                        {{-- <li class="nav-item"><a class="nav-link"
                                                                                href="#historico-atestado-{{ $index }}"
                                                                                data-bs-toggle="tab">Solicitações</a></li> --}}
                                                                        <li class="nav-item"><a class="nav-link"
                                                                                href="#historico-condicao-{{ $index }}"
                                                                                data-bs-toggle="tab">Condição Fisica</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="tab-content">
                                                                        <div class="tab-pane active"
                                                                            id="historico-queixa-{{ $index }}">
                                                                            <div class="timeline-post">
                                                                                <h4 class="line-head">Queixa Principal</h4>
                                                                                <div class="row mb-12">
                                                                                    <div class="col-md-12">
                                                                                        <textarea class="form-control" rows="15" id="queixas" name="queixas" readonly>{{ $registro->at_queixas }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="tab-pane fade"
                                                                            id="historico-evolucao-{{ $index }}">
                                                                            <div class="timeline-post">
                                                                                <h4 class="line-head">Evolução</h4>
                                                                                <div class="row mb-12">
                                                                                    <div class="col-md-12">
                                                                                        <textarea class="form-control" rows="15" id="evolucao" name="evolucao" readonly>{{ $registro->at_evolucao }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        {{-- <div class="tab-pane fade"
                                                                            id="historico-atestado-{{ $index }}">
                                                                            <div class="timeline-post">
                                                                                <h4 class="line-head">Solicitações</h4>
                                                                                <div class="row mb-12">
                                                                                    <div class="col-md-12">
                                                                                        <textarea class="form-control" rows="15" id="atestado" name="atestado" readonly>{{ $registro->at_atestado }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div> --}}
                                                                        <div class="tab-pane fade"
                                                                            id="historico-condicao-{{ $index }}">
                                                                            <div class="timeline-post">
                                                                                <h4 class="line-head">Condição Fisica</h4>
                                                                                <div class="row mb-12">
                                                                                    <div class="col-md-12">
                                                                                        <textarea class="form-control" rows="15" id="condicao" name="condicao" readonly>{{ $registro->at_evolucao }}</textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade"
                                                            id="historico-prescricao-{{ $index }}">
                                                            <div class="timeline-post">
                                                                <div class="col-md-12">
                                                                    <ul class="nav nav-tabs user-tabs">
                                                                        <li class="nav-item"><a class="nav-link active"
                                                                                href="#historico-exame-{{ $index }}"
                                                                                data-bs-toggle="tab">Exame</a></li>
                                                                        <li class="nav-item"><a class="nav-link"
                                                                                href="#historico-remedio-{{ $index }}"
                                                                                data-bs-toggle="tab">Remédio</a></li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="tab-content">
                                                                        <div class="tab-pane active"
                                                                            id="historico-exame-{{ $index }}">
                                                                            <div class="timeline-post">
                                                                                <div id="exame-container">
                                                                                    <table class="table">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Procedimento</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody id="exame-table-body">
                                                                                            @php
                                                                                                $procedimentos = explode(
                                                                                                    ',',
                                                                                                    $registro->procedimentos,
                                                                                                );
                                                                                            @endphp
                                                                                            @foreach ($procedimentos as $exame_id)
                                                                                                <tr class="exame-row">
                                                                                                    <td>{{ $exame_id }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endforeach
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="tab-pane fade"
                                                                            id="historico-remedio-{{ $index }}">
                                                                            <div class="timeline-post">
                                                                                <div id="prescricao-container">
                                                                                    <table class="table">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Remédio</th>
                                                                                                <th>Dose</th>
                                                                                                <th>Horas</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody id="prescricao-table-body">
                                                                                            @php
                                                                                                $medicamentos = explode(
                                                                                                    ',',
                                                                                                    $registro->medicamentos,
                                                                                                );
                                                                                                $doses = explode(
                                                                                                    ',',
                                                                                                    $registro->dose,
                                                                                                );
                                                                                                $horas = explode(
                                                                                                    ',',
                                                                                                    $registro->horas,
                                                                                                );
                                                                                            @endphp
                                                                                            @for ($i = 0; $i < count($medicamentos); $i++)
                                                                                                <tr class="prescricao-row">
                                                                                                    <td>{{ $medicamentos[$i] ?? '' }}
                                                                                                    </td>
                                                                                                    <td>{{ $doses[$i] ?? '' }}
                                                                                                    </td>
                                                                                                    <td>{{ $horas[$i] ?? '' }}
                                                                                                    </td>
                                                                                                </tr>
                                                                                            @endfor
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        </div>
    </main>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        $(document).ready(function() {
            $('#altura').mask('0.00');
        });

        function calcularIMC() {
            const peso = parseFloat(document.getElementById('peso').value);
            const altura = parseFloat(document.getElementById('altura').value);

            if (!isNaN(peso) && !isNaN(altura) && altura > 0) {
                const imc = peso / (altura * altura);
                document.getElementById('imc').value = imc.toFixed(2);

                let classificacao = '';
                if (imc < 18.5) {
                    classificacao = 'Peso baixo';
                } else if (imc >= 18.5 && imc <= 24.9) {
                    classificacao = 'Peso normal';
                } else if (imc >= 25 && imc <= 29.9) {
                    classificacao = 'Acima do peso';
                } else {
                    classificacao = 'Obesidade';
                }
                document.getElementById('classificacao').value = classificacao;
            } else {
                document.getElementById('imc').value = '';
                document.getElementById('classificacao').value = '';
            }
        }


        $(document).ready(function() {
            var agenda_id = "{{ $agenda->id }}"; // Valor correto para a agenda_id
            var paciente_id = "{{ $paciente->id }}"; // Valor correto para o paciente_id
            // alert("agenda_id: " + agenda_id + ", paciente_id: " + paciente_id);
            // Verificar se existem dados no banco antes de carregar o formulário
            $.ajax({
                url: '/atendimentos/' + agenda_id + '/' + paciente_id, // Ajuste a rota conforme necessário
                type: 'GET',
                success: function(response) {
                    // Se houver dados no banco, preencha o formulário
                    if (response.data) {
                        $('#queixas').val(response.data.queixas);
                        $('#evolucao').val(response.data.evolucao);
                        $('#atestado').val(response.data.atestado);
                        $('#condicao').val(response.data.condicao);
                    }
                },
                error: function(response) {
                    // alert('Erro ao carregar dados do banco.');
                    pass();
                }
            });

            $('#saveButton').on('click', function() {
                // Salvar dados do formulário no localStorage
                var formData = {
                    queixas: $('#queixas').val(),
                    evolucao: $('#evolucao').val(),
                    atestado: $('#atestado').val(),
                    condicao: $('#condicao').val(),
                };
                localStorage.setItem('formData', JSON.stringify(formData));

                // Definir a URL com base no atendimentoId
                var url = '/atendimentos/store';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $('#atendimentoForm').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Atendimento cadastrado/atualizado com sucesso');
                        // Atualize o campo atendimento_id com o ID retornado pelo servidor
                        $('#atendimento_id').val(response.atendimento_id);
                    },
                    error: function(response) {
                        alert('Ocorreu um erro. Tente novamente.');
                    }
                });
            });
        });

        $(document).ready(function() {
            // Verificar se já existe uma anamnese para o paciente na data atual
            $.ajax({
                url: '/anamneses/check/' + $('#paciente_id').val(),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.anamnese) {
                        // Se já existe uma anamnese, preencha os campos do formulário com os dados existentes
                        $('#pa').val(response.anamnese.pa);
                        $('#temp').val(response.anamnese.temp);
                        $('#peso').val(response.anamnese.peso);
                        $('#altura').val(response.anamnese.altura);
                        $('#imc').val(response.anamnese.imc);
                        $('#classificacao').val(response.anamnese.classificacao);
                        $('input[name="gestante"][value="' + response.anamnese.gestante + '"]').prop(
                            'checked', true);
                        $('#dextro').val(response.anamnese.dextro);
                        $('#spo2').val(response.anamnese.spo2);
                        $('#fc').val(response.anamnese.fc);
                        $('#fr').val(response.anamnese.fr);
                        $('#acolhimento').val(response.anamnese.acolhimento);
                        $('#acolhimento1').val(response.anamnese.acolhimento1);
                        $('#acolhimento2').val(response.anamnese.acolhimento2);
                        $('#acolhimento3').val(response.anamnese.acolhimento3);
                        $('#acolhimento4').val(response.anamnese.acolhimento4);
                        $('#alergia1').val(response.anamnese.alergia1);
                        $('#alergia2').val(response.anamnese.alergia2);
                        $('#alergia3').val(response.anamnese.alergia3);
                        $('#anamnese').val(response.anamnese.anamnese);
                        $('#agenda_id').val(response.anamnese.agenda_id);
                    }
                },
                error: function(response) {
                    // alert('Ocorreu um erro ao carregar os dados da anamnese. Tente novamente.');
                    pass();
                }
            });

            $('#saveAnamneseButton').on('click', function() {
                // Salvar dados do formulário no localStorage
                var formData = {
                    pa: $('#pa').val(),
                    temp: $('#temp').val(),
                    peso: $('#peso').val(),
                    altura: $('#altura').val(),
                    imc: $('#imc').val(),
                    classificacao: $('#classificacao').val(),
                    gestante: $('input[name="gestante"]:checked').val(),
                    dextro: $('#dextro').val(),
                    spo2: $('#spo2').val(),
                    fc: $('#fc').val(),
                    fr: $('#fr').val(),
                    acolhimento: $('#acolhimento').val(),
                    acolhimento1: $('#acolhimento1').val(),
                    acolhimento2: $('#acolhimento2').val(),
                    acolhimento3: $('#acolhimento3').val(),
                    acolhimento4: $('#acolhimento4').val(),
                    alergia1: $('#alergia1').val(),
                    alergia2: $('#alergia2').val(),
                    alergia3: $('#alergia3').val(),
                    anamnese: $('#anamnese').val(),
                    paciente_id: $('#paciente_id').val(),
                    profissional_id: $('#profissional_id').val(),
                    agenda_id: $('#agenda_id').val(),
                };

                // Enviar formulário via AJAX
                $.ajax({
                    url: '/anamneses/store',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Anamnese cadastrada/atualizada com sucesso');
                    },
                    error: function(response) {
                        alert('Ocorreu um erro. Tente novamente.');
                    }
                });
            });
        });

        $(document).ready(function() {
            var agenda_id = "{{ $agenda->id }}";
            var paciente_id = "{{ $paciente->id }}";

            function addPrescricaoRow() {
                var newRow = `
        <tr class="prescricao-row">
            <td>
                <select class="form-control medicamento_id" name="medicamento_id[]">
                    <option value="">Selecione o remédio</option>
                    @foreach ($medicamento as $item)
                        <option value="{{ $item->id }}">{{ $item->nome }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" class="form-control dose" name="dose[]" placeholder="Dose">
            </td>
            <td>
                <input type="number" class="form-control horas" name="horas[]" placeholder="Horas">
            </td>
            <td>
                <button type="button" class="btn btn-success add-row">+</button>
                <button type="button" class="btn btn-danger remove-row">-</button>
            </td>
        </tr>`;
                $('#prescricao-table-body').append(newRow);
            }

            $(document).on('click', '.add-row', function() {
                addPrescricaoRow();
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('.prescricao-row').remove();
            });

            // Verificar se existem dados no banco antes de carregar o formulário
            $.ajax({
                url: '/remedios/' + agenda_id + '/' + paciente_id,
                type: 'GET',
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        // Se houver dados no banco, preencha o formulário
                        response.data.forEach(function(remedio) {
                            addPrescricaoRow();
                            $('#prescricao-table-body').find('.prescricao-row:last').find(
                                '.medicamento_id').val(remedio.medicamento_id);
                            $('#prescricao-table-body').find('.prescricao-row:last').find(
                                '.dose').val(remedio.dose);
                            $('#prescricao-table-body').find('.prescricao-row:last').find(
                                '.horas').val(remedio.horas);
                        });
                    }
                },
                error: function(response) {
                    //alert('Erro ao carregar dados do banco.');
                }
            });

            $('#saveRemedioButton').on('click', function() {
                var formData = {
                    medicamento_id: [],
                    dose: [],
                    horas: []
                };

                $('.medicamento_id').each(function() {
                    formData.medicamento_id.push($(this).val());
                });

                $('.dose').each(function() {
                    formData.dose.push($(this).val());
                });

                $('.horas').each(function() {
                    formData.horas.push($(this).val());
                });

                localStorage.setItem('formData', JSON.stringify(formData));

                var url = '/remedios/store';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $('#remedioForm').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Prescrição de remédios cadastrada/atualizada com sucesso');
                    },
                    error: function(response) {
                        alert('Ocorreu um erro. Tente novamente.');
                    }
                });
            });
        });

        $(document).ready(function() {
            var agenda_id = "{{ $agenda->id }}"; // Valor correto para a agenda_id
            var paciente_id = "{{ $paciente->id }}"; // Valor correto para o paciente_id

            function addExameRow() {
                var newRow = `
        <tr class="exame-row">
            <td>
                <select class="form-control procedimento_id" name="procedimento_id[]">
                    <option value="">Selecione o Procedimento</option>
                    @foreach ($procedimento as $item)
                        <option value="{{ $item->id }}">{{ $item->procedimento }}</option>
                    @endforeach
                </select>
            </td>
            <td class="actions">
                <button type="button" class="btn btn-success plus-row">+</button>
                <button type="button" class="btn btn-danger delete-row">-</button>
            </td>
        </tr>`;
                $('#exame-table-body').append(newRow);
            }

            // Adiciona uma nova linha de procedimento quando o botão '+' é clicado
            $(document).on('click', '.plus-row', function() {
                addExameRow();
            });

            // Remove a linha de procedimento quando o botão '-' é clicado
            $(document).on('click', '.delete-row', function() {
                $(this).closest('.exame-row').remove();
            });

            // Verificar se existem dados no banco antes de carregar o formulário
            $.ajax({
                url: '/exames/' + agenda_id + '/' + paciente_id, // Ajuste a rota conforme necessário
                type: 'GET',
                success: function(response) {
                    // Se houver dados no banco, preencha o formulário
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(item) {
                            addExameRow();
                            $('#exame-table-body').find('.exame-row:last').find(
                                '.procedimento_id').val(item.procedimento_id);
                        });
                    }
                },
                error: function(response) {
                    // alert('Erro ao carregar dados do banco.');
                }
            });

            $('#saveExameButton').on('click', function() {
                // Salvar dados do formulário no localStorage
                var formData = {
                    procedimento_id: []
                };

                $('.procedimento_id').each(function() {
                    formData.procedimento_id.push($(this).val());
                });

                localStorage.setItem('formData', JSON.stringify(formData));

                // Definir a URL com base no atendimentoId
                var url = '/exames/store';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $('#exameForm').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Exame cadastrado/atualizado com sucesso');
                        // Atualize o campo atendimento_id com o ID retornado pelo servidor
                    },
                    error: function(response) {
                        alert('Ocorreu um erro. Tente novamente.');
                    }
                });
            });
        });

        document.getElementById('enviarBtn').addEventListener('click', function() {
            $('#confirmModal').modal('show');
        });

        document.getElementById('confirmPrintBtn').addEventListener('click', function() {
            document.getElementById('printForm').submit();
            $('#confirmModal').modal('hide');
        });


        document.getElementById('enviarAtes').addEventListener('click', function() {
            // Capture the selected radio button value
            let selectedOption = document.querySelector('input[name="flexRadioDefault"]:checked')?.value;
            if (!selectedOption) {
                console.error('Nenhuma opção selecionada.');
                alert('Por favor, selecione uma opção.');
                return;
            }

            let dia_id = document.getElementById('dia_id')?.value || '0';
            let obs_id = document.getElementById('obs_id')?.value || '-';
            console.log('Dia ID:', dia_id);

            let paciente_id = document.getElementById('paciente_id1')?.value || '';
            let agenda_id = document.getElementById('agenda_id1')?.value || '';
            let profissional_id = document.getElementById('profissional_id1')?.value || '';

            if (!paciente_id || !agenda_id || !profissional_id) {
                console.error('Dados incompletos.');
                alert('Dados incompletos. Por favor, verifique os campos.');
                return;
            }

            // AJAX request
            $.ajax({
                url: '/solicitacoes', // Your route here
                type: 'POST',
                data: {
                    selectedOption: selectedOption,
                    dia_id: dia_id,
                    obs_id: obs_id,
                    paciente_id: paciente_id,
                    agenda_id: agenda_id,
                    profissional_id: profissional_id,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function(response) {
                    // Open the new view in another tab
                    window.open(response.redirect_url, '_blank');
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        // Show/Hide input based on selected radio button
        document.querySelectorAll('input[name="flexRadioDefault"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'atestado') {
                    document.getElementById('diasInput').style.display = 'block';
                } else {
                    document.getElementById('diasInput').style.display = 'none';
                }
            });
        });

    </script>
@endsection

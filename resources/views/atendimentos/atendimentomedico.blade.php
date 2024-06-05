@extends('layouts.app')
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-receipt"></i> Atendimento</h1>
                <p>{{ $paciente->name }} {{ $paciente->sobrenome }}</p>
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
                        <li class="nav-item"><a class="nav-link" href="#atendimento-evolucao"
                                data-bs-toggle="tab">Evolução</a></li>
                        <li class="nav-item"><a class="nav-link" href="#atendimento-atestado"
                                data-bs-toggle="tab">Atestado</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-10">
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
                                                <div class="row">
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label"><strong>PA mmHg:</strong></label>
                                                        <input class="form-control" id="pa" name="pa"
                                                            type="text">
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label"><strong>Temp(ºC):</strong></label>
                                                        <input class="form-control" id="temp" name="temp"
                                                            type="text">
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label"><strong>Peso(Kg):</strong></label>
                                                        <input class="form-control" id="peso" name="peso"
                                                            type="text">
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <label class="form-label"><strong>Altura(cm):</strong></label>
                                                        <input class="form-control" id="altura" name="altura"
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
                                                        <input class="form-control" id="acolhimento" name="acolhimento"
                                                            type="text">
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
                                                        <input class="form-control" id="acolhimento1" name="acolhimento1"
                                                            type="text">
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <input class="form-control" id="acolhimento2" name="acolhimento2"
                                                            type="text">
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <input class="form-control" id="acolhimento3" name="acolhimento3"
                                                            type="text">
                                                    </div>
                                                    <div class="mb-3 col-md-3">
                                                        <input class="form-control" id="acolhimento4" name="acolhimento4"
                                                            type="text">
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
                                                    <button id="saveAnamneseButton" class="btn btn-primary"
                                                        type="button"><i
                                                            class="bi bi-check-circle-fill me-2"></i>Salvar</button>
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
                                    <li class="nav-item"><a class="nav-link" href="#atendimento-exame"
                                            data-bs-toggle="tab">Exame Fisico</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#atendimento-plano"
                                            data-bs-toggle="tab">Plano Terapêutico</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#atendimento-hipoteses"
                                            data-bs-toggle="tab">Hipóteses Diagnósticas</a></li>
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
                                <input class="form-control" id="profissional_id" name="profissional_id" type="text"
                                    value="{{ $agenda->profissional_id }}" hidden>
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
                                        <div class="tab-pane fade" id="atendimento-exame">
                                            <div class="timeline-post">
                                                <h4 class="line-head">Exame Fisico</h4>
                                                <div class="row mb-12">
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" rows="15" id="exame" name="exame"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="atendimento-plano">
                                            <div class="timeline-post">
                                                <h4 class="line-head">Plano Terapêutico</h4>
                                                <div class="row mb-12">
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" rows="15" id="plano" name="plano"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="atendimento-hipoteses">
                                            <div class="timeline-post">
                                                <h4 class="line-head">Hipóteses Diagnósticas</h4>
                                                <div class="row mb-12">
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" rows="15" id="hipoteses" name="hipoteses"></textarea>
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
                                <hr>
                                <div class="tile-footer">
                                    <button class="btn btn-danger" type="button" id="saveButton"><i
                                            class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="atendimento-prescricao">
                        <div class="timeline-post">
                            <h4 class="line-head">Prescrição</h4>
                            <div class="col-md-12">
                                <ul class="nav nav-tabs user-tabs">
                                    <li class="nav-item"><a class="nav-link active" href="#prescricao-exame"
                                            data-bs-toggle="tab">Exame</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#prescricao-remedio"
                                            data-bs-toggle="tab">Remedio</a></li>
                                </ul>
                            </div>
                            <form method="POST" action="#">
                                @csrf
                                <input class="form-control" id="paciente_id" name="paciente_id" type="text"
                                    value="{{ $paciente->id }}" hidden>
                                <input class="form-control" id="agenda_id" name="agenda_id" type="text"
                                    value="{{ $agenda->id }}" hidden>
                                <div class="col-md-12">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="prescricao-exame">
                                            <div class="timeline-post">
                                                <h4 class="line-head">Exame</h4>
                                                <div class="row mb-12">
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" rows="15" id="atestado" name="atestado"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="prescricao-remedio">
                                            <div class="timeline-post">
                                                <h4 class="line-head">Remedio</h4>
                                                <div class="row mb-12">
                                                    <div class="col-md-12">
                                                        <textarea class="form-control" rows="15" id="atestado" name="atestado"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="bi bi-check-circle-fill me-2"></i>Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="atendimento-evolucao">
                        <div class="timeline-post">
                            <h4 class="line-head">Evolução</h4>
                            <form method="POST" action="#">
                                @csrf
                                <input class="form-control" id="paciente_id" name="paciente_id" type="text"
                                    value="{{ $paciente->id }}" hidden>
                                <input class="form-control" id="agenda_id" name="agenda_id" type="text"
                                    value="{{ $agenda->id }}" hidden>
                                <div class="row mb-12">
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="15" id="atestado" name="atestado"></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="bi bi-check-circle-fill me-2"></i>Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="atendimento-atestado">
                        <div class="timeline-post">
                            <h4 class="line-head">Atestado</h4>
                            <form method="POST" action="#">
                                @csrf
                                <input class="form-control" id="paciente_id" name="paciente_id" type="text"
                                    value="{{ $paciente->id }}" hidden>
                                <input class="form-control" id="agenda_id" name="agenda_id" type="text"
                                    value="{{ $agenda->id }}" hidden>
                                <div class="row mb-12">
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="15" id="atestado" name="atestado"></textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="tile-footer">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="bi bi-check-circle-fill me-2"></i>Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
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
                        $('#exame').val(response.data.exame);
                        $('#plano').val(response.data.plano);
                        $('#hipoteses').val(response.data.hipoteses);
                        $('#condicao').val(response.data.condicao);
                    }
                },
                error: function(response) {
                    alert('Erro ao carregar dados do banco.');
                }
            });

            $('#saveButton').on('click', function() {
                // Salvar dados do formulário no localStorage
                var formData = {
                    queixas: $('#queixas').val(),
                    exame: $('#exame').val(),
                    plano: $('#plano').val(),
                    hipoteses: $('#hipoteses').val(),
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
                    }
                },
                error: function(response) {
                    alert('Ocorreu um erro ao carregar os dados da anamnese. Tente novamente.');
                }
            });

            $('#saveAnamneseButton').on('click', function() {
                // Salvar dados do formulário no localStorage
                var formData = {
                    pa: $('#pa').val(),
                    temp: $('#temp').val(),
                    peso: $('#peso').val(),
                    altura: $('#altura').val(),
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
    </script>
@endsection

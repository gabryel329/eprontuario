@extends('layouts.app')
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Lista de Guias</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Faturamento</li>
                <li class="breadcrumb-item"><a href="#">Baixas</a></li>
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
            <div class="tile">
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Selecione o Convênio</label>
                            <select name="convenio_id" id="convenio_id" class="form-select" required>
                                <option value="">Escolha o Convênio</option>
                                @foreach ($convenios as $convenio)
                                    <option value="{{ $convenio->id }}">{{ $convenio->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipo da Guia</label>
                            <select id="tipo_guia" class="form-select">
                                <option value="">Selecione o tipo de guia</option>
                                <option value="consulta">Consulta</option>
                                <option value="sadt">SADT</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome do Paciente</label>
                            <input type="text" id="nome_paciente" class="form-control"
                                placeholder="Digite o nome do paciente">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Número do Lote</label>
                            <input type="text" id="numero_lote" class="form-control"
                                placeholder="Digite o número do lote">
                        </div>

                        <div class="col-md-12 d-flex justify-content-end">
                            <button type="button" id="btnFiltrar" class="btn btn-primary">
                                <i class="bi bi-funnel"></i> Filtrar
                            </button>
                        </div>
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
                                    <a class="nav-link" href="#honorario" data-bs-toggle="tab"
                                        data-identificador="GERADO">Guias Geradas</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tile-title d-flex justify-content-between align-items-center">
                        <label class="form-label"></label>
                        <button type="button" class="btn btn-success" id="btnGerarGuias" disabled>
                            <i class="bi bi-file-earmark-zip"></i> Dar baixa nas Guias Selecionadas
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
                            <tbody >
                            </tbody>
                        </table>
                        <div id="paginacao" class="mt-3 text-center">
                        </div>
                    </div>
                </div>
            </div>
    </main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(document).ready(function() {
    $('#btnFiltrar').on('click', function() {
        let convenioId = $('#convenio_id').val();
        let tipoGuia = $('#tipo_guia').val();
        let nomePaciente = $('#nome_paciente').val();
        let numeroLote = $('#numero_lote').val();

        let url = tipoGuia === 'consulta' ? '{{ route('baixas.filtrarConsulta') }}' : '{{ route('baixas.filtrarSadt') }}';

        $.ajax({
            url: url,
            method: 'GET',
            data: {
                convenio_id: convenioId,
                tipo_guia: tipoGuia,
                nome_paciente: nomePaciente,
                numero_lote: numeroLote
            },
            success: function(response) {
                let tbody = $('table tbody');
                tbody.empty();

                if (response.length > 0) {
                    $.each(response, function(index, guia) {
                        var data = new Date(guia.created_at);
                        var dataFormatada = data.toLocaleDateString('pt-BR', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        });
                        tbody.append(`
                            <tr>
                                <td><input type="checkbox" class="guia-checkbox" value="${guia.id}" /></td>
                                <td>${guia.id}</td>
                                <td>${guia.nome_beneficiario}</td>
                                <td>${guia.numeracao ?? '0'}</td>
                                <td>${dataFormatada}</td>
                                <td>
                                    <button class="btn btn-sm btn-info">Ver</button>
                                </td>
                            </tr>
                        `);
                    });
                    $('#btnGerarGuias').prop('disabled', false);
                } else {
                    tbody.append('<tr><td colspan="6">Nenhuma guia encontrada.</td></tr>');
                    $('#btnGerarGuias').prop('disabled', true);
                }
            },
            error: function() {
                alert('Erro ao buscar as guias.');
            }
        });
    });
});
</script>
@endsection

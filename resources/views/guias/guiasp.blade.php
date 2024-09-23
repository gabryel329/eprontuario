@extends('layouts.app')
@section('content')
    <main class="app-content">
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
                    <div class="tile-title d-flex justify-content-between align-items-center">
                        <label class="form-label">Lista de Guias</label>
                        <button type="button" class="btn btn-primary" id="btnNovoGuia" data-bs-toggle="modal" data-bs-target="#novoGuiaModal" disabled>
                            <i class="bi bi-plus-circle"></i> Novo
                        </button>
                    </div>
                    <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Registro ANS</th>
                                <th>Data</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="listaGuias">
                            <!-- Guias serão listadas aqui via AJAX -->
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
<div class="modal fade" id="visualizarGuiaModal" tabindex="-1" aria-labelledby="visualizarGuiaModalLabel" aria-hidden="true">
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
            <input type="hidden" id="convenio_id_hidden" name="convenio_id">
            <div class="row">
                <div class="mb-3 col-md-2">
                    <label class="form-label"><strong>1- Registro ANS</strong></label>
                    <input class="form-control" id="registro_ans" name="registro_ans" type="text" readonly>
                </div>
                <div class="mb-3 col-md-2">
                    <label class="form-label">2- Nº da guia no prestador</label>
                    <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador" type="text" readonly>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">4- Nº da carteira do beneficiário</label>
                    <input class="form-control" id="numero_carteira" name="numero_carteira" type="text" readonly>
                </div>
                <div class="mb-3 col-md-8">
                    <label class="form-label">7- Nome do beneficiário</label>
                    <input class="form-control" id="nome_beneficiario" name="nome_beneficiario" type="text" readonly>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">18- Data da realização</label>
                    <input class="form-control" id="data_atendimento" name="data_atendimento" type="date" readonly>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">Hora Início do Atendimento</label>
                    <input class="form-control" id="hora_inicio_atendimento" name="hora_inicio_atendimento" type="text" readonly>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">19- Tipo de consulta</label>
                    <input class="form-control" id="tipo_consulta" name="tipo_consulta" type="text" readonly>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">17- Indicação de acidente</label>
                    <input class="form-control" id="indicacao_acidente" name="indicacao_acidente" type="text" readonly>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">20- Código da Tabela</label>
                    <input class="form-control" id="codigo_tabela" name="codigo_tabela" type="text" readonly>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">21- Código do procedimento</label>
                    <input class="form-control" id="codigo_procedimento" name="codigo_procedimento" type="text" readonly>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">22- Valor do procedimento</label>
                    <input class="form-control" id="valor_procedimento" name="valor_procedimento" type="text" readonly>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">12- Nome do profissional</label>
                    <input class="form-control" id="nome_profissional" name="nome_profissional" type="text" readonly>
                </div>
                <div class="mb-3 col-md-2">
                    <label class="form-label">13- Sigla do conselho</label>
                    <input class="form-control" id="sigla_conselho" name="sigla_conselho" type="text" readonly>
                </div>
                <div class="mb-3 col-md-2">
                    <label class="form-label">14- Nº do conselho</label>
                    <input class="form-control" id="numero_conselho" name="numero_conselho" type="text" readonly>
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

<!-- Modal para criar nova guia -->
<div class="modal fade" id="novoGuiaModal" tabindex="-1" aria-labelledby="novoGuiaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novoGuiaModalLabel">Guia de Consulta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('guiasp.store')}}" method="POST" enctype="multipart/form-data" id="formNovaGuia">
                    @csrf
                    <input type="hidden" id="convenio_id_hidden" name="convenio_id">
                    <div class="row">
                    <div class="mb-3 col-md-4">
                        <label class="form-label"><strong>1- Registro ANS</strong></label>
                        <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">2- Nº da guia no prestador</label>
                        <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador" type="text" value="{{ old('numero_guia_prestador') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">4- Nº da carteira do beneficiário</label>
                        <input class="form-control" id="numero_carteira" name="numero_carteira" type="text" value="{{ old('numero_carteira') }}">
                    </div>
                    <div class="mb-3 col-md-8">
                        <label class="form-label">7- Nome do beneficiário</label>
                        <input class="form-control" id="nome_beneficiario" name="nome_beneficiario" type="text" value="{{ old('nome_beneficiario') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">18- Data da realização</label>
                        <input class="form-control" id="data_atendimento" name="data_atendimento" type="date" value="{{ old('data_atendimento') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Hora Início do Atendimento</label>
                        <input class="form-control" id="hora_inicio_atendimento" name="hora_inicio_atendimento" type="text" value="{{ old('hora_inicio_atendimento') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">19- Tipo de consulta</label>
                        <input class="form-control" id="tipo_consulta" name="tipo_consulta" type="text" value="{{ old('tipo_consulta') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">17- Indicação de acidente</label>
                        <input class="form-control" id="indicacao_acidente" name="indicacao_acidente" type="text" value="{{ old('indicacao_acidente') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">20- Tabela</label>
                        <input class="form-control" id="codigo_tabela" name="codigo_tabela" type="text" value="{{ old('codigo_tabela') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">21- Cód. do procedimento</label>
                        <input class="form-control" id="codigo_procedimento" name="codigo_procedimento" type="text" value="{{ old('codigo_procedimento') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">22- Valor do procedimento</label>
                        <input class="form-control" id="valor_procedimento" name="valor_procedimento" type="text" value="{{ old('valor_procedimento') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">12- Nome do profissional</label>
                        <input class="form-control" id="nome_profissional" name="nome_profissional" type="text" value="{{ old('nome_profissional') }}">
                    </div>
                    <div class="mb-3 col-md-2">
                        <label class="form-label">13- Conselho</label>
                        <input class="form-control" id="sigla_conselho" name="sigla_conselho" type="text" value="{{ old('sigla_conselho') }}">
                    </div>
                    <div class="mb-3 col-md-2">
                        <label class="form-label">14- Nº profissional</label>
                        <input class="form-control" id="numero_conselho" name="numero_conselho" type="text" value="{{ old('numero_conselho') }}">
                    </div>
                    <div class="mb-3 col-md-2">
                        <label class="form-label">15- UF</label>
                        <input class="form-control" id="uf_conselho" name="uf_conselho" type="text" value="{{ old('uf_conselho') }}">
                    </div>
                    <div class="mb-3 col-md-2">
                        <label class="form-label">16- CBO</label>
                        <input class="form-control" id="cbo" name="cbo" type="text" value="{{ old('cbo') }}">
                    </div>
                    <div class="mb-3 col-md-12">
                        <label class="form-label">23- Observação / Justificativa</label>
                        <input class="form-control" id="observacao" name="observacao" type="text" value="{{ old('observacao') }}">
                    </div>
                    <div class="mb-3 col-md-4">
                        <label class="form-label">Hash</label>
                        <input class="form-control" id="hash" name="hash" type="text" value="{{ old('hash') }}">
                    </div>
                </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4 align-self-end">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-check-circle-fill me-2"></i>Salvar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(document).ready(function(){
    $('#hora_inicio_atendimento').mask('00:00');
});

$(document).ready(function() {
    $('#convenio_id').change(function() {
        var convenio_id = $(this).val();
        if (convenio_id) {
            $.ajax({
                url: '/guia-sp/listar',
                type: 'GET',
                data: { convenio_id: convenio_id },
                success: function(response) {
                    if (response.guias && response.guias.length > 0) {
                        var html = '';
                        $.each(response.guias, function(index, guia) {
                            var data = new Date(guia.created_at);
                            var dataFormatada = data.toLocaleDateString('pt-BR', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });

                            html += '<tr>';
                            html += '<td>' + guia.id + '</td>';
                            html += '<td>' + guia.registro_ans + '</td>';
                            html += '<td>' + dataFormatada + '</td>';
                            html += '<td>';
                            html += '<button type="button" class="btn btn-info btnVisualizarGuia" data-id="' + guia.id + '">';
                            html += 'Visualizar';
                            html += '</button>';
                            html += '</td>';
                            html += '</tr>';
                        });
                        $('#listaGuias').html(html);
                    } else {
                        $('#listaGuias').html('<tr><td colspan="4">Nenhuma guia encontrada para este convênio.</td></tr>');
                    }
                    $('#btnNovoGuia').prop('disabled', false);
                    $('#convenio_id_hidden').val(convenio_id);
                },
                error: function() {
                    alert('Erro ao buscar as guias.');
                    $('#btnNovoGuia').prop('disabled', true);
                }
            });
        } else {
            $('#listaGuias').html('');
            $('#btnNovoGuia').prop('disabled', true);
        }
    });

    $(document).on('click', '.btnVisualizarGuia', function() {
    var guiaId = $(this).data('id');
    
    // Fazer a requisição AJAX para buscar os detalhes da guia
    $.ajax({
        url: '/guia-sp/detalhes/' + guiaId,  // Atualize para a rota correta
        type: 'GET',
        success: function(response) {
            // Preencher os campos do formulário com os dados da guia
            $('#user_id').val(response.user_id);
            $('#convenio_id_hidden').val(response.convenio_id);
            $('#registro_ans').val(response.registro_ans);
            $('#numero_guia_prestador').val(response.numero_guia_prestador);
            $('#numero_carteira').val(response.numero_carteira);
            $('#nome_beneficiario').val(response.nome_beneficiario);
            $('#data_atendimento').val(response.data_atendimento);
            $('#hora_inicio_atendimento').val(response.hora_inicio_atendimento);
            $('#tipo_consulta').val(response.tipo_consulta);
            $('#indicacao_acidente').val(response.indicacao_acidente);
            $('#codigo_tabela').val(response.codigo_tabela);
            $('#codigo_procedimento').val(response.codigo_procedimento);
            $('#valor_procedimento').val(response.valor_procedimento);
            $('#nome_profissional').val(response.nome_profissional);
            $('#sigla_conselho').val(response.sigla_conselho);
            $('#numero_conselho').val(response.numero_conselho);
            $('#uf_conselho').val(response.uf_conselho);
            $('#cbo').val(response.cbo);
            $('#observacao').val(response.observacao);
            $('#hash').val(response.hash);
            
            // Abrir o modal
            $('#visualizarGuiaModal').modal('show');
        },
        error: function() {
            alert('Erro ao buscar os detalhes da guia.');
        }
    });
});
});
</script>
@endsection

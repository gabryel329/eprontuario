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
            <input type="hidden" id="convenio_id" name="convenio_id">
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
                <form action="{{ route('guiasp.store') }}" method="POST" enctype="multipart/form-data" id="formNovaGuia">
                    @csrf
                    <input type="hidden" id="convenio_id_hidden" name="convenio_id">

                    <div class="row">
                        <!-- Registro ANS -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label"><strong>1- Registro ANS</strong></label>
                            <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                        </div>

                        <!-- Número da Guia do Prestador -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">3- Nº da Guia do Prestador</label>
                            <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador" type="text" value="{{ old('numero_guia_prestador') }}">
                        </div>

                        <!-- Data da Autorização -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">4- Data da autorização</label>
                            <input class="form-control" id="data_autorizacao" name="data_autorizacao" type="date" value="{{ old('data_autorizacao') }}">
                        </div>

                        <!-- Senha -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">5- Senha</label>
                            <input class="form-control" id="senha" name="senha" type="text" value="{{ old('senha') }}">
                        </div>

                        <!-- Data de Validade da Senha -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">6- Data de Validade da Senha</label>
                            <input class="form-control" id="validade_senha" name="validade_senha" type="date" value="{{ old('validade_senha') }}">
                        </div>

                        <!-- Número da Guia Atribuído pela Operadora -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">7- Nº da Guia Atribuído pela Operadora</label>
                            <input class="form-control" id="numero_guia_op" name="numero_guia_op" type="text" value="{{ old('numero_guia_op') }}">
                        </div>

                        <!-- Número da Carteira -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">8- Nº da Carteira</label>
                            <input class="form-control" id="numero_carteira" name="numero_carteira" type="text" value="{{ old('numero_carteira') }}">
                        </div>

                        <!-- Validade da Carteira -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">9- Validade da Carteira</label>
                            <input class="form-control" id="validade_carteira" name="validade_carteira" type="date" value="{{ old('validade_carteira') }}">
                        </div>

                        <!-- Nome Beneficiário -->
                        <div class="mb-3 col-md-8">
                            <label class="form-label">10- Nome Beneficiário</label>
                            <input class="form-control" id="nome_beneficiario" name="nome_beneficiario" type="text" value="{{ old('nome_beneficiario') }}">
                        </div>

                        <!-- Atendimento a RN -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">12- Atendimento a RN</label>
                            <select class="form-control" id="atendimento_rn" name="atendimento_rn">
                                <option value="0" {{ old('atendimento_rn') == '0' ? 'selected' : '' }}>Não</option>
                                <option value="1" {{ old('atendimento_rn') == '1' ? 'selected' : '' }}>Sim</option>
                            </select>
                        </div>

                        <!-- Nome do Profissional Solicitante -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">15- Nome do Profissional Solicitante</label>
                            <input class="form-control" id="nome_profissional_solicitante" name="nome_profissional_solicitante" type="text" value="{{ old('nome_profissional_solicitante') }}">
                        </div>

                        <!-- Conselho Profissional -->
                        <div class="mb-3 col-md-2">
                            <label class="form-label">16- Conselho Profissional</label>
                            <input class="form-control" id="conselho_profissional" name="conselho_profissional" type="text" value="{{ old('conselho_profissional') }}">
                        </div>

                        <!-- Número do Conselho -->
                        <div class="mb-3 col-md-2">
                            <label class="form-label">17- Nº do Conselho</label>
                            <input class="form-control" id="numero_conselho" name="numero_conselho" type="text" value="{{ old('numero_conselho') }}">
                        </div>

                        <!-- UF do Conselho -->
                        <div class="mb-3 col-md-2">
                            <label class="form-label">18- UF</label>
                            <input class="form-control" id="uf_conselho" name="uf_conselho" type="text" value="{{ old('uf_conselho') }}">
                        </div>

                        <!-- Código CBO -->
                        <div class="mb-3 col-md-2">
                            <label class="form-label">19- Código CBO</label>
                            <input class="form-control" id="codigo_cbo" name="codigo_cbo" type="text" value="{{ old('codigo_cbo') }}">
                        </div>

                        <!-- Código do Procedimento Solicitado -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">25- Código do Procedimento Solicitado</label>
                            <input class="form-control" id="codigo_procedimento_solicitado" name="codigo_procedimento_solicitado" type="text" value="{{ old('codigo_procedimento_solicitado') }}">
                        </div>

                        <!-- Descrição do Procedimento -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">26- Descrição do Procedimento</label>
                            <input class="form-control" id="descricao_procedimento" name="descricao_procedimento" type="text" value="{{ old('descricao_procedimento') }}">
                        </div>

                        <!-- Código da Operadora Executante -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">29- Código da Operadora Executante</label>
                            <input class="form-control" id="codigo_operadora_executante" name="codigo_operadora_executante" type="text" value="{{ old('codigo_operadora_executante') }}">
                        </div>

                        <!-- Nome do Contratado Executante -->
                        <div class="mb-3 col-md-8">
                            <label class="form-label">30- Nome do Contratado Executante</label>
                            <input class="form-control" id="nome_contratado_executante" name="nome_contratado_executante" type="text" value="{{ old('nome_contratado_executante') }}">
                        </div>

                        <!-- Código CNES -->
                        <div class="mb-3 col-md-4">
                            <label class="form-label">31- Código CNES</label>
                            <input class="form-control" id="codigo_cnes" name="codigo_cnes" type="text" value="{{ old('codigo_cnes') }}">
                        </div>

                        <!-- Observação -->
                        <div class="mb-3 col-md-12">
                            <label class="form-label">58- Observação / Justificativa</label>
                            <textarea class="form-control" id="observacao" name="observacao">{{ old('observacao') }}</textarea>
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
                            html += '<button type="button" class="btn btn-info btnVisualizarGuia" data-id="' + guia.id + '">Visualizar</button> ';
                            html += '<a href="/guia/sp/' + guia.id + '" class="btn btn-primary" target="_blank">';
                            html += '<i class="bi bi-printer"></i> Imprimir';
                            html += '</a>';
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

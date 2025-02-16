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

<!-- Modal para visualização de guias -->
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
<!-- Modal para criar nova guia -->
<div class="modal fade" id="novoGuiaModal" tabindex="-1" aria-labelledby="novoGuiaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('guiahonorario.store')}}" method="POST" enctype="multipart/form-data" id="formNovaGuia">
                    @csrf
                    <input type="hidden" id="convenio_id_hidden" name="convenio_id">
                    
                    <h5><strong>Guia de Consulta</strong></h5>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="registro_ans" class="form-label"><strong>Registro ANS</strong></label>
                            <input class="form-control" id="registro_ans" name="registro_ans" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="numero_guia_operadora" class="form-label"><strong>Nº Guia Atribuído pela Operadora</strong></label>
                            <input class="form-control" id="numero_guia_operadora" name="numero_guia_operadora" type="text">
                        </div>
                    </div>

                    <!-- Dados do Beneficiário -->
                    <h5><strong>Dados do Beneficiário</strong></h5>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="numero_carteira" class="form-label"><strong>Número da Carteira</strong></label>
                            <input class="form-control" id="numero_carteira" name="numero_carteira" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="validade_carteira" class="form-label"><strong>Validade da Carteira</strong></label>
                            <input class="form-control" id="validade_carteira" name="validade_carteira" type="date">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="atendimento_rn" class="form-label"><strong>Atendimento RN</strong></label>
                            <select class="form-select" id="atendimento_rn" name="atendimento_rn">
                                <option value="1">Sim</option>
                                <option value="0">Não</option>
                            </select>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="nome_social" class="form-label"><strong>Nome Social</strong></label>
                            <input class="form-control" id="nome_social" name="nome_social" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="nome_beneficiario" class="form-label"><strong>Nome do Beneficiário</strong></label>
                            <input class="form-control" id="nome_beneficiario" name="nome_beneficiario" type="text">
                        </div>
                    </div>

                    <!-- Dados do Contratado -->
                    <h5><strong>Dados do Contratado</strong></h5>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="codigo_operadora" class="form-label"><strong>Código na Operadora</strong></label>
                            <input class="form-control" id="codigo_operadora" name="codigo_operadora" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="nome_contratado" class="form-label"><strong>Nome do Contratado</strong></label>
                            <input class="form-control" id="nome_contratado" name="nome_contratado" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="codigo_cnes" class="form-label"><strong>Código CNES</strong></label>
                            <input class="form-control" id="codigo_cnes" name="codigo_cnes" type="text">
                        </div>
                    </div>

                    <!-- Dados do Profissional Executante -->
                    <h5><strong>Dados do Profissional Executante</strong></h5>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="nome_profissional_executante" class="form-label"><strong>Nome do Profissional Executante</strong></label>
                            <input class="form-control" id="nome_profissional_executante" name="nome_profissional_executante" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="conselho_profissional" class="form-label"><strong>Conselho Profissional</strong></label>
                            <input class="form-control" id="conselho_profissional" name="conselho_profissional" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="numero_conselho" class="form-label"><strong>Número no Conselho</strong></label>
                            <input class="form-control" id="numero_conselho" name="numero_conselho" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="uf_conselho" class="form-label"><strong>UF do Conselho</strong></label>
                            <input class="form-control" id="uf_conselho" name="uf_conselho" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="codigo_cbo" class="form-label"><strong>Código CBO</strong></label>
                            <input class="form-control" id="codigo_cbo" name="codigo_cbo" type="text">
                        </div>
                    </div>

                    <!-- Dados do Atendimento / Procedimento Realizado -->
                    <h5><strong>Dados do Atendimento / Procedimento Realizado</strong></h5>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="indicacao_acidente" class="form-label"><strong>Indicação de Acidente</strong></label>
                            <input class="form-control" id="indicacao_acidente" name="indicacao_acidente" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="indicacao_cobertura_especial" class="form-label"><strong>Indicação de Cobertura Especial</strong></label>
                            <input class="form-control" id="indicacao_cobertura_especial" name="indicacao_cobertura_especial" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="regime_atendimento" class="form-label"><strong>Regime de Atendimento</strong></label>
                            <input class="form-control" id="regime_atendimento" name="regime_atendimento" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="saude_ocupacional" class="form-label"><strong>Saúde Ocupacional</strong></label>
                            <input class="form-control" id="saude_ocupacional" name="saude_ocupacional" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="data_atendimento" class="form-label"><strong>Data do Atendimento</strong></label>
                            <input class="form-control" id="data_atendimento" name="data_atendimento" type="date">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="tipo_consulta" class="form-label"><strong>Tipo de Consulta</strong></label>
                            <input class="form-control" id="tipo_consulta" name="tipo_consulta" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="codigo_tabela" class="form-label"><strong>Código da Tabela</strong></label>
                            <input class="form-control" id="codigo_tabela" name="codigo_tabela" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="codigo_procedimento" class="form-label"><strong>Código do Procedimento</strong></label>
                            <input class="form-control" id="codigo_procedimento" name="codigo_procedimento" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="valor_procedimento" class="form-label"><strong>Valor do Procedimento</strong></label>
                            <input class="form-control" id="valor_procedimento" name="valor_procedimento" type="text">
                        </div>
                    </div>

                    <!-- Observações e Assinaturas -->
                    <h5><strong>Observações</strong></h5>
                    <div class="mb-3 col-md-12">
                        <textarea class="form-control" id="observacao" name="observacao"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">
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
$(document).ready(function(){
    // Aplicar a máscara no campo de hora
    $('#hora_inicio_atendimento').mask('00:00');

    // Carregar as guias ao selecionar o convênio
    $('#convenio_id').change(function() {
        var convenio_id = $(this).val();
        if (convenio_id) {
            $.ajax({
                url: '/guia-tiss/listar',
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
                            html += '<a href="/guia/tiss/' + guia.id + '" class="btn btn-primary" target="_blank">';
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

        // Fazer a requisição AJAX para buscar os detalhes da guia com o ID correto
        $.ajax({
            url: '/guia-tiss/detalhes/' + guiaId,  // Atualizando para a rota correta
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

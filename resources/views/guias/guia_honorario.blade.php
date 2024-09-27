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
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="visualizarGuiaModalLabel">Detalhes da Guia</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="formVisualizarGuia">
            @csrf
            <input type="hidden" id="user_id" name="user_id">
            <input type="hidden" id="convenio_id" name="convenio_id" hidden>
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label for="registro_ans" class="form-label"><strong>Registro ANS</strong></label>
                    <input class="form-control" id="registro_ans" name="registro_ans" type="text" readonly>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="numero_guia_solicitacao" class="form-label"><strong>Nº Guia de Solicitação de Internação</strong></label>
                    <input class="form-control" id="numero_guia_solicitacao" name="numero_guia_solicitacao" type="text" readonly>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="senha" class="form-label"><strong>Senha</strong></label>
                    <input class="form-control" id="senha" name="senha" type="text" readonly>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="numero_guia_operadora" class="form-label"><strong>Nº Guia Atribuído pela Operadora</strong></label>
                    <input class="form-control" id="numero_guia_operadora" name="numero_guia_operadora" type="text" readonly>
                </div>
            </div>
            <!-- Dados do Beneficiário -->
            <h5><strong>Dados do Beneficiário</strong></h5>
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label for="numero_carteira" class="form-label"><strong>Número da Carteira</strong></label>
                    <input class="form-control" id="numero_carteira" name="numero_carteira" type="text" readonly>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="nome_social" class="form-label"><strong>Nome Social</strong></label>
                    <input class="form-control" id="nome_social" name="nome_social" type="text" readonly>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="atendimento_rn" class="form-label"><strong>Atendimento RN</strong></label>
                    <input class="form-control" id="nome_social" name="nome_social" type="text" readonly>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="name" class="form-label"><strong>Nome</strong></label>
                    <input class="form-control" id="name" name="name" type="text" readonly>
                </div>
            </div>

            <!-- Dados do Contratado (onde foi executado o procedimento) -->
            <h5><strong>Dados do Contratado (onde foi executado o procedimento)</strong></h5>
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label for="codigo_operadora_contratado" class="form-label"><strong>Código na Operadora (Contratado)</strong></label>
                    <input class="form-control" id="codigo_operadora_contratado" name="codigo_operadora_contratado" type="text" readonly>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="nome_hospital_local" class="form-label"><strong>Nome do Hospital/Local</strong></label>
                    <input class="form-control" id="nome_hospital_local" name="nome_hospital_local" type="text" readonly>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="codigo_cnes_contratado" class="form-label"><strong>Código CNES do Contratado</strong></label>
                    <input class="form-control" id="codigo_cnes_contratado" name="codigo_cnes_contratado" type="text" readonly>
                </div>
            </div>

            <!-- Dados da Contratada Executante -->
            <h5><strong>Dados da Contratada Executante</strong></h5>
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label for="codigo_operadora_executante" class="form-label"><strong>Código na Operadora (Executante)</strong></label>
                    <input class="form-control" id="codigo_operadora_executante" name="codigo_operadora_executante" type="text" readonly>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="codigo_cnes_executante" class="form-label"><strong>Código CNES do Executante</strong></label>
                    <input class="form-control" id="codigo_cnes_executante" name="codigo_cnes_executante" type="text" readonly>
                </div>
                <div class="mb-3 col-md-3">
                    <label for="nome_contratado" class="form-label"><strong>Nome do Contratado</strong></label>
                    <input class="form-control" id="nome_contratado" name="nome_contratado" type="text" readonly>
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
                            <label for="numero_guia_prestador" class="form-label"><strong>Nº Guia do prestador</strong></label>
                            <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="numero_guia_solicitacao" class="form-label"><strong>Nº Guia de Solicitação de Internação</strong></label>
                            <input class="form-control" id="numero_guia_solicitacao" name="numero_guia_solicitacao" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="senha" class="form-label"><strong>Senha</strong></label>
                            <input class="form-control" id="senha" name="senha" type="text">
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
                            <label for="nome_social" class="form-label"><strong>Nome Social</strong></label>
                            <input class="form-control" id="nome_social" name="nome_social" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="atendimento_rn" class="form-label"><strong>Atendimento RN</strong></label>
                            <input class="form-control" id="atendimento_rn" name="atendimento_rn" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="nome_beneficiario" class="form-label"><strong>Nome Beneficiário</strong></label>
                            <input class="form-control" id="nome_beneficiario" name="nome_beneficiario" type="text">
                        </div>
                    </div>

                    <!-- Dados do Contratado (onde foi executado o procedimento) -->
                    <h5><strong>Dados do Contratado (onde foi executado o procedimento)</strong></h5>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="codigo_operadora_contratado" class="form-label"><strong>Código na Operadora (Contratado)</strong></label>
                            <input class="form-control" id="codigo_operadora_contratado" name="codigo_operadora_contratado" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="nome_hospital_local" class="form-label"><strong>Nome do Hospital/Local</strong></label>
                            <input class="form-control" id="nome_hospital_local" name="nome_hospital_local" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="codigo_cnes_contratado" class="form-label"><strong>Código CNES do Contratado</strong></label>
                            <input class="form-control" id="codigo_cnes_contratado" name="codigo_cnes_contratado" type="text">
                        </div>
                    </div>

                    <!-- Dados da Contratada Executante -->
                    <h5><strong>Dados da Contratada Executante</strong></h5>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label for="codigo_operadora_executante" class="form-label"><strong>Código na Operadora (Executante)</strong></label>
                            <input class="form-control" id="codigo_operadora_executante" name="codigo_operadora_executante" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="codigo_cnes_executante" class="form-label"><strong>Código CNES do Executante</strong></label>
                            <input class="form-control" id="codigo_cnes_executante" name="codigo_cnes_executante" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="nome_contratado" class="form-label"><strong>Nome do Contratado</strong></label>
                            <input class="form-control" id="nome_contratado" name="nome_contratado" type="text">
                        </div>
                    </div>
                    <h5><strong>Observações</strong></h5>
                    <div class="mb-3 col-md-12">
                        <textarea class="form-control" id="observacoes" name="observacoes" type="text"></textarea>
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
    $('#hora_inicio_atendimento').mask('00:00');
});

$(document).ready(function() {
    $('#convenio_id').change(function() {
        var convenio_id = $(this).val();
        if (convenio_id) {
            $.ajax({
                url: '/guia-honorario/listar',
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
                            html += '<a href="/guia/honorario/' + guia.id + '" class="btn btn-primary" target="_blank">';
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
            url: '/guia-honorario/detalhes/' + guiaId,  // Atualize para a rota correta
            type: 'GET',
            success: function(response) {
                // Preencher os campos do formulário com os dados da guia
                $('#user_id').val(response.user_id);
                $('#convenio_id_hidden').val(response.convenio_id);
                $('#registro_ans').val(response.registro_ans);
                $('#numero_guia_solicitacao').val(response.numero_guia_solicitacao);  // Corrigido
                $('#senha').val(response.senha);  // Corrigido
                $('#numero_guia_operadora').val(response.numero_guia_operadora);  // Corrigido
                $('#numero_carteira').val(response.numero_carteira);
                $('#nome_social').val(response.nome_social);
                $('#atendimento_rn').val(response.atendimento_rn);  // Corrigido
                $('#name').val(response.name);  // Corrigido
                
                // Preencher os campos de contratado
                $('#codigo_operadora_contratado').val(response.codigo_operadora_contratado);
                $('#nome_hospital_local').val(response.nome_hospital_local);
                $('#codigo_cnes_contratado').val(response.codigo_cnes_contratado);

                // Preencher os campos de executante
                $('#codigo_operadora_executante').val(response.codigo_operadora_executante);
                $('#codigo_cnes_executante').val(response.codigo_cnes_executante);
                $('#nome_contratado').val(response.nome_contratado);
                
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

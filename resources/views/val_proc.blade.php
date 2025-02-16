@extends('layouts.app')
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Valores Procedimentos
                    <span id="displaySelectedEspecialidade" class="selected-info"></span>
                </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Call-Center</li>
                <li class="breadcrumb-item"><a href="#">Valores Procedimentos</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label" for="convenio"><h4>Convênio</h4></label>
                                <select name="convenio" class="form-select" id="convenio">
                                    <option value="">Escolha um convênio</option>
                                    @foreach ($convenio as $c)
                                        <option value="{{ $c->id }}">{{ $c->nome }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-3 d-flex justify-content-end align-items-center">
                                <button id="refreshButton" class="btn btn-primary"> 
                                    <i class="bi bi-arrow-clockwise"></i> Atualizar valores
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Lista dos Procedimentos</h3>
                    <div class="table-scroll-wrapper">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-striped" id="proceduresTable">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Procedimento</th>
                                        <th>Valor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal de Carregando -->
        <div id="loadingModal" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <h4>Carregando...</h4>
                        {{-- <img src="loading.gif" alt="Carregando..." /> <!-- Imagem ou ícone de carregamento --> --}}
                    </div>
                </div>
            </div>
        </div>

    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Função para exibir o modal de carregamento
            function showLoadingModal() {
                $('#loadingModal').modal('show');
            }
    
            // Função para esconder o modal de carregamento
            function hideLoadingModal() {
                $('#loadingModal').modal('hide');
            }
    
            // Função para carregar os procedimentos quando o convênio for alterado
            $('#convenio').change(function() {
                const convenioId = $(this).val();
                if (convenioId) {
                    showLoadingModal();  // Exibe o modal de carregamento
    
                    $.ajax({
                        url: `/convenios/procedures/${convenioId}`,
                        type: 'GET',
                        success: function(data) {
                            const tableBody = $('#proceduresTable tbody');
                            tableBody.empty();  // Limpa a tabela antes de adicionar os novos dados
                            console.log(data);
    
                            data.forEach(function(procedure) {
                                tableBody.append(`
                                    <tr>
                                        <td>${procedure.codigo}</td>
                                        <td>${procedure.procedimento}</td>
                                        <td>${procedure.valor}</td>
                                    </tr>
                                `);
                            });
    
                            hideLoadingModal();  // Esconde o modal de carregamento após os dados serem carregados
                        },
                        error: function() {
                            alert('Erro ao carregar os procedimentos.');
                            hideLoadingModal();  // Esconde o modal de carregamento em caso de erro
                        }
                    });
                } else {
                    $('#proceduresTable tbody').empty();  // Limpa a tabela se nenhum convênio estiver selecionado
                }
            });
    
            // Função para atualizar os valores dos procedimentos
            $('#refreshButton').click(function() {
                const convenioId = $('#convenio').val();
                if (convenioId) {
                    showLoadingModal();  // Exibe o modal de carregamento
    
                    $.ajax({
                        url: `/convenios/update-procedures-values/${convenioId}`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Valores dos procedimentos atualizados com sucesso.');
                            hideLoadingModal();  // Esconde o modal de carregamento
                        },
                        error: function() {
                            alert('Erro ao atualizar os valores dos procedimentos.');
                            hideLoadingModal();  // Esconde o modal de carregamento em caso de erro
                        }
                    });
                } else {
                    alert('Por favor, selecione um convênio primeiro.');
                }
            });
        });
    </script>
    
@endsection

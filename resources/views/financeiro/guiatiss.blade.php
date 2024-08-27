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
                                    <th>Paciente</th>
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

    <!-- Modal -->
    <div class="modal fade" id="novoGuiaModal" tabindex="-1" aria-labelledby="novoGuiaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="novoGuiaModalLabel">Guia de Consulta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="POST" enctype="multipart/form-data" id="formNovaGuia">
                        @csrf
                        <input type="hidden" id="convenio_id_hidden" name="convenio_id">
                        <div class="row">
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>1- Registro ANS</strong></label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">2- Nº da guia no prestador</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">3- Nº da guia operadora</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Nº Fatura</strong></label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>ID da Solicitação</strong></label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>Status da guia</strong></label>
                                <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador" type="text" value="{{ old('numero_guia_prestador') }}">
                            </div>
                        </div>
                        <hr>
                        <h6>Dados do beneficiário (Paciente)</h6>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">4- Nº da carteira do beneficiário</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">5- Validade da Carteira</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">6- Recém-nascido</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-8">
                                <label class="form-label">7- Nome do beneficiário</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">8- Cartão Nacional de Saúde</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                        </div>
                        <hr>
                        <h6>Dados do contratado</h6>
                        <div class="row">
                            <div class="mb-3 col-md-5">
                                <label class="form-label">9- Cód. do contratado executante na operação</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-5">
                                <label class="form-label">10- Nome do contratado executante</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">11- CNES</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">12- Nome do profissional</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">13- Conselho</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">14- Nº profissional</label>
                                <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador" type="text" value="{{ old('numero_guia_prestador') }}">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">15- UF</label>
                                <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador" type="text" value="{{ old('numero_guia_prestador') }}">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">16- CBO</label>
                                <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador" type="text" value="{{ old('numero_guia_prestador') }}">
                            </div>
                        </div>
                        <hr>
                        <h6>Dados do Atendimento/Procedimento realizado</h6>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">17- Indicação de acidente</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">18- Data da realização</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">19- Tipo de consulta</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">20- Tabela</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">21- Cód. do procedimento</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Descrição procediemento</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">22- Valor do procedimento</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-12">
                                <label class="form-label">23- Observação / Justificatica</label>
                                <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador" type="text" value="{{ old('numero_guia_prestador') }}">
                            </div>
                        </div>
                        <!-- Continue com os demais campos -->
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
        $(document).ready(function() {
            $('#convenio_id').change(function() {
                var convenio_id = $(this).val();
                if (convenio_id) {
                    $.ajax({
                        url: '/guia/listar',  // Atualize com a rota correta
                        type: 'GET',
                        data: { convenio_id: convenio_id },
                        success: function(response) {
                            if (response.guias && response.guias.length > 0) {
                                var html = '';
                                $.each(response.guias, function(index, guia) {
                                    html += '<tr>';
                                    html += '<td>' + guia.id + '</td>';
                                    html += '<td>' + guia.paciente + '</td>';
                                    html += '<td>' + guia.data + '</td>';
                                    html += '<td>';
                                    html += '<button type="button" class="btn btn-success" name="guia" id="guia' + guia.id + '">';
                                    html += '<i class="icon bi bi-filetype-xml"></i>';
                                    html += '</button>';
                                    html += '<button type="button" class="btn btn-secondary" name="guia" id="guia' + guia.id + '">';
                                    html += '<i class="icon bi bi-printer"></i>';
                                    html += '</button>';
                                    html += '<button type="button" class="btn btn-danger" name="guia" id="guia' + guia.id + '">';
                                    html += '<i class="icon bi bi-trash"></i>';
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

            $('#formNovaGuia').submit(function(e) {
                e.preventDefault();
                var convenio_id = $('#convenio_id_hidden').val();
                if (!convenio_id) {
                    alert('Selecione um convênio antes de criar uma nova guia.');
                    return;
                }
                this.submit();
            });
        });

    </script>
@endsection

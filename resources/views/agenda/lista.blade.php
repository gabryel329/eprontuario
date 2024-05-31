@extends('layouts.app')

<style>
    .selected-info {
        margin-left: 15px;
        /* Ajuste a margem conforme necessário */
        font-size: 1rem;
        /* Tamanho da fonte para ajustar a aparência */
        color: #666;
        /* Cor do texto para distinção */
    }
</style>

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Consultar Agenda</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Agenda</li>
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
                                    <label class="form-label">Data</label>
                                    <input name="data" id="data" class="form-control" type="date" value="{{ session('data', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Médico</label>
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
                                                class="bi bi-check-circle-fill me-2"></i>Buscar</button>
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
                        @if(session('data') || session('profissional_id'))
                            Data: {{ session('data') ?? 'N/A' }} - 
                            Médico: 
                            @if(session('profissional_id'))
                                @php
                                    $profissional = $profissionals->firstWhere('id', session('profissional_id'));
                                @endphp
                                {{ $profissional ? $profissional->name : 'N/A' }} {{ $profissional ? $profissional->sobrenome : 'N/A' }}
                            @else
                                N/A
                            @endif
                        @else
                            Nenhum filtro aplicado.
                        @endif
                    </span>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>Consulta</th>
                                <th>Status</th>
                                <th>Excluir</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agendas as $item)
                                <tr>
                                    <td>{{ $item->hora }}</td>
                                    <td>{{ $item->name }} {{ $item->sobrenome }}</td>
                                    <td>{{ $item->cpf }}</td>
                                    <td>{{ $item->consulta_id }}</td>
                                    <td>
                                        <select class="form-control status-select" data-id="{{ $item->id }}"
                                            data-paciente-id="{{ $item->paciente_id }}">
                                            <option value="MARCADO" {{ $item->status == 'MARCADO' ? 'selected' : '' }}>
                                                MARCADO</option>
                                            <option value="CHEGOU" {{ $item->status == 'CHEGOU' ? 'selected' : '' }}>CHEGOU
                                            </option>
                                            <option value="CANCELADO" {{ $item->status == 'CANCELADO' ? 'selected' : '' }}>
                                                CANCELADO</option>
                                            <option value="EVADIO" {{ $item->status == 'EVADIO' ? 'selected' : '' }}>EVADIO
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <form action="{{ route('agenda.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="bi bi-x-circle"></i></button>
                                        </form>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info"
                                            onclick="openEditModal('{{ $item->id }}')"><i
                                                class="bi bi-pencil-square"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                        <form method="POST" action="{{ route('agenda.update', $item->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Médico</label>
                                    <select class="form-control" id="edit-profissional-id-{{ $item->id }}" name="profissional_id">
                                        <option disabled selected style="font-size:18px;color: black;">
                                            {{ $item->profissional->name }} {{ $item->profissional->sobrenome }}</option>
                                        @foreach ($profissionals as $profissional)
                                            <option value="{{ $profissional->id }}">{{ $profissional->name }}
                                                {{ $profissional->sobrenome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" name="profissional_id" value="{{ $item->profissional_id }}">
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="edit-data-{{ $item->id }}">Data</label>
                                    <input class="form-control" id="edit-data-{{ $item->id }}" name="data" type="date" value="{{ $item->data }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="edit-hora-{{ $item->id }}">Hora</label>
                                    <input class="form-control" id="edit-hora-{{ $item->id }}" name="hora" type="time" value="{{ $item->hora }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Selecione o Paciente</label>
                                    <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                                        data-bs-target="#pacienteModal-{{ $item->id }}">
                                        <i class="bi bi-person-add"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label"><strong>Nome:</strong></label>
                                    <input type="hidden" id="paciente_id{{ $item->id }}" name="paciente_id" value="{{ $item->paciente_id }}">
                                    <input class="form-control" id="edit-name-{{ $item->id }}" name="name" type="text" value="{{ $item->name }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label"><strong>Sobrenome:</strong></label>
                                    <input class="form-control" id="edit-sobrenome-{{ $item->id }}" name="sobrenome" type="text" value="{{ $item->sobrenome }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Consulta</label>
                                    <input class="form-control" id="edit-consulta-id-{{ $item->id }}" name="consulta_id" type="text" value="{{ $item->consulta_id }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
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
                                    <th>Sobrenome</th>
                                    <th>CPF</th>
                                    <th>Nome Social</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pacientes as $p)
                                    <tr>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->sobrenome }}</td>
                                        <td>{{ $p->cpf }}</td>
                                        <td>{{ $p->nome_social }}</td>
                                        <td>
                                            <button class="btn btn-primary" type="button"
                                                onclick="selectPaciente('{{ $item->id }}', '{{ $p->id }}', '{{ $p->name }}', '{{ $p->sobrenome }}')">Selecionar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.status-select').change(function() {
                var status = $(this).val();
                var id = $(this).data('id');
                var pacienteId = $(this).data('paciente-id');

                if (status === 'CHEGOU' && !pacienteId) {
                    if (confirm('Paciente não tem Cadastro. Deseja criar um novo paciente?')) {
                        window.location.href = "{{ route('paciente.index') }}";
                    } else {
                        $(this).val($(this).data('original-status')); // Reverte para o status original
                        return;
                    }
                }


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

            // Store the original status when the dropdown is focused
            $('.status-select').focus(function() {
                $(this).data('original-status', $(this).val());
            });
        });

        function openEditModal(id) {
            $('#editModal' + id).modal('show');
        }

        function selectPaciente(itemId, id, name, sobrenome) {
            $('#paciente_id' + itemId).val(id);
            $('#edit-name-' + itemId).val(name);
            $('#edit-sobrenome-' + itemId).val(sobrenome);
            var pacienteModal = bootstrap.Modal.getInstance(document.getElementById('pacienteModal-' + itemId));
            pacienteModal.hide();
        }

        $(document).ready(function() {
            // Quando o modal de seleção de pacientes é fechado, reabre o modal de edição
            $('[id^="pacienteModal"]').on('hidden.bs.modal', function() {
                var itemId = $(this).attr('id').split('-')[1];
                $('#editModal' + itemId).modal('show');
            });
        });

        // Search function for paciente modal
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
    </script>
@endsection

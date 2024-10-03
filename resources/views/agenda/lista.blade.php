@extends('layouts.app')

<style>
    .selected-info {
        margin-left: 15px;
        font-size: 1rem;
        color: #666;
    }
</style>

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Consultar Marcação</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Marcação</li>
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
                                    <label class="form-label"><Strong>Data:</Strong></label>
                                    <input name="data" id="data" class="form-control" type="date"
                                        value="{{ session('data', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label"><Strong>Médico:</Strong></label>
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
                                                class="bi bi-check-circle-fill me-2"
                                                onclick="showAdditionalFields()"></i>Buscar</button>
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
                        @if (session('data') || session('profissional_id'))
                            @php
                                $data = session('data');
                                $formattedDate = $data ? \Carbon\Carbon::parse($data)->format('d/m/Y') : 'N/A';
                            @endphp
                            Data: {{ $formattedDate }} -
                            Dr(a):
                            @if (session('profissional_id'))
                                @php
                                    $profissional = $profissionals->firstWhere('id', session('profissional_id'));
                                @endphp
                                {{ $profissional ? $profissional->name : 'N/A' }}
                            @else
                                N/A
                            @endif
                            <input type="hidden" id="dataSessao" name="dataSessao" value="{{ $data ? \Carbon\Carbon::parse($data)->format('Y-m-d') : '' }}">
                        @else
                            Nenhum filtro aplicado.
                        @endif
                    </span>
                    <div class="table-responsive">
                        <table class="table table-striped" style="text-align: center">
                            <thead>
                                <tr>
                                    <th>Hora</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Contato</th>
                                    <th>Medico</th>
                                    <th>Consulta</th>
                                    <th>Status</th>
                                    <th>Chamar</th>
                                    <th>Excluir</th>
                                    <th>Editar</th>
                                    <th>Guias</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($agendas as $item)
                                    <tr>
                                        <td>{{ $item->hora }}</td>
                                        <td>{{ optional($item->paciente)->name ?? $item->name }}</td>
                                        <td>{{ optional($item->paciente)->cpf ?? 'PACIENTE SEM CPF' }}</td>
                                        <td>{{ $item->celular ?? optional($item->paciente)->celular }}</td>
                                        <td>{{ optional($item->profissional)->name ?? '-' }}</td>
                                        <td>{{ $item->procedimento_id }}</td>
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
                                            <a type="submit"
                                                class="btn btn-warning form-control chamar-btn {{ $item->paciente_id ? '' : 'disabled' }}"
                                                data-paciente-id="{{ $item->paciente_id ?? null }}"
                                                data-agenda-id="{{ $item->id ?? null }}"
                                                data-paciente-nome="{{ $item->paciente->nome ?? null }}">
                                                <i class="bi bi-volume-up"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal{{ $item->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info"
                                                onclick="openEditModal('{{ $item->id }}')"><i
                                                    class="bi bi-pencil-square"></i></button>
                                        </td>
                                        <td>
                                            <select class="form-control guia-select" data-id="{{ $item->id }}" data-paciente-id="{{ $item->paciente_id }}">
                                                <option selected disabled>Selecione a Guia</option>
                                                <option value="consulta">Guia de Consulta</option>
                                                <option value="sadt">Guia SADT</option>
                                                <option value="tiss">Guia TISS</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                        <form method="POST" action="{{ route('agenda.update', $item->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
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
                                <div class="mb-3 col-md-12">
                                    <label class="form-label"><strong>Nome Completo:</strong></label>
                                    <input type="hidden" id="paciente_id{{ $item->id }}" name="paciente_id"
                                        value="{{ $item->paciente_id }}">
                                    <input type="hidden" id="convenio_id{{ $item->id }}" name="convenio_id" value="{{ $item->convenio_id }}">
                                    <input type="hidden" id="matricula{{ $item->id }}" name="matricula" value="{{ $item->matricula }}">
                                    <input class="form-control" id="edit-name-{{ $item->id }}" name="name"
                                        type="text" value="{{ $item->name }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Médico</label>
                                    <select class="form-control" id="edit-profissional-id-{{ $item->id }}"
                                        name="profissional_id">
                                        @foreach ($profissionals as $profissional)
                                            <option value="{{ $profissional->id }}"
                                                {{ $item->profissional_id == $profissional->id ? 'selected' : '' }}>
                                                {{ $profissional->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Data</label>
                                    <input type="date" class="form-control" name="data"
                                        value="{{ $item->data }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Hora</label>
                                    <input type="time" class="form-control" name="hora"
                                        value="{{ $item->hora }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Procedimento</label>
                                    <select class="form-control" id="edit-procedimento-id-{{ $item->id }}"
                                        name="procedimento_id">
                                        @foreach ($procedimentos as $procedimento)
                                            <option value="{{ $procedimento->procedimento }}"
                                                {{ $item->procedimento_id == $procedimento->procedimento ? 'selected' : '' }}>
                                                {{ $procedimento->procedimento }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
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
                                    <th>CPF</th>
                                    <th>Nome Social</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pacientes as $p)
                                    <tr>
                                        <td>{{ $p->name }}</td>
                                        <td>{{ $p->cpf }}</td>
                                        <td>{{ $p->nome_social }}</td>
                                        <td>
                                            <button class="btn btn-primary" type="button"
                                                onclick="selectPaciente('{{ $item->id }}', '{{ $p->id }}', '{{ $p->name }}', '{{ $p->convenio_id }}', '{{ $p->matricula }}')">Selecionar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modal para excluir --}}
        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza de que deseja excluir?<strong> {{ $item->name }} </strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('agenda.destroy', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.guia-select').change(function() {
                var guiaType = $(this).val();
                var agendaId = $(this).data('id');
                var pacienteId = $(this).data('paciente-id');

                if (guiaType) {
                    var url = '';
                    switch (guiaType) {
                        case 'consulta':
                            url = "{{ route('guia.consulta', ':id') }}".replace(':id', agendaId);
                            break;
                        case 'sadt': // ajuste no case 'sadt'
                            url = "{{ route('guia.sadt', ':id') }}".replace(':id', agendaId);
                            break;
                    }
                    window.open(url, '_blank');
                }
            });
        });

        $(document).ready(function() {
            var dataSessao = $('#dataSessao').val();
            $('.status-select').change(function() {
                var status = $(this).val();
                var dataAgenda = dataSessao; // Data da agenda vinda do atributo data
                var id = $(this).data('id');
                var pacienteId = $(this).data('paciente-id');

                // Verificar a data atual
                var dataAtual = new Date();
                var dataAtualFormatada = dataAtual.toISOString().split('T')[0]; // Formato YYYY-MM-DD

                // Verificar se o status é "CHEGOU" e se não há paciente vinculado
                if (status === 'CHEGOU') {
                    if (!pacienteId) {
                        if (confirm(
                                'Paciente não tem cadastro ou não vinculado. Deseja criar um novo paciente?'
                                )) {
                            window.location.href = "{{ route('paciente.index') }}";
                        } else {
                            $(this).val($(this).data('original-status'));
                            return;
                        }
                    }

                    // Verificar se a data da agenda é diferente da data atual
                    if (dataAgenda !== dataAtualFormatada) {
                        alert(
                            'A data da agenda não coincide com a data atual. Não é possível marcar como CHEGOU.');
                        $(this).val($(this).data('original-status'));
                        return;
                    }
                }

                // Caso passe nas verificações, continuar com a atualização via AJAX
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

            $('.status-select').focus(function() {
                $(this).data('original-status', $(this).val());
            });
        });


        function openEditModal(id) {
            $('#editModal' + id).modal('show');
        }

        function selectPaciente(itemId, id, name, convenio_id, matricula) {
            $('#paciente_id' + itemId).val(id);
            $('#edit-name-' + itemId).val(name);
            $('#convenio_id' + itemId).val(convenio_id);
            $('#matricula' + itemId).val(matricula);
            var pacienteModal = bootstrap.Modal.getInstance(document.getElementById('pacienteModal-' + itemId));
            pacienteModal.hide();
        }

        $(document).ready(function() {
            $('[id^="pacienteModal"]').on('hidden.bs.modal', function() {
                var itemId = $(this).attr('id').split('-')[1];
                $('#editModal' + itemId).modal('show');
            });
        });

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

        document.querySelectorAll('.chamar-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Impede o comportamento padrão do botão

                let pacienteId = this.getAttribute('data-paciente-id');
                let agendaId = this.getAttribute('data-agenda-id');
                let pacienteNome = this.getAttribute('data-paciente-nome');

                // Envia os dados via AJAX para o servidor
                fetch('{{ route('consultorioPainel.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            paciente_id: pacienteId,
                            agenda_id: agendaId,
                            nome: pacienteNome
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Paciente chamado!');
                        } else {
                            alert('Erro ao salvar os dados');
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Erro ao salvar os dados');
                    });
            });
        });

        function showAdditionalFields() {
            var data = document.getElementById('data').value;
            var profissionalId = document.getElementById('profissional_id').value;
            var profissionalName = document.getElementById('profissional_id').options[document.getElementById(
                'profissional_id').selectedIndex].text;

            if (!data) {
                alert('Por favor, selecione uma data.');
                return;
            }

            if (!profissionalId || profissionalId === "Escolha") {
                alert('Por favor, selecione um médico.');
                return;
            }

            document.getElementById('selectedData').value = data;
            document.getElementById('selectedProfissionalId').value = profissionalId;

            document.getElementById('displaySelectedData').innerText = data;
            document.getElementById('displaySelectedProfissional').innerText = profissionalName;

            document.getElementById('initial-form').style.display = 'none';
            document.getElementById('additional-fields').style.display = 'block';
            document.getElementById('agenda-table').style.display = 'block';

            fetchAgenda(data, profissionalId);
        }
    </script>
@endsection

{{-- case 'consulta':
                    url = "{{ route('guia.consulta', ':id') }}".replace(':id', agendaId);
                    break;
                case 'sadt':
                    url = "{{ route('guia.sadt', ':id') }}".replace(':id', agendaId);
                    break;
                case 'tiss':
                    url = "{{ route('guia.tiss', ':id') }}".replace(':id', agendaId);
                    break; --}}
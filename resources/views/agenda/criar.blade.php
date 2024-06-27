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
                <h1><i class="bi bi-ui-checks"></i> Criar Agenda<span id="displaySelectedProfissional"
                        class="selected-info"></span>
                    <span id="displaySelectedData" class="selected-info"></span>
                </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Agenda</li>
                <li class="breadcrumb-item"><a href="#">Criar Agenda</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">
                        Novo
                    </h3>
                    <div class="tile-body">
                        <div id="initial-form">
                            <div class="mb-3">
                                <label class="form-label">Data</label>
                                <input class="form-control" id="data" name="data" type="date" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Médico</label>
                                <select class="form-control" id="profissional_id" name="profissional_id" required>
                                    <option disabled selected style="font-size:18px;color: black;">Escolha</option>
                                    @foreach ($profissional as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary"
                                onclick="showAdditionalFields()">Confirmar</button>
                        </div>
                        <div id="additional-fields" style="display: none;">
                            <form id="agenda-form" method="POST" action="{{ route('agenda.store') }}"
                                class="form-horizontal">
                                @csrf
                                <input type="hidden" id="selectedData" name="data">
                                <input type="hidden" id="selectedProfissionalId" name="profissional_id">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Hora</label>
                                        <input class="form-control" id="hora" name="hora" type="time" list="time-options" required>
                                        <datalist id="time-options"></datalist>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Selecione o Paciente</label>
                                        <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                                            data-bs-target="#pacienteModal">
                                            <i class="bi bi-person-add"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label"><strong>Nome:</strong></label>
                                        <input class="form-control" id="paciente_id" name="paciente_id" type="text"
                                            hidden>
                                        <input class="form-control" id="name" name="name" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-md-12">
                                        <label class="form-label"><strong>Contato :</strong></label>
                                        <input class="form-control" id="celular" name="celular" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Consulta</label>
                                        <select class="form-control" id="procedimento_id" name="procedimento_id" required>
                                            <option value="">Selecione o Procedimento
                                            </option>
                                            @foreach ($procedimentos as $item)
                                                <option value="{{ $item->procedimento }}">
                                                    {{ $item->procedimento }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="tile-footer">
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-3">
                                            <button class="btn btn-primary" type="button" onclick="storeAgenda()">
                                                <i class="bi bi-check-circle-fill me-2"></i>Adicionar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6" id="agenda-table" style="display: none;">
                <div class="tile">
                    <h3 class="tile-title">Agenda
                    </h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Consulta</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="agenda-body">
                            <!-- Os dados da agenda serão inseridos aqui via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pacienteModalLabel">Selecione o Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" id="pacienteSearch" type="text"
                            placeholder="Pesquisar por nome ou CPF...">
                    </div>
                    <table class="table table-hover" id="pacienteTable">
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
                                            onclick="selectPaciente('{{ $p->id }}', '{{ $p->name }}')">Selecionar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dateInput = document.getElementById('data');
            var today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);

            dateInput.addEventListener('input', function() {
                var selectedDate = new Date(this.value);
                var dayOfWeek = selectedDate.getUTCDay(); // Domingo = 0, Segunda = 1, etc.

                if (dayOfWeek === 0) {
                    alert('Domingos não são permitidos. Por favor, escolha outro dia.');
                    this.value = '';
                }
            });
        });

        function showAdditionalFields() {
            var data = document.getElementById('data').value;
            var profissionalId = document.getElementById('profissional_id').value;
            var profissionalName = document.getElementById('profissional_id').options[document.getElementById('profissional_id').selectedIndex].text;

            if (!data) {
                alert('Por favor, selecione uma data.');
                return;
            }

            if (!profissionalId || profissionalId === "Escolha") {
                alert('Por favor, selecione um médico.');
                return;
            }

            if (isHoliday(data)) {
                alert('A data selecionada é um feriado. Por favor, escolha outra data.');
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

        const currentYear = new Date().getFullYear();
        const feriados = [
            `${currentYear}-01-01`, // Ano Novo
            `${currentYear}-02-12`, // Carnaval (segunda-feira)
            `${currentYear}-02-13`, // Carnaval (terça-feira)
            `${currentYear}-02-14`, // Quarta-feira de Cinzas (ponto facultativo até às 14h)
            `${currentYear}-03-29`, // Paixão de Cristo
            `${currentYear}-04-21`, // Tiradentes
            `${currentYear}-05-01`, // Dia do Trabalho
            `${currentYear}-05-30`, // Corpus Christi
            `${currentYear}-06-24`, // São João
            `${currentYear}-07-02`, // Independência da Bahia
            `${currentYear}-09-07`, // Independência do Brasil
            `${currentYear}-10-12`, // Nossa Senhora Aparecida
            `${currentYear}-11-02`, // Finados
            `${currentYear}-11-15`, // Proclamação da República
            `${currentYear}-12-08`, // Nossa Senhora da Conceição da Praia
            `${currentYear}-12-25`  // Natal
        ];

        function isHoliday(data) {
            return feriados.includes(data);
        }

        function fetchAgenda(data, profissionalId) {
            $.ajax({
                url: '{{ route('agenda.index') }}',
                type: 'GET',
                data: {
                    data: data,
                    profissional_id: profissionalId
                },
                success: function(response) {
                    var agendaBody = document.getElementById('agenda-body');
                    agendaBody.innerHTML = '';

                    response.agendas.forEach(function(agenda) {
                        var row = '<tr>' +
                            '<td>' + agenda.hora + '</td>' +
                            '<td>' + agenda.procedimento_id + '</td>' +
                            '<td>' + agenda.status + '</td>' +
                            '<td>' +
                            '<button type="button" class="btn btn-danger" onclick="deleteAgenda(' +
                            agenda.id + ')"><i class="bi bi-x-circle"></i></button>' +
                            '</td>' +
                            '</tr>';
                        agendaBody.innerHTML += row;
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        document.getElementById('pacienteSearch').addEventListener('keyup', function() {
            var input = this.value.toLowerCase();
            var rows = document.getElementById('pacienteTable').getElementsByTagName('tbody')[0]
                .getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                var name = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
                var cpf = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
                if (name.indexOf(input) > -1 || cpf.indexOf(input) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }
        });

        function selectPaciente(id, name) {
            document.getElementById('name').value = name;
            document.getElementById('paciente_id').value = id;
            var modal = bootstrap.Modal.getInstance(document.getElementById('pacienteModal'));
            modal.hide();
        }

        function storeAgenda() {
            var form = $('#agenda-form');
            var data = form.serializeArray();
            if (!$('#paciente_id').val()) {
                data = data.filter(function(item) {
                    return item.name !== 'paciente_id';
                });
            }
            var hora = document.getElementById('hora').value;
            var procedimento = document.getElementById('procedimento_id').value;

            if (!hora || !procedimento) {
                alert('Por favor, preencha todos os campos obrigatórios.');
                return false;
            }

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: $.param(data),
                success: function(response) {
                    if (response.success) {
                        alert(response.success);
                        fetchAgenda(document.getElementById('selectedData').value, document.getElementById(
                            'selectedProfissionalId').value);
                    } else if (response.error) {
                        alert(response.error);
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        alert(xhr.responseJSON.error);
                    } else {
                        console.log(xhr.responseText);
                    }
                }
            });
        }

        function deleteAgenda(id) {
            if (confirm('Tem certeza de que deseja deletar esta agenda?')) {
                $.ajax({
                    url: '{{ url('agenda') }}/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.success);
                            fetchAgenda(document.getElementById('selectedData').value, document.getElementById(
                                'selectedProfissionalId').value);
                        } else if (response.error) {
                            alert(response.error);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            alert(xhr.responseJSON.error);
                        } else {
                            console.log(xhr.responseText);
                        }
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const timeList = document.getElementById('time-options');
            for (let i = 0; i < 24 * 2; i++) {
                const hour = Math.floor(i / 2).toString().padStart(2, '0');
                const minutes = (i % 2 === 0) ? '00' : '30';
                const timeOption = `${hour}:${minutes}`;
                const option = document.createElement('option');
                option.value = timeOption;
                timeList.appendChild(option);
            }
        });
    </script>
@endsection

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
                <h1><i class="bi bi-ui-checks"></i> Marcação
                    <span id="displaySelectedProfissional" class="selected-info"></span>
                    <span id="displaySelectedData" class="selected-info"></span>
                </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Marcação</li>
                <li class="breadcrumb-item"><a href="#">Criar Marcação</a></li>
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
                                <label class="form-label"><strong>Data:</strong></label>
                                <input class="form-control" id="data" name="data" type="date" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Médico:</strong></label>
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
                                        <label class="form-label"><strong>Horário:</strong></label>
                                        <input class="form-control" id="hora" name="hora" type="time"
                                            list="time-options" required>
                                        <datalist id="time-options"></datalist>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><Strong>Selecione o Paciente:</Strong></label>
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
                                        <input class="form-control" id="name" name="name" type="text"
                                            placeholder="Nome do Paciente">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2 col-md-12">
                                        <label class="form-label"><strong>Contato:</strong></label>
                                        <input class="form-control" id="celular" name="celular" type="text"
                                            placeholder="Telefone Para Contato">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label"><strong>Código:</strong></label>
                                            <input type="text" name="codigo[]" value="" class="form-control"
                                                readonly disabled>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label"><strong>Consulta:</strong></label>
                                            <br>
                                            <select class="select2 form-control" id="procedimento_id" name="procedimento_id"
                                                style="width: 100%" required onchange="updateCodigo(this)">
                                                <option value="" data-codigo="">Selecione o Procedimento</option>
                                                @foreach ($procedimentos as $item)
                                                    <option value="{{ $item->procedimento }}"
                                                        data-codigo="{{ $item->codigo }}">{{ $item->procedimento }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
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
                    <h3 class="tile-title">Agenda</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Hora</th>
                                <th>Marcação</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="agenda-body">
                            <!-- Os dados da agenda serão inseridos aqui -->
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
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
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
                                                onclick="selectPaciente('{{ $p->id }}', '{{ $p->name }}', '{{ $p->celular }}')">Selecionar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function updateCodigo(selectElement) {
            const row = selectElement.closest('.row.mb-3');
            const codigoInput = row.querySelector('input[name="codigo[]"]');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            codigoInput.value = selectedOption.getAttribute('data-codigo');
        }
        document.addEventListener('DOMContentLoaded', function() {
            var dateInput = document.getElementById('data');
            var today = new Date().toISOString().split('T')[0];
            dateInput.setAttribute('min', today);

            dateInput.addEventListener('input', function() {
                var dateParts = this.value.split('/'); // Divide a data em dia, mês e ano
                var day = parseInt(dateParts[0], 10); // Dia
                var month = parseInt(dateParts[1], 10) - 1; // Mês (0-indexed, então subtrai 1)
                var year = parseInt(dateParts[2], 10); // Ano

                var selectedDate = new Date(year, month, day); // Converte para objeto Date
                var dayOfWeek = selectedDate.getUTCDay(); // Domingo = 0, Segunda = 1, etc.

                if (dayOfWeek === 0) {
                    alert('Domingos não são permitidos. Por favor, escolha outro dia.');
                    this.value = '';
                }
            });
        });

        function formatDate(dateString) {
            // Cria um objeto Date usando o fuso horário local
            const [year, month, day] = dateString.split('-');
            const date = new Date(year, month - 1, day);

            // Formata a data como dd/mm/yyyy
            const formattedDay = ("0" + date.getDate()).slice(-2);
            const formattedMonth = ("0" + (date.getMonth() + 1)).slice(-2);
            const formattedYear = date.getFullYear();

            return `${formattedDay}/${formattedMonth}/${formattedYear}`;
        }


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

            fetch('/verificar-feriado', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        data: data
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.isHoliday) {
                        alert('A data selecionada é um feriado.');
                    } else if (data.isSunday) {
                        alert('A data selecionada é um domingo.');
                    } else {
                        // Formatar a data antes de exibir
                        var formattedData = formatDate(data.data);

                        document.getElementById('selectedData').value = data.data;
                        document.getElementById('selectedProfissionalId').value = profissionalId;

                        document.getElementById('displaySelectedData').innerText = formattedData;
                        document.getElementById('displaySelectedProfissional').innerText = 'Dr(a): ' + profissionalName;

                        document.getElementById('initial-form').style.display = 'none';
                        document.getElementById('additional-fields').style.display = 'block';
                        document.getElementById('agenda-table').style.display = 'block';

                        fetchAgenda(data.data, profissionalId);
                    }
                })
                .catch(error => console.error('Erro:', error));
        }

        // function isHoliday(dateString) {
        //     const currentYear = new Date().getFullYear();
        //     const feriados = [
        //         `01/01/${currentYear}`, `12/02/${currentYear}`, `13/02/${currentYear}`,
        //         `14/02/${currentYear}`, `29/03/${currentYear}`, `21/04/${currentYear}`,
        //         `01/05/${currentYear}`, `30/05/${currentYear}`, `24/06/${currentYear}`,
        //         `02/07/${currentYear}`, `07/09/${currentYear}`, `12/10/${currentYear}`,
        //         `02/11/${currentYear}`, `15/11/${currentYear}`, `08/12/${currentYear}`,
        //         `25/12/${currentYear}`
        //     ];

        //     // Converte a data recebida para DD/MM/YYYY
        //     const [year, month, day] = dateString.split("-");
        //     const formattedDate = `${day}/${month}/${year}`;

        //     return feriados.includes(formattedDate);
        // }

        function checkHoliday(dateString) {
            fetch(`/check-holiday/${dateString}`)
                .then(response => response.json())
                .then(data => {
                    if (data.isHoliday) {
                        alert(data.message); // Exibe a mensagem de erro se for um feriado
                    } else {
                        alert(data.message); // Exibe a mensagem de sucesso se não for um feriado
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                });
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
                    agendaBody.innerHTML = ''; // Limpa o conteúdo existente

                    response.agendas.forEach(function(agenda) {
                        var row = '<tr id="agenda-row-' + agenda.id + '">' +
                            // Adiciona ID único à linha
                            '<td>' + agenda.hora + '</td>' +
                            '<td>' + agenda.procedimento_id + '</td>' +
                            '<td>' + agenda.status + '</td>' +
                            '<td>' +
                            '<button type="button" class="btn btn-danger" onclick="deleteAgenda(' +
                            agenda.id + ')"><i class="bi bi-x-circle"></i></button>' +
                            '</td>' +
                            '</tr>';
                        agendaBody.innerHTML += row; // Adiciona a linha ao corpo da tabela
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

        function selectPaciente(id, name, celular) {
            document.getElementById('name').value = name;
            document.getElementById('paciente_id').value = id;
            document.getElementById('celular').value = celular;
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
            console.log('Tentando deletar a agenda');

            if (confirm('Tem certeza de que deseja deletar esta agenda?')) {
                // Remove a linha da tabela imediatamente
                var row = document.getElementById('agenda-row-' + id);
                if (row) {
                    row.remove();
                    console.log('Linha removida');
                } else {
                    console.log('Linha não encontrada');
                }

                // Faça a requisição AJAX para excluir a agenda no servidor
                $.ajax({
                    url: '{{ url('agenda') }}/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.success);
                        } else if (response.error) {
                            alert(response.error);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            alert(xhr.responseJSON.error);
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

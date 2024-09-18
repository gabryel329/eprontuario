@extends('layouts.app')

<!-- CSS do FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Marcação
                    <span id="displaySelectedEspecialidade" class="selected-info"></span>
                </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Marcação</li>
                <li class="breadcrumb-item"><a href="#">Criar Marcação</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="tile">
                    <h3 class="tile-title">Filtro de Especialidade</h3>
                    <form id="filtroForm">
                        <div class="tile-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="especialidade">Especialidade:</label>
                                    <select id="especialidade" name="especialidade" class="form-control">
                                        <option value="">Selecione uma especialidade</option>
                                        @foreach ($especialidades as $especialidade)
                                            <option value="{{ $especialidade->id }}">{{ $especialidade->especialidade }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="profissionais">Profissionais:</label>
                                    <select id="profissionais" name="profissionais" class="form-control">
                                        <option value="">Selecione um profissional</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tile" id="calendario">
                    <h3 class="tile-title">Selecione a data</h3>
                    <div class="tile-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="tile">
                    <h3 class="tile-title">Lista</h3>
                    <p><strong>Data Selecionada: </strong><span style="color: red" id="displaySelectedData" class="selected-info"></span></p>
                    <div class="tile-body">
                        <div id="horariosDisponiveis" class="tile">
                            <h3 class="tile-title">Horários Disponíveis</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts do FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales/pt-br.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/interaction.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                dateClick: function(info) {
                    var selectedDate = info.dateStr;
                    document.getElementById('displaySelectedData').textContent = selectedDate;
                    fetchHorariosDisponiveis(selectedDate);
                },
            });
            calendar.render();

            document.getElementById('especialidade').addEventListener('change', function() {
                var especialidadeId = this.value;
                if (especialidadeId) {
                    fetchProfissionais(especialidadeId);
                }
            });
        });

        function fetchProfissionais(especialidadeId) {
            fetch(`/get-profissionais/${especialidadeId}`)
                .then(response => response.json())
                .then(data => {
                    var select = document.getElementById('profissionais');
                    select.innerHTML = '<option value="">Selecione um profissional</option>';
                    data.profissionais.forEach(profissional => {
                        var option = document.createElement('option');
                        option.value = profissional.id;
                        option.textContent = profissional.name;
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error('Erro ao buscar profissionais:', error));
        }

        function fetchHorariosDisponiveis(selectedDate) {
            var profissionalId = document.getElementById('profissionais').value;
            var especialidadeId = document.getElementById('especialidade').value;

            if (profissionalId && especialidadeId) {
                fetch(`/verificar-disponibilidade/${profissionalId}/${especialidadeId}/${selectedDate}`)
                    .then(response => response.json())
                    .then(data => {
                        var horariosContainer = document.getElementById('horariosDisponiveis');
                        horariosContainer.innerHTML = ''; // Limpar horários anteriores

                        if (Array.isArray(data.horarios) && data.horarios.length > 0) {
                            // Criar tabela
                            var table = document.createElement('table');
                            table.className = 'table table-bordered';
                            var thead = document.createElement('thead');
                            var tbody = document.createElement('tbody');

                            // Adicionar cabeçalho da tabela
                            var headerRow = document.createElement('tr');
                            var headers = ['Hora', 'Paciente', 'Contato', 'Convênio', 'Consulta', 'Código', 'Ação'];
                            headers.forEach(headerText => {
                                var th = document.createElement('th');
                                th.textContent = headerText;
                                headerRow.appendChild(th);
                            });
                            thead.appendChild(headerRow);
                            table.appendChild(thead);

                            // Adicionar uma linha para cada horário
                            data.horarios.forEach(horario => {
                                var row = document.createElement('tr');

                                // Coluna de hora
                                var horarioCell = document.createElement('td');
                                horarioCell.textContent = horario;
                                row.appendChild(horarioCell);

                                // Coluna de paciente (input)
                                var pacienteCell = document.createElement('td');
                                var pacienteInput = document.createElement('input');
                                pacienteInput.type = 'text';
                                pacienteInput.name = `paciente[${horario}]`;
                                pacienteInput.className = 'form-control';
                                pacienteCell.appendChild(pacienteInput);
                                row.appendChild(pacienteCell);

                                // Coluna de contato (input)
                                var contatoCell = document.createElement('td');
                                var contatoInput = document.createElement('input');
                                contatoInput.type = 'text';
                                contatoInput.name = `celular[${horario}]`;
                                contatoInput.className = 'form-control';
                                contatoCell.appendChild(contatoInput);
                                row.appendChild(contatoCell);

                                // Coluna de convênio (select)
                                var convenioCell = document.createElement('td');
                                var convenioSelect = document.createElement('select');
                                convenioSelect.name = `convenio[${horario}]`;
                                convenioSelect.className = 'form-control';
                                convenioSelect.innerHTML = '<option value="" data-codigo="">Selecione o Convênio</option>';

                                // Adicionar as opções de convênios ao select
                                data.convenios.forEach(convenio => {
                                    var option = document.createElement('option');
                                    option.value = convenio.id;
                                    option.textContent = convenio.nome;
                                    convenioSelect.appendChild(option);
                                });

                                convenioCell.appendChild(convenioSelect);
                                row.appendChild(convenioCell);

                                // Coluna de consulta (select)
                                var consultaCell = document.createElement('td');
                                var consultaSelect = document.createElement('select');
                                consultaSelect.className = 'select2 form-control';
                                consultaSelect.name = `procedimento_id[${horario}]`;
                                consultaSelect.id = `procedimento_id${horario}`;
                                consultaSelect.style.width = '100%';
                                consultaSelect.setAttribute('required', 'true');
                                consultaSelect.setAttribute('onchange', 'updateCodigo(this)');
                                consultaSelect.innerHTML = '<option value="" data-codigo="">Selecione o Procedimento</option>';

                                data.procedimentos.forEach(procedimento => {
                                    var option = document.createElement('option');
                                    option.value = procedimento.procedimento;
                                    option.setAttribute('data-codigo', procedimento.codigo);
                                    option.textContent = procedimento.procedimento;
                                    consultaSelect.appendChild(option);
                                });

                                consultaCell.appendChild(consultaSelect);
                                row.appendChild(consultaCell);

                                // Coluna de código (input)
                                var codigoCell = document.createElement('td');
                                var codigoInput = document.createElement('input');
                                codigoInput.type = 'text';
                                codigoInput.name = `codigo[${horario}]`;
                                codigoInput.className = 'form-control';
                                codigoInput.readOnly = true;
                                codigoCell.appendChild(codigoInput);
                                row.appendChild(codigoCell);

                                // Adicionar o botão de envio
                                var buttonCell = document.createElement('td');
                                var sendButton = document.createElement('button');
                                sendButton.className = 'btn btn-primary';
                                sendButton.textContent = 'Enviar';
                                sendButton.addEventListener('click', function() {
                                    enviarDados(pacienteInput.value, contatoInput.value, convenioSelect.value, consultaSelect.value, codigoInput.value, horario);
                                });
                                buttonCell.appendChild(sendButton);
                                row.appendChild(buttonCell);

                                tbody.appendChild(row);
                            });

                            table.appendChild(tbody);
                            horariosContainer.appendChild(table);
                        } else {
                            horariosContainer.innerHTML = 'Nenhum horário disponível para a data selecionada.';
                        }
                    })
                    .catch(error => console.error('Erro ao buscar horários disponíveis:', error));
            } else {
                alert('Por favor, selecione um profissional e uma especialidade.');
            }
        }

        function updateCodigo(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var codigoInput = selectElement.closest('tr').querySelector('input[name^="codigo"]');
            codigoInput.value = selectedOption.getAttribute('data-codigo');
        }

        function enviarDados(paciente, celular, convenio, procedimento, codigo, horario) {
    // Captura de valores individuais
    var selectedDate = document.getElementById('displaySelectedData').textContent;
    var profissionalId = document.getElementById('profissionais').value;
    var especialidadeId = document.getElementById('especialidade').value;

    // Dados a serem enviados
    var requestData = {
        paciente: paciente,
        celular: celular,
        convenio: convenio,
        procedimento: procedimento,
        codigo: codigo,
        horario: horario,
        data: selectedDate,
        profissionalId: profissionalId,
        especialidadeId: especialidadeId
    };

    // Log dos dados que serão enviados
    console.log('Dados enviados:', requestData);

    // Envio dos dados diretamente no corpo da solicitação
    fetch('/agendar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(requestData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Dados enviados com sucesso!');
        } else {
            alert('Erro ao enviar dados.');
        }
    })
    .catch(error => console.error('Erro ao enviar dados:', error));
}


    </script>
@endsection

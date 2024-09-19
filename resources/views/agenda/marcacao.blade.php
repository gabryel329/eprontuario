@extends('layouts.app')
<style>
    #calendar {
        width: 100%;
        height: auto;
        min-height: 300px;
        /* Define uma altura mínima */
    }
</style>
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
                                            <option value="{{ $especialidade->id }}">{{ $especialidade->especialidade }}
                                            </option>
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
                    <p><strong>Data Selecionada: </strong><span style="color: red" id="displaySelectedData"
                            class="selected-info"></span></p>
                    <div class="tile-body">
                        <h3 class="tile-title">Horários Disponíveis</h3>
                        <div class="table-responsive" id="horariosDisponiveis">
                            <!-- Aqui será inserida a tabela dinamicamente -->
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

            var today = new Date(); // Captura a data atual

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'pt-br',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                validRange: {
                    start: today // Desabilita datas anteriores ao dia atual
                },
                dateClick: function(info) {
                    var selectedDate = info.dateStr;

                    // Converte a data para o formato dd/mm/YYYY sem ajustar fuso horário
                    var parts = selectedDate.split('-');
                    var formattedDate = parts[2] + '/' + parts[1] + '/' + parts[0];

                    // Enviar a data para verificação no backend
                    fetch('/verificar-feriado', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                data: selectedDate
                            }) // 'data' deve ser o nome esperado pelo backend
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.isSunday) {
                                alert('Essa data é domingo e não pode ser selecionada.');
                            } else if (data.isHoliday) {
                                alert('Essa data é feriado e não pode ser selecionada.');
                            } else {
                                // Exibir a data no formato dd/mm/YYYY
                                document.getElementById('displaySelectedData').textContent =
                                    formattedDate;
                                fetchHorariosDisponiveis(selectedDate);
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao verificar feriado ou domingo:', error);
                        });
                }

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

                        if (data.horarios && data.horarios.length > 0) {
                            horariosContainer.innerHTML = renderHorariosTable(data.horarios, data.convenios, data
                                .procedimentos);
                        } else {
                            horariosContainer.innerHTML = 'Nenhum horário disponível para a data selecionada.';
                        }
                    })
                    .catch(error => console.error('Erro ao buscar horários disponíveis:', error));
            } else {
                alert('Por favor, selecione um profissional e uma especialidade.');
            }
        }

        function renderHorariosTable(horarios, convenios, procedimentos) {
            var table = `
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th>Paciente</th>
                        <th>Contato</th>
                        <th>Convênio</th>
                        <th>Matricula</th>
                        <th>Consulta</th>
                        <th>Código</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    ${horarios.map(horario => renderTableRow(horario, convenios, procedimentos)).join('')}
                </tbody>
            </table>
        `;
            return table;
        }

        function renderTableRow(horario, convenios, procedimentos) {
            return `
            <tr>
                <td>${horario}</td>
                <td><input type="text" name="paciente[${horario}]" class="form-control"></td>
                <td><input type="text" name="celular[${horario}]" class="form-control"></td>
                <td>${renderConvenioSelect(horario, convenios)}</td>
                <td><input type="text" name="matricula[${horario}]" class="form-control"></td>
                <td>${renderProcedimentoSelect(horario, procedimentos)}</td>
                <td><input type="text" name="codigo[${horario}]" class="form-control" readonly></td>
                <td><button class="btn btn-primary" onclick="enviarDados('${horario}')">Enviar</button></td>
            </tr>
        `;
        }

        function renderConvenioSelect(horario, convenios) {
            return `
            <select name="convenio[${horario}]" class="form-control">
                <option value="">Selecione o Convênio</option>
                ${convenios.map(convenio => `<option value="${convenio.id}">${convenio.nome}</option>`).join('')}
            </select>
        `;
        }

        function renderProcedimentoSelect(horario, procedimentos) {
            return `
            <select class="select2 form-control" name="procedimento_id[${horario}]" id="procedimento_id${horario}" onchange="updateCodigo(this)">
                <option value="">Selecione o Procedimento</option>
                ${procedimentos.map(proc => `<option value="${proc.procedimento}" data-codigo="${proc.codigo}">${proc.procedimento}</option>`).join('')}
            </select>
        `;
        }

        function updateCodigo(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var codigoInput = selectElement.closest('tr').querySelector('input[name^="codigo"]');
            codigoInput.value = selectedOption.getAttribute('data-codigo');
        }

        function enviarDados(horario) {
            // Captura os valores do formulário para o horário específico
            var selectedDate = document.getElementById('displaySelectedData').textContent;
            var profissionalId = document.getElementById('profissionais').value;
            var especialidadeId = document.getElementById('especialidade').value;
            var paciente = document.querySelector(`input[name="paciente[${horario}]"]`).value;
            var celular = document.querySelector(`input[name="celular[${horario}]"]`).value;
            var matricula = document.querySelector(`input[name="matricula[${horario}]"]`).value;
            var convenio = document.querySelector(`select[name="convenio[${horario}]"]`).value;
            var procedimento = document.querySelector(`select[name="procedimento_id[${horario}]"]`).value;
            var codigo = document.querySelector(`input[name="codigo[${horario}]"]`).value;

            // Dados a serem enviados
            var requestData = {
                paciente: paciente,
                celular: celular,
                convenio: convenio,
                matricula: matricula,
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
                        alert('Erro ao enviar dados: ' + (data.message || 'Falha desconhecida'));
                    }
                })
                .catch(error => console.error('Erro ao enviar dados:', error));
        }
    </script>
@endsection

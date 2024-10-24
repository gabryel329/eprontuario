@extends('layouts.app')
<style>
    #calendar {
        width: 100%;
        height: auto;
        min-height: 300px;
        /* Define uma altura mínima */
    }

    #horariosDisponiveis {
        max-height: 610px;
        /* Define a altura máxima para a tabela */
        overflow-y: auto;
        /* Adiciona o scrollbar vertical */
    }

    #horariosDisponiveis .table-responsive {
        display: block;
        max-height: 610px;
        overflow-y: auto;
    }

    .custom-modal-body {
        max-height: 400px;
        /* Define a altura máxima */
        overflow-y: auto;
        /* Habilita o scrollbar vertical */
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
                                    <select id="especialidade" name="especialidade" class="form-control" required>
                                        <option selected value="">Selecione uma especialidade</option>
                                        @foreach ($especialidades as $especialidade)
                                            <option value="{{ $especialidade->id }}">{{ $especialidade->especialidade }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="profissionais">Profissionais:</label>
                                    <select id="profissionais" name="profissionais" class="form-control" required>
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

                <div class="tile">
                    <h3 class="tile-title">Dias disponíveis</h3>
                    <div class="tile-body">
                        <p><span id="displayDiasDisponiveis" class="selected-info"></span></p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="tile">
                    <h4>
                        <strong>Data Selecionada: </strong>
                        <span style="color: red" id="displaySelectedData" class="selected-info"></span>
                        <button type="button" class="btn btn-success" onclick="enviarTodosDados()">Salvar</button>
                    </h4>

                    <div class="tile-body">
                        <div class="table-responsive" id="horariosDisponiveis" style="overflow-x: auto;">
                            <!-- Aqui será inserida a tabela dinamicamente -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="procedimentoModal" tabindex="-1" aria-labelledby="procedimentoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="procedimentoModalLabel">Selecione o Procedimento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body custom-modal-body">
                    <div class="mb-3">
                        <input class="form-control" id="procedimentoSearch" type="text"
                            placeholder="Pesquisar por nome ou código...">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="procedimentoTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Código</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($procedimentos as $procedimento)
                                    <tr>
                                        <td>{{ $procedimento->id }}</td>
                                        <td>{{ $procedimento->procedimento }}</td>
                                        <td>{{ $procedimento->codigo }}</td>
                                        <td>
                                            <button class="btn btn-primary" type="button"
                                                onclick="selectProcedimento('{{ $procedimento->id }}', '{{ $procedimento->procedimento }}', '{{ $procedimento->codigo }}')">
                                                Selecionar
                                            </button>
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
                        console.log(data.horarios);
                        // Exibir os dias disponíveis
                        var diasDisponiveis = [];
                        if (data.diasdisponivel) {
                            if (data.diasdisponivel.dom) diasDisponiveis.push('Dom');
                            if (data.diasdisponivel.seg) diasDisponiveis.push('Seg');
                            if (data.diasdisponivel.ter) diasDisponiveis.push('Ter');
                            if (data.diasdisponivel.qua) diasDisponiveis.push('Qua');
                            if (data.diasdisponivel.qui) diasDisponiveis.push('Qui');
                            if (data.diasdisponivel.sex) diasDisponiveis.push('Sex');
                            if (data.diasdisponivel.sab) diasDisponiveis.push('Sab');
                        }

                        // Criar a tabela para exibir os dias disponíveis
                        var tabelaDiasDisponiveis = `
                            <table style="border-collapse: collapse; width: 100%; text-align: center;">
                                <tr>
                                    ${diasDisponiveis.map(dia => `<td style="border: 1px solid black; padding: 10px;">${dia}</td>`).join('')}
                                </tr>
                            </table>
                        `;

                        // Inserir a tabela na div 'displayDiasDisponiveis'
                        document.getElementById('displayDiasDisponiveis').innerHTML = tabelaDiasDisponiveis;


                        var today = new Date();
                        var isToday = selectedDate === today.toISOString().split('T')[
                            0]; // Verifica se a data selecionada é o dia atual
                        var currentHour = today.getHours(); // Pega a hora atual
                        var currentMinute = today.getMinutes(); // Pega os minutos atuais

                        if (data.horarios && data.horarios.length > 0) {
                            horariosContainer.innerHTML = renderHorariosTable(data.horarios, data.convenios, data
                                .procedimentos, isToday, currentHour, currentMinute);
                        } else {
                            horariosContainer.innerHTML = 'Nenhum horário disponível para a data selecionada.';
                        }
                    })
                    .catch(error => console.error('Erro ao buscar horários disponíveis:', error));
            } else {
                alert('Por favor, selecione um profissional e uma especialidade.');
            }
        }

        function renderHorariosTable(horarios, convenios, procedimentos, isToday, currentHour, currentMinute) {
            var table = `
        <div class="table-responsive">
            <table class="table table-bordered" style="font-size: 12px; min-width: 1200px;">
                <thead>
                    <tr>
                        <th>Hora</th>
                        <th class="col-3">Paciente</th>
                        <th>Contato</th>
                        <th>Convênio</th>
                        <th>Matricula</th>
                        <th>Consulta</th>
                        <th>Código</th>
                    </tr>
                </thead>
                <tbody>
                    ${horarios.map(horario => renderTableRow(horario, convenios, procedimentos, isToday, currentHour, currentMinute)).join('')}
                </tbody>
            </table>
        </div>
    `;
            return table;
        }


        function renderTableRow(horario, convenios, procedimentos, isToday, currentHour, currentMinute) {
            // Extrai a hora e os minutos do horário
            var [horaHorario, minutoHorario] = horario.hora.split(':').map(Number);

            // Verifica se a linha deve ser desabilitada
            var isDisabled = '';
            if (isToday) {
                if (horaHorario < currentHour || (horaHorario === currentHour && minutoHorario < currentMinute)) {
                    isDisabled = 'disabled';
                }
            }

            return `
        <tr>
            <td><input type="text" readonly name="hora[${horario}]" value="${horario.hora ?? ''}" class="form-control" ${isDisabled}></td>
            <td class="col-3"><input type="text" name="paciente[${horario}]" value="${horario.name ?? ''}" class="form-control" ${isDisabled}></td>
            <td><input type="text" name="celular[${horario}]" value="${horario.celular ?? ''}" class="form-control" ${isDisabled}></td>
            <td>${renderConvenioSelect(horario, convenios, isDisabled)}</td>
            <td><input type="text" name="matricula[${horario}]" value="${horario.matricula ?? ''}" class="form-control" ${isDisabled}></td>
            <td>${renderProcedimentoInput(horario, procedimentos, isDisabled)}</td>
            <td><input type="text"name="codigo[${horario.hora}]" id="codigo${horario.hora}" value="${horario.codigo ?? ''}" class="form-control" readonly ${isDisabled}></td>

        </tr>
    `;
        }



        function renderProcedimentoInput(horario, isDisabled) {
            return `
                 <input 
        type="text" 
        class="form-control" 
        name="procedimento_nome[${horario.hora}]" 
        id="procedimento_nome${horario.hora}" 
        value="${horario.procedimento_id ?? ''}"
        placeholder="Selecione o Procedimento" 
        title="${horario.procedimento_id ?? ''}"
        readonly 
        onclick="abrirModalProcedimento('${horario.hora}')">
    <input type="hidden" name="procedimento_id[${horario.hora}]" id="procedimento_id${horario.hora}">
</td>
                    `;
        }

        function abrirModalProcedimento(horario) {
            console.log('Horário selecionado:', horario); // Verificar o horário selecionado
            $('#procedimentoModal').data('horario', horario).modal('show');
        }


        function selectProcedimento(id, procedimento, codigo) {
            const horario = $('#procedimentoModal').data('horario');
            document.getElementById(`procedimento_id${horario}`).value = id;
            document.getElementById(`procedimento_nome${horario}`).value = procedimento;
            document.getElementById(`codigo${horario}`).value = codigo;

            $('#procedimentoModal').modal('hide');
        }


        document.getElementById('procedimentoSearch').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            document.querySelectorAll('#procedimentoTable tbody tr').forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' :
                    'none'; // Correção de 'procedimento' para 'none'
            });
        });


        function renderConvenioSelect(horario, convenios, isDisabled) {
            return `
                <select name="convenio[${horario}]" class="select2 form-control" ${isDisabled}>
                    <option value="">${horario.convenio_id ? '' : 'Selecione um Convênio'}</option>
                    ${convenios.map(convenio => `
                                                    <option value="${convenio.id}" ${horario.convenio_id == convenio.id ? 'selected' : ''}>
                                                        ${convenio.nome}
                                                    </option>
                                                `).join('')}
                </select>
            `;
        }

        // function updateCodigo(selectElement) {
        //     var selectedOption = selectElement.options[selectElement.selectedIndex];
        //     var codigoInput = selectElement.closest('tr').querySelector('input[name^="codigo"]');
        //     codigoInput.value = selectedOption.getAttribute('data-codigo');
        // }


        function enviarTodosDados() {
            var selectedDate = document.getElementById('displaySelectedData').textContent;
            if (!selectedDate) {
                alert('Por favor, selecione uma data.');
                return; // Interrompe a execução se a data não for selecionada
            }
            var horariosRows = document.querySelectorAll(
                '#horariosDisponiveis tbody tr'); // Seleciona todas as linhas da tabela
            var todosHorariosDados = []; // Array para armazenar os dados de todas as linhas

            horariosRows.forEach(row => {
                // Capturar os valores de todos os inputs da linha
                var paciente = row.querySelector('input[name^="paciente"]')?.value || '';
                var hora = row.querySelector('input[name^="hora"]')?.value || '';
                var celular = row.querySelector('input[name^="celular"]')?.value || '';
                var matricula = row.querySelector('input[name^="matricula"]')?.value || '';
                var convenio = row.querySelector('select[name^="convenio"]')?.value || '';
                var procedimento = row.querySelector('input[name^="procedimento_nome"]')?.value || '';
                var codigo = row.querySelector('input[name^="codigo"]')?.value || '';

                var selectedDate = document.getElementById('displaySelectedData').textContent;
                var profissionalId = document.getElementById('profissionais').value;
                var especialidadeId = document.getElementById('especialidade').value;

                // Só adiciona ao array se o campo "procedimento" não estiver vazio
                if (procedimento !== '') {
                    // Coletar todos os dados em um objeto
                    var dadosHorario = {
                        paciente: paciente,
                        celular: celular,
                        convenio: convenio,
                        matricula: matricula,
                        procedimento: procedimento,
                        codigo: codigo,
                        horario: hora,
                        data: selectedDate,
                        profissionalId: profissionalId,
                        especialidadeId: especialidadeId
                    };

                    // Adicionar os dados ao array
                    todosHorariosDados.push(dadosHorario);
                }
            });

            // Mostrar o array de dados no console
            console.log('Todos os dados:', todosHorariosDados);

            // Enviar os dados se nenhum horário estiver inválido
            fetch('/agendar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(todosHorariosDados)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Dados atulizados com sucesso!');
                    } else {
                        alert('Erro ao enviar dados: ' + (data.message || 'Falha desconhecida'));
                    }
                })

        }
    </script>
@endsection

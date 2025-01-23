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
    <div class="modal fade" id="procedimentoModal" tabindex="-1" aria-labelledby="procedimentoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="procedimentoModalLabel">Selecione o Procedimento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body custom-modal-body">
                    <div class="mb-3">
                        <input class="form-control" id="procedimentoSearch" type="text" placeholder="Pesquisar por nome ou código...">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="procedimentoTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Código</th>
                                    <th>Valor</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- O conteúdo será inserido dinamicamente pelo JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pacienteModalLabel">Selecione o Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body custom-modal-body">
                    <div class="mb-3">
                        <input class="form-control" id="pacienteSearch" type="text" placeholder="Pesquisar por nome ou CPF...">
                    </div>
                    <div class="table-responsive">
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
                                                onclick="selectPaciente('{{ $p->id }}', '{{ $p->name }}', '{{ $p->celular }}', {{ $p->convenio_id }})">
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
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>

    <script>
        function abrirModalPaciente(horario) {
            console.log('Horário selecionado:', horario); // Para depuração
            $('#pacienteModal').data('horario', horario).modal('show');
        }

        function selectPaciente(id, name, celular, convenio_id) {
            const horario = $('#pacienteModal').data('horario'); // Recupera o horário associado ao modal

            // Preenche o nome e o ID do paciente nos campos correspondentes
            document.getElementById(`paciente_nome${horario}`).value = name; // Nome do paciente
            document.getElementById(`paciente_id${horario}`).value = id; // ID do paciente
            document.querySelector(`[name="celular[${horario}]"]`).value = celular;
            document.querySelector(`[name="convenio[${horario}]"]`).value = convenio_id; // Celular do paciente
            document.querySelector(`[name="convenio2[${horario}]"]`).value = convenio_id;
            $('#pacienteModal').modal('hide'); // Fecha o modal
        }

        document.getElementById('pacienteSearch').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            document.querySelectorAll('#pacienteTable tbody tr').forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });

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
                    //start:null
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
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
                                document.getElementById('displaySelectedData').textContent = formattedDate;
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
                        var isToday = selectedDate === today.toISOString().split('T')[0]; // Verifica se a data selecionada é o dia atual
                        var currentHour = today.getHours(); // Pega a hora atual
                        var currentMinute = today.getMinutes(); // Pega os minutos atuais

                        if (data.horarios && data.horarios.length > 0) {
                            horariosContainer.innerHTML = renderHorariosTable(data.horarios, data.convenios, data.procedimentos, isToday, currentHour, currentMinute);
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
                    <table class="table table-bordered" style="font-size: 12px; min-width: 500px;">
                        <thead>
                            <tr>
                                <th class="col-1">Hora</th>
                                <th class="col-2">Paciente</th>
                                <th class="col-1">Contato</th>
                                <th class="col-1">Convênio</th>
                                <th class="col-2">Consulta</th>
                                <th class="col-1">Código</th>
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
            var [horaHorario, minutoHorario] = horario.hora.split(':').map(Number);

            var isDisabled = '';
            if (isToday && (horaHorario < currentHour || (horaHorario === currentHour && minutoHorario <= currentMinute))) {
                isDisabled = '';
                //isDisabled = 'disabled';
            }

            return `
                <tr>
                    <td class="col-1"><input type="text" readonly name="hora[${horario.hora}]" value="${horario.hora}" class="form-control" ${isDisabled}></td>
                    <td class="col-2">
                        <div class="d-flex align-items-center">
                            <input type="text" id="paciente_nome${horario.hora}" title="${horario.paciente_nome || ''}" name="paciente_nome[${horario.hora}]" value="${horario.paciente_nome || ''}" class="form-control me-2" ${isDisabled}>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pacienteModal" onclick="abrirModalPaciente('${horario.hora}')" ${isDisabled}>
                                <i class="bi bi-person"></i>
                            </button>
                        </div>
                        <input type="hidden" id="paciente_id${horario.hora}" name="paciente_id[${horario.hora}]" value="${horario.paciente_id || ''}">
                    </td>
                    <td class="col-1"><input type="text" name="celular[${horario.hora}]" value="${horario.celular || ''}" class="form-control" ${isDisabled}></td>
                    <td class="col-1">
                        ${renderConvenioSelect(horario, convenios, isDisabled)}
                        <input type="text" id="convenio2${horario.hora}" name="convenio2[${horario.hora}]" value="${horario.convenio_id || ''}">
                    </td>
                    <td class="col-1">
                        <div class="d-flex align-items-center">
                            <input type="text" id="procedimento_nome${horario.hora}" title="${horario.procedimento_id || ''}" name="procedimento_nome[${horario.hora}]" value="${horario.procedimento_id || ''}" class="form-control me-2" ${isDisabled}>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#procedimentoModal" onclick="abrirModalProcedimento('${horario.hora}')" ${isDisabled}>
                                <i class="bi bi-list"></i>
                            </button>
                        </div>
                        <input type="hidden" id="procedimento_id${horario.hora}" name="procedimento_id[${horario.hora}]" value="${horario.procedimento_id || ''}">
                    </td>
                    <td class="col-1"><input type="text" name="codigo[${horario.hora}]" id="codigo${horario.hora}" value="${horario.codigo || ''}" class="form-control" readonly ${isDisabled}>
                    <input type="hidden" name="valor_proc[${horario.hora}]" id="valor_proc${horario.hora}" value="${horario.valor_proc || ''}" class="form-control" ${isDisabled}></td>
                </tr>
            `;
        }

        function abrirModalProcedimento(horario) {
            console.log('Horário selecionado:', horario); // Verificar o horário selecionado
            $('#procedimentoModal').data('horario', horario).modal('show');
        }

        function selectProcedimento(id, procedimento, codigo, valor_proc) {
            const horario = $('#procedimentoModal').data('horario'); // Recupera o horário associado ao modal

            // Atualiza os campos na tabela
            document.getElementById(`procedimento_id${horario}`).value = id; // Salva o ID no campo hidden
            document.getElementById(`procedimento_nome${horario}`).value = procedimento; // Exibe o nome no campo visível
            document.getElementById(`codigo${horario}`).value = codigo;
            document.getElementById(`valor_proc${horario}`).value = valor_proc;

            $('#procedimentoModal').modal('hide'); // Fecha o modal
        }

        document.getElementById('procedimentoSearch').addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            document.querySelectorAll('#procedimentoTable tbody tr').forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });

        function renderConvenioSelect(horario, convenios, isDisabled) {
            return `
                <select id="convenioProc" name="convenio[${horario.hora}]" class="select2 form-control" ${isDisabled}>
                    <option value="">${horario.convenio_id ? '' : 'Convênio'}</option>
                    ${convenios.map(convenio => `
                        <option value="${convenio.id}" ${horario.convenio_id == convenio.id ? 'selected' : ''}>
                            ${convenio.nome}
                        </option>
                    `).join('')}
                </select>
            `;
        }
        
        $(document).on('change', '#convenioProc', function() {
            const convenioId = $(this).val(); // Pega o ID do convênio selecionado

            if (convenioId) {
                $.ajax({
                    url: '{{ route('get.procedimentos') }}', // URL correta para o controlador
                    type: 'POST',
                    data: {
                        convenio_id: convenioId,
                        _token: '{{ csrf_token() }}' // Token CSRF para segurança
                    },
                    success: function(data) {
                        // Limpa o conteúdo atual da tabela
                        const tbody = $('#procedimentoTable tbody');
                        tbody.empty();

                        // Verifica se há procedimentos retornados
                        if (data.length > 0) {
                            data.forEach(function(procedimento) {
                                const row = `
                                    <tr>
                                        <td>${procedimento.id}</td>
                                        <td>${procedimento.descricao || procedimento.procedimento}</td>
                                        <td>${procedimento.codigo || procedimento.codigo_anatomico}</td>
                                        <td>${procedimento.valor_proc}</td>
                                        <td>
                                            <button class="btn btn-primary" type="button"
                                                onclick="selectProcedimento('${procedimento.id}', '${procedimento.descricao || procedimento.procedimento}', '${procedimento.codigo || procedimento.codigo_anatomico}','${procedimento.valor_proc}')">
                                                Selecionar
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                tbody.append(row);
                            });
                        } else {
                            const emptyRow = `
                                <tr>
                                    <td colspan="4" class="text-center">Nenhum procedimento encontrado</td>
                                </tr>
                            `;
                            tbody.append(emptyRow);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao buscar procedimentos:', error);
                    }
                });
            } else {
                console.log('Nenhum convênio selecionado');
            }
        });

        function enviarTodosDados() {
            var selectedDate = document.getElementById('displaySelectedData').textContent;
            if (!selectedDate) {
                alert('Por favor, selecione uma data.');
                return; // Interrompe a execução se a data não for selecionada
            }

            var horariosRows = document.querySelectorAll('#horariosDisponiveis tbody tr'); // Seleciona todas as linhas da tabela
            var todosHorariosDados = []; // Array para armazenar os dados de todas as linhas

            horariosRows.forEach(row => {
                var paciente = row.querySelector('input[name^="paciente_nome"]')?.value || '';
                var pacienteId = row.querySelector('input[name^="paciente_id"]')?.value || null;
                var celular = row.querySelector('input[name^="celular"]')?.value || '';
                var hora = row.querySelector('input[name^="hora"]')?.value || '';
                var matricula = row.querySelector('input[name^="matricula"]')?.value || '';
                var convenio = row.querySelector('select[name^="convenio"]')?.value || '';
                var procedimentoId = row.querySelector('input[name^="procedimento_nome"]')?.value || null;
                var codigo = row.querySelector('input[name^="codigo"]')?.value || '';
                var valorProc = row.querySelector('input[name^="valor_proc"]')?.value || '';

                var profissionalId = document.getElementById('profissionais').value;
                var especialidadeId = document.getElementById('especialidade').value;

                if (procedimentoId) {
                    todosHorariosDados.push({
                        paciente: paciente,
                        paciente_id: pacienteId,
                        celular: celular,
                        matricula: matricula,
                        convenio: convenio,
                        procedimento_id: procedimentoId, // Envie o ID do procedimento
                        codigo: codigo,
                        valor_proc: valorProc,
                        horario: hora,
                        data: selectedDate,
                        profissionalId: profissionalId,
                        especialidadeId: especialidadeId,
                    });
                }
            });

            if (todosHorariosDados.length === 0) {
                alert('Nenhum dado para salvar. Verifique os campos obrigatórios.');
                return;
            }

            // Enviar os dados para o backend
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
                    alert('Dados salvos com sucesso!');
                    //location.reload(); // Recarrega a página ou atualiza os dados, conforme necessário
                } else {
                    alert('Erro ao salvar os dados: ' + (data.message || 'Erro desconhecido.'));
                }
            })
            .catch(error => {
                console.error('Erro ao salvar os dados:', error);
                alert('Erro ao salvar os dados. Consulte o console para mais detalhes.');
            });
        }
    </script>
@endsection

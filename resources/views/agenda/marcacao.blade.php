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
                                        <option selected value="">Selecione uma especialidade</option>
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
                    <p><strong>Data Selecionada: </strong><span style="color: red" id="displaySelectedData"
                            class="selected-info"></span></p>
                    <div class="tile-body">
                        <h3 class="tile-title">Horários Disponíveis</h3> 
                        <button type="button" class="btn btn-success" onclick="enviarTodosDados()">Salvar</button>
                        <hr>
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
                        console.log(data.horarios);
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
                <td><input type="text" readonly name="hora[${horario}]" value="${horario.hora ?? ''}" class="form-control"></td>
                <td><input type="text" name="paciente[${horario}]" value="${horario.name ?? ''}" class="form-control"></td>
                <td><input type="text" name="celular[${horario}]" value="${horario.celular ?? ''}" class="form-control"></td>
                <td>${renderConvenioSelect(horario, convenios)}</td>
                <td><input type="text" name="matricula[${horario}]" value="${horario.matricula ?? ''}" class="form-control"></td>
                <td>${renderProcedimentoSelect(horario, procedimentos)}</td>
                <td><input type="text" name="codigo[${horario}]" value="${horario.codigo ?? ''}" class="form-control" readonly></td>
            </tr>
        `;
        }

        function renderConvenioSelect(horario, convenios) {
        return `
            <select name="convenio[${horario}]" class="form-control">
                <option value="">${horario.convenio_id ? '' : 'Selecione um Convênio'}</option>
                ${convenios.map(convenio => `
                    <option value="${convenio.id}" ${horario.convenio_id == convenio.id ? 'selected' : ''}>
                        ${convenio.nome}
                    </option>
                `).join('')}
            </select>
        `;
    }


    function renderProcedimentoSelect(horario, procedimentos) {
        return `
        <select class="select2 form-control" name="procedimento_id[${horario}]" id="procedimento_id${horario}" onchange="updateCodigo(this)">
            <option value="">${horario.procedimento_id ? '' : 'Selecione o Procedimento'}</option>
                ${procedimentos.map(proc => `
                    <option value="${proc.procedimento}" ${horario.procedimento_id == proc.procedimento ? 'selected' : ''} data-codigo="${proc.codigo}">
                        ${proc.procedimento}
                    </option>
                `).join('')}
        </select>
    `;
    }

    function updateCodigo(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var codigoInput = selectElement.closest('tr').querySelector('input[name^="codigo"]');
        codigoInput.value = selectedOption.getAttribute('data-codigo');
    }

    function enviarTodosDados() {
    var horariosRows = document.querySelectorAll('#horariosDisponiveis tbody tr'); // Seleciona todas as linhas da tabela
    var todosHorariosDados = []; // Array para armazenar os dados de todas as linhas
    var horarioInvalido = false; // Variável para verificar se existe algum horário inválido (passado)

    // Obter a data e hora atuais
    var dataAtual = new Date();
    var anoAtual = dataAtual.getFullYear();
    var mesAtual = String(dataAtual.getMonth() + 1).padStart(2, '0'); // Mês começa em 0, por isso é necessário adicionar 1
    var diaAtual = String(dataAtual.getDate()).padStart(2, '0');
    var horaAtual = dataAtual.getHours();
    var minutosAtuais = dataAtual.getMinutes();

    // Formatar a data atual no formato "DD/MM/YYYY"
    var dataFormatadaAtual = diaAtual + '/' + mesAtual + '/' + anoAtual;

    horariosRows.forEach(row => {
        // Capturar os valores de todos os inputs da linha
        var paciente = row.querySelector('input[name^="paciente"]')?.value || '';
        var hora = row.querySelector('input[name^="hora"]')?.value || '';
        var celular = row.querySelector('input[name^="celular"]')?.value || '';
        var matricula = row.querySelector('input[name^="matricula"]')?.value || '';
        var convenio = row.querySelector('select[name^="convenio"]')?.value || '';
        var procedimento = row.querySelector('select[name^="procedimento_id"]')?.value || '';
        var codigo = row.querySelector('input[name^="codigo"]')?.value || '';

        var selectedDate = document.getElementById('displaySelectedData').textContent;
        var profissionalId = document.getElementById('profissionais').value;
        var especialidadeId = document.getElementById('especialidade').value;

        // Verifica se a data selecionada é igual à data atual
        if (selectedDate === dataFormatadaAtual) {
            // Se a data for igual, verificar se o horário é maior que o horário atual
            var [horaAgendada, minutosAgendados] = hora.split(':').map(Number); // Quebrar a hora agendada em horas e minutos

            // Verificar se o horário agendado é menor que o horário atual
            if (horaAgendada < horaAtual || (horaAgendada === horaAtual && minutosAgendados <= minutosAtuais)) {
                horarioInvalido = true; // Marcar como horário inválido
            }
        }

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

    // Se algum horário for inválido, exibir alerta e não enviar os dados
    if (horarioInvalido) {
        alert('Não é possível marcar porque o horário já passou ou é igual ao horário atual.');
        return; // Cancela o envio dos dados
    }

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
            alert('Dados enviados com sucesso!');
        } else {
            alert('Erro ao enviar dados: ' + (data.message || 'Falha desconhecida'));
        }
    })
    
}

</script>
@endsection

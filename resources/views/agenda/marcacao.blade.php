@extends('layouts.app')

<!-- CSS do FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet">

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Marcação
                    <span id="displaySelectedEspecialidade" class="selected-info"></span>
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
            <div class="col-md-8">
                <div class="tile">
                    <h3 class="tile-title">Filtro de Especialidade</h3>
                    <form id="filtroForm">
                        <div class="tile-body">
                            <div class="form-group">
                                <label for="especialidade">Especialidade:</label>
                                <select id="especialidade" name="especialidade" class="form-control">
                                    <option value="">Selecione uma especialidade</option>
                                    @foreach ($especialidades as $especialidade)
                                        <option value="{{ $especialidade->id }}">{{ $especialidade->especialidade }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </div>
                    </form>
                </div>
                <div class="tile">
                    <h3 class="tile-title">Profissionais Disponíveis</h3>
                    <select id="profissionais" name="profissionais" class="form-control">
                        <option value="">Selecione um profissional</option>
                    </select>
                    <div id="horariosDisponiveis" class="tile">
                        <h3 class="tile-title">Horários Disponíveis</h3>
                    </div>

                </div>

            </div>
            <div class="col-md-4" id="calendario">
                <div class="tile">
                    <h3 class="tile-title">Data</h3>
                    <div id="calendar"></div>
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
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        dateClick: function(info) {
            var selectedDate = info.dateStr;
            document.getElementById('displaySelectedData').textContent = 'Data Selecionada: ' + selectedDate;
            fetchHorariosDisponiveis(selectedDate);
        },
    });
    calendar.render();

    // Evento de submissão do formulário de filtro
    document.getElementById('filtroForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var especialidadeId = document.getElementById('especialidade').value;
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
    var especialidadeId = document.getElementById('especialidade').value; // Adicionar especialidade

    if (profissionalId && especialidadeId) { // Certificar que ambos estão preenchidos
        fetch(`/verificar-disponibilidade/${profissionalId}/${especialidadeId}/${selectedDate}`)
            .then(response => response.json())
            .then(data => {
                var horariosContainer = document.getElementById('horariosDisponiveis');
                horariosContainer.innerHTML = ''; // Limpar horários anteriores

                if (Array.isArray(data.horarios) && data.horarios.length > 0) {
                    data.horarios.forEach(horario => {
                        var horarioItem = document.createElement('div');
                        horarioItem.textContent = `Horário: ${horario}`;
                        horariosContainer.appendChild(horarioItem);
                    });
                } else {
                    horariosContainer.textContent = 'Nenhum horário disponível para essa data.';
                }
            })
            .catch(error => console.error('Erro ao verificar disponibilidade:', error));
    }
}


    </script>
@endsection

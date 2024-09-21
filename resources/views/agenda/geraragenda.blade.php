@extends('layouts.app')
<style>
    .form-label {
        display: block;
        margin-bottom: 0.5em;
    }

    .form-control {
        width: 100%;
        padding: 0.5em;
    }

    .hidden {
        display: none;
    }
</style>
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-ui-checks"></i> Gerar Agenda</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Gerar Agenda</a></li>
        </ul>
    </div>
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
            <div class="timeline-post">
                <div class="col-md-12">
                    <ul class="nav nav-tabs user-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#manha" data-bs-toggle="tab">Turno Manhã</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tarde" data-bs-toggle="tab">Turno Tarde</a></li>
                        <li class="nav-item"><a class="nav-link" href="#noturno" data-bs-toggle="tab">Turno Noturno</a></li>
                    </ul>
                </div>
                <div class="tab-content">
                    <!-- Tab Manhã -->
                    <div class="tile tab-pane fade show active" id="manha">
                        @include('partials.form-agenda', ['formId' => 'profissionalFormManha', 'turno' => 'M'])
                    </div>
                    
                    <!-- Tab Tarde -->
                    <div class="tile tab-pane fade" id="tarde">
                        @include('partials.form-agenda', ['formId' => 'profissionalFormTarde', 'turno' => 'T'])
                    </div>
                    
                    <!-- Tab Noite -->
                    <div class="tile tab-pane fade" id="noturno">
                        @include('partials.form-agenda', ['formId' => 'profissionalFormNoturno', 'turno' => 'N'])
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).on('change', '#profissional_id', function () {
    const profissionalId = this.value; // Pega o valor do profissional selecionado
    const especialidadeSelect = $(this).closest('form').find('#especialidade'); // Localiza o select correspondente

    if (profissionalId) {
        $.ajax({
            url: '/especialidades/' + profissionalId, // Corrige a URL com o ID do profissional
            type: 'GET',
            success: function (response) {
                let options = '<option disabled selected>Selecione uma especialidade</option>';
                
                // Adiciona as especialidades retornadas à lista de opções
                response.forEach(function (especialidade) {
                    options += `<option value="${especialidade.id}">${especialidade.especialidade}</option>`;
                });
                
                especialidadeSelect.html(options); // Preenche o select de especialidades
            },
            error: function (xhr) {
                console.error('Erro ao buscar especialidades: ', xhr.responseText);
            }
        });
    } else {
        // Limpa o select de especialidades se nenhum profissional for selecionado
        especialidadeSelect.html('<option disabled selected>Escolha</option>');
    }
});
document.addEventListener('DOMContentLoaded', function () {
    // Definindo horários para cada turno
    const horariosTurnos = {
        'M': { inicio: '08:00', fim: '12:00' },  // Manhã
        'T': { inicio: '13:00', fim: '18:00' },  // Tarde
        'N': { inicio: '19:00', fim: '23:00' }   // Noite
    };

    // Função para atualizar os horários de início e fim com base no turno
    function atualizarHorarios(turno) {
        const iniHonorarioInput = document.getElementById(`inihonorario_${turno}`);
        const fimHonorarioInput = document.getElementById(`fimhonorario_${turno}`);

        if (horariosTurnos[turno]) {
            iniHonorarioInput.value = horariosTurnos[turno].inicio;
            iniHonorarioInput.min = horariosTurnos[turno].inicio;
            iniHonorarioInput.max = horariosTurnos[turno].fim;

            fimHonorarioInput.value = horariosTurnos[turno].fim;
            fimHonorarioInput.min = horariosTurnos[turno].inicio;
            fimHonorarioInput.max = horariosTurnos[turno].fim;
        }
    }

    // Detectando quando as abas são mostradas
    const tabManha = document.getElementById('manha');
    const tabTarde = document.getElementById('tarde');
    const tabNoite = document.getElementById('noturno');

    tabManha.addEventListener('shown.bs.tab', function () {
        atualizarHorarios('M');
    });

    tabTarde.addEventListener('shown.bs.tab', function () {
        atualizarHorarios('T');
    });

    tabNoite.addEventListener('shown.bs.tab', function () {
        atualizarHorarios('N');
    });

    // Inicializando a aba ativa (por exemplo, Manhã)
    if (tabManha.classList.contains('active')) {
        atualizarHorarios('M');
    }
});
function formatTo24Hour(time) {
    const [hours, minutes] = time.split(':');
    return `${hours.padStart(2, '0')}:${minutes.padStart(2, '0')}`;
}

function atualizarHorarios(turno) {
    const iniHonorarioInput = document.getElementById(`inihonorario_${turno}`);
    const fimHonorarioInput = document.getElementById(`fimhonorario_${turno}`);

    if (horariosTurnos[turno]) {
        iniHonorarioInput.value = formatTo24Hour(horariosTurnos[turno].inicio);
        iniHonorarioInput.min = formatTo24Hour(horariosTurnos[turno].inicio);
        iniHonorarioInput.max = formatTo24Hour(horariosTurnos[turno].fim);

        fimHonorarioInput.value = formatTo24Hour(horariosTurnos[turno].fim);
        fimHonorarioInput.min = formatTo24Hour(horariosTurnos[turno].inicio);
        fimHonorarioInput.max = formatTo24Hour(horariosTurnos[turno].fim);
    }
}

</script>
@endsection

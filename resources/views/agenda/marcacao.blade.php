@extends('layouts.app')
<style>
    .text-danger {
    color: red;
    font-weight: bold;
}

</style>
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
            <div class="col-md-6">
                <div class="tile">
                    <h3 class="tile-title">Novo</h3>
                    <div class="tile-body">
                        <form id="initial-form" method="POST" action="{{ route('agenda.index3') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label"><strong>Especialidade:</strong></label>
                                <select class="form-control" id="especialidade" name="especialidade_id" required>
                                    <option disabled selected>Escolha</option>
                                    @foreach ($especialidades as $item)
                                        <option value="{{ $item->id }}" {{ request('especialidade_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->especialidade }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>

                        <div id="additional-fields" style="display: none;">
                            <form id="agenda-form" method="POST" action="{{ route('agenda.store') }}" class="form-horizontal">
                                @csrf
                                <input type="hidden" id="selectedData" name="data">
                                <input type="hidden" id="selectedEspecialidadeId">
                                
                                <div class="mb-3">
                                    <label class="form-label"><strong>Profissional:</strong></label>
                                    <select class="form-control" id="profissional" name="profissional_id" required>
                                        <option disabled selected>Escolha</option>
                                        <!-- Options will be populated dynamically -->
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label"><strong>Selecione o Paciente:</strong></label>
                                        <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal" data-bs-target="#pacienteModal">
                                            <i class="bi bi-person-add"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Nome:</strong></label>
                                        <input class="form-control" id="paciente_id" name="paciente_id" type="text" hidden>
                                        <input class="form-control" id="name" name="name" type="text" placeholder="Nome do Paciente">
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label"><strong>Contato:</strong></label>
                                        <input class="form-control" id="celular" name="celular" type="text" placeholder="Telefone Para Contato">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Código:</strong></label>
                                        <input type="text" name="codigo[]" value="" class="form-control" readonly disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label"><strong>Consulta:</strong></label>
                                        <select class="select2 form-control" id="procedimento_id" name="procedimento_id" style="width: 100%" required onchange="updateCodigo(this)">
                                            <option value="" data-codigo="">Selecione o Procedimento</option>
                                            @foreach ($procedimentos as $item)
                                                <option value="{{ $item->procedimento }}" data-codigo="{{ $item->codigo }}">{{ $item->procedimento }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="tile-footer">
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-3">
                                            <button class="btn btn-primary" type="submit">
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
            <div class="col-md-6" id="calendario">
                <div class="tile">
                    <h3 class="tile-title">Data</h3>
                    <input id="dataInput" class="form-control" type="date">
                </div>
                <table class="table mt-3" id="horariosTable">
                    <thead>
                        <tr>
                            <th>Horário</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Horários serão inseridos aqui pelo JavaScript -->
                    </tbody>
                </table>
                <div class="mb-2 col-md-6">
                    <label class="form-label"><strong>Convênio:</strong></label>
                    <select class="form-control" id="convenio" name="convenio_id" required>
                        <option disabled selected>Escolha</option>
                        @foreach ($convenios as $item)
                            <option value="{{ $item->id }}">{{ $item->nome }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal for selecting patient -->
    <div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pacienteModalLabel">Selecione o Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" id="pacienteSearch" type="text" placeholder="Pesquisar por nome ou CPF...">
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
                                            <button class="btn btn-primary" type="button" onclick="selectPaciente('{{ $p->id }}', '{{ $p->name }}', '{{ $p->celular }}')">Selecionar</button>
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
        document.addEventListener('DOMContentLoaded', function() {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const especialidadeSelect = document.getElementById('especialidade');
    const profissionalSelect = document.getElementById('profissional');
    const dataInput = document.getElementById('dataInput');
    const horariosTable = document.getElementById('horariosTable').querySelector('tbody');
    let diasDisponiveis = {};

    // Atualiza os campos adicionais quando a especialidade muda
    especialidadeSelect.addEventListener('change', function() {
        showAdditionalFields();
        fetchProfissionais(especialidadeSelect.value); // Função para buscar profissionais
    });

    function showAdditionalFields() {
        const especialidadeId = especialidadeSelect.value;
        const especialidadeName = especialidadeSelect.options[especialidadeSelect.selectedIndex].text;

        if (!especialidadeId) {
            alert('Por favor, selecione uma especialidade.');
            return;
        }

        const data = new FormData();
        data.append('data', document.getElementById('selectedData').value);

        fetch('/verificar-feriado', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ data: data.get('data') })
        })
        .then(response => response.json())
        .then(data => {
            if (data.isHoliday) {
                alert('A data selecionada é um feriado.');
            } else if (data.isSunday) {
                alert('A data selecionada é um domingo.');
            } else {
                document.getElementById('selectedEspecialidadeId').value = especialidadeId;
                document.getElementById('displaySelectedEspecialidade').innerText = `Especialidade: ${especialidadeName}`;
                document.getElementById('additional-fields').style.display = 'block';
                document.getElementById('selectedData').value = dataInput.value;
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function fetchProfissionais(especialidadeId) {
        $.ajax({
            url: '/get-profissionais/' + especialidadeId,
            type: 'GET',
            success: function(response) {
                var options = '<option value="">Selecione um profissional</option>';
                $.each(response.profissionais, function(index, profissional) {
                    options += '<option value="' + profissional.id + '">' + profissional.name + '</option>';
                });
                profissionalSelect.innerHTML = options; // Preenche o select com os profissionais
            },
            error: function(xhr) {
                console.log('Erro ao buscar profissionais: ', xhr.responseText);
            }
        });
    }

    // Atualiza a disponibilidade do profissional quando a data muda
    dataInput.addEventListener('change', function() {
    const selectedDate = this.value;

    if (!selectedDate || !profissionalSelect.value) {
        alert('Selecione um profissional primeiro.');
        return;
    }

    fetch(`/get-disponibilidade/${profissionalSelect.value}`)
        .then(response => response.json())
        .then(data => {
            diasDisponiveis = data.diasDisponiveis;
            updateHorariosTable(selectedDate); // Atualiza a tabela com os horários da data selecionada
        })
        .catch(error => console.error('Error:', error));
});


    function updateHorariosTable(date) {
    if (!diasDisponiveis[date]) {
        alert('Data indisponível.');
        return;
    }

    horariosTable.innerHTML = ''; // Limpa a tabela de horários

    const horarios = diasDisponiveis[date];

    // Destacar os dias disponíveis em vermelho
    dataInput.classList.add('text-danger'); // Exemplo de destaque
    horarios.forEach(horario => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${horario}</td>
            <td><button class="btn btn-success" type="button" onclick="selectHorario('${horario}')">Selecionar</button></td>
        `;
        horariosTable.appendChild(row);
    });
}


    function selectHorario(horario) {
        document.getElementById('horario').value = horario;
    }
});


        // Função para selecionar paciente do modal
        function selectPaciente(id, name, celular) {
            document.getElementById('paciente_id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('celular').value = celular;
            $('#pacienteModal').modal('hide');
        }

        function updateCodigo(select) {
            const codigo = select.options[select.selectedIndex].dataset.codigo;
            document.querySelector('#agenda-form input[name="codigo[]"]').value = codigo;
        }
    </script>
@endsection

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
                <h1><i class="bi bi-ui-checks"></i> Call-Center</h1>
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
                <div class="mb-3 col-md-4 align-self-end">
                    <a class="btn btn-primary" href="{{ route('profissional.index1') }}">Lista de
                        Profissionais</a>
                </div>
                <div class="timeline-post">
                    <div class="tile">
                        <form id="profissionalForm" action="{{route('gerar-agenda.store')}}" method="POST">
                            <h3 class="tile-title">Gerar Agenda</h3>
                            <div class="tile-body">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Profissional:</strong></label>
                                        <select class="form-control" id="profissional_id" name="profissional_id" required>
                                            <option disabled selected>Escolha</option>
                                            @foreach ($profissionais as $item)
                                                <option value="{{ $item->id }}" {{ request('profissional_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label"><strong>Especialidade:</strong></label>
                                        <select class="form-control" id="especialidade" name="especialidade_id" required>
                                            <option disabled selected>Escolha</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <h4>Atendimento</h4>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Disponibilidade</label>
                                    <div class="d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <label class="form-check-label" for="manha_dom">D</label>
                                            <input class="form-check-input" type="checkbox" id="manha_dom" name="manha_dom"
                                                value="S">
                                        </div>
                                        <div class="form-check me-3">
                                            <label class="form-check-label" for="manha_seg">S</label>
                                            <input class="form-check-input" type="checkbox" id="manha_seg" name="manha_seg"
                                                value="S">
                                        </div>
                                        <div class="form-check me-3">
                                            <label class="form-check-label" for="manha_ter">T</label>
                                            <input class="form-check-input" type="checkbox" id="manha_ter" name="manha_ter"
                                                value="S">
                                        </div>
                                        <div class="form-check me-3">
                                            <label class="form-check-label" for="manha_qua">Q</label>
                                            <input class="form-check-input" type="checkbox" id="manha_qua" name="manha_qua"
                                                value="S">
                                        </div>
                                        <div class="form-check me-3">
                                            <label class="form-check-label" for="manha_qui">Q</label>
                                            <input class="form-check-input" type="checkbox" id="manha_qui" name="manha_qui"
                                                value="S">
                                        </div>
                                        <div class="form-check me-3">
                                            <label class="form-check-label" for="manha_sex">S</label>
                                            <input class="form-check-input" type="checkbox" id="manha_sex" name="manha_sex"
                                                value="S">
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label" for="manha_sab">S</label>
                                            <input class="form-check-input" type="checkbox" id="manha_sab" name="manha_sab"
                                                value="S">
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Turno</label>
                                    <select class="form-control" id="turno" name="turno" required>
                                        <option disabled selected style="font-size:18px;color: black;">Escolha</option>
                                        <option value="M">Manhã</option>
                                        <option value="T">Tarde</option>
                                        <option value="N">Noite</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Inicio</label>
                                    <input class="form-control" id="inihonorariomanha" name="inihonorariomanha"
                                        type="time" placeholder="00:00">
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Intervalo</label>
                                    <input class="form-control" id="interhonorariomanha" name="interhonorariomanha"
                                        type="text" placeholder="00">
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Fim</label>
                                    <input class="form-control" id="fimhonorariomanha" name="fimhonorariomanha"
                                        type="time" placeholder="00:00">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4 align-self-end">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="bi bi-check-circle-fill me-2"></i>Gerar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        const profissionalSelect = document.getElementById('profissional_id');
        const especialidadeSelect = document.getElementById('especialidade');

        // Função para buscar especialidades com base no profissional selecionado
        profissionalSelect.addEventListener('change', function () {
            const profissionalId = this.value; // Pega o valor do profissional selecionado

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
                        
                        especialidadeSelect.innerHTML = options; // Preenche o select de especialidades
                    },
                    error: function (xhr) {
                        console.error('Erro ao buscar especialidades: ', xhr.responseText);
                    }
                });
            } else {
                // Limpa o select de especialidades se nenhum profissional for selecionado
                especialidadeSelect.innerHTML = '<option disabled selected>Escolha</option>';
            }
        });

    </script>
@endsection

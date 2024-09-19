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


    </script>
@endsection

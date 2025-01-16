@extends('layouts.app')

@section('content')
    @php
        $empresa = \App\Models\Empresas::first();
    @endphp

    <style>
        body {
            background-color: #E5E5E5 !important;
        }
        .app-content {
            min-height: calc(100vh - 50px);
            margin-top: 50px;
            padding: 30px;
            background-color: #E5E5E5;
            -webkit-transition: margin-left 0.3s ease;
            transition: margin-left 0.3s ease;
            background-size: 20%;
            background-position: center;
            background-repeat: no-repeat;
        }
        .content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    </style>

    <main class="app-content">
        <div id="messageContainer"></div>
        <div class="content">
            <div class="container py-5">
                <h2 class="mb-4 border-start border-3 border-primary ps-3">Atalhos Rápidos</h2>
                <div class="row g-4">
                    <!-- Card Agenda do Dia -->
                    <div class="col-md-6 col-lg-3">
                        <a
                            class="card text-center shadow-sm h-100 text-decoration-none"
                            href="{{ url('/lista?_token=' . csrf_token() . '&data=' . now()->format('Y-m-d')) }}"
                        >
                            <div class="card-body">
                                <i class="bi bi-calendar-check fs-1 text-primary"></i>
                                <p class="card-text mt-3 text-dark">Agenda do Dia</p>
                            </div>
                        </a>
                    </div>
                    <!-- Card 2 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-car-front fs-1 text-primary"></i>
                                <p class="card-text mt-3">Transporte e veículos</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-briefcase fs-1 text-primary"></i>
                                <p class="card-text mt-3">Emprego e previdência</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-cash-stack fs-1 text-primary"></i>
                                <p class="card-text mt-3">Impostos e registros empresariais</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 5 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-balance-scale fs-1 text-primary"></i>
                                <p class="card-text mt-3">Justiça e cidadania</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 6 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-house fs-1 text-primary"></i>
                                <p class="card-text mt-3">Moradia e serviços sociais</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 7 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-droplet fs-1 text-primary"></i>
                                <p class="card-text mt-3">Água e esgoto</p>
                            </div>
                        </div>
                    </div>
                    <!-- Card 8 -->
                    <div class="col-md-6 col-lg-3">
                        <div class="card text-center shadow-sm h-100">
                            <div class="card-body">
                                <i class="bi bi-mortarboard fs-1 text-primary"></i>
                                <p class="card-text mt-3">Educação</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal fade" id="saveModal" tabindex="-1" aria-labelledby="saveModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Por favor, insira a informação:</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="sala" class="form-control" placeholder="Digite a resposta" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    function verificarUsuario(user_id, permisao_id) {
    var pergunta;

    if (permisao_id === 1) {
        pergunta = "Qual o consultório?";
    } else if (permisao_id === 2) {
        pergunta = "Qual o guichê?";
    }

    if (pergunta) {
        // Define a pergunta no modal
        $('#saveModal .modal-header h5').text(pergunta);

        // Exibe o modal
        $('#saveModal').modal('show');

        // Adiciona o evento de salvar quando o botão de salvar for clicado
        $('#saveModal .btn-primary').off('click').on('click', function() {
            var resposta = $('#saveModal input[name="sala"]').val();

            if (resposta) {
                $.ajax({
                    url: '/salvar-sala',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: user_id,
                        sala: resposta
                    },
                    success: function(response) {
                        // Esconde o modal
                        $('#saveModal').modal('hide');

                        // Exibe a mensagem de sucesso no frontend
                        $('#messageContainer').html(`
                            <div class="alert alert-success">
                                ${response.message}
                            </div>
                        `);
                    },
                    error: function(xhr, status, error) {
                        // Esconde o modal
                        $('#saveModal').modal('hide');

                        // Exibe a mensagem de erro no frontend
                        $('#messageContainer').html(`
                            <div class="alert alert-warning">
                                Ocorreu um erro ao salvar a resposta.
                            </div>
                        `);
                    }
                });
            }
        });
    }
}

$(document).ready(function() {
    @if (session('question_asked') == false && auth()->check() && (auth()->user()->permisao_id == 1 || auth()->user()->permisao_id == 2))
        verificarUsuario({{ auth()->user()->id }}, {{ auth()->user()->permisao_id }});
    @endif
});
    </script>
@endsection

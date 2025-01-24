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
            @if($empresa && $empresa->imagem)
                background-image: url('{{ asset('images/' . $empresa->imagem) }}');
            @else
                background-image: url('https://randomuser.me/api/portraits/men/1.jpg');
            @endif
        }

        .content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        /* Estilo do card padrão */
        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        /* Estilo ao passar o mouse */
        .hover-card:hover {
            transform: translateY(-10px); /* Move o card para cima */
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2); /* Aumenta a sombra */
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
                        <a class="card hover-card text-center shadow-sm h-100 text-decoration-none"
                            href="{{ url('/lista?_token=' . csrf_token() . '&data=' . now()->format('Y-m-d')) }}">
                            <div class="card-body">
                                <i class="bi bi-calendar-check fs-1 text-primary"></i>
                                <p class="card-text mt-3 text-dark">Agenda do Dia</p>
                            </div>
                        </a>
                    </div>
                    <!-- Card 2 -->
                    <div class="col-md-6 col-lg-3">
                        <a class="card hover-card text-center shadow-sm h-100 text-decoration-none"
                            href="{{ route('contasReceber.index') }}">
                            <div class="card-body">
                                <i class="bi bi-wallet2 fs-1 text-primary"></i>
                                <p class="card-text mt-3 text-dark">Contas a Receber</p>
                            </div>
                        </a>
                    </div>
                    <!-- Card 3 -->
                    <div class="col-md-6 col-lg-3">
                        <a class="card hover-card text-center shadow-sm h-100 text-decoration-none"
                            href="{{ route('guiaconsulta.index') }}">
                            <div class="card-body">
                                <i class="bi bi-file-earmark-medical fs-1 text-primary"></i>
                                <p class="card-text mt-3 text-dark">Guia Consulta</p>
                            </div>
                        </a>
                    </div>
                    <!-- Card 4 -->
                    <div class="col-md-6 col-lg-3">
                        <a class="card hover-card text-center shadow-sm h-100 text-decoration-none"
                            href="{{ route('guiasp.index') }}">
                            <div class="card-body">
                                <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                                <p class="card-text mt-3 text-dark">Guia Sadt</p>
                            </div>
                        </a>
                    </div>
                    <!-- Card 5 -->
                    <div class="col-md-6 col-lg-3">
                        <a class="card hover-card text-center shadow-sm h-100 text-decoration-none"
                            href="{{ route('paciente.index') }}">
                            <div class="card-body">
                                <i class="icon bi bi-person-add fs-1 text-primary"></i>
                                <p class="card-text mt-3 text-dark">Cadastrar Pacientes</p>
                            </div>
                        </a>
                    </div>
                    <!-- Card 6 -->
                    <div class="col-md-6 col-lg-3">
                        <a class="card hover-card text-center shadow-sm h-100 text-decoration-none"
                            href="{{ route('contasPagar.index') }}">
                            <div class="card-body">
                                <i class="bi bi-cash-coin fs-1 text-primary"></i>
                                <p class="card-text mt-3 text-dark">Contas a Pagar</p>
                            </div>
                        </a>
                    </div>
                    <!-- Card 7 -->
                    <div class="col-md-6 col-lg-3">
                        <a id="btn-relatorio-agenda" class="card hover-card text-center shadow-sm h-100 text-decoration-none" href="#">
                            <div class="card-body">
                                <i class="bi bi-calendar-week fs-1 text-primary"></i>
                                <p class="card-text mt-3 text-dark">Relatório de Agendas</p>
                            </div>
                        </a>
                    </div>
                    <!-- Card 8 -->
                    <div class="col-md-6 col-lg-3">
                        <a class="card hover-card text-center shadow-sm h-100 text-decoration-none"
                            href="{{ route('faturamentoGlosa.index') }}">
                            <div class="card-body">
                                <i class="icon bi bi-piggy-bank-fill fs-1 text-primary"></i>
                                <p class="card-text mt-3 text-dark">Glosa das Guias</p>
                            </div>
                        </a>
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
            @if (session('question_asked') == false &&
                    auth()->check() &&
                    (auth()->user()->permisao_id == 1 || auth()->user()->permisao_id == 2))
                verificarUsuario({{ auth()->user()->id }}, {{ auth()->user()->permisao_id }});
            @endif
        });
    </script>
@endsection

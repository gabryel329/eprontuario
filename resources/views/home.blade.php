@extends('layouts.app')

@section('content')
    @php
        $empresa = \App\Models\Empresas::first();
    @endphp

    <style>
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
    </style>

    <main class="app-content">
        <div class="content">
            @if ($empresa)
                <h1>{{ $empresa->name }}</h1>
            @else
                <h1>Empresa não encontrada</h1>
            @endif
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
                        alert('Resposta salva com sucesso!');
                        $('#saveModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        alert('Ocorreu um erro ao salvar a resposta.');
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

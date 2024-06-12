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
        var resposta = prompt(pergunta);
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
                    // Aqui você pode adicionar qualquer ação adicional que você queira realizar após a resposta bem-sucedida
                    alert('Resposta salva com sucesso!');
                },
                error: function(xhr, status, error) {
                    // Aqui você pode adicionar ações adicionais para lidar com erros
                    alert('Ocorreu um erro ao salvar a resposta.');
                }
            });
        }
    }
}


    $(document).ready(function() {
        @if (session('question_asked') == false && auth()->check() && (auth()->user()->permisao_id == 1 || auth()->user()->permisao_id == 2))
            verificarUsuario({{ auth()->user()->id }}, {{ auth()->user()->permisao_id }});
        @endif
    });
    </script>
@endsection

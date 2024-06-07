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
        if (permisao_id === 1 || permisao_id === 2) {
            var resposta = prompt("Qual o Guinche/Escritório?");
            if (resposta) {
                $.ajax({
                    url: '/salvar-sala',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        user_id: user_id,
                        sala: resposta
                    },
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

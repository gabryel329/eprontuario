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
            position: relative; /* Garante que o conteúdo esteja acima da imagem de fundo */
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    </style>

    <main class="app-content">
        <div class="content">
            <!-- Conteúdo adicional pode ser adicionado aqui -->
            @if ($empresa)
                <h1>{{ $empresa->name }}</h1>
            @else
                <h1>Empresa não encontrada</h1>
            @endif
        </div>
    </main>
@endsection
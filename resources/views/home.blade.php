@extends('layouts.app')

@section('content')
    <main class="app-content">
        @php
            $empresa = \App\Models\Empresas::first();
        @endphp
        @if ($empresa)
            <div class="image-container">
                <img src="{{ asset('images/' . $empresa->imagem) }}" alt="User Image">
            </div>
        @else
            <div class="image-container">
                <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
            </div>
        @endif
    </main>
@endsection

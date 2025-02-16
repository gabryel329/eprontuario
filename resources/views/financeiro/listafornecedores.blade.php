@extends('layouts.app')

@section('content')

<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-table"></i> Cadastro de Fornecedores</h1>
        </div>
        <button type="button" class="btn btn-primary" onclick="window.location='{{ route('fornecedores.index') }}'">
            Cadastrar Fornecedor
        </button>
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

    <div class="col-md-12">
        <div class="tile">
            <h3 class="tile-title">Lista de Fornecedores</h3>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CNPJ</th>
                                <th>CPF</th>
                                <th>Nome</th>
                                <th>Fantasia</th>
                                <th>Telefone</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($fornecedores as $fornecedor)
                                <tr>
                                    <td>{{ $fornecedor->id }}</td>
                                    <td>{{ $fornecedor->cnpj }}</td>
                                    <td>{{ $fornecedor->cpf }}</td>
                                    <td>{{ $fornecedor->name }}</td>
                                    <td>{{ $fornecedor->fantasia }}</td>
                                    <td>{{ $fornecedor->telefone }}</td>
                                    <td>{{ $fornecedor->email }}</td>
                                    <td>
                                        {{-- <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" class="btn btn-sm btn-warning">Editar</a>   --}}
                                        <form action="{{ route('listafornecedores.destroy', $fornecedor->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este fornecedor?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Nenhum fornecedor encontrado</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script>
$(document).ready(function() {
    // Máscaras
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 0000-0000');
    $('#cnpj').mask('00.000.000/0000-00');
});
</script>
@endsection

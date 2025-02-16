@extends('layouts.app')

@section('content')

<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-bank"></i> Cadastro de Bancos</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Financeiro</li>
            <li class="breadcrumb-item"><a href="{{ route('bancos.index')}}">Bancos</a></li>
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
        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Novo Banco</h3>
                <div class="tile-body">
                    <form method="POST" action="{{ route('bancos.store') }}" class="form-horizontal">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Nome do Banco</label>
                                <input name="nome" id="nome" class="form-control" type="text" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Código do Banco</label>
                                <input name="codigo_banco" id="codigo_banco" class="form-control" type="text" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Agência</label>
                                <input name="agencia" id="agencia" class="form-control" type="text" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Número da Conta</label>
                                <input name="numero_conta" id="numero_conta" class="form-control" type="text" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Tipo de Conta</label>
                                <input name="tipo_conta" id="tipo_conta" class="form-control" type="text" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Titular</label>
                                <input name="titular" id="titular" class="form-control" type="text" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">CPF/CNPJ</label>
                                <input name="cpf_cnpj" id="cpf_cnpj" class="form-control" type="text" required>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-check-circle-fill me-2"></i> Cadastrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="tile">
                <h3 class="tile-title">Lista de Bancos</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Código</th>
                            <th>Agência</th>
                            <th>Nº Conta</th>
                            <th>Editar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bancos as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->nome }}</td>
                                <td>{{ $item->codigo_banco }}</td>
                                <td>{{ $item->agencia }}</td>
                                <td>{{ $item->numero_conta }}</td>
                                <td>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                        Editar
                                    </button>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                        Excluir
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal de Exclusão -->
                            <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirmar Exclusão</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Tem certeza de que deseja excluir <strong>{{ $item->nome }}</strong>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <form action="{{ route('bancos.destroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Excluir</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal de Edição -->
                            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Editar Banco</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('bancos.update', $item->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Nome do Banco</label>
                                                        <input name="nome" class="form-control" type="text" value="{{ $item->nome }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Código do Banco</label>
                                                        <input name="codigo_banco" class="form-control" type="text" value="{{ $item->codigo_banco }}" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Agência</label>
                                                        <input name="agencia" class="form-control" type="text" value="{{ $item->agencia }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Número da Conta</label>
                                                        <input name="numero_conta" class="form-control" type="text" value="{{ $item->numero_conta }}" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Tipo de Conta</label>
                                                        <input name="tipo_conta" class="form-control" type="text" value="{{ $item->tipo_conta }}" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Titular</label>
                                                        <input name="titular" class="form-control" type="text" value="{{ $item->titular }}" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">CPF/CNPJ</label>
                                                        <input name="cpf_cnpj" class="form-control" type="text" value="{{ $item->cpf_cnpj }}" required>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script>
$(document).ready(function() {
    // Máscaras de campos
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 0000-0000');
    $('#cnpj').mask('00.000.000/0000-00');

    // Detecta quando o CPF está completo e valida
    $('#cpf').on('input', function() {
        var cpf = $(this).val();
        if (cpf.length === 14) { // A máscara usa 14 caracteres (11 dígitos + pontos e traço)
            if (validarCPF(cpf)) {
                $('#cpfValidationMessage').hide(); // CPF válido
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $('#cpfValidationMessage').show(); // CPF inválido
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        }
    });

    // Verifica o CPF ao submeter o formulário
    $('form').on('submit', function(event) {
        var cpf = $('#cpf').val();
        if (!validarCPF(cpf)) {
            event.preventDefault(); // Impede o envio do formulário
            $('#cpfValidationMessage').show(); // Exibe a mensagem de erro
            $('#cpf').removeClass('is-valid').addClass('is-invalid');
            alert('CPF inválido. Por favor, verifique o número informado.');
        }
    });
});
@endsection

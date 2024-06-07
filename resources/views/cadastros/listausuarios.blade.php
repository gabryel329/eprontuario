@extends('layouts.app')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-table"></i> Lista de Usuários</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Administração</li>
                <li class="breadcrumb-item active"><a href="#">Usuários</a></li>
            </ul>
        </div>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-warning">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Editar</th>
                                        <th>Deletar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $p)
                                        <tr>
                                            <td>{{ $p->name }} {{ $p->sobrenome }}</td>
                                            <td>{{ $p->email }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $p->id }}">
                                                        Editar
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <form action="{{ route('usuario.destroy', $p->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal de Edição -->
                                        <div class="modal fade" id="editModal{{ $p->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $p->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $p->id }}">Editar Usuário</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('usuario.update', $p->id) }}" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="mb-3 col-md-5">
                                                                    <label class="form-label">Nome</label>
                                                                    <input class="form-control" name="name" type="text" value="{{ $p->name }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Sobrenome</label>
                                                                    <input class="form-control" name="sobrenome" type="text" value="{{ $p->sobrenome }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Permissão</label>
                                                                    <select class="form-control" name="permisao_id">
                                                                        @foreach ($permissoes as $permissao)
                                                                            <option value="{{ $permissao->id }}" {{ old('permisao_id', $p->permisao_id) == $permissao->id ? 'selected' : '' }}>
                                                                                {{ $permissao->cargo }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    
                                                                </div>                                                                
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">E-mail</label>
                                                                    <input class="form-control" name="email" type="email" value="{{ $p->email }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Nova Senha</label>
                                                                    <input class="form-control" id="password{{ $p->id }}" name="password" type="password" onmousedown="togglePassword({{ $p->id }}, true)" onmouseup="togglePassword({{ $p->id }}, false)" onmouseleave="togglePassword({{ $p->id }}, false)">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Foto</label>
                                                                    <input class="form-control" type="file" name="imagem">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                                            </div>
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
            </div>
        </div>
    </main>
    <script>
        function togglePassword(id, show) {
            var passwordField = document.getElementById('password' + id);
            passwordField.type = show ? 'text' : 'password';
        }
    </script>
@endsection

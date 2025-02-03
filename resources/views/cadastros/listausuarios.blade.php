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
            <div class="mb-3 col-md-2">
                <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                    data-bs-target="#pacienteModal">Buscar <i class="bi bi-search"></i>
                </button>
            </div>
            <div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pacienteModalLabel">Selecione o Usuário</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <input class="form-control" id="pacienteSearch" type="text"
                                    placeholder="Pesquisar por Nome ou E-mail...">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover text-center" id="pacienteTable">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>Ação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $p)
                                            <tr>
                                                <td>{{ $p->name }}</td>
                                                <td>{{ $p->email }}</td>
                                                <td>
                                                    <button class="btn btn-primary" type="button" onclick="editModal('{{ $p->id }}')">Selecionar</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
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
                                            <td>{{ $p->name }}</td>
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
                                                                <div class="mb-3 col-md-9">
                                                                    <label class="form-label">Nome</label>
                                                                    <input class="form-control" name="name" type="text" value="{{ $p->name }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Permissão</label>
                                                                    @foreach ($permissoes as $permisao)
                                                                        <div class="form-check">
                                                                            <input 
                                                                                type="checkbox" 
                                                                                class="form-check-input" 
                                                                                id="permisao_{{ $permisao->id }}" 
                                                                                name="permisao_id[]" 
                                                                                value="{{ $permisao->id }}"
                                                                                {{ $p->permissoes->contains($permisao->id) ? 'checked' : '' }}
                                                                            >
                                                                            <label class="form-check-label" for="permisao_{{ $permisao->id }}">
                                                                                {{ $permisao->cargo }}
                                                                            </label>
                                                                        </div>
                                                                    @endforeach
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
                        {{-- {{ $users->links('pagination::bootstrap-4') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        function editModal(pacienteId) {
            // Abrir o modal correspondente ao ID do paciente selecionado
            var modal = new bootstrap.Modal(document.getElementById('editModal' + pacienteId));
            modal.show();
        }

        document.getElementById('pacienteSearch').addEventListener('keyup', function() {
    var input = this.value.toLowerCase();
    var rows = document.getElementById('pacienteTable').getElementsByTagName('tbody')[0]
        .getElementsByTagName('tr');

    for (var i = 0; i < rows.length; i++) {
        var name = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
        var email = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
        
        // Verifica se o nome ou CPF contém o valor digitado no input
        if (name.includes(input) || email.includes(input)) {
            rows[i].style.display = "";
        } else {
            rows[i].style.display = "none";
        }
    }
});

        function togglePassword(id, show) {
            var passwordField = document.getElementById('password' + id);
            passwordField.type = show ? 'text' : 'password';
        }
    </script>
@endsection

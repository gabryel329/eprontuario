@extends('layouts.app')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-ui-checks"></i> Usuários</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Atendimento</li>
            <li class="breadcrumb-item"><a href="#">Usuários</a></li>
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
                <h3 class="tile-title">Cadastro de Usuários</h3>
                <div class="tile-body">
                    <div class="mb-3 col-md-5" style="gap: 5px">
                      <a class="btn btn-primary" href="{{ route('usuario.index1') }}">Lista de Usuários</a>
                      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#profissionalModal">
                      Selecionar o(a) Profissional
                      </button>
                    </div>
                    <form method="POST" action="{{ route('usuario.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-8">
                                <label class="form-label"><strong>Nome Completo:</strong></label>
                                <input class="form-control" id="id" name="id" type="text" hidden>
                                <input class="form-control" id="name" name="name" type="text" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Permissão:</label>
                                <select class="form-control" id="permisao_id" name="permissao_id">
                                    <option disabled selected style="font-size:18px;color: black;">Escolha</option>
                                    @foreach ($permissoes as $item)
                                        <option value="{{ $item->id }}">{{ $item->cargo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label"><strong>Email:</strong></label>
                                <input class="form-control" id="email" name="email" type="email" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label"><strong>Senha:</strong></label>
                                <input class="form-control" id="password" name="password" type="password" onmouseover="showPassword()" onmouseout="hidePassword()" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Foto</label>
                                <input class="form-control" type="file" name="imagem">
                            </div>
                        </div>
                        
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<div class="modal fade" id="profissionalModal" tabindex="-1" aria-labelledby="profissionalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="profissionalModalLabel">Selecione o Profissional</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input class="form-control" id="profissionalSearch" type="text" placeholder="Pesquisar por nome ou CPF...">
                </div>
                <table class="table table-hover" id="profissionalTable">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Nome Social</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($profissioanls as $p)
                            <tr>
                                <td>{{ $p->name }}</td>
                                <td>{{ $p->cpf }}</td>
                                <td>{{ $p->nome_social }}</td>
                                <td>
                                    <button class="btn btn-primary" type="button" onclick="selectProfissional('{{ $p->id }}', '{{ $p->name }}', '{{ $p->email }}')">Selecionar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function showPassword() {
        var passwordField = document.getElementById('password');
        passwordField.type = 'text';
    }   

    function hidePassword() {
        var passwordField = document.getElementById('password');
        passwordField.type = 'password';
    }

    document.getElementById('profissionalSearch').addEventListener('keyup', function() {
        var input = this.value.toLowerCase();
        var rows = document.getElementById('profissionalTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (var i = 0; i < rows.length; i++) {
            var name = rows[i].getElementsByTagName('td')[0].textContent.toLowerCase();
            var cpf = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();
            if (name.indexOf(input) > -1 || cpf.indexOf(input) > -1) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    });

    function selectProfissional(id, name, email) {
        document.getElementById('name').value = name;
        document.getElementById('id').value = id;
        document.getElementById('email').value = email;

        // Fecha o modal
        var modal = document.getElementById('profissionalModal');
        var modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
    }
</script>
@endsection

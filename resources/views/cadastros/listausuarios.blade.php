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
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Permissão</th>
                                        <th>Especialidade</th>
                                        <th>E-mail</th>
                                        <th>Editar</th>
                                        <th>Deletar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td>{{ $item->name }} {{ $item->sobrenome }}</td>
                                            <td>{{ $item->permisao->cargo }}</td>
                                            <td>{{ $item->especialidade->especialidade }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>
                                                <div>
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->id }}">
                                                        Editar
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('usuario.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">
                                                            Editar Usuário</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('usuario.update', $item->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Nome</label>
                                                                    <input class="form-control"
                                                                        id="name{{ $item->id }}" name="name"
                                                                        type="text" value="{{ $item->name }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Sobrenome</label>
                                                                    <input class="form-control" id="sobrenome"
                                                                        name="sobrenome" type="text"
                                                                        value="{{ $item->sobrenome }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">E-mail</label>
                                                                    <input class="form-control" id="email"
                                                                        name="email" type="email"
                                                                        value="{{ $item->email }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Senha</label>
                                                                    <input class="form-control" id="password"
                                                                        name="password" type="password"
                                                                        onmouseover="showPassword()"
                                                                        onmouseout="hidePassword()">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Nascimento</label>
                                                                    <input class="form-control" id="nasc"
                                                                        name="nasc" type="date"
                                                                        value="{{ $item->nasc }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">CPF</label>
                                                                    <input class="form-control" id="cpf"
                                                                        name="cpf" type="text"
                                                                        value="{{ $item->cpf }}">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Gênero</label>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio"
                                                                                id="genero" name="genero" value="M"
                                                                                {{ $item->genero == 'M' ? 'checked' : '' }}>Masculino
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <label class="form-check-label">
                                                                            <input class="form-check-input" type="radio"
                                                                                id="genero" name="genero"
                                                                                value="F"
                                                                                {{ $item->genero == 'F' ? 'checked' : '' }}>Feminino
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Foto</label>
                                                                    <input class="form-control" type="file"
                                                                        name="imagem">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Permissão</label>
                                                                    <select class="form-control"
                                                                        id="permisoes_id{{ $item->id }}"
                                                                        name="permisoes_id">
                                                                        <option disabled selected
                                                                            style="font-size:18px;color: black;">Escolha
                                                                        </option>
                                                                        @foreach ($permissoes as $permissao)
                                                                            <option value="{{ $permissao->id }}"
                                                                                {{ $item->permisoes_id == $permissao->id ? 'selected' : '' }}>
                                                                                {{ $permissao->cargo }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div id="especialidade-div{{ $item->id }}"
                                                                    class="mb-3 col-md-4 hidden">
                                                                    <label class="form-label">Especialidades</label>
                                                                    <select class="form-control"
                                                                        id="especialidade_id{{ $item->id }}"
                                                                        name="especialidade_id">
                                                                        <option disabled selected
                                                                            style="font-size:18px;color: black;">Escolha
                                                                        </option>
                                                                        @foreach ($especialidades as $especialidade)
                                                                            <option value="{{ $especialidade->id }}"
                                                                                {{ $item->especialidade_id == $especialidade->id ? 'selected' : '' }}>
                                                                                {{ $especialidade->especialidade }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div id="crm-div{{ $item->id }}"
                                                                    class="mb-3 col-md-4 hidden">
                                                                    <label class="form-label">CRM</label>
                                                                    <input class="form-control"
                                                                        id="crm{{ $item->id }}" name="crm"
                                                                        type="text" value="{{ $item->crm }}">
                                                                </div>
                                                                <div id="corem-div{{ $item->id }}"
                                                                    class="mb-3 col-md-4 hidden">
                                                                    <label class="form-label">COREM</label>
                                                                    <input class="form-control"
                                                                        id="corem{{ $item->id }}" name="corem"
                                                                        type="text" value="{{ $item->corem }}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">CEP</label>
                                                                    <input class="form-control" name="cep"
                                                                        type="text" id="cep"
                                                                        value="{{ $item->cep }}" size="10"
                                                                        maxlength="9" onblur="pesquisacep(this.value);">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Rua</label>
                                                                    <input class="form-control" name="rua"
                                                                        type="text" id="rua"
                                                                        value="{{ $item->rua }}" size="60">
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">Bairro</label>
                                                                    <input class="form-control" name="bairro"
                                                                        type="text" id="bairro"
                                                                        value="{{ $item->bairro }}" size="40">
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Cidade</label>
                                                                    <input class="form-control" name="cidade"
                                                                        type="text" id="cidade"
                                                                        value="{{ $item->cidade }}" size="40">
                                                                </div>
                                                                <div class="mb-3 col-md-1">
                                                                    <label class="form-label">Estado</label>
                                                                    <input class="form-control" name="uf"
                                                                        type="text" id="uf"
                                                                        value="{{ $item->uf }}" size="2">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Salvar</button>
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
      document.addEventListener('DOMContentLoaded', function() {
          var permissoesSelect = document.getElementById('permisoes_id{{ $item->id }}');
          var especialidadeDiv = document.getElementById('especialidade-div{{ $item->id }}');
          var crmDiv = document.getElementById('crm-div{{ $item->id }}');
          var coremDiv = document.getElementById('corem-div{{ $item->id }}');
  
          permissoesSelect.addEventListener('change', function() {
              var selectedOption = permissoesSelect.options[permissoesSelect.selectedIndex].text.toLowerCase();
              if (selectedOption === 'médico') {
                  especialidadeDiv.classList.remove('hidden');
                  crmDiv.classList.remove('hidden');
                  coremDiv.classList.add('hidden');
              } else if (selectedOption === 'enfermeiro') {
                  especialidadeDiv.classList.add('hidden');
                  crmDiv.classList.add('hidden');
                  coremDiv.classList.remove('hidden');
              } else {
                  especialidadeDiv.classList.add('hidden');
                  crmDiv.classList.add('hidden');
                  coremDiv.classList.add('hidden');
              }
          });
      });
  
      function showPassword() {
          var passwordField = document.getElementById('password');
          passwordField.type = 'text';
      }
  
      function hidePassword() {
          var passwordField = document.getElementById('password');
          passwordField.type = 'password';
      }
  </script>
@endsection

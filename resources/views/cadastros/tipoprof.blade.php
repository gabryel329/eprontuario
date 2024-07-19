@extends('layouts.app')

@section('content')

<main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="bi bi-ui-checks"></i> Cadastro de Tipo Profissional</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        <li class="breadcrumb-item">Administração</li>
        <li class="breadcrumb-item">Cadastros</li>
        <li class="breadcrumb-item"><a href="#">Tipo Profissional</a></li>
      </ul>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
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
        <div class="col-md-6">
            <div class="tile">
              <h3 class="tile-title">Novo</h3>
              <div class="tile-body">
                <form method="POST" action="{{route('tipoprof.store')}}" class="form-horizontal">
                @csrf
                  <div class="row">
                    <div class="col-md-6">
                      <label class="form-label">Tipo Profissional</label>
                      <input name="nome" id="nome" class="form-control" type="text" placeholder="" required>
                    </div>
                    <div class="col-md-6">
                      <label class="form-label">Conselho</label>
                      <input name="conselho" id="conselho" class="form-control" type="text" placeholder="">
                    </div>
                  </div>
                  <div class="tile-footer">
                    <div class="row">
                      <div class="col-md-8 col-md-offset-3">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Novo</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tile">
              <h3 class="tile-title">Lista dos Tipos</h3>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Conselho</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($tipoprof as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->conselho }}</td>
                            <td>
                                <div>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                        Editar
                                    </button>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('tipoprof.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            </td>                            
                        </tr>

                        <!-- Modal for Editing -->
                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Editar Tipo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('tipoprof.update', $item->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                              <div class="col-md-6">
                                                  <label for="nome{{ $item->id }}" class="form-label">Nome</label>
                                                  <input type="text" class="form-control" id="nome{{ $item->id }}" name="nome" value="{{ $item->nome }}">
                                              </div>
                                              <div class="col-md-6">
                                                  <label for="conselho{{ $item->id }}" class="form-label">Conselho</label>
                                                  <input type="text" class="form-control" id="conselho{{ $item->id }}" name="conselho" value="{{ $item->conselho }}">
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
</main>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var permisaoForm = document.getElementById('permisaoForm');
    
    permisaoForm.addEventListener('submit', function(event) {
        var requiredFields = permisaoForm.querySelectorAll('[required]');
        var isValid = true;

        requiredFields.forEach(function(field) {
            if (!field.value) {
                field.setCustomValidity('Por favor, preencha este campo.');
                field.reportValidity();
                isValid = false;
            } else {
                field.setCustomValidity(''); // Limpa a mensagem personalizada
            }
        });

        if (!isValid) {
            event.preventDefault(); // Impede o envio do formulário
        }
    });

    // Adiciona um evento de input para limpar a mensagem personalizada quando o usuário começa a digitar
    permisaoForm.querySelectorAll('[required]').forEach(function(field) {
        field.addEventListener('input', function() {
            field.setCustomValidity('');
        });
    });
});
</script>

@endsection
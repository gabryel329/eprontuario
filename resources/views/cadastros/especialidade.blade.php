@extends('layouts.app')

@section('content')

<main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="bi bi-ui-checks"></i> Cadastro de Especialidades</h1>
      </div>
      <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
        <li class="breadcrumb-item">Administração</li>
        <li class="breadcrumb-item">Cadastros</li>
        <li class="breadcrumb-item"><a href="#">Especialidades</a></li>
      </ul>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="tile">
              <h3 class="tile-title">Novo</h3>
              <div class="tile-body">
                <form method="POST" action="{{route('especialidade.store')}}" class="form-horizontal">
                @csrf
                  <div class="mb-3 row">
                    <label class="form-label col-md-3">Nome da Especialidade</label>
                    <div class="col-md-8">
                      <input name="especialidade" id="especialidade" class="form-control" type="text" placeholder="">
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
              <h3 class="tile-title">Lista de Especialidade</h3>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Especialidades</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($especialidade as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->especialidade }}</td>
                            <td>
                                <div>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                        Editar
                                    </button>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('especialidade.destroy', $item->id) }}" method="POST">
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
                                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Editar Especialidade</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('especialidade.update', $item->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="especialidade{{ $item->id }}" class="form-label">Nome</label>
                                                <input type="text" class="form-control" id="especialidade{{ $item->id }}" name="especialidade" value="{{ $item->especialidade }}">
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
@endsection
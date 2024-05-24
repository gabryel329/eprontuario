@extends('layouts.app')
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-person-plus"></i> Criar Paciente</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Administração</li>
            <li class="breadcrumb-item active"><a href="#">Criar Paciente</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form method="POST" action="{{ route('paciente.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Nome</label>
                                <input class="form-control" name="name" type="text" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Sobrenome</label>
                                <input class="form-control" name="sobrenome" type="text" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">E-mail</label>
                                <input class="form-control" name="email" type="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Nascimento</label>
                                <input class="form-control" name="nasc" type="date" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">CPF</label>
                                <input class="form-control" name="cpf" type="text" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Gênero</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="genero" value="M" required>Masculino
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="radio" name="genero" value="F" required>Feminino
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Foto</label>
                                <input class="form-control" type="file" name="imagem">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">CEP</label>
                                <input class="form-control" name="cep" type="text" maxlength="9" required onblur="pesquisacep(this.value);">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Rua</label>
                                <input class="form-control" name="rua" type="text" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Bairro</label>
                                <input class="form-control" name="bairro" type="text" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Cidade</label>
                                <input class="form-control" name="cidade" type="text" required>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Estado</label>
                                <input class="form-control" name="uf" type="text" required>
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
</main>
@endsection

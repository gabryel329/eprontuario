@extends('layouts.app')
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-table"></i> Lista de Profissionais</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Administração</li>
            <li class="breadcrumb-item active"><a href="#">Profissionais</a></li>
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
                                    <th>#</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Honorario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profissioanls as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <div>
                                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#editModal{{ $item->id }}">
                                                    Editar
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Modal for Editing -->
                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Editar Profissional</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST" action="{{ route('profissional.update', $item->id) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="row">
                                                            <div class="mb-3 col-md-8">
                                                                <label class="form-label">Nome Completo</label>
                                                                <input class="form-control" name="name" type="text" value="{{ old('name', $item->name) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">E-mail</label>
                                                                <input class="form-control" name="email" type="email" value="{{ old('email', $item->email) }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Nascimento</label>
                                                                <input class="form-control" name="nasc" type="date" value="{{ old('nasc', $item->nasc) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">CPF</label>
                                                                <input class="form-control" name="cpf" type="text" value="{{ old('cpf', $item->cpf) }}" required>
                                                            </div>
                                                            <div class="mb-3 col-md-2">
                                                                <label class="form-label">Gênero</label>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="radio" name="genero" value="M" {{ old('genero', $item->genero) == 'M' ? 'checked' : '' }}>Masculino
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="radio" name="genero" value="F" {{ old('genero', $item->genero) == 'F' ? 'checked' : '' }}>Feminino
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Foto</label>
                                                                <input class="form-control" type="file" name="imagem">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-4 hidden" id="campo_conselho">
                                                                <label id="label_conselho" class="form-label">Conselho</label>
                                                                <input type="text" name="conselho" class="form-control" id="input_conselho" value="{{ old('conselho', $item->conselho) }}" placeholder="">
                                                                <div class="invalid-feedback">Por favor, preencha o campo Conselho.</div>
                                                            </div>                                                  
                                                        </div>
                                                        <div class="row" id="campos_comuns">
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">RG</label>
                                                                <input class="form-control" name="rg" type="text" value="{{ old('rg', $item->rg) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Étnia</label>
                                                                <select class="form-control" name="cor">
                                                                    <option disabled selected value="" style="font-size:18px;color: black;">{{ old('cor', $item->cor) }}</option>
                                                                    <option value="Branco" {{ old('cor', $item->cor) == 'Branco' ? 'selected' : '' }}>Branco</option>
                                                                    <option value="Preto" {{ old('cor', $item->cor) == 'Preto' ? 'selected' : '' }}>Preto</option>
                                                                    <option value="Amarelo" {{ old('cor', $item->cor) == 'Amarelo' ? 'selected' : '' }}>Amarelo</option>
                                                                    <option value="Pardo" {{ old('cor', $item->cor) == 'Pardo' ? 'selected' : '' }}>Pardo</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Telefone</label>
                                                                <input class="form-control" name="telefone" type="text" value="{{ old('telefone', $item->telefone) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Celular</label>
                                                                <input class="form-control" name="celular" type="text" value="{{ old('celular', $item->celular) }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">CEP</label>
                                                                <input class="form-control" name="cep" type="text" id="cep" value="{{ old('cep', $item->cep) }}" size="10" maxlength="9" onblur="pesquisacep(this.value);">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Rua</label>
                                                                <input class="form-control" name="rua" type="text" id="rua" value="{{ old('rua', $item->rua) }}" size="60">
                                                            </div>
                                                            <div class="mb-3 col-md-2">
                                                                <label class="form-label">Bairro</label>
                                                                <input class="form-control" name="bairro" type="text" id="bairro" value="{{ old('bairro', $item->bairro) }}" size="40">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Cidade</label>
                                                                <input class="form-control" name="cidade" type="text" id="cidade" value="{{ old('cidade', $item->cidade) }}" size="40">
                                                            </div>
                                                            <div class="mb-3 col-md-1">
                                                                <label class="form-label">Estado</label>
                                                                <input class="form-control" name="uf" type="text" id="uf" value="{{ old('uf', $item->uf) }}" size="2">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
$(document).ready(function(){
    $('#cnpj').mask('00.000.000/0000-00');
    $('#telefone').mask('(00) 0000-0000');
    $('#celular').mask('(00) 00000-0000');
});
</script>
@endsection

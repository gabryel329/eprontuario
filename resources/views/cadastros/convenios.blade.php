@extends('layouts.app')
@section('content')
<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-table"></i> Lista de Convenios</h1>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">Novo</button>
        </div>
    </div>
     <!-- Modal -->
     <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Novo Convênio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Conteúdo do modal aqui -->
                    <form method="POST" action="{{route('convenio.store')}}">
                        @csrf
                        <div class="row">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Nome</label>
                                    <input class="form-control" id="nome" name="nome" type="text">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Registro ANS</label>
                                    <input class="form-control" id="ans" name="ans" type="text">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">CNPJ</label>
                                    <input class="form-control" id="cnpj" name="cnpj" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Telefone</label>
                                    <input class="form-control" id="telefone" name="telefone" type="text">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Celular</label>
                                    <input class="form-control" id="celular" name="celular" type="text" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Rua</label>
                                    <input class="form-control" id="rua" name="rua" type="text" required>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Número</label>
                                    <input class="form-control" id="numero" name="numero" type="text" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Complemento</label>
                                    <input class="form-control" id="complemento" name="complemento" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Bairro</label>
                                    <input class="form-control" id="bairro" name="bairro" type="text" required>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">CEP</label>
                                    <input class="form-control" id="cep" name="cep" type="text" onblur="pesquisacep2(this.value);" required>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Cidade</label>
                                    <input class="form-control" id="cidade" name="cidade" type="text" required>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Estado</label>
                                    <input class="form-control" id="uf" name="uf" type="text" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>CNPJ</th>
                                <th>ANS</th>
                                <th>Procedimentos</th>
                                <th>Editar</th>
                                <th>Deletar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($convenios as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nome }}</td>
                                    <td>{{ $item->cnpj }}</td>
                                    <td>{{ $item->ans }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" {{ $item->id }}>
                                            <i class="icon bi bi-list-ul"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                            <i class="icon bi bi-pencil-square"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                            <i class="icon bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Editar Convenios</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST"
                                                    action="{{ route('convenio.update', $item->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Nome</label>
                                                                <input class="form-control" id="nome{{ $item->id }}" name="nome" type="text" value="{{ $item->nome }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Registro ANS</label>
                                                                <input class="form-control" id="ans{{ $item->id }}" name="ans" type="text" value="{{ $item->ans }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">CNPJ</label>
                                                                <input class="form-control" id="cnpj{{ $item->id }}" name="cnpj" type="text" value="{{ $item->cnpj }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Telefone</label>
                                                                <input class="form-control" id="telefone{{ $item->id }}" name="telefone" type="text" value="{{ $item->telefone }}">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Celular</label>
                                                                <input class="form-control" id="celular{{ $item->id }}" name="celular" type="text" value="{{ $item->celular }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Rua</label>
                                                                <input class="form-control" id="rua{{ $item->id }}" name="rua" type="text" value="{{ $item->rua }}" required>
                                                            </div>
                                                            <div class="mb-3 col-md-2">
                                                                <label class="form-label">Número</label>
                                                                <input class="form-control" id="numero{{ $item->id }}" name="numero" type="text" value="{{ $item->numero }}" required>
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Complemento</label>
                                                                <input class="form-control" id="complemento{{ $item->id }}" name="complemento" type="text" value="{{ $item->complemento }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Bairro</label>
                                                                <input class="form-control" id="bairro{{ $item->id }}" name="bairro" type="text" value="{{ $item->bairro }}" required>
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">CEP</label>
                                                                <input class="form-control" id="cep{{ $item->id }}" name="cep" type="text" value="{{ $item->cep }}" onblur="pesquisacep(this.value);" required>
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Cidade</label>
                                                                <input class="form-control" id="cidade{{ $item->id }}" name="cidade" type="text" value="{{ $item->cidade }}" required>
                                                            </div>
                                                            <div class="mb-3 col-md-2">
                                                                <label class="form-label">Estado</label>
                                                                <input class="form-control" id="uf{{ $item->id }}" name="uf" type="text" value="{{ $item->uf }}" required>
                                                            </div>
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

                                <!-- Delete Confirmation Modal -->
                                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $item->id }}">Confirmar Exclusão</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Tem certeza de que deseja excluir o Convenio <strong>{{ $item->nome }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('convenio.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Excluir</button>
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
</main>

<script>
function pesquisacep(valor) {
        var cep = valor.replace(/\D/g, '');
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                document.getElementById('rua').value = "...";
                document.getElementById('bairro').value = "...";
                document.getElementById('cidade').value = "...";
                document.getElementById('uf').value = "...";

                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';
                document.body.appendChild(script);
            } else {
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } else {
            limpa_formulário_cep();
        }
    }

    function limpa_formulário_cep() {
        document.getElementById('rua').value = "";
        document.getElementById('bairro').value = "";
        document.getElementById('cidade').value = "";
        document.getElementById('uf').value = "";
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            document.getElementById('rua').value = conteudo.logradouro;
            document.getElementById('bairro').value = conteudo.bairro;
            document.getElementById('cidade').value = conteudo.localidade;
            document.getElementById('uf').value = conteudo.uf;
        } else {
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function pesquisacep2(valor) {
        var cep = valor.replace(/\D/g, '');
        if (cep != "") {
            var validacep = /^[0-9]{8}$/;
            if (validacep.test(cep)) {
                document.getElementById('rua').value = "...";
                document.getElementById('bairro').value = "...";
                document.getElementById('cidade').value = "...";
                document.getElementById('uf').value = "...";

                var script = document.createElement('script');
                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback2';
                document.body.appendChild(script);
            } else {
                limpa_formulário_cep2();
                alert("Formato de CEP inválido.");
            }
        } else {
            limpa_formulário_cep2();
        }
    }

    function limpa_formulário_cep2() {
        document.getElementById('rua').value = "";
        document.getElementById('bairro').value = "";
        document.getElementById('cidade').value = "";
        document.getElementById('uf').value = "";
    }

    function meu_callback2(conteudo) {
        if (!("erro" in conteudo)) {
            document.getElementById('rua').value = conteudo.logradouro;
            document.getElementById('bairro').value = conteudo.bairro;
            document.getElementById('cidade').value = conteudo.localidade;
            document.getElementById('uf').value = conteudo.uf;
        } else {
            limpa_formulário_cep2();
            alert("CEP não encontrado.");
        }
    }
</script>
@endsection

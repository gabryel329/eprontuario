@extends('layouts.app')
@section('content')
<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-table"></i> Lista de Pacientes</h1>
        </div>
        <button type="button" class="btn btn-primary" onclick="window.location='{{ route('agenda.index1') }}'">Ir para Agenda</button>
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
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>CPF</th>
                                <th>Celular</th>
                                <th>Editar</th>
                                <th>Deletar</th>
                                <th>Imprimir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paciente as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->cpf }}</td>
                                    <td>{{ $item->celular }}</td>
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
                                    <td>
                                        <a href="{{ route('paciente.ficha', $item->id) }}" class="btn btn-primary" target="_blank">Imprimir</a>
                                    </td>
                                </tr>
                                
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Editar Paciente</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('paciente.update', $item->id) }}" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Nome Completo</label>
                                                                <input class="form-control" name="name" type="text" value="{{ old('name', $item->name) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">E-mail</label>
                                                                <input class="form-control" name="email" type="email" value="{{ old('email', $item->email) }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">CPF</label>
                                                                <input class="form-control" name="cpf" type="text" value="{{ old('cpf', $item->cpf) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">RG</label>
                                                                <input class="form-control" name="rg" type="text" value="{{ old('rg', $item->rg) }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Nascimento</label>
                                                                <input class="form-control" name="nasc" type="date" value="{{ old('nasc', $item->nasc) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Nome Social</label>
                                                                <input class="form-control" name="nome_social" type="text" value="{{ old('nome_social', $item->nome_social) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Gênero</label>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="radio" name="genero" value="M" {{ old('genero', $item->genero) == 'M' ? 'checked' : '' }}> Masculino
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="radio" name="genero" value="F" {{ old('genero', $item->genero) == 'F' ? 'checked' : '' }}> Feminino
                                                                    </label>
                                                            </div>
                                                        </div>    
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Certidão de Nascimento</label>
                                                                <input class="form-control" name="certidao" type="text" value="{{ old('certidao', $item->certidao) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">SUS</label>
                                                                <input class="form-control" name="sus" type="text" value="{{ old('sus', $item->sus) }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-2">
                                                                <label class="form-label">Convênio</label>
                                                                <select class="form-control" name="convenio_id">
                                                                    <option value="">Selecione</option>
                                                                    @foreach ($convenios as $convenio)
                                                                        <option value="{{ $convenio->id }}" {{ old('convenio_id', $item->convenio_id) == $convenio->id ? 'selected' : '' }}>{{ $convenio->nome }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Matrícula</label>
                                                                <input class="form-control" name="matricula" type="text" value="{{ old('matricula', $item->matricula) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-2">
                                                                <label class="form-label">Plano</label>
                                                                <input class="form-control" name="plano" type="text" value="{{ old('plano', $item->plano) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-2">
                                                                <label class="form-label">Titular</label>
                                                                <input class="form-control" name="titular" type="text" value="{{ old('titular', $item->titular) }}">
                                                            </div>
                                                            <div class="mb-3 col-md-2">
                                                                <label class="form-label">Produto</label>
                                                                <input class="form-control" name="produto" type="text" value="{{ old('produto', $item->produto) }}">
                                                            </div>
                                                        </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label">Cor</label>
                                                            <input class="form-control" name="cor" type="text" value="{{ old('cor', $item->cor) }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label">Nome do Pai</label>
                                                            <input class="form-control" name="nome_pai" type="text" value="{{ old('nome_pai', $item->nome_pai) }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label">Nome da Mãe</label>
                                                            <input class="form-control" name="nome_mae" type="text" value="{{ old('nome_mae', $item->nome_mae) }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label">Acompanhante</label>
                                                            <input class="form-control" name="acompanhante" type="text" value="{{ old('acompanhante', $item->acompanhante) }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label">Estado Civil</label>
                                                            <select class="form-control" name="estado_civil">
                                                                <option value="">Selecione</option>
                                                                <option value="Solteiro(a)" {{ old('estado_civil', $item->estado_civil) == 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
                                                                <option value="Casado(a)" {{ old('estado_civil', $item->estado_civil) == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                                                <option value="Divorciado(a)" {{ old('estado_civil', $item->estado_civil) == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                                                <option value="Viuvo(a)" {{ old('estado_civil', $item->estado_civil) == 'Viuvo(a)' ? 'selected' : '' }}>Viuvo(a)</option>
                                                                <option value="Separado(a)" {{ old('estado_civil', $item->estado_civil) == 'Separado(a)' ? 'selected' : '' }}>Separado(a)</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label">PCD</label>
                                                            <input class="form-control" name="pcd" type="text" value="{{ old('pcd', $item->pcd) }}">
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label">Imagem</label>
                                                            <input class="form-control" name="imagem" type="file">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label">CEP</label>
                                                            <input class="form-control" name="cep" type="text" value="{{ old('cep', $item->cep) }}" onblur="pesquisacep(this.value);">
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label">Rua</label>
                                                            <input class="form-control" name="rua" type="text" value="{{ old('rua', $item->rua) }}">
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <label class="form-label">Bairro</label>
                                                            <input class="form-control" name="bairro" type="text" value="{{ old('bairro', $item->bairro) }}">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label">Número</label>
                                                            <input class="form-control" name="numero" type="text" value="{{ old('numero', $item->numero) }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label">Complemento</label>
                                                            <input class="form-control" name="complemento" type="text" value="{{ old('complemento', $item->complemento) }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label">Cidade</label>
                                                            <input class="form-control" name="cidade" type="text" value="{{ old('cidade', $item->cidade) }}">
                                                        </div>
                                                        <div class="mb-3 col-md-3">
                                                            <label class="form-label">Estado</label>
                                                            <input class="form-control" name="uf" type="text" value="{{ old('uf', $item->uf) }}">
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
                                                <p>Tem certeza de que deseja excluir o paciente <strong>{{ $item->name }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('paciente.destroy', $item->id) }}" method="POST">
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
</script>
@endsection

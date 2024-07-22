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
                                                <form method="POST"
                                                    action="{{ route('paciente.update', $item->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row">
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Nome Completo</label>
                                                                <input class="form-control" id="name{{ $item->id }}" name="name" type="text" value="{{ $item->name }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">E-mail</label>
                                                                <input class="form-control" id="email{{ $item->id }}" name="email" type="text" value="{{ $item->email }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Nome Social</label>
                                                                <input class="form-control" id="nome_social{{ $item->id }}" name="nome_social" type="text" value="{{ $item->nome_social }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Nascimento </label>
                                                                <input class="form-control" id="nasc{{ $item->id }}" name="nasc" type="date" value="{{ $item->nasc }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">CPF </label>
                                                                <input class="form-control" id="cpf{{ $item->id }}" name="cpf" type="text" value="{{ $item->cpf }}">
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Gênero</label>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="radio" id="generoM{{ $item->id }}" name="genero" value="M" {{ $item->genero == 'M' ? 'checked' : '' }}>Masculino
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <label class="form-check-label">
                                                                        <input class="form-check-input" type="radio" id="generoF{{ $item->id }}" name="genero" value="F" {{ $item->genero == 'F' ? 'checked' : '' }}>Feminino
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3 col-md-3">
                                                                <label class="form-label">Foto</label>
                                                                <input class="form-control" type="file" name="imagem">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">RG </label>
                                                                <input class="form-control" id="rg{{ $item->id }}" name="rg" type="text" value="{{ $item->rg }}" required>
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Certidão de Nascimento</label>
                                                                <input class="form-control" id="certidao{{ $item->id }}" name="certidao" type="text" value="{{ $item->certidao }}">
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">SUS</label>
                                                                <input class="form-control" id="sus{{ $item->id }}" name="sus" type="text" value="{{ $item->sus }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Convênio:</label>
                                                                <select class="form-control" id="convenio{{ $item->id }}" name="convenio">
                                                                    <option disabled selected style="font-size:18px;color: black;">Escolha</option>
                                                                    {{-- @foreach ($convenios as $convenio)
                                                                        <option value="{{ $convenio->id }}" {{ $convenio->id == $item->convenio_id ? 'selected' : '' }}>{{ $convenio->nome }}</option>
                                                                    @endforeach --}}
                                                                </select>
                                                            </div>                                                            
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Matricula</label>
                                                                <input class="form-control" id="matricula{{ $item->id }}" name="matricula" type="text" value="{{ $item->matricula }}">
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Cor</label>
                                                                <select class="form-control" id="cor{{ $item->id }}" name="cor">
                                                                    <option disabled selected style="font-size:18px;color: black;">{{ $item->cor }}</option>       
                                                                    <option value="Branco" {{ $item->cor == 'Branco' ? 'selected' : '' }}>Branco</option>
                                                                    <option value="Preto" {{ $item->cor == 'Preto' ? 'selected' : '' }}>Preto</option>
                                                                    <option value="Amarelo" {{ $item->cor == 'Amarelo' ? 'selected' : '' }}>Amarelo</option>
                                                                    <option value="Pardo" {{ $item->cor == 'Pardo' ? 'selected' : '' }}>Pardo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Nome do Pai</label>
                                                                <input class="form-control" id="nome_pai{{ $item->id }}" name="nome_pai" type="text" value="{{ $item->nome_pai }}">
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Nome da Mãe</label>
                                                                <input class="form-control" id="nome_mae{{ $item->id }}" name="nome_mae" type="text" value="{{ $item->nome_mae }}" required>
                                                            </div>
                                                            <div class="mb-3 col-md-4">
                                                                <label class="form-label">Acompanhante</label>
                                                                <input class="form-control" id="acompanhante{{ $item->id }}" name="acompanhante" type="text" value="{{ $item->acompanhante }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Estado Civil</label>
                                                                <select class="form-control" id="estado_civil{{ $item->id }}" name="estado_civil">
                                                                    <option disabled selected style="font-size:18px;color: black;">{{ $item->estado_civil }}</option>
                                                                    <option value="Solteiro(a)" {{ $item->estado_civil == 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
                                                                    <option value="Casado(a)" {{ $item->estado_civil == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                                                    <option value="Divorciado(a)" {{ $item->estado_civil == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                                                    <option value="Viuvo(a)" {{ $item->estado_civil == 'Viuvo(a)' ? 'selected' : '' }}>Viuvo(a)</option>
                                                                    <option value="Separado(a)" {{ $item->estado_civil == 'Separado(a)' ? 'selected' : '' }}>Separado(a)</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 col-md-6" id="pcd-container2">
                                                                <label class="form-label">PCD:</label>
                                                                <input class="form-control" id="pcd{{ $item->id }}" name="pcd" type="text" placeholder="Opcional" value="{{ $item->pcd }}">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="mb-3 col-md-6">
                                                                <label class="form-label">Telefone Fixo</label>
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

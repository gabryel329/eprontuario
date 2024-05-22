@extends('layouts.app')
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-table"></i> Lista de Pacientes </h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item active"><a href="#">Pacientes</a></li>
            </ul>
        </div>
        <div class="">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                Novo
            </button>
        </div>
        <br>
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Novo Paciente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('paciente.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Nome </label>
                                    <input class="form-control" id="name" name="name" type="text">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Sobrenome </label>
                                    <input class="form-control" id="sobrenome" name="sobrenome" type="text">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">E-mail</label>
                                    <input class="form-control" id="email" name="email" type="email">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Nome Social</label>
                                    <input class="form-control" id="nome_social" name="nome_social" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Nascimento </label>
                                    <input class="form-control" id="nasc" name="nasc" type="date">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">CPF </label>
                                    <input class="form-control" id="cpf" name="cpf" type="text">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Gênero</label>
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input class="form-check-input" type="radio" id="genero" name="genero" value="M">Masculino
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input class="form-check-input" type="radio" id="genero" name="genero" value="F">Feminino
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
                                    <label class="form-label">RG</label>
                                    <input class="form-control" id="rg" name="rg" type="text">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Certidão de Nascimento</label>
                                    <input class="form-control" id="certidao" name="certidao" type="text">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">SUS</label>
                                    <input class="form-control" id="sus" name="sus" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Convênio</label>
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input class="form-check-input" type="radio" id="convenio" name="convenio" value="S">SIM
                                      </label>
                                    </div>
                                    <div class="form-check">
                                      <label class="form-check-label">
                                        <input class="form-check-input" type="radio" id="convenio" name="convenio" value="N">NÃO
                                      </label>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Matricula</label>
                                    <input class="form-control" id="matricula" name="matricula" type="text">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Cor</label>
                                    <select class="form-control" id="cor" name="cor">
                                        <option disabled selected style="font-size:18px;color: black;">Escolha</option>       
                                            <option value="Branco">Branco</option>
                                            <option value="Preto">Preto</option>
                                            <option value="Amarelo">Amarelo</option>
                                            <option value="Pardo">Pardo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Nome do Pai</label>
                                    <input class="form-control" id="nome_pai" name="nome_pai" type="text">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Nome da Mãe</label>
                                    <input class="form-control" id="nome_mãe" name="nome_mãe" type="text">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Acompanhante</label>
                                    <input class="form-control" id="acompanhante" name="acompanhante" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Telefone</label>
                                    <input class="form-control" id="telefone" name="telefone" type="text">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Celular</label>
                                    <input class="form-control" id="celular" name="celular" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">CEP </label>
                                    <input class="form-control" name="cep" type="text" id="cep" value="" size="10" maxlength="9"
                                    onblur="pesquisacep(this.value);">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Rua </label>
                                    <input class="form-control" name="rua" type="text" id="rua" size="60">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Bairro</label>
                                    <input class="form-control" name="bairro" type="text" id="bairro" size="40">
                                </div>
                                <div class="mb-3 col-md-1">
                                    <label class="form-label">Estado</label>
                                    <input class="form-control"  name="uf" type="text" id="uf" size="2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Cidade</label>
                                    <input class="form-control" name="cidade" type="text" id="cidade" size="40">
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Numero</label>
                                    <input class="form-control" name="numero" type="text" id="numero" size="40">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Complemento</label>
                                    <input class="form-control" name="complemento" type="text" id="complemento" size="40">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4 align-self-end">
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Salva</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" id="sampleTable">
                                <thead>
                                    <tr>
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
                                            <td>{{ $item->name }} {{ $item->sobrenome }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->cpf }}</td>
                                            <td>{{ $item->celular }}</td>
                                            <td>
                                                <div>
                                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                        data-bs-target="#editModal{{ $item->id }}">
                                                        Editar
                                                    </button>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('paciente.destroy', $item->id) }}" method="POST">
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
                                                            Editar Paciente</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST"
                                                            action="{{ route('paciente.update', $item->id) }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="row">
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label">Nome </label>
                                                                        <input class="form-control" id="name{{ $item->id }}" name="name" type="text" value="{{ $item->name }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label">Sobrenome </label>
                                                                        <input class="form-control" id="sobrenome{{ $item->id }}" name="sobrenome" type="text" value="{{ $item->sobrenome }}">
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
                                                                                <input class="form-check-input" type="radio" id="genero" name="genero" value="M" {{ $item->genero == 'M' ? 'checked' : '' }}>Masculino
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input class="form-check-input" type="radio" id="genero" name="genero" value="F" {{ $item->genero == 'F' ? 'checked' : '' }}>Feminino
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label">Foto</label>
                                                                        <input class="form-control" type="file" name="imagem">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label">RG </label>
                                                                        <input class="form-control" id="rg{{ $item->id }}" name="rg" type="text" value="{{ $item->rg }}">
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
                                                                        <label class="form-label">Convênio</label>
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input class="form-check-input" type="radio" id="convenio" name="convenio" value="S" {{ $item->convenio == 'S' ? 'checked' : '' }}>Sim
                                                                            </label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <label class="form-check-label">
                                                                                <input class="form-check-input" type="radio" id="convenio" name="convenio" value="N" {{ $item->convenio == 'N' ? 'checked' : '' }}>Não
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3 col-md-4">
                                                                        <label class="form-label">Matricula</label>
                                                                        <input class="form-control" id="matricula{{ $item->id }}" name="matricula" type="text" value="{{ $item->matricula }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-4">
                                                                        <label class="form-label">Cor</label>
                                                                        <select class="form-control" id="cor" name="cor">
                                                                            <option disabled selected style="font-size:18px;color: black;">{{ $item->cor }}</option>       
                                                                                <option value="Branco">Branco</option>
                                                                                <option value="Preto">Preto</option>
                                                                                <option value="Amarelo">Amarelo</option>
                                                                                <option value="Pardo">Pardo</option>
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
                                                                        <input class="form-control" id="nome_mae{{ $item->id }}" name="nome_mae" type="text" value="{{ $item->nome_mae }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-4">
                                                                        <label class="form-label">Acompanhante</label>
                                                                        <input class="form-control" id="acompanhante{{ $item->id }}" name="acompanhante" type="text" value="{{ $item->acompanhante }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">Telefone</label>
                                                                        <input class="form-control" id="telefone{{ $item->id }}" name="telefone" type="text" value="{{ $item->telefone }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">Celular</label>
                                                                        <input class="form-control" id="celular{{ $item->id }}" name="celular" type="text" value="{{ $item->celular }}">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-3">
                                                                        <label class="form-label">CEP </label>
                                                                        <input class="form-control" name="cep" type="text" id="cep" value="{{ $item->cep }}" size="10" maxlength="9"
                                                                        onblur="pesquisacep(this.value);">
                                                                    </div>
                                                                    <div class="mb-3 col-md-4">
                                                                        <label class="form-label">Rua </label>
                                                                        <input class="form-control" name="rua" type="text" id="rua" value="{{ $item->rua }}" size="60">
                                                                    </div>
                                                                    <div class="mb-3 col-md-4">
                                                                        <label class="form-label">Bairro</label>
                                                                        <input class="form-control" name="bairro" type="text" id="bairro" value="{{ $item->bairro }}" size="40">
                                                                    </div>
                                                                    <div class="mb-3 col-md-1">
                                                                        <label class="form-label">Estado</label>
                                                                        <input class="form-control"  name="uf" type="text" id="uf" value="{{ $item->uf }}" size="2">
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-4">
                                                                        <label class="form-label">Cidade</label>
                                                                        <input class="form-control" name="cidade" type="text" id="cidade" value="{{ $item->cidade }}" size="40">
                                                                    </div>
                                                                    <div class="mb-3 col-md-2">
                                                                        <label class="form-label">Numero</label>
                                                                        <input class="form-control" name="numero" type="text" id="numero" value="{{ $item->numero }}" size="40">
                                                                    </div>
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">Complemento</label>
                                                                        <input class="form-control" name="complemento" type="text" id="complemento" value="{{ $item->complemento }}" size="40">
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
        function limpa_formulário_cep() {
                //Limpa valores do formulário de cep.
                document.getElementById('rua').value=("");
                document.getElementById('bairro').value=("");
                document.getElementById('cidade').value=("");
                document.getElementById('uf').value=("");
        }
    
        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('rua').value=(conteudo.logradouro);
                document.getElementById('bairro').value=(conteudo.bairro);
                document.getElementById('cidade').value=(conteudo.localidade);
                document.getElementById('uf').value=(conteudo.uf);
            } //end if.
            else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }
            
        function pesquisacep(valor) {
    
            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');
    
            //Verifica se campo cep possui valor informado.
            if (cep != "") {
    
                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;
    
                //Valida o formato do CEP.
                if(validacep.test(cep)) {
    
                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('rua').value="...";
                    document.getElementById('bairro').value="...";
                    document.getElementById('cidade').value="...";
                    document.getElementById('uf').value="...";
    
                    //Cria um elemento javascript.
                    var script = document.createElement('script');
    
                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
    
                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);
    
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        };
    
    </script>
@endsection

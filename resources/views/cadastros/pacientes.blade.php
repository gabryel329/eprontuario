@extends('layouts.app')
@section('content')
<main class="app-content">
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
            <h3 class="tile-title">Novo Paciente</h3>
            <div class="tile-body">
                <form action="{{route('paciente.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nome Completo</label>
                            <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">E-mail</label>
                            <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Nome Social</label>
                            <input class="form-control" id="nome_social" name="nome_social" type="text" value="{{ old('nome_social') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Nascimento </label>
                            <input class="form-control" id="nasc" name="nasc" type="date" value="{{ old('nasc') }}" max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">CPF </label>
                            <input class="form-control" id="cpf" name="cpf" type="text" value="{{ old('cpf') }}" required>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Gênero</label>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="genero" name="genero" value="M" {{ old('genero') == 'M' ? 'checked' : '' }}>Masculino
                              </label>
                            </div>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="genero" name="genero" value="F" {{ old('genero') == 'F' ? 'checked' : '' }}>Feminino
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
                            <input class="form-control" id="rg" name="rg" type="text" value="{{ old('rg') }}" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Certidão de Nascimento</label>
                            <input class="form-control" id="certidao" name="certidao" type="text" value="{{ old('certidao') }}">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">CNS</label>
                            <input class="form-control" id="sus" name="sus" type="text" value="{{ old('sus') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Convênio</label>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="convenio" name="convenio" value="S" {{ old('convenio') == 'S' ? 'checked' : '' }}>SIM
                              </label>
                            </div>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="convenio" name="convenio" value="N" {{ old('convenio') == 'N' ? 'checked' : '' }}>NÃO
                              </label>
                            </div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Matricula</label>
                            <input class="form-control" id="matricula" name="matricula" type="text" value="{{ old('matricula') }}">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Étnia</label>
                            <select class="form-control" id="cor" name="cor" required>
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
                            <input class="form-control" id="nome_pai" name="nome_pai" type="text" value="{{ old('nome_pai') }}">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Nome da Mãe</label>
                            <input class="form-control" id="nome_mãe" name="nome_mãe" type="text" value="{{ old('nome_mãe') }}">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Acompanhante</label>
                            <input class="form-control" id="acompanhante" name="acompanhante" type="text" value="{{ old('acompanhante') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Telefone</label>
                            <input class="form-control" id="telefone" name="telefone" type="text" value="{{ old('telefone') }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Celular</label>
                            <input class="form-control" id="celular" name="celular" type="text" value="{{ old('celular') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label class="form-label">CEP </label>
                            <input class="form-control" name="cep" type="text" id="cep" value="{{ old('cep') }}" size="10" maxlength="9"
                            onblur="pesquisacep(this.value);" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Rua </label>
                            <input class="form-control" name="rua" type="text" id="rua" size="60" value="{{ old('rua') }}">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Bairro</label>
                            <input class="form-control" name="bairro" type="text" id="bairro" size="40" value="{{ old('bairro') }}">
                        </div>
                        <div class="mb-3 col-md-1">
                            <label class="form-label">Estado</label>
                            <input class="form-control"  name="uf" type="text" id="uf" size="2" value="{{ old('uf') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Cidade</label>
                            <input class="form-control" name="cidade" type="text" id="cidade" size="40" value="{{ old('cidade') }}">
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label">Numero</label>
                            <input class="form-control" name="numero" type="text" id="numero" size="40" value="{{ old('numero') }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Complemento</label>
                            <input class="form-control" name="complemento" type="text" id="complemento" size="40" value="{{ old('complemento') }}">
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
    </main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function(){
        $('#cpf').mask('000.000.000-00');
        $('#telefone').mask('(00) 0000-0000');
        $('#celular').mask('(00) 00000-0000');
    });

    function limpa_formulário_cep() {
        document.getElementById('rua').value=("");
        document.getElementById('bairro').value=("");
        document.getElementById('cidade').value=("");
        document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } else {
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function pesquisacep(valor) {
        var cep = valor.replace(/\D/g, '');

        if (cep != "") {
            var validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                var script = document.createElement('script');

                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                document.body.appendChild(script);

            } else {
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } else {
            limpa_formulário_cep();
        }
    }
</script>
@endsection
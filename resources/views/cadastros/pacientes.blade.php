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
                            <input class="form-control" id="cpf" name="cpf" type="text" required>
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
                            <input class="form-control" id="rg" name="rg" type="text" required>
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
                            <label class="form-label">Étnia</label>
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
                            <input class="form-control" id="celular" name="celular" type="text" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label class="form-label">CEP </label>
                            <input class="form-control" name="cep" type="text" id="cep" value="" size="10" maxlength="9"
                            onblur="pesquisacep(this.value);" required>
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
    </main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function(){
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 0000-0000');
    $('#celular').mask('(00) 00000-0000');
});

    function showPassword() {
        var passwordField = document.getElementById('password');
        passwordField.type = 'text';
    }

    function hidePassword() {
        var passwordField = document.getElementById('password');
        passwordField.type = 'password';
    }

    document.addEventListener('DOMContentLoaded', function() {
        var permissoesSelect = document.getElementById('permisoes_id');
        var especialidadeDiv = document.getElementById('especialidade-div');
        var crmDiv = document.getElementById('crm-div');
        var coremDiv = document.getElementById('corem-div');

        permissoesSelect.addEventListener('change', function() {
            var selectedValue = permissoesSelect.value;

            if (selectedValue == '2') { // Certifique-se de que '2' é o ID correspondente a 'médico'
                especialidadeDiv.classList.remove('hidden');
                crmDiv.classList.remove('hidden');
                coremDiv.classList.add('hidden');
            } else if (selectedValue == '3') { // Certifique-se de que '3' é o ID correspondente a 'enfermeiro'
                especialidadeDiv.classList.remove('hidden');
                crmDiv.classList.add('hidden');
                coremDiv.classList.remove('hidden');
            } else {
                especialidadeDiv.classList.add('hidden');
                crmDiv.classList.add('hidden');
                coremDiv.classList.add('hidden');
            }
        });
    });
    
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

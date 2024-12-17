    @extends('layouts.app')

    @section('content')
    <style>
        .larger-checkbox {
        transform: scale(1.5); /* Ajuste o valor para o tamanho desejado */
        margin: 0;
        cursor: pointer;
    }
    </style>

    <main class="app-content">
        <div class="app-title d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-table"></i> Cadastro de Fornecedores</h1>
            </div>
            <button type="button" class="btn btn-primary" onclick="window.location='{{ route('listafornecedores.index1') }}'">Lista de Fornecedores</button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-warning">
                {{ session('error') }}
            </div>
        @endif
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <form method="POST" action="{{ route('fornecedores.store')}}">
                            @csrf
                            <!-- Dados Gerais -->
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <strong>Dados Gerais</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Nome</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">C.N.P.J</label>
                                            <input type="text" name="cnpj" id="cnpj" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">C.P.F</label>
                                            <input type="text" name="cpf" id="cpf" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Insc. Municipal</label>
                                            <input type="text" name="insc_municipal" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Fantasia</label>
                                            <input type="text" name="fantasia" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Insc. Est.</label>
                                            <input type="text" name="insc_est" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Endereço -->
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <strong>Endereço</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">CEP </label>
                                            <input class="form-control" name="cep" type="text" id="cep"
                                                value="" size="10" maxlength="9"
                                                onblur="pesquisacep(this.value);" required>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Logradouro</label>
                                            <input type="text" name="rua" id="rua" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Cidade *</label>
                                            <input type="text" name="cidade" id="cidade" class="form-control" value="Salvador">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Bairro</label>
                                            <input type="text" name="bairro" id="bairro" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Número/Complemento</label>
                                            <input type="text" name="numero" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">U.F *</label>
                                            <input type="text" name="uf" id="uf" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Outras Informações -->
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <strong>Outras Informações</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Tipo</label>
                                            <select name="tipo" class="form-control">
                                                <option value="Física">Física</option>
                                                <option value="Jurídica">Jurídica</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Tipo C/F/A</label>
                                            <select name="tipo_cf_a" class="form-control">
                                                <option value="Ambos">Ambos</option>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Contato Principal</label>
                                            <input type="text" name="contato_principal" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Senha</label>
                                            <input type="password" name="senha" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" value="admin">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Telefone</label>
                                            <input type="text" name="telefone" id="telefone" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Prazo</label>
                                            <input type="text" name="prazo" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações Sobre o Contrato -->
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <strong>Informações Sobre o Contrato</strong>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Valor Mensal</label>
                                            <input type="text" name="valor_mensal" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Juros Dia</label>
                                            <input type="text" name="juros_dia" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Multa</label>
                                            <input type="text" name="multa" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">Multa Dia</label>
                                            <input type="text" name="multa_dia" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row">
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Ult. Reajuste</label>
                                                <input type="date" name="ultimo_reajuste" class="form-control">
                                            </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Dia do Vencimento</label>
                                            <input type="date" name="dia_vencimento" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Valido Até</label>
                                            <input type="date" name="valido_ate" class="form-control">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botão Salvar -->
                            <div class="tile-footer">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<script>
$(document).ready(function() {
    // Máscaras de campos
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 0000-0000');
    $('#cnpj').mask('00.000.000/0000-00');

    // Detecta quando o CPF está completo e valida
    $('#cpf').on('input', function() {
        var cpf = $(this).val();
        if (cpf.length === 14) { // A máscara usa 14 caracteres (11 dígitos + pontos e traço)
            if (validarCPF(cpf)) {
                $('#cpfValidationMessage').hide(); // CPF válido
                $(this).removeClass('is-invalid').addClass('is-valid');
            } else {
                $('#cpfValidationMessage').show(); // CPF inválido
                $(this).removeClass('is-valid').addClass('is-invalid');
            }
        }
    });

    // Verifica o CPF ao submeter o formulário
    $('form').on('submit', function(event) {
        var cpf = $('#cpf').val();
        if (!validarCPF(cpf)) {
            event.preventDefault(); // Impede o envio do formulário
            $('#cpfValidationMessage').show(); // Exibe a mensagem de erro
            $('#cpf').removeClass('is-valid').addClass('is-invalid');
            alert('CPF inválido. Por favor, verifique o número informado.');
        }
    });
});

function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
            document.getElementById('uf').value = ("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('rua').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);
            } else {
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
                if (validacep.test(cep)) {
                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('rua').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('uf').value = "...";

                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);
                } else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        }
</script>
@endsection

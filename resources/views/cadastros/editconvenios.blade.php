@extends('layouts.app')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i>Editar Convênios</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Administração</li>
                <li class="breadcrumb-item">Editar</li>
                <li class="breadcrumb-item"><a href="#">Convênios</a></li>
            </ul>
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
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 col-md-4 d-flex justify-content-start align-items-end">
                    <a class="btn btn-primary me-2" href="{{ route('convenio.index1') }}">Lista de Convênios</a>
                </div>
                <div class="timeline-post">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs user-tabs">
                            <li class="nav-item"><a class="nav-link active" href="#dados" data-bs-toggle="tab">Dados</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#impostos" data-bs-toggle="tab">Imposto</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tile">
                        <form action="{{ route('convenio.update', $convenios->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="tab-content">
                                <div class="tab-pane active" id="dados">
                                    <h3 class="tile-title">Editar Convênio</h3>
                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Nome</label>
                                                <input class="form-control" id="nome" name="nome" type="text"
                                                    value="{{ old('nome', $convenios->nome ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Registro ANS</label>
                                                <input class="form-control" id="ans" name="ans" type="text"
                                                    value="{{ old('ans', $convenios->ans ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">CNPJ</label>
                                                <input class="form-control" id="cnpj" name="cnpj" type="text"
                                                    value="{{ old('cnpj', $convenios->cnpj ?? '') }}">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Cód. Operadora</label>
                                                <input class="form-control" id="operadora" name="operadora" type="text"
                                                    value="{{ old('operadora', $convenios->operadora ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Telefone</label>
                                                <input class="form-control" id="telefone" name="telefone" type="text"
                                                    value="{{ old('telefone', $convenios->telefone ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Celular</label>
                                                <input class="form-control" id="celular" name="celular" type="text"
                                                    value="{{ old('celular', $convenios->celular ?? '') }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">CEP</label>
                                                <input class="form-control" id="cep" name="cep" type="text"
                                                    value="{{ old('cep', $convenios->cep ?? '') }}"
                                                    onblur="pesquisacep(this.value);" required>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Bairro</label>
                                                <input class="form-control" id="bairro" name="bairro" type="text"
                                                    value="{{ old('bairro', $convenios->bairro ?? '') }}" required>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Cidade</label>
                                                <input class="form-control" id="cidade" name="cidade" type="text"
                                                    value="{{ old('cidade', $convenios->cidade ?? '') }}" required>
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Estado</label>
                                                <input class="form-control" id="uf" name="uf" type="text"
                                                    value="{{ old('uf', $convenios->uf ?? '') }}" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Rua</label>
                                                <input class="form-control" id="rua" name="rua" type="text"
                                                    value="{{ old('rua', $convenios->rua ?? '') }}" required>
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Número</label>
                                                <input class="form-control" id="numero" name="numero" type="text"
                                                    value="{{ old('numero', $convenios->numero ?? '') }}" required>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Complemento</label>
                                                <input class="form-control" id="complemento" name="complemento"
                                                    type="text"
                                                    value="{{ old('complemento', $convenios->complemento ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="impostos">
                                    <h3 class="tile-title">Convênio</h3>
                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">% Imp Médico</label>
                                                <input class="form-control" id="impmedico" name="impmedico"
                                                    type="text"
                                                    value="{{ old('impmedico', $convenios->impmedico ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">INSS</label>
                                                <input class="form-control" id="inss" name="inss" type="text"
                                                    value="{{ old('inss', $convenios->inss ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">ISS</label>
                                                <input class="form-control" id="iss" name="iss" type="text"
                                                    value="{{ old('iss', $convenios->iss ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">IR</label>
                                                <input class="form-control" id="ir" name="ir" type="text"
                                                    value="{{ old('ir', $convenios->ir ?? '') }}">
                                            </div>
                                        </div>

                                        <hr>
                                        <h4>Informação de Cobrança</h4>
                                        <div class="row">
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Valor Multa</label>
                                                <input class="form-control" id="multa" name="multa" type="text"
                                                    value="{{ old('multa', $convenios->multa ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">% Juros</label>
                                                <input class="form-control" id="juros" name="juros" type="text"
                                                    value="{{ old('juros', $convenios->juros ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">N° Dias Desc</label>
                                                <input class="form-control" id="dias_desc" name="dias_desc"
                                                    type="text"
                                                    value="{{ old('dias_desc', $convenios->dias_desc ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">% Desconto</label>
                                                <input class="form-control" id="desconto" name="desconto"
                                                    type="text"
                                                    value="{{ old('desconto', $convenios->desconto ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Agrupa Faturamento</label>
                                                <input class="form-control" id="agfaturamento" name="agfaturamento"
                                                    type="text"
                                                    value="{{ old('agfaturamento', $convenios->agfaturamento ?? '') }}">
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Forma de Pagamento</label>
                                                <input class="form-control" id="pagamento" name="pagamento"
                                                    type="text"
                                                    value="{{ old('pagamento', $convenios->pagamento ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="bi bi-check-circle-fill me-2"></i> Salva
                                        </button>
                                    </div>
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
        $(document).ready(function() {
            $('#cpf').mask('000.000.000-00');
            $('#telefone').mask('(00) 0000-0000');
            $('#celular').mask('(00) 00000-0000');
            $('#corem').mask('0000000-AA', {
                translation: {
                    'A': {
                        pattern: /[A-Za-z]/
                    },
                    '0': {
                        pattern: /\d/,
                        optional: true
                    }
                },
                onKeyPress: function(cep, event, currentField, options) {
                    var masks = ['000000-AA', '0000000-AA'];
                    var mask = (cep.length > 5) ? masks[1] : masks[0];
                    $('#corem').mask(mask, options);
                }
            });
            $('#crm').mask('000000-AA', {
                translation: {
                    'A': {
                        pattern: /[A-Za-z]/
                    }
                }
            });
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            var generoMasculino = document.getElementById('genero_m').checked;
            var generoFeminino = document.getElementById('genero_f').checked;

            if (!generoMasculino && !generoFeminino) {
                event.preventDefault();
                alert('Por favor, selecione um gênero.');
            }
        });


        function limpa_formulário_cep() {
            // Limpa valores do formulário de CEP
            document.getElementById('rua').value = "";
            document.getElementById('bairro').value = "";
            document.getElementById('cidade').value = "";
            document.getElementById('uf').value = "";
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                // Atualiza os campos com os valores retornados
                document.getElementById('rua').value = conteudo.logradouro;
                document.getElementById('bairro').value = conteudo.bairro;
                document.getElementById('cidade').value = conteudo.localidade;
                document.getElementById('uf').value = conteudo.uf;
            } else {
                // CEP não encontrado
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {
            // Nova variável "cep" somente com dígitos
            var cep = valor.replace(/\D/g, '');

            // Verifica se o campo CEP possui valor informado
            if (cep !== "") {
                // Expressão regular para validar o CEP
                var validacep = /^[0-9]{8}$/;

                // Valida o formato do CEP
                if (validacep.test(cep)) {
                    // Preenche os campos com "..." enquanto consulta o webservice
                    document.getElementById('rua').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('uf').value = "...";

                    // Cria um elemento JavaScript
                    var script = document.createElement('script');

                    // Sincroniza com o callback
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    // Insere script no documento e carrega o conteúdo
                    document.body.appendChild(script);
                } else {
                    // CEP é inválido
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                // CEP sem valor, limpa formulário
                limpa_formulário_cep();
            }
        }
    </script>
@endsection

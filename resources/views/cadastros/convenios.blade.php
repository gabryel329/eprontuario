@extends('layouts.app')
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-ui-checks"></i> Convênios</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Administração</li>
            <li class="breadcrumb-item">Cadastros</li>
            <li class="breadcrumb-item"><a href="#">Convênios</a></li>
        </ul>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {!! session('success') !!}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-warning">
            {!! session('error') !!}
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
                        <li class="nav-item"><a class="nav-link active" href="#dados" data-bs-toggle="tab">Dados</a></li>
                        <li class="nav-item"><a class="nav-link" href="#impostos" data-bs-toggle="tab">Imposto</a></li>
                        <li class="nav-item"><a class="nav-link" href="#tabelas" data-bs-toggle="tab">Tabelas</a></li>
                    </ul>
                </div>
                <div class="tile">
                    <form action="{{ route('convenio.store') }}" method="POST"
                        enctype="multipart/form-data">
                        <div class="tab-content">
                            <div class="tab-pane active" id="dados">
                                <h3 class="tile-title">Adicionar Convênio</h3>
                                <div class="tile-body">
                                    @csrf
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
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Cód. Operadora</label>
                                            <input class="form-control" id="operadora" name="operadora" type="text">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Telefone</label>
                                            <input class="form-control" id="telefone" name="telefone" type="text">
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Celular</label>
                                            <input class="form-control" id="celular" name="celular" type="text" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label class="form-label">CEP</label>
                                            <input class="form-control" id="cep" name="cep" type="text" onblur="pesquisacep2(this.value);" required>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Bairro</label>
                                            <input class="form-control" id="bairro" name="bairro" type="text" required>
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
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Rua</label>
                                            <input class="form-control" id="rua" name="rua" type="text" required>
                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label class="form-label">Numero</label>
                                            <input class="form-control" id="numero" name="numero" type="text" required>
                                        </div>
                                        <div class="mb-3 col-md-4">
                                            <label class="form-label">Complemento</label>
                                            <input class="form-control" id="complemento" name="complemento" type="text" required>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="tab-pane" id="impostos">
                                    <h3 class="tile-title">Imposto</h3>
                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">%Imp Médico </label>
                                                <input class="form-control" id="impmedico" name="impmedico"
                                                    placeholder="%" type="text">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">INSS</label>
                                                <input class="form-control" id="inss" name="inss" type="text">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">ISS</label>
                                                <input class="form-control" id="iss" name="iss"
                                                    type="text">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">IR</label>
                                                <input class="form-control" id="ir" name="ir"
                                                    type="text">
                                            </div>
                                        </div>
                                        <hr>
                                        <h4>Informação de cobrança</h4>
                                        <div class="tab-content">
                                            <div class="tile-body">
                                                <div class="row">
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Valor Multa</label>
                                                        <input class="form-control" id="multa" name="multa"
                                                            type="text">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">% Juros</label>
                                                        <input class="form-control" id="juros" name="juros"
                                                            type="text">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">N° Dias Desc</label>
                                                        <input class="form-control" id="dias_desc" name="dias_desc"
                                                            type="text">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">% Desconto</label>
                                                        <input class="form-control" id="desconto" name="desconto"
                                                            type="text">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Agrupa Faturamento</label>
                                                        <input class="form-control" id="agfaturamento" name="agfaturamento"
                                                            type="text">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Forma De Pagamento</label>
                                                        <input class="form-control" id="pagamento" name="pagamento"
                                                            type="text">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabelas">
                                    <h3 class="tile-title">Tabelas</h3>
                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Procedimentos</label>
                                                <input class="form-control" id="impmedico" name="impmedico"
                                                    placeholder="%" type="text">
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Medicamentos</label>
                                                <input class="form-control" id="inss" name="inss" type="text">
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Material</label>
                                                <input class="form-control" id="iss" name="iss"
                                                    type="text">
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Taxa</label>
                                                <input class="form-control" id="ir" name="ir"
                                                    type="text">
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Cotação</label>
                                                <input class="form-control" id="ir" name="ir"
                                                    type="text">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="bi bi-check-circle-fill me-2"></i>Salva
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

@extends('layouts.app')
@section('content')
<main class="app-content">
    <div class="row user">
        <div class="col-md-12">
            <div class="profile">
                <div class="info">
                    @php
                        $empresa = \App\Models\Empresas::first();
                    @endphp
                    @if($empresa)
                        <img class="app-sidebar__user-avatar" src="{{ asset('images/' . $empresa->imagem) }}" alt="User Image" class="user-image">
                    @else
                        <img class="app-sidebar__user-avatar" src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
                    @endif
                </div>
                <div class="cover-image"></div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="tile p-0">
                <ul class="nav flex-column nav-tabs user-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-bs-toggle="tab">Dados da empresa</a></li>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div class="tab-content">
                <div class="tab-pane active" id="user-timeline">
                    <div class="tile user-timeline">
                        <h4 class="line">Dados</h4>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
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
                        @if ($empresa)
                            <form method="POST" action="{{ route('empresa.update', $empresa->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Razão Social</label>
                                        <input class="form-control" type="text" id="name" name="name" value="{{ $empresa->name }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Nome Fantasia</label>
                                        <input class="form-control" type="text" id="fantasia" name="fantasia" value="{{ $empresa->fantasia }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">CNPJ</label>
                                        <input class="form-control" type="text" id="cnpj" name="cnpj" value="{{ $empresa->cnpj }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Email</label>
                                        <input class="form-control" type="text" id="email" name="email" value="{{ $empresa->email }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Telefone</label>
                                        <input class="form-control" type="text" id="telefone" name="telefone" value="{{ $empresa->telefone }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Celular</label>
                                        <input class="form-control" type="text" id="celular" name="celular" value="{{ $empresa->celular }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Médico Responsável</label>
                                        <input class="form-control" type="text" id="medico" name="medico" value="{{ $empresa->medico }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">CRM</label>
                                        <input class="form-control" type="text" id="crm" name="crm" value="{{ $empresa->crm }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Licença</label>
                                        <input class="form-control" id="licenca" name="licenca" type="date" value="{{ $empresa->licenca }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Contrato</label>
                                        <select class="form-control" id="contrato" name="contrato">
                                            <option disabled selected style="font-size:18px;color: black;">{{ $empresa->contrato }}</option>       
                                            <option value="Bronze">Bronze</option>
                                            <option value="Prata">Prata</option>
                                            <option value="Ouro">Ouro</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label class="form-label">CNES</label>
                                        <input class="form-control" id="cnes" name="cnes" type="text" value="{{ $empresa->cnes }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">CEP</label>
                                        <input class="form-control" type="text" id="cep" name="cep" onblur="pesquisacep(this.value)" value="{{ $empresa->cep }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Rua</label>
                                        <input class="form-control" type="text" id="rua" name="rua" value="{{ $empresa->rua }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Bairro</label>
                                        <input class="form-control" type="text" id="bairro" name="bairro" value="{{ $empresa->bairro }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">UF</label>
                                        <input class="form-control" type="text" id="uf" name="uf" value="{{ $empresa->uf }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Cidade</label>
                                        <input class="form-control" type="text" id="cidade" name="cidade" value="{{ $empresa->cidade }}">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Complemento</label>
                                        <input class="form-control" type="text" id="complemento" name="complemento" value="{{ $empresa->complemento }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Nº</label>
                                        <input class="form-control" type="text" id="numero" name="numero" value="{{ $empresa->numero }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label class="form-label">Cód. Municipio</label>
                                        <input class="form-control" type="text" id="codigo_municipio" name="codigo_municipio" value="{{ $empresa->codigo_municipio }}">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="form-label">Inscrição Estadual</label>
                                        <input class="form-control" type="text" id="insc_est" name="insc_est" value="{{ $empresa->insc_est }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Cód. UF</label>
                                        <input class="form-control" type="text" id="codigo_uf" name="codigo_uf" value="{{ $empresa->codigo_uf }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label" class="form-label">Logo</label>
                                        <input class="form-control" type="file" name="imagem">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-3">
                                        <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i> Editar</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <p>Empresa não encontrada!</p>
                        @endif
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

function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
            document.getElementById('uf').value = ("");
            document.getElementById('codigo_municipio').value=("");
            document.getElementById('codigo_uf').value = "";
        }

        function getCodigoUF(uf) {
            const codigosUF = {
                "AC": 12, "AL": 27, "AP": 16, "AM": 13, "BA": 29, "CE": 23, "DF": 53, "ES": 32, "GO": 52,
                "MA": 21, "MT": 51, "MS": 50, "MG": 31, "PA": 15, "PB": 25, "PR": 41, "PE": 26, "PI": 22,
                "RJ": 33, "RN": 24, "RS": 43, "RO": 11, "RR": 14, "SC": 42, "SP": 35, "SE": 28, "TO": 17
            };
            return codigosUF[uf] || "";
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('rua').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);
                document.getElementById('codigo_municipio').value=(conteudo.ibge);
                document.getElementById('codigo_uf').value = getCodigoUF(conteudo.uf);
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
                    document.getElementById('codigo_municipio').value="...";
                    document.getElementById('codigo_uf').value = "...";

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

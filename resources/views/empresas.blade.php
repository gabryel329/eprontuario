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
                        @if ($empresa)
                            <form method="POST" action="{{ route('empresa.update', $empresa->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Razão Social</label>
                                        <input class="form-control" type="text" id="name" name="name" value="{{ $empresa->name }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Nome Fantasia</label>
                                        <input class="form-control" type="text" id="fantasia" name="fantasia" value="{{ $empresa->fantasia }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>CNPJ</label>
                                        <input class="form-control" type="text" id="cnpj" name="cnpj" value="{{ $empresa->cnpj }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Email</label>
                                        <input class="form-control" type="text" id="email" name="email" value="{{ $empresa->email }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Telefone</label>
                                        <input class="form-control" type="text" id="telefone" name="telefone" value="{{ $empresa->telefone }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Celular</label>
                                        <input class="form-control" type="text" id="celular" name="celular" value="{{ $empresa->celular }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9">
                                        <label>Médico Responsável</label>
                                        <input class="form-control" type="text" id="medico" name="medico" value="{{ $empresa->medico }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>CRM</label>
                                        <input class="form-control" type="text" id="crm" name="crm" value="{{ $empresa->crm }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>CEP</label>
                                        <input class="form-control" type="text" id="cep" name="cep" value="{{ $empresa->cep }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Rua</label>
                                        <input class="form-control" type="text" id="rua" name="rua" value="{{ $empresa->rua }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Bairro</label>
                                        <input class="form-control" type="text" id="bairro" name="bairro" value="{{ $empresa->bairro }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label>UF</label>
                                        <input class="form-control" type="text" id="uf" name="uf" value="{{ $empresa->uf }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Cidade</label>
                                        <input class="form-control" type="text" id="cidade" name="cidade" value="{{ $empresa->cidade }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Complemento</label>
                                        <input class="form-control" type="text" id="complemento" name="complemento" value="{{ $empresa->complemento }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>Nº</label>
                                        <input class="form-control" type="text" id="numero" name="numero" value="{{ $empresa->numero }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Logo</label>
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
</script>
@endsection

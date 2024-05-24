@extends('layouts.app')
@section('content')
<main class="app-content">
    <div class="row user">
        <div class="col-md-12">
            <div class="profile">
                <div class="info"><img class="user-img" src="images/CamaraoEmpanado.jpg">
                    <h4>{{ Auth::user()->name }}</h4>
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
                            <form method="POST" action="{{ route('empresa.update', $empresa->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label>Nome da Empresa</label>
                                        <input class="form-control" type="text" id="name" name="name" value="{{ $empresa->name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>CNPJ</label>
                                        <input class="form-control" type="text" id="cnpj" name="cnpj" value="{{ $empresa->cnpj }}">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label>Email</label>
                                        <input class="form-control" type="text" id="email" name="email" value="{{ $empresa->email }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Telefone</label>
                                        <input class="form-control" type="text" id="telefone" name="telefone" value="{{ $empresa->telefone }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Médico Responsável</label>
                                        <input class="form-control" type="text" id="medico" name="medico" value="{{ $empresa->medico }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>CRM</label>
                                        <input class="form-control" type="text" id="crm" name="crm" value="{{ $empresa->crm }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label>CPF</label>
                                        <input class="form-control" type="text" id="cpf" name="cpf" value="{{ $empresa->cpf }}">
                                    </div>
                                </div>
                                <div class="row mb-10">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i> Edit</button>
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
@endsection
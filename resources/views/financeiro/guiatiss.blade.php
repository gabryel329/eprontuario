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
        {!! session('error') !!}
      </div>
    @endif
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-title">
            <label class="form-label">Selecione o Convenio</label>

            </div>
          </div>
          <div class="tile">
            <h3 class="tile-title">Guia - Tiss</h3>
            <div class="tile-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Registro ANS:</label>
                        <input class="form-control" id="registro_ans" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Número da Guia do Prestador:</label>
                        <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador" type="text" value="{{ old('numero_guia_prestador') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Número da Carteira:</label>
                        <input class="form-control" id="numero_carteira" name="numero_carteira" type="text" value="{{ old('numero_carteira') }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Nome do Beneficiário:</label>
                        <input class="form-control" id="nome_beneficiario" name="nome_beneficiario" type="text" value="{{ old('nome_beneficiario') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-3">
                        <label class="form-label">Data do Atendimento:</label>
                        <input class="form-control" id="data_atendimento" name="data_atendimento" type="date" value="{{ old('data_atendimento') }}">
                    </div>
                    <div class="mb-3 col-md-3">
                        <label class="form-label">Hora de Início do Atendimento:</label>
                        <input class="form-control" id="hora_inicio_atendimento" name="hora_inicio_atendimento" type="time" value="{{ old('hora_inicio_atendimento') }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Tipo de Consulta:</label>
                        <input class="form-control" id="tipo_consulta" name="tipo_consulta" type="text" value="{{ old('tipo_consulta') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Indicação de Acidente:</label>
                        <input class="form-control" id="indicacao_acidente" name="indicacao_acidente" type="text" value="{{ old('indicacao_acidente') }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Código da Tabela:</label>
                        <input class="form-control" id="codigo_tabela" name="codigo_tabela" type="text" value="{{ old('codigo_tabela') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Código do Procedimento:</label>
                        <input class="form-control" id="codigo_procedimento" name="codigo_procedimento" type="text" value="{{ old('codigo_procedimento') }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Valor do Procedimento:</label>
                        <input class="form-control" id="valor_procedimento" name="valor_procedimento" type="text" value="{{ old('valor_procedimento') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Nome do Profissional:</label>
                        <input class="form-control" id="nome_profissional" name="nome_profissional" type="text" value="{{ old('nome_profissional') }}">
                    </div>
                    <div class="mb-3 col-md-2">
                        <label class="form-label">Sigla do Conselho:</label>
                        <input class="form-control" id="sigla_conselho" name="sigla_conselho" type="text" value="{{ old('sigla_conselho') }}">
                    </div>
                    <div class="mb-3 col-md-2">
                        <label class="form-label">Número do Conselho:</label>
                        <input class="form-control" id="numero_conselho" name="numero_conselho" type="text" value="{{ old('numero_conselho') }}">
                    </div>
                    <div class="mb-3 col-md-2">
                        <label class="form-label">UF do Conselho:</label>
                        <input class="form-control" id="uf_conselho" name="uf_conselho" type="text" value="{{ old('uf_conselho') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Código CBO:</label>
                        <input class="form-control" id="cbo" name="cbo" type="text" value="{{ old('cbo') }}">
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Observação:</label>
                        <textarea class="form-control" id="observacao" name="observacao">{{ old('observacao') }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label class="form-label">Hash:</label>
                        <input class="form-control" id="hash" name="hash" type="text" value="{{ old('hash') }}">
                    </div>
                    <div class="mb-3 col-md-4 align-self-end">
                        <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Salvar</button>
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
@endsection
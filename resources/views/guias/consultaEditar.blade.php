@extends('layouts.app')

@section('content')
<main class="app-content">
    <div class="app-title">
        <h1><i class="bi bi-pencil"></i> Editar Guia de Consulta</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('guias-consulta.update', $guiaConsulta->id) }}">
                @csrf
                @method('PUT')

                <!-- Seção Guia de Consulta -->
                <h5 class="mb-3">Guia de Consulta</h5>
                <div class="row">
                    <div class="col-md-4">
                        <label for="registro_ans" class="form-label">Registro ANS</label>
                        <input type="text" name="registro_ans" id="registro_ans" class="form-control"
                            value="{{ old('registro_ans', $guiaConsulta->registro_ans) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="numero_guia_operadora" class="form-label">Nº Guia Atribuído pela Operadora</label>
                        <input type="text" name="numero_guia_operadora" id="numero_guia_operadora" class="form-control"
                            value="{{ old('numero_guia_operadora', $guiaConsulta->numero_guia_operadora) }}" required>
                    </div>
                </div>

                <hr>

                <!-- Seção Dados do Beneficiário -->
                <h5 class="mb-3">Dados do Beneficiário</h5>
                <div class="row">
                    <div class="col-md-4">
                        <label for="numero_carteira" class="form-label">Número da Carteira</label>
                        <input type="text" name="numero_carteira" id="numero_carteira" class="form-control"
                            value="{{ old('numero_carteira', $guiaConsulta->numero_carteira) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="validade_carteira" class="form-label">Validade da Carteira</label>
                        <input type="date" name="validade_carteira" id="validade_carteira" class="form-control"
                            value="{{ old('validade_carteira', $guiaConsulta->validade_carteira) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="atendimento_rn" class="form-label">Atendimento RN</label>
                        <select name="atendimento_rn" id="atendimento_rn" class="form-select">
                            <option value="S" {{ old('atendimento_rn', $guiaConsulta->atendimento_rn) == 'S' ? 'selected' : '' }}>Sim</option>
                            <option value="N" {{ old('atendimento_rn', $guiaConsulta->atendimento_rn) == 'N' ? 'selected' : '' }}>Não</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="nome_social" class="form-label">Nome Social</label>
                        <input type="text" name="nome_social" id="nome_social" class="form-control"
                            value="{{ old('nome_social', $guiaConsulta->nome_social) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="nome_beneficiario" class="form-label">Nome do Beneficiário</label>
                        <input type="text" name="nome_beneficiario" id="nome_beneficiario" class="form-control"
                            value="{{ old('nome_beneficiario', $guiaConsulta->nome_beneficiario) }}" required>
                    </div>
                </div>

                <hr>

                <!-- Seção Dados do Contratado -->
                <h5 class="mb-3">Dados do Contratado</h5>
                <div class="row">
                    <div class="col-md-4">
                        <label for="codigo_operadora" class="form-label">Código na Operadora</label>
                        <input type="text" name="codigo_operadora" id="codigo_operadora" class="form-control"
                            value="{{ old('codigo_operadora', $guiaConsulta->codigo_operadora) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="nome_contratado" class="form-label">Nome do Contratado</label>
                        <input type="text" name="nome_contratado" id="nome_contratado" class="form-control"
                            value="{{ old('nome_contratado', $guiaConsulta->nome_contratado) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="cnes" class="form-label">Código CNES</label>
                        <input type="text" name="cnes" id="cnes" class="form-control"
                            value="{{ old('cnes', $guiaConsulta->codigo_cnes) }}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="nome_profissional_executante" class="form-label">Nome do Profissional Executante</label>
                        <input type="text" name="nome_profissional_executante" id="nome_profissional_executante" class="form-control"
                            value="{{ old('nome_profissional_executante', $guiaConsulta->nome_profissional_executante) }}">
                    </div>
                    <div class="col-md-2">
                        <label for="conselho_profissional" class="form-label">Conselho</label>
                        <select name="conselho_profissional" id="conselho_profissional" class="form-select">
                            <option selected disabled>Selecione</option>
                            @foreach ($conselhos as $conselho => $codigo)
                                <option value="{{ $codigo }}"
                                    {{ old('conselho_profissional', $guiaConsulta->conselho_profissional) == $codigo ? 'selected' : '' }}>
                                    {{ $conselho }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="conselho_1" class="form-label">Nº Conselho</label>
                        <input type="text" name="conselho_1" id="conselho_1" class="form-control"
                            value="{{ old('conselho_1', $guiaConsulta->numero_conselho) }}">
                    </div>
                    <div class="col-md-2">
                        <label for="uf_conselho" class="form-label">UF Conselho</label>
                        <select name="uf_conselho" id="uf_conselho" class="form-select">
                            <option selected disabled>Selecione</option>
                            @foreach ($ufs as $uf => $codigo)
                                <option value="{{ $codigo }}"
                                    {{ old('uf_conselho', $guiaConsulta->uf_conselho) == $codigo ? 'selected' : '' }}>
                                    {{ $uf }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <hr>

                <!-- Seção Dados do Atendimento / Procedimento Realizado -->
                <h5 class="mb-3">Dados do Atendimento / Procedimento Realizado</h5>
                <div class="row">
                    <div class="col-md-4">
                        <label for="indicacao_acidente" class="form-label">Indicação de Acidente</label>
                        <select name="indicacao_acidente" id="indicacao_acidente" class="form-select">
                            <option value="1" {{ old('indicacao_acidente', $guiaConsulta->indicacao_acidente) == '1' ? 'selected' : '' }}>Sim</option>
                            <option value="2" {{ old('indicacao_acidente', $guiaConsulta->indicacao_acidente) == '2' ? 'selected' : '' }}>Não</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="data_atendimento" class="form-label">Data do Atendimento</label>
                        <input type="date" name="data_atendimento" id="data_atendimento" class="form-control"
                            value="{{ old('data_atendimento', $guiaConsulta->data_atendimento) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="tipo_consulta" class="form-label">Tipo de Consulta</label>
                        <input type="text" name="tipo_consulta" id="tipo_consulta" class="form-control"
                            value="{{ old('tipo_consulta', $guiaConsulta->tipo_consulta) }}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label for="codigo_procedimento" class="form-label">Código do Procedimento</label>
                        <input type="text" name="codigo_procedimento" id="codigo_procedimento" class="form-control"
                            value="{{ old('codigo_procedimento', $guiaConsulta->codigo_procedimento) }}">
                    </div>
                    <div class="col-md-6">
                        <label for="valor_procedimento" class="form-label">Valor do Procedimento</label>
                        <input type="number" step="0.01" name="valor_procedimento" id="valor_procedimento" class="form-control"
                            value="{{ old('valor_procedimento', $guiaConsulta->valor_procedimento) }}" required>
                    </div>
                </div>

                <hr>

                <!-- Observações -->
                <div class="mb-3">
                    <label for="observacao" class="form-label">Observações</label>
                    <textarea name="observacao" id="observacao" class="form-control" rows="4">{{ old('observacao', $guiaConsulta->observacao) }}</textarea>
                </div>

                <!-- Botões de Ação -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-2"></i>Salvar Alterações</button>
                    <a href="{{ route('faturamentoGlosa.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-2"></i>Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

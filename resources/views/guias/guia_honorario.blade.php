@extends('layouts.app')

@section('content')
<main class="app-content">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-warning">
            {!! session('error') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Cadastrar Guia Honorário</h3>
                <div class="tile-body">
                    <form action="{{ route('guia_honorario.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Registro ANS:</label>
                                <input class="form-control" name="registro_ans" type="text" value="{{ old('registro_ans') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Nº Guia de solicitação de internação:</label>
                                <input class="form-control" name="num_guia_solicitacao_internacao" type="text" value="{{ old('num_guia_solicitacao_internacao') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Senha:</label>
                                <input class="form-control" name="senha" type="text" value="{{ old('senha') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Número da Guia Atribuído pela Operadora:</label>
                                <input class="form-control" name="num_guia_atribuido_operadora" type="text" value="{{ old('num_guia_atribuido_operadora') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Número da Carteira:</label>
                                <input class="form-control" name="numero_carteira" type="text" value="{{ old('numero_carteira') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Nome Social:</label>
                                <input class="form-control" name="nome_social" type="text" value="{{ old('nome_social') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Atendimento a RN:</label>
                                <input class="form-control" name="atendimento_rn" type="text" value="1">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Nome:</label>
                                <input class="form-control" name="nome" type="text" value="{{ old('nome') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Código na Operadora:</label>
                                <input class="form-control" name="codigo_operadora" type="text" value="{{ old('codigo_operadora') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Nome do Hospital/Local:</label>
                                <input class="form-control" name="nome_hospital" type="text" value="{{ old('nome_hospital') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Código na Operadora (Contratado):</label>
                                <input class="form-control" name="codigo_operadora_contratado" type="text" value="{{ old('codigo_operadora_contratado') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Nome do Contratado:</label>
                                <input class="form-control" name="nome_contratado" type="text" value="{{ old('nome_contratado') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Código CNES:</label>
                                <input class="form-control" name="codigo_cnes" type="text" value="{{ old('codigo_cnes') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Data do início do faturamento:</label>
                                <input class="form-control" name="data_inicio_faturamento" type="date" value="{{ old('data_inicio_faturamento') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Data do fim do faturamento:</label>
                                <input class="form-control" name="data_fim_faturamento" type="date" value="{{ old('data_fim_faturamento') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Data:</label>
                                <input class="form-control" name="data" type="date" value="{{ old('data') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Hora Inicial:</label>
                                <input class="form-control" name="hora_inicial" type="time" value="{{ old('hora_inicial') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Hora Final:</label>
                                <input class="form-control" name="hora_final" type="time" value="{{ old('hora_final') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Tabela:</label>
                                <input class="form-control" name="tabela" type="text" value="{{ old('tabela') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Código do Procedimento:</label>
                                <input class="form-control" name="codigo_procedimento" type="text" value="{{ old('codigo_procedimento') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Descrição:</label>
                                <input class="form-control" name="descricao" type="text" value="{{ old('descricao') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Quantidade:</label>
                                <input class="form-control" name="quantidade" type="number" value="{{ old('quantidade') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Via:</label>
                                <input class="form-control" name="via" type="text" value="{{ old('via') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Técnica:</label>
                                <input class="form-control" name="tecnica" type="text" value="{{ old('tecnica') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Fator Redução:</label>
                                <input class="form-control" name="fator_reducao" type="number" step="0.01" value="{{ old('fator_reducao') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Valor Unitário (R$):</label>
                                <input class="form-control" name="valor_unitario" type="number" step="0.01" value="{{ old('valor_unitario') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Valor Total (R$):</label>
                                <input class="form-control" name="valor_total" type="number" step="0.01" value="{{ old('valor_total') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Seq. Ref:</label>
                                <input class="form-control" name="seq_ref" type="text" value="{{ old('seq_ref') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Grau Part:</label>
                                <input class="form-control" name="grau_part" type="text" value="{{ old('grau_part') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Código na Operadora (Profissional):</label>
                                <input class="form-control" name="codigo_operadora_profissional" type="text" value="{{ old('codigo_operadora_profissional') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">CPF Profissional:</label>
                                <input class="form-control" name="cpf_profissional" type="text" value="{{ old('cpf_profissional') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Nome do Profissional:</label>
                                <input class="form-control" name="nome_profissional" type="text" value="{{ old('nome_profissional') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Conselho:</label>
                                <input class="form-control" name="conselho" type="text" value="{{ old('conselho') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Número do Conselho:</label>
                                <input class="form-control" name="numero_conselho" type="text" value="{{ old('numero_conselho') }}">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">UF Conselho:</label>
                                <input class="form-control" name="uf_conselho" type="text" value="{{ old('uf_conselho') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Código CBO:</label>
                                <input class="form-control" name="codigo_cbo" type="text" value="{{ old('codigo_cbo') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Valor Total dos Honorários (R$):</label>
                                <input class="form-control" name="valor_total_honorarios" type="number" step="0.01" value="{{ old('valor_total_honorarios') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Data de Emissão:</label>
                                <input class="form-control" name="data_emissao" type="date" value="{{ old('data_emissao') }}">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Assinatura do Profissional Executante:</label>
                                <input class="form-control" name="assinatura_profissional" type="text" value="{{ old('assinatura_profissional') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-4 align-self-end">
                                <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Cadastrar</button>
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

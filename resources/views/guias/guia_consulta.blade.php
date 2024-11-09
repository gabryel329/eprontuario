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
                    <div class="tile-title">
                        <label class="form-label">Selecione o Convênio</label>
                        <select name="convenio_id" id="convenio_id" class="form-select" required>
                            <option value="">Escolha o Convênio</option>
                            @foreach ($convenios as $convenio)
                                <option value="{{ $convenio->id }}">
                                    {{ $convenio->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-title d-flex justify-content-between align-items-center">
                        <label class="form-label">Lista de Guias</label>
                        <!-- Botão para gerar guias em massa -->
                        <button type="button" class="btn btn-success" id="btnGerarGuias" disabled>
                            <i class="bi bi-file-earmark-zip"></i> Gerar Guias Selecionadas
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll" /></th>
                                    <th>Registro ANS</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="listaGuias">
                                <!-- Guias serão listadas aqui via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal para visualização de guias -->
    <div class="modal fade" id="visualizarGuiaModal" tabindex="-1" aria-labelledby="visualizarGuiaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visualizarGuiaModalLabel">Detalhes da Guia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formVisualizarGuia">
                        @csrf
                        <input class="form-control" id="convenio_id" name="convenio_id" type="hidden">
                        <input class="form-control" id="paciente_id" name="paciente_id" type="hidden">
                        <input class="form-control" id="profissional_id" name="profissional_id" type="hidden">
                        <input class="form-control" id="agenda_id" name="agenda_id" type="hidden">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="registro_ans" class="form-label">Registro ANS</label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" readonly>
                            </div>
                            <div class="col-md-5">
                                <label for="numero_guia_operadora" class="form-label">Nº Guia Atribuído pela
                                    Operadora</label>
                                <input class="form-control" id="numero_guia_operadora" name="numero_guia_operadora"
                                    type="text" readonly>
                            </div>
                        </div>
                        <hr>
                        <h5>Dados do Beneficiário</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="numero_carteira" class="form-label">Número da Carteira</label>
                                <input class="form-control" id="numero_carteira" name="numero_carteira" type="text"
                                    readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="validade_carteira" class="form-label">Validade da Carteira</label>
                                <input class="form-control" id="validade_carteira" name="validade_carteira" type="date"
                                    readonly>
                            </div>
                            <div class="col-md-4">
                                <label for="atendimento_rn" class="form-label">Atendimento RN</label>
                                <select class="form-select" id="atendimento_rn" name="atendimento_rn" readonly>
                                    <option selected disabled>Escolha</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nome_social" class="form-label">Nome Social</label>
                                <input class="form-control" id="nome_social" name="nome_social" type="text" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="nome_beneficiario" class="form-label">Nome do Beneficiário</label readonly>
                                <input class="form-control" id="nome_beneficiario" name="nome_beneficiario"
                                    type="text">
                            </div>
                        </div>
                        <hr>
                        <h5>Dados do Contratado</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="codigo_operadora" class="form-label">Código na Operadora</label readonly>
                                <input class="form-control" id="codigo_operadora" name="codigo_operadora"
                                    type="text">
                            </div>
                            <div class="col-md-6">
                                <label for="nome_contratado" class="form-label">Nome do Contratado</label>
                                <input class="form-control" id="nome_contratado" name="nome_contratado" type="text"
                                    readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="codigo_cnes" class="form-label">Código CNES</label>
                                <input class="form-control" id="codigo_cnes" name="codigo_cnes" type="text" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nome_profissional_executante" class="form-label">Nome do Profissional
                                    Executante</label>
                                <input class="form-control" id="nome_profissional_executante"
                                    name="nome_profissional_executante" type="text" readonly>
                            </div>
                            <div class="col-md-1">
                                <label for="conselho_profissional" class="form-label">Conselho</label>
                                <input class="form-control" id="conselho_profissional" name="conselho_profissional"
                                    type="text" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="numero_conselho" class="form-label">Nº Conselho</label>
                                <input class="form-control" id="numero_conselho" name="numero_conselho" type="text"
                                    readonly>
                            </div>
                            <div class="col-md-1">
                                <label for="uf_conselho" class="form-label">UF</label>
                                <input class="form-control" id="uf_conselho" name="uf_conselho" type="text" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="codigo_cbo" class="form-label">Código CBO</label>
                                <input class="form-control" id="codigo_cbo" name="codigo_cbo" type="text" readonly>
                            </div>
                        </div>
                        <hr>
                        <h5>Dados do Atendimento / Procedimento Realizado</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <label for="indicacao_acidente" class="form-label">Indicação de Acidente</label>
                                <select class="form-select" id="indicacao_acidente" name="indicacao_acidente" readonly>
                                    <option selected disabled>Escolha</option>
                                    <option value="1">Sim</option>
                                    <option value="2">Não</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="indicacao_cobertura_especial" class="form-label">Indicação de Cobertura
                                    Especial</label>
                                <select class="form-select" id="indicacao_cobertura_especial"
                                    name="indicacao_cobertura_especial" readonly>
                                    <option selected disabled>Escolha</option>
                                    <option value="1">Sim</option>
                                    <option value="2">Não</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="regime_atendimento" class="form-label">Regime de Atendimento</label>
                                <select class="form-select" id="regime_atendimento" name="regime_atendimento" readonly>
                                    <option selected disabled>Escolha</option>
                                    <option value="1">Ambulatórial</option>
                                    <option value="2">Emergência</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="saude_ocupacional" class="form-label">Saúde Ocupacional</label>
                                <select class="form-select" id="saude_ocupacional" name="saude_ocupacional" readonly>
                                    <option selected disabled>Escolha</option>
                                    <option value="1">Sim</option>
                                    <option value="2">Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <label for="data_atendimento" class="form-label">Data do Atendimento</label>
                                <input class="form-control" id="data_atendimento" name="data_atendimento" type="date"
                                    readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="tipo_consulta" class="form-label">Tipo de Consulta</label>
                                <select class="form-select" id="tipo_consulta" name="tipo_consulta" readonly>
                                    <option selected disabled>Escolha</option>
                                    <option value="1">Consulta de rotina</option>
                                    <option value="2">Consulta de urgência</option>
                                    <option value="3">Consulta de especialidade</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="codigo_tabela" class="form-label">Código da Tabela</label>
                                <input class="form-control" id="codigo_tabela" name="codigo_tabela" type="text"
                                    readonly>
                            </div>
                            <div class="col-md-3">
                                <label for="codigo_procedimento" class="form-label">Código do Procedimento</label>
                                <input class="form-control" id="codigo_procedimento" name="codigo_procedimento"
                                    type="text" readonly>
                            </div>
                            <div class="col-md-2">
                                <label for="valor_procedimento" class="form-label">Valor do Procedimento</label>
                                <input class="form-control" id="valor_procedimento" name="valor_procedimento"
                                    type="text" readonly>
                            </div>
                        </div>
                        <hr>
                        <h5>Observações</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="form-control" id="observacao" name="observacao" readonly></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Hash</label>
                                <input class="form-control" id="hash" name="hash" type="text" readonly>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para criar nova guia -->
    <!-- Modal para criar nova guia -->
    <div class="modal fade" id="novoGuiaModal" tabindex="-1" aria-labelledby="novoGuiaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guiaconsulta.store') }}" method="POST" enctype="multipart/form-data"
                        id="formNovaGuia">
                        @csrf
                        <input type="hidden" id="convenio_id_hidden" name="convenio_id">

                        <h5><strong>Guia de Consulta</strong></h5>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="registro_ans" class="form-label"><strong>Registro ANS</strong></label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="numero_guia_operadora" class="form-label"><strong>Nº Guia Atribuído pela
                                        Operadora</strong></label>
                                <input class="form-control" id="numero_guia_operadora" name="numero_guia_operadora"
                                    type="text">
                            </div>
                        </div>

                        <!-- Dados do Beneficiário -->
                        <h5><strong>Dados do Beneficiário</strong></h5>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="numero_carteira" class="form-label"><strong>Número da
                                        Carteira</strong></label>
                                <input class="form-control" id="numero_carteira" name="numero_carteira" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="validade_carteira" class="form-label"><strong>Validade da
                                        Carteira</strong></label>
                                <input class="form-control" id="validade_carteira" name="validade_carteira"
                                    type="date">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="atendimento_rn" class="form-label"><strong>Atendimento RN</strong></label>
                                <select class="form-select" id="atendimento_rn" name="atendimento_rn" readonly>
                                    <option selected disabled>Escolha</option>
                                    <option value="S">Sim</option>
                                    <option value="N">Não</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome_social" class="form-label"><strong>Nome Social</strong></label>
                                <input class="form-control" id="nome_social" name="nome_social" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome_beneficiario" class="form-label"><strong>Nome do
                                        Beneficiário</strong></label>
                                <input class="form-control" id="nome_beneficiario" name="nome_beneficiario"
                                    type="text">
                            </div>
                        </div>

                        <!-- Dados do Contratado -->
                        <h5><strong>Dados do Contratado</strong></h5>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="codigo_operadora" class="form-label"><strong>Código na
                                        Operadora</strong></label>
                                <input class="form-control" id="codigo_operadora" name="codigo_operadora"
                                    type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="nome_contratado" class="form-label"><strong>Nome do
                                        Contratado</strong></label>
                                <input class="form-control" id="nome_contratado" name="nome_contratado" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="codigo_cnes" class="form-label"><strong>Código CNES</strong></label>
                                <input class="form-control" id="codigo_cnes" name="codigo_cnes" type="text">
                            </div>
                        </div>

                        <!-- Dados do Profissional Executante -->
                        <h5><strong>Dados do Profissional Executante</strong></h5>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="nome_profissional_executante" class="form-label"><strong>Nome do Profissional
                                        Executante</strong></label>
                                <input class="form-control" id="nome_profissional_executante"
                                    name="nome_profissional_executante" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="conselho_profissional" class="form-label"><strong>Conselho
                                        Profissional</strong></label>
                                <input class="form-control" id="conselho_profissional" name="conselho_profissional"
                                    type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="numero_conselho" class="form-label"><strong>Número no
                                        Conselho</strong></label>
                                <input class="form-control" id="numero_conselho" name="numero_conselho" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="uf_conselho" class="form-label"><strong>UF do Conselho</strong></label>
                                <input class="form-control" id="uf_conselho" name="uf_conselho" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="codigo_cbo" class="form-label"><strong>Código CBO</strong></label>
                                <input class="form-control" id="codigo_cbo" name="codigo_cbo" type="text">
                            </div>
                        </div>

                        <!-- Dados do Atendimento / Procedimento Realizado -->
                        <h5><strong>Dados do Atendimento / Procedimento Realizado</strong></h5>
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="indicacao_acidente" class="form-label"><strong>Indicação de
                                        Acidente</strong></label>
                                <select class="form-select" id="indicacao_acidente" name="indicacao_acidente" readonly>
                                    <option selected disabled>Escolha</option>
                                    <option value="1">Sim</option>
                                    <option value="2">Não</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="indicacao_cobertura_especial" class="form-label"><strong>Indicação de
                                        Cobertura Especial</strong></label>
                                <select class="form-select" id="indicacao_cobertura_especial"
                                    name="indicacao_cobertura_especial" readonly>
                                    <option selected disabled>Escolha</option>
                                    <option value="1">Sim</option>
                                    <option value="2">Não</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="regime_atendimento" class="form-label"><strong>Regime de
                                        Atendimento</strong></label>
                                <input class="form-control" id="regime_atendimento" name="regime_atendimento"
                                    type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="saude_ocupacional" class="form-label"><strong>Saúde
                                        Ocupacional</strong></label>
                                <select class="form-select" id="saude_ocupacional" name="saude_ocupacional" readonly>
                                    <option selected disabled>Escolha</option>
                                    <option value="1">Sim</option>
                                    <option value="2">Não</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="data_atendimento" class="form-label"><strong>Data do
                                        Atendimento</strong></label>
                                <input class="form-control" id="data_atendimento" name="data_atendimento"
                                    type="date">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="tipo_consulta" class="form-label"><strong>Tipo de Consulta</strong></label>
                                <select class="form-select" id="tipo_consulta" name="tipo_consulta" readonly>
                                    <option selected disabled>Escolha</option>
                                    <option value="1">Consulta de rotina</option>
                                    <option value="2">Consulta de urgência</option>
                                    <option value="3">Consulta de especialidade</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="codigo_tabela" class="form-label"><strong>Código da Tabela</strong></label>
                                <input class="form-control" id="codigo_tabela" name="codigo_tabela" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="codigo_procedimento" class="form-label"><strong>Código do
                                        Procedimento</strong></label>
                                <input class="form-control" id="codigo_procedimento" name="codigo_procedimento"
                                    type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="valor_procedimento" class="form-label"><strong>Valor do
                                        Procedimento</strong></label>
                                <input class="form-control" id="valor_procedimento" name="valor_procedimento"
                                    type="text">
                            </div>
                        </div>

                        <!-- Observações e Assinaturas -->
                        <h5><strong>Observações</strong></h5>
                        <div class="mb-3 col-md-12">
                            <textarea class="form-control" id="observacao" name="observacao"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-check-circle-fill me-2"></i>Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function() {
            // Selecionar todas as guias
            $('#selectAll').on('change', function() {
                $('input[name="guiaCheckbox"]').prop('checked', $(this).is(':checked'));
                toggleMassActionButton();
            });

            // Atualizar botão de ação em massa quando um checkbox individual é clicado
            $(document).on('change', 'input[name="guiaCheckbox"]', function() {
                toggleMassActionButton();
            });

            // Habilitar/desabilitar o botão de gerar guias em massa
            function toggleMassActionButton() {
                const anyChecked = $('input[name="guiaCheckbox"]:checked').length > 0;
                $('#btnGerarGuias').prop('disabled', !anyChecked);
            }

            // Função para gerar guias em massa
            $('#btnGerarGuias').on('click', function() {
                const selectedIds = $('input[name="guiaCheckbox"]:checked').map(function() {
                    return $(this).val();
                }).get();

                if (selectedIds.length > 0) {
                    gerarLote(selectedIds);
                } else {
                    alert('Nenhuma guia selecionada.');
                }
            });

            function gerarLote(ids) {
        let numeracao = null;

        // Função para verificar e solicitar numeração apenas se necessário
        function verificarNumeracao() {
            return fetch(`/verificar-numeracao`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ guia_ids: ids })
            })
            .then(response => response.json())
            .then(data => {
                if (data.numeracao) {
                    numeracao = data.numeracao;
                    return true;
                } else {
                    numeracao = prompt("Numeração não encontrada. Por favor, insira a numeração para o lote:");
                    return numeracao ? true : false;
                }
            })
            .catch(error => {
                alert("Erro ao verificar a numeração: " + error.message);
                return false;
            });
        }

        // Função para gerar o XML em lote
        function gerarXml() {
            return fetch("{{ route('guias.gerarXmlEmLote') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ guia_ids: ids, numeracao: numeracao })
            })
            .then(response => {
                if (response.status === 422) return response.json();
                else if (response.ok) return response.blob();
                else throw new Error('Erro ao gerar XML.');
            })
            .then(data => {
                if (data && data.error) {
                    alert("Erro: " + data.error);
                    return false;
                } else if (data instanceof Blob) {
                    const url = window.URL.createObjectURL(data);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `lote_guias_consulta.xml`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    return true;
                }
            })
            .catch(error => alert("Erro ao gerar XML em lote: " + error.message));
        }

        // Função para gerar o ZIP em lote
        function gerarZip() {
            return fetch("{{ route('guias.gerarZipEmLote') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ guia_ids: ids, numeracao: numeracao })
            })
            .then(response => {
                if (response.status === 422) return response.json();
                else if (response.ok) return response.blob();
                else throw new Error('Erro ao gerar ZIP.');
            })
            .then(data => {
                if (data && data.error) {
                    alert("Erro: " + data.error);
                    return false;
                } else if (data instanceof Blob) {
                    const url = window.URL.createObjectURL(data);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `lote_guias_consulta.zip`;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    return true;
                }
            })
            .catch(error => alert("Erro ao gerar ZIP em lote: " + error.message));
        }

        // Executa as funções para gerar XML e ZIP em sequência após verificar numeração
        verificarNumeracao().then(result => {
            if (result) {
                gerarXml().then(result => {
                    if (result !== false) {
                        return gerarZip();
                    }
                });
            }
        });
    }

            // Aplicar a máscara no campo de hora
            $('#hora_inicio_atendimento').mask('00:00');

            // Carregar as guias ao selecionar o convênio
            $('#convenio_id').change(function() {
                var convenio_id = $(this).val();
                if (convenio_id) {
                    $.ajax({
                        url: '/guia-consulta/listar',
                        type: 'GET',
                        data: { convenio_id: convenio_id },
                        success: function(response) {
                            if (response.guias && response.guias.length > 0) {
                                var html = '';
                                $.each(response.guias, function(index, guia) {
                                    var data = new Date(guia.created_at);
                                    var dataFormatada = data.toLocaleDateString('pt-BR', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    });

                                    html += '<tr>';
                                    html += '<td><input type="checkbox" name="guiaCheckbox" value="' + guia.id + '"></td>';
                                    html += '<td>' + guia.nome_beneficiario + '</td>';
                                    html += '<td>' + dataFormatada + '</td>';
                                    html += '<td>';
                                    html += '<button type="button" class="btn btn-success btnVisualizarImprimir" data-id="' + guia.id + '" title="Visualizar e Imprimir">';
                                    html += '<i class="bi bi-printer"></i>';
                                    html += '</button>';
                                    html += '<a href="javascript:void(0);" class="btn btn-danger ms-2" title="Gerar XML e ZIP" onclick="baixarArquivos(' + guia.id + ')">';
                                    html += '<i class="bi bi-filetype-xml"></i>';
                                    html += '</a>';
                                    html += '</td>';
                                    html += '</tr>';
                                });

                                $('#listaGuias').html(html);
                            } else {
                                $('#listaGuias').html('<tr><td colspan="4">Nenhuma guia encontrada para este convênio.</td></tr>');
                            }
                            $('#btnNovoGuia').prop('disabled', false);
                            $('#convenio_id_hidden').val(convenio_id);
                        },
                        error: function() {
                            alert('Erro ao buscar as guias.');
                            $('#btnNovoGuia').prop('disabled', true);
                        }
                    });
                } else {
                    $('#listaGuias').html('');
                    $('#btnNovoGuia').prop('disabled', true);
                }
            });

            $(document).on('click', '.btnVisualizarGuia', function() {
                var guiaId = $(this).data('id');

                // Fazer a requisição AJAX para buscar os detalhes da guia com o ID correto
                $.ajax({
                    url: '/guia-consulta/detalhes/' + guiaId, // Atualizando para a rota correta
                    type: 'GET',
                    success: function(response) {
                        // Preencher os campos do formulário com os dados da guia
                        $('#user_id').val(response.user_id);
                        $('#convenio_id_hidden').val(response.convenio_id);
                        $('#registro_ans').val(response.registro_ans);
                        $('#numero_guia_prestador').val(response.numero_guia_prestador);
                        $('#numero_carteira').val(response.numero_carteira);
                        $('#validade_carteira').val(response.validade_carteira);
                        $('#atendimento_rn').val(response.atendimento_rn);
                        $('#nome_beneficiario').val(response.nome_beneficiario);
                        $('#nome_social').val(response.nome_social);
                        $('#data_atendimento').val(response.data_atendimento);
                        $('#codigo_operadora').val(response.codigo_operadora);
                        $('#nome_contratado').val(response.nome_contratado);
                        $('#tipo_consulta').val(response.tipo_consulta);
                        $('#codigo_tabela').val(response.codigo_tabela);
                        $('#codigo_procedimento').val(response.codigo_procedimento);
                        $('#valor_procedimento').val(response.valor_procedimento);
                        $('#nome_profissional_executante').val(response
                            .nome_profissional_executante);
                        $('#conselho_profissional').val(response.conselho_profissional);
                        $('#numero_conselho').val(response.numero_conselho);
                        $('#uf_conselho').val(response.uf_conselho);
                        $('#codigo_cbo').val(response.codigo_cbo);
                        $('#indicacao_acidente').val(response.indicacao_acidente);
                        $('#codigo_cnes').val(response.codigo_cnes);
                        $('#indicacao_cobertura_especial').val(response
                            .indicacao_cobertura_especial);
                        $('#regime_atendimento').val(response.regime_atendimento);
                        $('#saude_ocupacional').val(response.saude_ocupacional);
                        $('#numero_guia_operadora').val(response.numero_guia_operadora);
                        $('#observacao').val(response.observacao);
                        $('#hash').val(response.hash);

                        // Abrir o modal
                        $('#visualizarGuiaModal').modal('show');
                    },
                    error: function() {
                        alert('Erro ao buscar os detalhes da guia.');
                    }
                });
            });
        });

        $(document).on('click', '.btnVisualizarImprimir', function() {
            // Capturar o ID da guia a partir do botão
            var guiaId = $(this).data('id');

            // Substituir ':id' na rota com o ID da guia
            var url = "{{ route('guia.consulta', '/id') }}".replace('/id', guiaId);

            // Abrir a URL em uma nova janela popup e iniciar a impressão
            var newWindow = window.open(url, '_blank',
                'toolbar=no,scrollbars=yes,resizable=yes,width=1000,height=800');

            newWindow.onload = function() {
                newWindow.print();
            };
        });

// Função para verificar numeração no backend
function verificarNumeracao(id) {
    return fetch(`/verificar-numeracao`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ guia_ids: [id] })
    })
    .then(response => response.json())
    .then(data => data.numeracao);
}

// Função para gerar o XML com verificação de numeração
function gerarXmlGuiaConsulta(id) {
    if (!numGuia) {
        numGuia = prompt("Numeração não encontrada para esta guia. Por favor, insira a numeração:");
        if (!numGuia) {
            alert("A numeração é necessária para gerar o XML.");
            return;
        }
    }

    fetch(`/gerar-xml-guia-consulta/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ numeracao: numGuia })
    })
    .then(response => response.blob())
    .then(blob => downloadBlob(blob, `guia_consulta_${id}.xml`))
    .catch(error => alert("Erro ao gerar XML: " + error.message));
}

// Função para gerar o ZIP com a mesma numeração
function gerarZipGuiaConsulta(id) {
    if (!numGuia) {
        alert("Por favor, gere o XML primeiro para definir a numeração.");
        return;
    }

    fetch(`/gerar-zip-guia-consulta/${id}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ numeracao: numGuia })
    })
    .then(response => response.blob())
    .then(blob => downloadBlob(blob, `guia_consulta_${id}.zip`))
    .catch(error => alert("Erro ao gerar ZIP: " + error.message));
}

// Função para baixar arquivos XML e ZIP com verificação de numeração
function baixarArquivos(guiaId) {
    verificarNumeracao(guiaId).then(numeracao => {
        if (numeracao) {
            numGuia = numeracao; // Usa a numeração existente
        } else {
            // Solicita a numeração se não estiver definida
            numGuia = prompt("Numeração não encontrada para esta guia. Por favor, insira a numeração:");
            if (!numGuia) {
                alert("A numeração é necessária para gerar os arquivos.");
                return;
            }
        }

        // Gera o XML e ZIP usando a numeração confirmada ou nova
        gerarXmlGuiaConsulta(guiaId);
        gerarZipGuiaConsulta(guiaId);
    }).catch(error => alert("Erro ao verificar a numeração: " + error.message));
}

// Função de download de blobs
function downloadBlob(blob, filename) {
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    document.body.appendChild(a);
    a.click();
    a.remove();
}
    </script>
@endsection

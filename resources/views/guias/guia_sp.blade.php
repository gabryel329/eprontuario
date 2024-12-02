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
                    <div class="timeline-post">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs user-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#dados" data-bs-toggle="tab"
                                        data-identificador="PENDENTE">Guias Pendentes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#honorario" data-bs-toggle="tab"
                                        data-identificador="GERADO">Guias Geradas</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tile-title d-flex justify-content-between align-items-center">
                        <label class="form-label">Lista de Guias SADT</label>
                        <button type="button" class="btn btn-success" id="btnGerarGuias" disabled>
                            <i class="bi bi-file-earmark-zip"></i> Gerar Guias Selecionadas
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered text-center">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll" /></th>
                                    <th>Lote</th>
                                    <th>Data</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="listaGuias">
                                <!-- Dados dinâmicos serão carregados aqui -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="visualizarGuiaModal" tabindex="-1" aria-labelledby="visualizarGuiaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="visualizarGuiaModalLabel">Detalhes da Guia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formVisualizarGuia">
                        @csrf
                        <input type="hidden" id="user_id" name="user_id">
                        <input type="hidden" id="convenio_id" name="convenio_id">
                        <div class="row">
                            <div class="mb-3 col-md-2">
                                <label class="form-label"><strong>1- Registro ANS</strong></label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">2- Nº da guia no prestador</label>
                                <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">4- Nº da carteira do beneficiário</label>
                                <input class="form-control" id="numero_carteira" name="numero_carteira" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-8">
                                <label class="form-label">7- Nome do beneficiário</label>
                                <input class="form-control" id="nome_beneficiario" name="nome_beneficiario" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">18- Data da realização</label>
                                <input class="form-control" id="data_atendimento" name="data_atendimento" type="date"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Hora Início do Atendimento</label>
                                <input class="form-control" id="hora_inicio_atendimento" name="hora_inicio_atendimento"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">19- Tipo de consulta</label>
                                <input class="form-control" id="tipo_consulta" name="tipo_consulta" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">17- Indicação de acidente</label>
                                <input class="form-control" id="indicacao_acidente" name="indicacao_acidente"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">20- Código da Tabela</label>
                                <input class="form-control" id="codigo_tabela" name="codigo_tabela" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">21- Código do procedimento</label>
                                <input class="form-control" id="codigo_procedimento" name="codigo_procedimento"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">22- Valor do procedimento</label>
                                <input class="form-control" id="valor_procedimento" name="valor_procedimento"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">12- Nome do profissional</label>
                                <input class="form-control" id="nome_profissional" name="nome_profissional"
                                    type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">13- Sigla do conselho</label>
                                <input class="form-control" id="sigla_conselho" name="sigla_conselho" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">14- Nº do conselho</label>
                                <input class="form-control" id="numero_conselho" name="numero_conselho" type="text"
                                    readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">15- UF do conselho</label>
                                <input class="form-control" id="uf_conselho" name="uf_conselho" type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">16- CBO</label>
                                <input class="form-control" id="cbo" name="cbo" type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-12">
                                <label class="form-label">23- Observação / Justificativa</label>
                                <input class="form-control" id="observacao" name="observacao" type="text" readonly>
                            </div>
                            <div class="mb-3 col-md-4">
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
    <div class="modal fade" id="novoGuiaModal" tabindex="-1" aria-labelledby="novoGuiaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="novoGuiaModalLabel">Guia de Consulta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('guiasp.store') }}" method="POST" enctype="multipart/form-data"
                        id="formNovaGuia">
                        @csrf
                        <input type="hidden" id="convenio_id_hidden" name="convenio_id">

                        <div class="row">
                            <!-- Registro ANS -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label"><strong>1- Registro ANS</strong></label>
                                <input class="form-control" id="registro_ans" name="registro_ans" type="text"
                                    value="{{ old('registro_ans') }}">
                            </div>

                            <!-- Número da Guia do Prestador -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">3- Nº da Guia do Prestador</label>
                                <input class="form-control" id="numero_guia_prestador" name="numero_guia_prestador"
                                    type="text" value="{{ old('numero_guia_prestador') }}">
                            </div>

                            <!-- Data da Autorização -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">4- Data da autorização</label>
                                <input class="form-control" id="data_autorizacao" name="data_autorizacao" type="date"
                                    value="{{ old('data_autorizacao') }}">
                            </div>

                            <!-- Senha -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">5- Senha</label>
                                <input class="form-control" id="senha" name="senha" type="text"
                                    value="{{ old('senha') }}">
                            </div>

                            <!-- Data de Validade da Senha -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">6- Data de Validade da Senha</label>
                                <input class="form-control" id="validade_senha" name="validade_senha" type="date"
                                    value="{{ old('validade_senha') }}">
                            </div>

                            <!-- Número da Guia Atribuído pela Operadora -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">7- Nº da Guia Atribuído pela Operadora</label>
                                <input class="form-control" id="numero_guia_op" name="numero_guia_op" type="text"
                                    value="{{ old('numero_guia_op') }}">
                            </div>

                            <!-- Número da Carteira -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">8- Nº da Carteira</label>
                                <input class="form-control" id="numero_carteira" name="numero_carteira" type="text"
                                    value="{{ old('numero_carteira') }}">
                            </div>

                            <!-- Validade da Carteira -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">9- Validade da Carteira</label>
                                <input class="form-control" id="validade_carteira" name="validade_carteira"
                                    type="date" value="{{ old('validade_carteira') }}">
                            </div>

                            <!-- Nome Beneficiário -->
                            <div class="mb-3 col-md-8">
                                <label class="form-label">10- Nome Beneficiário</label>
                                <input class="form-control" id="nome_beneficiario" name="nome_beneficiario"
                                    type="text" value="{{ old('nome_beneficiario') }}">
                            </div>

                            <!-- Atendimento a RN -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">12- Atendimento a RN</label>
                                <select class="form-control" id="atendimento_rn" name="atendimento_rn">
                                    <option value="0" {{ old('atendimento_rn') == '0' ? 'selected' : '' }}>Não
                                    </option>
                                    <option value="1" {{ old('atendimento_rn') == '1' ? 'selected' : '' }}>Sim
                                    </option>
                                </select>
                            </div>

                            <!-- Nome do Profissional Solicitante -->
                            <div class="mb-3 col-md-6">
                                <label class="form-label">15- Nome do Profissional Solicitante</label>
                                <input class="form-control" id="nome_profissional_solicitante"
                                    name="nome_profissional_solicitante" type="text"
                                    value="{{ old('nome_profissional_solicitante') }}">
                            </div>

                            <!-- Conselho Profissional -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label">16- Conselho Profissional</label>
                                <input class="form-control" id="conselho_profissional" name="conselho_profissional"
                                    type="text" value="{{ old('conselho_profissional') }}">
                            </div>

                            <!-- Número do Conselho -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label">17- Nº do Conselho</label>
                                <input class="form-control" id="numero_conselho" name="numero_conselho" type="text"
                                    value="{{ old('numero_conselho') }}">
                            </div>

                            <!-- UF do Conselho -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label">18- UF</label>
                                <input class="form-control" id="uf_conselho" name="uf_conselho" type="text"
                                    value="{{ old('uf_conselho') }}">
                            </div>

                            <!-- Código CBO -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label">19- Código CBO</label>
                                <input class="form-control" id="codigo_cbo" name="codigo_cbo" type="text"
                                    value="{{ old('codigo_cbo') }}">
                            </div>

                            <!-- Código do Procedimento Solicitado -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">25- Código do Procedimento Solicitado</label>
                                <input class="form-control" id="codigo_procedimento_solicitado"
                                    name="codigo_procedimento_solicitado" type="text"
                                    value="{{ old('codigo_procedimento_solicitado') }}">
                            </div>

                            <!-- Descrição do Procedimento -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">26- Descrição do Procedimento</label>
                                <input class="form-control" id="descricao_procedimento" name="descricao_procedimento"
                                    type="text" value="{{ old('descricao_procedimento') }}">
                            </div>

                            <!-- Código da Operadora Executante -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">29- Código da Operadora Executante</label>
                                <input class="form-control" id="codigo_operadora_executante"
                                    name="codigo_operadora_executante" type="text"
                                    value="{{ old('codigo_operadora_executante') }}">
                            </div>

                            <!-- Nome do Contratado Executante -->
                            <div class="mb-3 col-md-8">
                                <label class="form-label">30- Nome do Contratado Executante</label>
                                <input class="form-control" id="nome_contratado_executante"
                                    name="nome_contratado_executante" type="text"
                                    value="{{ old('nome_contratado_executante') }}">
                            </div>

                            <!-- Código CNES -->
                            <div class="mb-3 col-md-4">
                                <label class="form-label">31- Código CNES</label>
                                <input class="form-control" id="codigo_cnes" name="codigo_cnes" type="text"
                                    value="{{ old('codigo_cnes') }}">
                            </div>

                            <!-- Observação -->
                            <div class="mb-3 col-md-12">
                                <label class="form-label">58- Observação / Justificativa</label>
                                <textarea class="form-control" id="observacao" name="observacao">{{ old('observacao') }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-4 align-self-end">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-check-circle-fill me-2"></i>Salvar
                                </button>
                            </div>
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
            // Mascara para o campo de horário
            $('#hora_inicio_atendimento').mask('00:00');

            // Selecionar todas as guias
            $('#selectAll').on('change', function() {
                $('input[name="guiaCheckbox"]').prop('checked', $(this).is(':checked'));
                toggleMassActionButton();
            });

            // Atualizar botão de ação em massa quando um checkbox individual é clicado
            $(document).on('change', 'input[name="guiaCheckbox"]', function() {
                toggleMassActionButton();
            });

            // Função para habilitar/desabilitar o botão de gerar guias em massa
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
                    gerarLoteGuiasadt(selectedIds);
                } else {
                    alert('Nenhuma guia selecionada.');
                }
            });

            // Função para listar guias com base no convênio selecionado e na aba ativa
            $(document).ready(function() {
                function listarGuias() {
                    var convenio_id = $('#convenio_id').val(); // ID do convênio selecionado
                    var identificador = $('.nav-link.active').data(
                    'identificador'); // Identificador da aba ativa

                    if (convenio_id && identificador) {
                        $.ajax({
                            url: '/guia-sp/listar', // Verifique se essa rota está correta no Laravel
                            type: 'GET',
                            data: {
                                convenio_id: convenio_id,
                                identificador: identificador // Envia o identificador da aba ativa
                            },
                            success: function(response) {
                                var html = '';
                                if (response.guias && response.guias.length > 0) {
                                    $.each(response.guias, function(index, guia) {
                                        var data = new Date(guia.created_at);
                                        var dataFormatada = data.toLocaleDateString(
                                            'pt-BR', {
                                                day: '2-digit',
                                                month: '2-digit',
                                                year: 'numeric'
                                            });

                                        html += '<tr>';
                                        html +=
                                            '<td><input type="checkbox" name="guiaCheckbox" value="' +
                                            guia.id + '" /></td>';
                                        html += '<td>' + guia.numeracao + '</td>';
                                        html += '<td>' + dataFormatada + '</td>';
                                        html += '<td>';
                                        html +=
                                            '<button type="button" class="btn btn-success btnVisualizarImprimir" data-id="' +
                                            guia.id + '" title="Visualizar">';
                                        html += '<i class="bi bi-eye"></i></button>';
                                        html +=
                                            '<button type="button" class="btn btn-danger ms-2" title="Gerar XML e ZIP" onclick="baixarArquivosSadt(' +
                                            guia.id + ')">';
                                        html +=
                                            '<i class="bi bi-filetype-xml"></i></button>';
                                        html += '</td>';
                                        html += '</tr>';
                                    });
                                } else {
                                    html =
                                        '<tr><td colspan="4">Nenhuma guia encontrada para este convênio e aba selecionados.</td></tr>';
                                }
                                $('#listaGuias').html(html);
                            },
                            error: function() {
                                alert('Erro ao buscar as guias.');
                            }
                        });
                    } else {
                        $('#listaGuias').html(
                            '<tr><td colspan="4">Por favor, selecione um convênio e uma aba para ver as guias.</td></tr>'
                            );
                    }
                }

                // Evento para carregar guias ao trocar de convênio
                $('#convenio_id').change(function() {
                    listarGuias();
                });

                // Evento para carregar guias ao mudar de aba
                $('.nav-link').click(function() {
                    $('.nav-link').removeClass('active'); // Remove a classe ativa de outras abas
                    $(this).addClass('active'); // Adiciona a classe ativa à aba clicada
                    listarGuias(); // Carrega os dados para a aba selecionada
                });

                // Carregar guias iniciais com a primeira aba ativa
                listarGuias();
            });
        });

        $(document).on('click', '.btnVisualizarImprimir', function() {
            // Capturar o ID da guia a partir do botão
            var guiaId = $(this).data('id');

            // Substituir ':id' na rota com o ID da guia
            var url = "{{ route('guia.sp', '/id') }}".replace('/id', guiaId);

            // Abrir a URL em uma nova janela popup e iniciar a impressão
            var newWindow = window.open(url, '_blank',
                'toolbar=no,scrollbars=yes,resizable=yes,width=1000,height=800');

            newWindow.onload = function() {
                newWindow.print();
            };
        });

        function gerarLoteGuiasadt(ids) {
            let numeracao = null;

            function verificarNumeracao() {
                return fetch(`/verificar-numeracao-sadt`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            guia_ids: ids
                        })
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

            function gerarXmlGuiasadt() {
                return fetch("{{ route('guias.gerarXmlEmLote') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            guia_ids: ids,
                            numeracao: numeracao
                        })
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
                            a.download = `lote_guias_sadt.xml`;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            return true;
                        }
                    })
                    .catch(error => alert("Erro ao gerar XML em lote: " + error.message));
            }

            function gerarZipGuiasadt() {
                return fetch("{{ route('guias.gerarZipEmLote') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            guia_ids: ids,
                            numeracao: numeracao
                        })
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
                            a.download = `lote_guias_sadt.zip`;
                            document.body.appendChild(a);
                            a.click();
                            a.remove();
                            return true;
                        }
                    })
                    .catch(error => alert("Erro ao gerar ZIP em lote: " + error.message));
            }

            verificarNumeracao().then(result => {
                if (result) {
                    gerarXmlGuiasadt().then(result => {
                        if (result !== false) {
                            return gerarZipGuiasadt();
                        }
                    });
                }
            });
        }

        function baixarArquivosSadt(guiaId) {
            let numGuia = null;

            // Função `verificarNumeracao` movida para dentro de `baixarArquivosSadt`
            function verificarNumeracao(ids) {
                return fetch(`/verificar-numeracao-sadt`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            guia_ids: ids
                        })
                    })
                    .then(response => response.json())
                    .then(data => data.numeracao || null)
                    .catch(error => {
                        alert("Erro ao verificar a numeração: " + error.message);
                        return null;
                    });
            }

            verificarNumeracao([guiaId]).then(numeracao => {
                if (numeracao) {
                    numGuia = numeracao;
                } else {
                    numGuia = prompt("Numeração não encontrada para esta guia. Por favor, insira a numeração:");
                    if (!numGuia) {
                        alert("A numeração é necessária para gerar os arquivos.");
                        return;
                    }
                }

                gerarXmlGuiaSadt(guiaId, numGuia);
                gerarZipGuiaSadt(guiaId, numGuia);
            }).catch(error => alert("Erro ao verificar a numeração: " + error.message));
        }

        function gerarXmlGuiaSadt(id, numGuia) {
            fetch(`/gerar-xml-guia-sadt/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        numeracao: numGuia
                    })
                })
                .then(response => response.blob())
                .then(blob => downloadBlob(blob, `guia_sadt_${id}.xml`))
                .catch(error => alert("Erro ao gerar XML: " + error.message));
        }

        function gerarZipGuiaSadt(id, numGuia) {
            fetch(`/gerar-zip-guia-sadt/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        numeracao: numGuia
                    })
                })
                .then(response => response.blob())
                .then(blob => downloadBlob(blob, `guia_sadt_${id}.zip`))
                .catch(error => alert("Erro ao gerar ZIP: " + error.message));
        }

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

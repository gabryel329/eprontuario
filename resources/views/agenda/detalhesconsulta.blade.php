<!DOCTYPE html>
<html lang="en">

<head>
    <title>ePRONTUÁRIO</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Main CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">

    <!-- Bootstrap Icons CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO_01_VERDE.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* Estilos para o cabeçalho */
        .app-header {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 60px;
            width: 100%;
            background-color: #145046;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }

        .app-header__logo {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .header-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .header-image {
            max-height: 50px;
            max-width: 100%;
        }

        /* Ajusta o conteúdo principal para não ficar atrás do cabeçalho */
        main {
            margin-top: 80px;
            /* Ajuste com base na altura do cabeçalho */
        }

        .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <header class="app-header">
        <a href="#" class="app-header__logo">
            <div class="header-content">
                <img src="{{ asset('images/LOGO_01_HORIZONTAL.png') }}" alt="ePRONTUÁRIO" class="header-image">
            </div>
        </a>
    </header>

    <main>
        <div style="text-align: center">
            <h3>Ficha de Atendimento</h3>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <h4 class="line-head">Dados do Atendimento</h4>
                        <div class="tile-body">
                            <div class="row">
                                <div class="mb-3 col-md-2">
                                    <label class="form-label"><strong>Convênio</strong></label>
                                    <input class="form-control" id="convenio_id" name="convenio_id" type="text"
                                        value="{{ $agendas->convenio->nome }}" readonly>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label"><strong>Tipo de Atendimento</strong></label>
                                    <input class="form-control" id="tp_atend" name="tp_atend" type="text"
                                        value="Ambulatórial" readonly>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label"><strong>Cod. Paciente</strong></label>
                                    <input class="form-control" id="paceinte_id" name="paceinte_id" type="text"
                                        value="{{ $agendas->paciente->id }}" readonly>
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label"><strong>Nome do Paciente</strong></label>
                                    <input class="form-control" id="paciente" name="paciente" type="text"
                                        value="{{ $agendas->paciente->name }}" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label"><strong>Data/Hora</strong></label>
                                    <input class="form-control" id="data" name="data" type="text"
                                        value="{{ \Carbon\Carbon::parse($agendas->data)->format('d/m/Y') }} - {{ $agendas->hora }}"
                                        readonly>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label"><strong>Plano</strong></label>
                                    <input class="form-control" id="plano" name="plano" type="text"
                                        value="{{ $pacientes->plano }}" readonly>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label"><strong>Matr./CNS</strong></label>
                                    <input class="form-control" id="matricula" name="matricula" type="text"
                                        value="{{ $pacientes->matricula }}" readonly>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label"><strong>Origem</strong></label>
                                    <input class="form-control" id="origem" name="origem" type="text"
                                        value="Demanda Espontânea" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="tile">
                        <h4 class="line-head">Profissonal Responsável</h4>
                        <div class="tile-body">
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label"><strong>Cód. Profissional</strong></label>
                                    <input class="form-control" id="profissional_id" name="profissional_id"
                                        type="text" value="{{ $agendas->profissional->id }}" readonly>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label"><strong>Nome do Profissional</strong></label>
                                    <input class="form-control" id="profissional" name="profissional" type="text"
                                        value="{{ $agendas->profissional->name }}" readonly>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label"><strong>Especialidade</strong></label>
                                    <input class="form-control" id="especialidade" name="especialidade"
                                        value="{{ $agendas->especialidade->especialidade }}" type="text" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label"><strong>Cód. Procedimento</strong></label>
                                    <input class="form-control" id="codigo" name="codigo" type="text"
                                        value="{{ $agendas->codigo }}" readonly>
                                </div>
                                <div class="mb-3 col-md-7">
                                    <label class="form-label"><strong>Procedimento</strong></label>
                                    <input class="form-control" id="procedimento" name="procedimento" type="text"
                                        value="{{ $agendas->procedimento_id }}" readonly>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label"><strong>CID</strong></label>
                                    <input class="form-control" id="cid" name="cid" type="text"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs user-tabs">
                        <li class="nav-item"><a class="nav-link active" href="#procedimentos" data-bs-toggle="tab">Procedimentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="#Medicamentos" data-bs-toggle="tab">Medicamentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="#Material" data-bs-toggle="tab">Material</a></li>
                        <li class="nav-item"><a class="nav-link" href="#Taxa" data-bs-toggle="tab">Taxa</a></li>
                    </ul>
                </div>
                <div class="col-md-12">
                    <div class="tile">
                        <div class="tab-content">
                            <div class="tab-pane active" id="procedimentos">
                                <form id="exameForm" method="POST" action="#">
                                    @csrf
                                    <input type="hidden" name="paciente_id" value="{{ $pacientes->id }}">
                                    <input type="hidden" name="agenda_id" value="{{ $agendas->id }}">

                                    <div class="timeline-post">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Data</th>
                                                        <th>Procedimento</th>
                                                        <th>Código</th>
                                                        <th>Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="exame-table-body">
                                                    <tr class="exame-row">
                                                        <td>
                                                            <input type="date"
                                                                value="{{ session('data', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                                                class="form-control dataproc" name="dataproc[]">
                                                        </td>
                                                        <td class="col-4">
                                                            <select name="procedimento_id[]"
                                                                class="select2 form-control procedimento_id" required>
                                                                <option value="" data-codigo="">Selecione o
                                                                    Procedimento</option>
                                                                @foreach ($agendas->procedimento_lista as $procedimento)
                                                                    <option value="{{ $procedimento->id }}"
                                                                        data-codigo="{{ $procedimento->codigo }}"
                                                                        data-valor="{{ $procedimento->valor_proc }}">
                                                                        {{ $procedimento->procedimento }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control codigo"
                                                                name="codigo[]" placeholder="Código" readonly>
                                                            <input type="hidden" class="form-control valor"
                                                                name="valor[]" placeholder="Código" readonly>
                                                        </td>
                                                        <td class="actions">
                                                            <button type="button"
                                                                class="btn btn-success plus-row">+</button>
                                                            <button type="button"
                                                                class="btn btn-danger delete-row">-</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tile-footer text-center">
                                        <button {{ $agendas->status == 'FINALIZADO' ? 'disabled' : '' }}
                                            class="btn btn-danger" id="saveExameButton" type="button">
                                            <i class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar
                                        </button>
                                    </div>
                                </form>

                            </div>

                            <div class="tab-pane fade" id="Medicamentos">
                                <form id="remedioForm" method="POST" action="#">
                                    @csrf
                                    <input type="hidden" name="paciente_id" value="{{ $pacientes->id }}">
                                    <input type="hidden" name="agenda_id" value="{{ $agendas->id }}">

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Medicamentos</th>
                                                    <th>Código</th>
                                                    <th>Qtd</th>
                                                    <th>Unidade Medida</th>
                                                    <th>Fator Red./Acresc.</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody id="prescricao-table-body">
                                                <tr class="prescricao-row">
                                                    <td class="col-7">
                                                        <select class="form-control medicamento_id select2"
                                                            name="medicamento_id[]" onchange="updateValor(this)">
                                                            <option value="" data-valor="" data-codigo="">
                                                                Selecione o remédio</option>
                                                            @if ($agendas->medicamentos && $agendas->medicamentos->isNotEmpty())
                                                                @foreach ($agendas->medicamentos as $medicamento)
                                                                    <option value="{{ $medicamento->id }}"
                                                                        data-valor="{{ $medicamento->preco }}"
                                                                        data-codigo="{{ $medicamento->codigo }}">
                                                                        {{ $medicamento->medicamento }}-{{ $medicamento->unid }}
                                                                    </option>
                                                                @endforeach
                                                            @else
                                                                <option value="">Nenhum medicamento encontrado
                                                                </option>
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control codigo"
                                                            name="codigo[]" readonly>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control quantidade"
                                                            name="quantidade[]" placeholder="Qtd">
                                                        <input type="hidden" class="form-control valor"
                                                            name="valor[]" readonly>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="unidade_medida[]" id="unid"
                                                                value="001">
                                                            <label class="form-check-label"
                                                                for="unid">Unid.</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="unidade_medida[]" id="cx"
                                                                value="002">
                                                            <label class="form-check-label" for="cx">Cx.</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="unidade_medida[]" id="fr"
                                                                value="003">
                                                            <label class="form-check-label" for="fr">Fr.</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="unidade_medida[]" id="amp"
                                                                value="004">
                                                            <label class="form-check-label"
                                                                for="amp">Amp.</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="unidade_medida[]" id="comp"
                                                                value="005">
                                                            <label class="form-check-label"
                                                                for="comp">Comp.</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="unidade_medida[]" id="gts"
                                                                value="006">
                                                            <label class="form-check-label"
                                                                for="gts">Gts.</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="unidade_medida[]" id="ml"
                                                                value="007">
                                                            <label class="form-check-label" for="ml">ml</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="unidade_medida[]" id="g"
                                                                value="008">
                                                            <label class="form-check-label" for="g">g</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio"
                                                                name="unidade_medida[]" id="outros"
                                                                value="036">
                                                            <label class="form-check-label"
                                                                for="outros">Outros</label>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <input type="text" class="form-control fator"
                                                            name="fator[]" placeholder="Ex:(1,00)">
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                            class="btn btn-success add-row">+</button>
                                                        <button type="button"
                                                            class="btn btn-danger remove-row">-</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="tile-footer text-center">
                                        <button {{ $agendas->status == 'FINALIZADO' ? 'disabled' : '' }}
                                            class="btn btn-danger" id="saveRemedioButton" type="button">
                                            <i class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar
                                        </button>
                                    </div>
                                </form>

                            </div>

                            <div class="tab-pane fade" id="Material">
                                <form id="materialForm" method="POST" action="#">
                                    @csrf
                                    <input type="hidden" name="paciente_id" value="{{ $pacientes->id }}">
                                    <input type="hidden" name="agenda_id" value="{{ $agendas->id }}">

                                    <div class="timeline-post">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th class="col-7">Material</th>
                                                        <th>Código</th>
                                                        <th>Qtd</th>
                                                        <th>Unidade Medida</th>
                                                        <th>Fator Red./Acresc.</th>
                                                        <th>Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="material-table-body">
                                                    <tr class="material-row">
                                                        <td class="col-7">
                                                            <select class="form-control material_id select2"
                                                                name="material_id[]" onchange="updateValorCod(this)">
                                                                <option value="" data-valor="" data-codigo="">
                                                                    Selecione o Material</option>
                                                                @foreach ($agendas->materias as $material)
                                                                    <option value="{{ $material->id }}"
                                                                        data-valor="{{ $material->preco }}"
                                                                        data-codigo="{{ $material->codigo }}">
                                                                        {{ $material->medicamento }}-{{ $material->unid }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control codigo"
                                                                name="codigo[]" readonly>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="form-control quantidade"
                                                                name="quantidade[]" placeholder="Qtd">
                                                            <input type="hidden" class="form-control valor"
                                                                name="valor[]" readonly>
                                                        </td>
                                                        <td>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="unidade_medida[]" id="unid"
                                                                    value="001">
                                                                <label class="form-check-label"
                                                                    for="unid">Unid.</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="unidade_medida[]" id="cx"
                                                                    value="002">
                                                                <label class="form-check-label"
                                                                    for="cx">Cx.</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="unidade_medida[]" id="fr"
                                                                    value="003">
                                                                <label class="form-check-label"
                                                                    for="fr">Fr.</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="unidade_medida[]" id="amp"
                                                                    value="004">
                                                                <label class="form-check-label"
                                                                    for="amp">Amp.</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="unidade_medida[]" id="comp"
                                                                    value="005">
                                                                <label class="form-check-label"
                                                                    for="comp">Comp.</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="unidade_medida[]" id="gts"
                                                                    value="006">
                                                                <label class="form-check-label"
                                                                    for="gts">Gts.</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="unidade_medida[]" id="ml"
                                                                    value="007">
                                                                <label class="form-check-label"
                                                                    for="ml">ml</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="unidade_medida[]" id="g"
                                                                    value="008">
                                                                <label class="form-check-label"
                                                                    for="g">g</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio"
                                                                    name="unidade_medida[]" id="outros"
                                                                    value="036">
                                                                <label class="form-check-label"
                                                                    for="outros">Outros</label>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <input type="text" class="form-control fator"
                                                                name="fator[]" placeholder="Ex:(1,00)">
                                                        </td>
                                                        <td class="actions">
                                                            <button type="button"
                                                                class="btn btn-success plus1-row">+</button>
                                                            <button type="button"
                                                                class="btn btn-danger delete1-row">-</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tile-footer text-center">
                                        <button {{ $agendas->status == 'FINALIZADO' ? 'disabled' : '' }}
                                            class="btn btn-danger" id="saveMaterialButton" type="button">
                                            <i class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar
                                        </button>
                                    </div>
                                </form>

                            </div>

                            <div class="tab-pane fade" id="Taxa">
                                <form id="taxaForm" method="POST" action="#">
                                    @csrf
                                    <input type="hidden" name="paciente_id" value="{{ $pacientes->id }}">
                                    <input type="hidden" name="agenda_id" value="{{ $agendas->id }}">

                                    <div class="timeline-post">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Taxa</th>
                                                        <th>Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="taxa-table-body">
                                                    <tr class="taxa-row">
                                                        <td class="col-7">
                                                            <select class="form-control taxa_id select2"
                                                                name="taxa_id[]" onchange="updateCodValor(this)">
                                                                <option value="">Selecione a Taxa</option>
                                                                @foreach ($taxas as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        data-valor="{{ $item->valor }}">
                                                                        {{ $item->descricao }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" class="form-control valor"
                                                                name="valor[]" readonly>
                                                        </td>
                                                        <td class="actions">
                                                            <button type="button"
                                                                class="btn btn-success plus2-row">+</button>
                                                            <button type="button"
                                                                class="btn btn-danger delete2-row">-</button>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tile-footer text-center">
                                        <button {{ $agendas->status == 'FINALIZADO' ? 'disabled' : '' }}
                                            class="btn btn-danger" id="saveTaxaButton" type="button">
                                            <i class="bi bi-check-circle-fill me-2"></i>Salvar/Atualizar
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- JS do Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        function updateValor(selectElement) {
            // Encontra a linha mais próxima da seleção
            const row = selectElement.closest('.prescricao-row');

            // Encontra os inputs de 'codigo' e 'valor' na mesma linha
            const codigoInput = row.querySelector('input[name="codigo[]"]');
            const valorInput = row.querySelector('input[name="valor[]"]');

            // Obtém a opção selecionada no select
            const medicamentoSelect = row.querySelector('select[name="medicamento_id[]"]');

            // Obtém a opção selecionada do select
            const selectedOption = medicamentoSelect.options[medicamentoSelect.selectedIndex];

            // Obtém os atributos 'data-codigo' e 'data-valor' da opção
            const codigo = selectedOption.getAttribute('data-codigo') || "0";
            const valor = selectedOption.getAttribute('data-valor') || "0";

            // Preenche os inputs com os valores correspondentes
            if (codigoInput) {
                codigoInput.value = codigo; // Preenche o campo 'codigo'
            }

            if (valorInput) {
                valorInput.value = parseFloat(valor).toFixed(2);
            }
        }

        function updateValorCod(selectElement) {
            // Encontra a linha mais próxima da seleção
            const row = selectElement.closest('.material-row');

            // Encontra os inputs de 'codigo' e 'valor' na mesma linha
            const codigoInput = row.querySelector('input[name="codigo[]"]');
            const valorInput = row.querySelector('input[name="valor[]"]');

            // Obtém a opção selecionada no select
            const selectedOption = selectElement.options[selectElement.selectedIndex];

            // Obtém os atributos 'data-codigo' e 'data-valor' da opção
            const codigo = selectedOption.getAttribute('data-codigo') || "0";
            const valor = selectedOption.getAttribute('data-valor') || "0";

            // Preenche os inputs com os valores correspondentes
            if (codigoInput) {
                codigoInput.value = codigo; // Preenche o campo 'codigo'
            }

            if (valorInput) {
                valorInput.value = parseFloat(valor).toFixed(2); // Preenche o campo 'valor' formatado
            }
        }

        function updateCodValor(selectElement) {
            // Encontra a linha mais próxima da seleção
            const row = selectElement.closest('.taxa-row');

            // Encontra o input 'valor' na mesma linha
            const valorInput = row.querySelector('input[name="valor[]"]');

            // Obtém a opção selecionada no select
            const selectedOption = selectElement.options[selectElement.selectedIndex];

            // Obtém o atributo 'data-valor' da opção
            const valor = selectedOption.getAttribute('data-valor') || "0";

            // Atualiza o campo 'valor' com o formato adequado
            if (valorInput) {
                valorInput.value = parseFloat(valor).toFixed(2); // Formata para 2 casas decimais
            }
        }

        function updateCodigo(selectElement) {
            const row = selectElement.closest('.exame-row'); // Encontra a linha mais próxima
            const codigoInput = row.querySelector('input[name="codigo[]"]'); // Campo de código
            const valorInput = row.querySelector('input[name="valor[]"]'); // Campo de código
            const selectedOption = selectElement.options[selectElement.selectedIndex]; // Opção selecionada
            codigoInput.value = selectedOption.getAttribute('data-codigo'); // Define o código
        }

        function applySelect2(element) {
            element.select2({
                placeholder: "Selecione",
                allowClear: false,
                closeOnSelect: true,
                width: '60%'
            }).on('select2:select', function(e) {
                updateCodigo(this);
                updateCodValor(this);
                updateValor(this);
                updateValorCod(this);
            });
        }


        $(document).ready(function() {
            applySelect2($('select.select2'));

            // Função para adicionar uma nova linha na tabela de prescrição
            function addPrescricaoRow() {
                const rowCount = $('#prescricao-table-body .prescricao-row').length; // Conta as linhas existentes
                const newRow = `
        <tr class="prescricao-row">
            <td class="col-7">
                <select class="form-control medicamento_id select2" name="medicamento_id[]" onchange="updateValor(this)">
                    <option value="" data-valor="" data-codigo="">Selecione o remédio</option>
                    @if ($agendas->medicamentos && $agendas->medicamentos->isNotEmpty())
                        @foreach ($agendas->medicamentos as $medicamento)
                            <option value="{{ $medicamento->id }}" 
                                    data-valor="{{ $medicamento->preco }}" 
                                    data-codigo="{{ $medicamento->codigo }}">
                                {{ $medicamento->medicamento }}-{{ $medicamento->unid }}
                            </option>
                        @endforeach
                    @else
                        <option value="">Nenhum medicamento encontrado</option>
                    @endif
                </select>
            </td>
            <td class="col-1 text-center">
                <input type="text" class="form-control codigo" name="codigo[]" readonly>
            </td>
            <td>
                <input type="number" class="form-control quantidade" name="quantidade[]" placeholder="Qtd">
                <input type="hidden" class="form-control valor" name="valor[]" readonly>
            </td>
            <td>
                ${generateRadioButtons(rowCount)}
            </td>
            <td>
                <input type="text" class="form-control fator" name="fator[]" placeholder="Ex:(1,00)">
            </td>
            <td>
                <button type="button" class="btn btn-success add-row">+</button>
                <button type="button" class="btn btn-danger remove-row">-</button>
            </td>
        </tr>`;
                $('#prescricao-table-body').append(newRow);

                // Aplica Select2 ao novo select
                applySelect2($('#prescricao-table-body .prescricao-row:last .medicamento_id'));
            }

            function generateRadioButtons(index) {
                const options = [{
                        value: "001",
                        label: "Unid."
                    },
                    {
                        value: "002",
                        label: "Cx."
                    },
                    {
                        value: "003",
                        label: "Fr."
                    },
                    {
                        value: "004",
                        label: "Amp."
                    },
                    {
                        value: "005",
                        label: "Comp."
                    },
                    {
                        value: "006",
                        label: "Gts."
                    },
                    {
                        value: "007",
                        label: "ml"
                    },
                    {
                        value: "008",
                        label: "g"
                    },
                    {
                        value: "036",
                        label: "Outros"
                    }
                ];
                return options
                    .map(
                        (option) => `
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="unidade_medida[${index}]" value="${option.value}">
                <label class="form-check-label">${option.label}</label>
            </div>`
                    )
                    .join("");
            }

            // Adicionar e remover linhas dinamicamente
            $(document).on('click', '.add-row', function() {
                addPrescricaoRow();
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('.prescricao-row').remove();
            });

            // Evento para carregar dados ao selecionar um medicamento
            $(document).on('change', '.medicamento_id', function() {
                const row = $(this).closest('.prescricao-row');
                const selectedOption = $(this).find('option:selected');
                row.find('.codigo').val(selectedOption.data('codigo'));
                row.find('.valor').val(selectedOption.data('valor'));
            });

            // Carregar medicamentos do backend e adicionar as linhas dinamicamente
            const agenda_id = "{{ $agendas->id }}";
            const paciente_id = "{{ $pacientes->id }}";

            $.ajax({
                url: `/medicamento/${agenda_id}/${paciente_id}`,
                type: 'GET',
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(remedio => {
                            addPrescricaoRow();
                            const lastRow = $('#prescricao-table-body .prescricao-row:last');

                            // Preenche os campos com os dados retornados
                            lastRow.find('.medicamento_id').val(remedio.medicamento_id).trigger(
                                'change');
                            lastRow.find('.quantidade').val(remedio.quantidade);
                            lastRow.find(
                                `input[name^="unidade_medida"][value="${remedio.unidade_medida}"]`
                            ).prop('checked', true);
                            lastRow.find('.fator').val(remedio.fator);
                        });
                    } else {
                        console.warn('Nenhum medicamento encontrado.');
                    }
                },
                error: function(xhr) {
                    console.error('Erro ao carregar medicamentos:', xhr.responseText);
                }
            });

            // Salvar medicamentos via AJAX
            $('#saveRemedioButton').on('click', function(event) {
                event.preventDefault();

                const formData = $('#remedioForm').serialize();

                $.ajax({
                    url: '/medicamento/store',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        alert('Prescrição de remédios cadastrada/atualizada com sucesso');
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            alert(xhr.responseJSON.error);
                        } else {
                            alert('Ocorreu um erro. Tente novamente.');
                        }
                    }
                });
            });
        });


        $(document).ready(function() {
            applySelect2($('select.select2'));

            function addExameRow() {
                const rowHtml = `
                <tr class="exame-row">
                    <td>
                        <input type="date" value="{{ session('data', \Carbon\Carbon::now()->format('Y-m-d')) }}" class="form-control dataproc" name="dataproc[]">
                    </td>
                    <td class="col-4">
                        <select class="select2 form-control procedimento_id" name="procedimento_id[]" required>
                            <option value="" data-codigo="">Selecione o Procedimento</option>
                            @foreach ($agendas->procedimento_lista as $procedimento)
                                <option value="{{ $procedimento->id }}"
                                    data-codigo="{{ $procedimento->codigo }}" data-valor="{{ $procedimento->valor_proc }}">
                                    {{ $procedimento->procedimento }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control codigo" name="codigo[]" placeholder="Código" readonly>
                        <input type="hidden" class="form-control valor" name="valor[]" placeholder="Código" readonly>
                    </td>
                    <td class="actions">
                        <button type="button" class="btn btn-success plus-row">+</button>
                        <button type="button" class="btn btn-danger delete-row">-</button>
                    </td>
                </tr>
                `;

                // Adiciona a nova linha ao corpo da tabela
                $('#exame-table-body').append(rowHtml);

                // Reinicializa o Select2 na nova linha
                $('.select2').select2();
            }


            $(document).on('click', '.plus-row', function() {
                addExameRow();
            });

            $(document).on('click', '.delete-row', function() {
                $(this).closest('.exame-row').remove();
            });

            // Evento change para selects existentes
            $(document).on('change', '.procedimento_id', function() {
                var codigo = $(this).find('option:selected').data('codigo');
                $(this).closest('.exame-row').find('.codigo').val(codigo);
                var valor = $(this).find('option:selected').data('valor');
                $(this).closest('.exame-row').find('.valor').val(valor);
            });

            // Código para carregar procedimentos do backend
            var agenda_id = "{{ $agendas->id }}";
            var paciente_id = "{{ $pacientes->id }}";

            $.ajax({
                url: `/procedimentos/${agenda_id}/${paciente_id}`,
                type: 'GET',
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(item) {
                            console.log(item);

                            // Adiciona uma nova linha
                            addExameRow();

                            // Seleciona a última linha adicionada
                            const lastRow = $('#exame-table-body').find('.exame-row:last');

                            // Preenche os campos da linha com os dados recebidos
                            lastRow.find('.procedimento_id').val(item.procedimento_id).trigger(
                                'change');
                            lastRow.find('.codigo').val(item.codigo);
                            lastRow.find('.valor').val(item.valor);
                            lastRow.find('.dataproc').val(item.dataproc);
                        });
                    } else {
                        console.log('Nenhum dado encontrado.');
                    }
                },
                error: function() {
                    console.log('Erro ao carregar dados do banco.');
                }
            });


            $('#saveExameButton').on('click', function(event) {
                event.preventDefault();
                var url = '/procedimentos/store';

                // Serializa os dados do formulário e exibe no console
                var formData = $('#exameForm').serialize();
                console.log('Dados enviados:', formData);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        alert('Procedimentos cadastrados/atualizados com sucesso');
                    },
                    error: function(xhr) {
                        alert('Erro: ' + xhr.responseText);
                    }
                });
            });
            applySelect2($('select'));
        });

        $(document).ready(function () {
            const agenda_id = "{{ $agendas->id }}";
            const paciente_id = "{{ $pacientes->id }}";

            applySelect2($('select.select2'));

            // Função para adicionar uma nova linha na tabela de materiais
            function addMaterialRow() {
                const rowCount = $('#material-table-body .material-row').length; // Conta as linhas existentes
                const newRow = `
                    <tr class="material-row">
                        <td class="col-7">
                            <select class="form-control material_id select2" name="material_id[]" onchange="updateValorCod(this)">
                                <option value="" data-valor="" data-codigo="">Selecione o Material</option>
                                @foreach ($agendas->materias as $material)
                                    <option value="{{ $material->id }}" 
                                            data-valor="{{ $material->preco }}" 
                                            data-codigo="{{ $material->codigo }}">
                                        {{ $material->medicamento }}-{{ $material->unid }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control codigo" name="codigo[]" readonly>
                        </td>
                        <td>
                            <input type="number" class="form-control quantidade" name="quantidade[]" placeholder="Qtd">
                            <input type="hidden" class="form-control valor" name="valor[]" readonly>
                        </td>
                        <td>
                            ${generateMaterialRadioButtons(rowCount)}
                        </td>
                        <td>
                            <input type="text" class="form-control fator" name="fator[]" placeholder="Ex:(1,00)">
                        </td>
                        <td class="actions">
                            <button type="button" class="btn btn-success plus1-row">+</button>
                            <button type="button" class="btn btn-danger delete1-row">-</button>
                        </td>
                    </tr>`;
                $('#material-table-body').append(newRow);

                // Aplica Select2 ao novo select
                applySelect2($('#material-table-body .material-row:last .material_id'));
            }

            // Função para gerar botões rádio para materiais
            function generateMaterialRadioButtons(index) {
                const options = [
                    { value: "001", label: "Unid." },
                    { value: "002", label: "Cx." },
                    { value: "003", label: "Fr." },
                    { value: "004", label: "Amp." },
                    { value: "005", label: "Comp." },
                    { value: "006", label: "Gts." },
                    { value: "007", label: "ml" },
                    { value: "008", label: "g" },
                    { value: "036", label: "Outros" }
                ];
                return options
                    .map(
                        (option) => `
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="unidade_medida[${index}]" value="${option.value}">
                            <label class="form-check-label">${option.label}</label>
                        </div>`
                    )
                    .join("");
            }

            // Eventos para adicionar e remover linhas
            $(document).on('click', '.plus1-row', function () {
                addMaterialRow();
            });

            $(document).on('click', '.delete1-row', function () {
                $(this).closest('.material-row').remove();
            });

            // Carregar materiais do backend e preencher dinamicamente
            $.ajax({
                url: `/material/${agenda_id}/${paciente_id}`,
                type: 'GET',
                success: function (response) {
                    if (response.data && response.data.length > 0) {
                        response.data.forEach((item) => {
                            addMaterialRow();
                            const lastRow = $('#material-table-body .material-row:last');

                            // Preenche os campos com os dados retornados
                            lastRow.find('.material_id').val(item.material_id).trigger('change');
                            lastRow.find('.codigo').val(item.codigo);
                            lastRow.find('.quantidade').val(item.quantidade);
                            lastRow.find(`input[name^="unidade_medida"][value="${item.unidade_medida}"]`).prop('checked', true);
                            lastRow.find('.fator').val(item.fator);
                        });
                    } else {
                        console.warn('Nenhum material encontrado.');
                    }
                },
                error: function (xhr) {
                    console.error('Erro ao carregar materiais:', xhr.responseText);
                }
            });

            // Salvar materiais via AJAX
            $('#saveMaterialButton').on('click', function (event) {
                event.preventDefault();

                const formData = $('#materialForm').serialize();

                $.ajax({
                    url: '/material/store',
                    type: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function () {
                        alert('Materiais cadastrados/atualizados com sucesso');
                    },
                    error: function (xhr) {
                        console.error('Erro ao salvar materiais:', xhr.responseText);
                        alert('Erro ao salvar os materiais. Verifique os dados e tente novamente.');
                    }
                });
            });
        });


        $(document).ready(function() {
            var agenda_id = "{{ $agendas->id }}";
            var paciente_id = "{{ $pacientes->id }}";
            applySelect2($('select.select2'));


            function addTaxaRow() {
                var newRow = `
                <tr class="taxa-row">
                                                        <td>
                                                            <select class="form-control taxa_id select2" name="taxa_id[]" onchange="updateCodValor(this)">
                                                                <option value="">Selecione a Taxa</option>
                                                                @foreach ($taxas as $item)
                                                                    <option value="{{ $item->id }}" data-valor="{{ $item->valor }}">
                                                                        {{ $item->descricao }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input type="hidden" class="form-control valor" name="valor[]" readonly>
                                                        </td>
                                                        <td class="actions">
                                                            <button type="button" class="btn btn-success plus2-row">+</button>
                                                            <button type="button" class="btn btn-danger delete2-row">-</button>
                                                        </td>
                                                    </tr>`;
                $('#taxa-table-body').append(newRow);
                $('.select2').select2();
            }

            $(document).on('click', '.plus2-row', function() {
                addTaxaRow();
            });

            $(document).on('click', '.delete2-row', function() {
                $(this).closest('.taxa-row').remove();
            });

            $.ajax({
                url: `/taxa/${agenda_id}/${paciente_id}`,
                type: 'GET',
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(item) {
                            addTaxaRow();
                            $('#taxa-table-body').find('.taxa-row:last').find('.taxa_id').val(
                                item.taxa_id).trigger('change');
                        });
                    }
                },
                error: function() {
                    console.log('Erro ao carregar taxas.');
                }
            });

            $('#saveTaxaButton').on('click', function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/taxa/store',
                    type: 'POST',
                    data: $('#taxaForm').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        alert('Taxas cadastradas/atualizadas com sucesso');
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        alert('Erro: ' + xhr.responseText);
                    }
                });
            });
            applySelect2($('select'));
        });
    </script>
</body>

</html>

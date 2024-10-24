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
                        <li class="nav-item"><a class="nav-link active" href="#procedimentos"
                                data-bs-toggle="tab">Procedimentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="#Medicamentos"
                                data-bs-toggle="tab">Medicamentos</a></li>
                        <li class="nav-item"><a class="nav-link" href="#Material" data-bs-toggle="tab">Material</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="#Taxa" data-bs-toggle="tab">Taxa</a>
                        </li>
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
                                                        <th>Procedimento</th>
                                                        <th>Código</th>
                                                        <th>Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="exame-table-body">
                                                    <tr class="exame-row">
                                                        <td>
                                                            <select class="select2 form-control procedimento_id"
                                                                name="procedimento_id[]" id="procedimento_id"
                                                                style="width: 100%" required
                                                                onchange="updateCodigo(this)">
                                                                <option value="" data-codigo="">Selecione o
                                                                    Procedimento</option>
                                                                @foreach ($procedimento as $item)
                                                                    <option value="{{ $item->id }}"
                                                                        data-codigo="{{ $item->codigo }}">
                                                                        {{ $item->procedimento }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control codigo"
                                                                name="codigo[]" placeholder="Código" readonly>
                                                        </td>
                                                        <td class="actions col-md-2">
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
                                        <button {{ $agendas->status == 'FINALIZADO' ? 'disabled' : '' }} class="btn btn-danger" id="saveExameButton" type="button">
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
                                                    <th>Remédio</th>
                                                    <th>Dose</th>
                                                    <th>Horas</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody id="prescricao-table-body">
                                                <tr class="prescricao-row">
                                                    <td>
                                                        <select class="form-control medicamento_id"
                                                            name="medicamento_id[]">
                                                            <option value="">Selecione o remédio</option>
                                                            @foreach ($medicamento as $item)
                                                                <option value="{{ $item->id }}">
                                                                    {{ $item->nome }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control dose"
                                                            name="dose[]" placeholder="Dose">
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control hora"
                                                            name="hora[]" placeholder="Horas">
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
                                        <button {{ $agendas->status == 'FINALIZADO' ? 'disabled' : '' }} class="btn btn-danger" id="saveRemedioButton" type="button">
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
                                                        <th>Material</th>
                                                        <th>Ações</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="material-table-body">
                                                    <tr class="material-row">
                                                        <td class="col-md-10">
                                                            <select class="form-control material_id"
                                                                name="material_id[]" id="material_id">
                                                                <option value="">Selecione o Material</option>
                                                                @foreach ($produto as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->nome }}</option>
                                                                @endforeach
                                                            </select>
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
                                        <button {{ $agendas->status == 'FINALIZADO' ? 'disabled' : '' }} class="btn btn-danger" id="saveMaterialButton" type="button">
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
                                                        <td class="col-md-10">
                                                            <select class="form-control taxa_id"
                                                                name="taxa_id[]" id="taxa_id">
                                                                <option value="">Selecione o Taxa</option>
                                                                @foreach ($produto as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->nome }}</option>
                                                                @endforeach
                                                            </select>
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
                                        <button {{ $agendas->status == 'FINALIZADO' ? 'disabled' : '' }} class="btn btn-danger" id="saveTaxaButton" type="button">
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
    <script>
        function updateCodigo(selectElement) {
            // Encontra a linha mais próxima que contém o select
            const row = selectElement.closest('.exame-row');

            // Encontra o campo de input para o código dentro dessa linha
            const codigoInput = row.querySelector('input[name="codigo[]"]');

            // Obtém a opção selecionada
            const selectedOption = selectElement.options[selectElement.selectedIndex];

            // Define o valor do input com o código do procedimento selecionado
            codigoInput.value = selectedOption.getAttribute('data-codigo');
        }

        $(document).ready(function() {
            var agenda_id = "{{ $agendas->id }}";
            var paciente_id = "{{ $pacientes->id }}";

            function addPrescricaoRow() {
                var newRow = `
                <tr class="prescricao-row">
                    <td>
                        <select class="form-control medicamento_id" name="medicamento_id[]">
                            <option value="">Selecione o remédio</option>
                            @foreach ($medicamento as $item)
                                <option value="{{ $item->id }}">{{ $item->nome }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control dose" name="dose[]" placeholder="Dose">
                    </td>
                    <td>
                        <input type="number" class="form-control hora" name="hora[]" placeholder="Horas">
                    </td>
                    <td>
                        <button type="button" class="btn btn-success add-row">+</button>
                        <button type="button" class="btn btn-danger remove-row">-</button>
                    </td>
                </tr>`;
                $('#prescricao-table-body').append(newRow);
            }

            $(document).on('click', '.add-row', function() {
                addPrescricaoRow();
            });

            $(document).on('click', '.remove-row', function() {
                $(this).closest('.prescricao-row').remove();
            });

            // Verificar se existem dados no banco antes de carregar o formulário
            $.ajax({
                url: `/medicamento/${agenda_id}/${paciente_id}`,
                type: 'GET',
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(remedio) {
                            addPrescricaoRow();
                            $('#prescricao-table-body').find('.prescricao-row:last').find(
                                '.medicamento_id').val(remedio.medicamento_id);
                            $('#prescricao-table-body').find('.prescricao-row:last').find(
                                '.dose').val(remedio.dose);
                            $('#prescricao-table-body').find('.prescricao-row:last').find(
                                '.hora').val(remedio.hora);
                        });
                    }
                },
                error: function() {
                    console.log('Erro ao carregar dados do banco.');
                }
            });

            $('#saveRemedioButton').on('click', function(event) {
                event.preventDefault(); // Previne o envio padrão do formulário

                var url = '/medicamento/store';
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $('#remedioForm').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function() {
                        alert('Prescrição de remédios cadastrada/atualizada com sucesso');
                    },
                    error: function() {
                        alert('Ocorreu um erro. Tente novamente.');
                    }
                });
            });
        });


        $(document).ready(function() {
            var agenda_id = "{{ $agendas->id }}";
            var paciente_id = "{{ $pacientes->id }}"; // Corrigido o typo "paceinte_id"

            function addExameRow() {
                var newRow = `
        <tr class="exame-row">
            <td>
            <select class="select2 form-control procedimento_id" name="procedimento_id[]" 
                    id="procedimento_id" style="width: 100%" required onchange="updateCodigo(this)">
                <option value="" data-codigo="">Selecione o Procedimento</option>
                @foreach ($procedimento as $item)
                    <option value="{{ $item->id }}" data-codigo="{{ $item->codigo }}">
                        {{ $item->procedimento }}
                    </option>
                @endforeach
            </select>
        </td>
        <td>
            <input type="text" class="form-control codigo" name="codigo[]" placeholder="Código" readonly>
        </td>
            <td class="actions">
                <button type="button" class="btn btn-success plus-row">+</button>
                <button type="button" class="btn btn-danger delete-row">-</button>
            </td>
        </tr>`;
                $('#exame-table-body').append(newRow);
            }

            // Adiciona uma nova linha de procedimento ao clicar no botão '+'
            $(document).on('click', '.plus-row', function() {
                addExameRow();
            });

            // Remove uma linha de procedimento ao clicar no botão '-'
            $(document).on('click', '.delete-row', function() {
                $(this).closest('.exame-row').remove();
            });

            // Verificar se existem dados no banco antes de carregar o formulário
            $.ajax({
                url: `/procedimentos/${agenda_id}/${paciente_id}`,
                type: 'GET',
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(item) {
                            addExameRow();
                            $('#exame-table-body').find('.exame-row:last').find(
                                '.procedimento_id').val(item.procedimento_id);
                            $('#exame-table-body').find('.exame-row:last').find('.codigo').val(
                                item.codigo);
                        });
                    }
                },
                error: function(response) {
                    console.log('Erro ao carregar dados do banco.');
                }
            });

            // Salvar os procedimentos via AJAX
            $('#saveExameButton').on('click', function(event) {
                event.preventDefault(); // Previne o envio padrão do formulário

                var url = '/procedimentos/store'; // A URL correta para a rota POST

                $.ajax({
                    url: url,
                    type: 'POST', // Certifique-se de que está utilizando POST
                    data: $('#exameForm').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Procedimentos cadastrados/atualizados com sucesso');
                    },
                    error: function(xhr) {
                        alert('Erro: ' + xhr.responseText);
                    }
                });
            });

        });


        $(document).ready(function() {
            var agenda_id = "{{ $agendas->id }}";
            var paciente_id = "{{ $pacientes->id }}"; // Correção no typo

            function addMaterialRow() {
                var newRow = `
        <tr class="material-row">
            <td>
                <select class="form-control material_id" name="material_id[]">
                    <option value="">Selecione o Material</option>
                    @foreach ($produto as $item)
                        <option value="{{ $item->id }}">{{ $item->nome }}</option>
                    @endforeach
                </select>
            </td>
            <td class="actions">
                <button type="button" class="btn btn-success plus1-row">+</button>
                <button type="button" class="btn btn-danger delete1-row">-</button>
            </td>
        </tr>`;
                $('#material-table-body').append(newRow);
            }

            // Adiciona uma nova linha de material ao clicar no botão '+'
            $(document).on('click', '.plus1-row', function() {
                addMaterialRow();
            });

            // Remove uma linha de material ao clicar no botão '-'
            $(document).on('click', '.delete1-row', function() {
                $(this).closest('.material-row').remove();
            });

            // Verificar se existem dados no banco antes de carregar o formulário
            $.ajax({
                url: `/material/${agenda_id}/${paciente_id}`,
                type: 'GET',
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(item) {
                            addMaterialRow();
                            $('#material-table-body').find('.material-row:last').find(
                                '.material_id').val(item.material_id);
                        });
                    }
                },
                error: function(response) {
                    console.log('Erro ao carregar dados do banco.');
                }
            });

            // Salvar os materiais via AJAX
            $('#saveMaterialButton').on('click', function(event) {
                event.preventDefault(); // Previne o envio padrão do formulário

                var url = '/material/store';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $('#materialForm').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Materiais cadastrados/atualizados com sucesso');
                    },
                    error: function(xhr) {
                        console.error(xhr
                        .responseText); // Exibir erro no console para depuração
                        alert('Erro: ' + xhr.responseText);
                    }
                });
            });
        });

        $(document).ready(function() {
            var agenda_id = "{{ $agendas->id }}";
            var paciente_id = "{{ $pacientes->id }}"; // Correção no typo

            function addTaxaRow() {
                var newRow = `
        <tr class="taxa-row">
            <td>
                <select class="form-control taxa_id" name="taxa_id[]">
                    <option value="">Selecione o Taxa</option>
                    @foreach ($produto as $item)
                        <option value="{{ $item->id }}">{{ $item->nome }}</option>
                    @endforeach
                </select>
            </td>
            <td class="actions">
                <button type="button" class="btn btn-success plus2-row">+</button>
                <button type="button" class="btn btn-danger delete2-row">-</button>
            </td>
        </tr>`;
                $('#taxa-table-body').append(newRow);
            }

            // Adiciona uma nova linha de material ao clicar no botão '+'
            $(document).on('click', '.plus2-row', function() {
                addTaxaRow();
            });

            // Remove uma linha de material ao clicar no botão '-'
            $(document).on('click', '.delete2-row', function() {
                $(this).closest('.taxa-row').remove();
            });

            // Verificar se existem dados no banco antes de carregar o formulário
            $.ajax({
                url: `/taxa/${agenda_id}/${paciente_id}`,
                type: 'GET',
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(item) {
                            addTaxaRow();
                            $('#taxa-table-body').find('.taxa-row:last').find(
                                '.taxa_id').val(item.taxa_id);
                        });
                    }
                },
                error: function(response) {
                    console.log('Erro ao carregar dados do banco.');
                }
            });

            // Salvar os materiais via AJAX
            $('#saveTaxaButton').on('click', function(event) {
                event.preventDefault(); // Previne o envio padrão do formulário

                var url = '/taxa/store';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: $('#taxaForm').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Taxa cadastradas/atualizadas com sucesso');
                    },
                    error: function(xhr) {
                        console.error(xhr
                        .responseText); // Exibir erro no console para depuração
                        alert('Erro: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>

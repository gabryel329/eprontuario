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
/* Estilo do Select2 para se parecer com o campo da imagem */
.select2-container--default .select2-selection--single {
    height: 38px; /* Ajusta a altura conforme necessário */
    display: flex;
    align-items: center;
    padding: 0 0.75rem;
    font-size: 1rem;
    border: 1px solid #ced4da; /* Cor da borda */
    border-radius: 4px; /* Borda arredondada */
    background-color: #fff; /* Fundo branco */
    box-shadow: none; /* Remove sombras */
    font-family: "Lato", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

/* Remove a seta */
.select2-container--default .select2-selection--single .select2-selection__arrow {
    display: none;
}

/* Centraliza o texto no meio verticalmente e aplica a fonte */
.select2-container--default .select2-selection--single .select2-selection__rendered {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: left; /* Alinhado à esquerda */
    padding: 0;
    color: #495057; /* Cor do texto */
    text-align: left;
    font-family: "Lato", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

/* Remove o botão de limpar (X) */
.select2-container--default .select2-selection--single .select2-selection__clear {
    display: none;
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
                                                    {{-- Gera Exame --}}
                                                </tbody>
                                                <tbody id="exame-table-body">
                                                    <tr class="exame-row">
                                                        <td>
                                                            <select name="procedimento_id[]" id="procedimento_id" required>
                                                                <option value="" data-codigo="">Selecione o Procedimento</option>
                                                                @foreach ($procedimento as $item)
                                                                    <option value="{{ $item->id }}" data-codigo="{{ $item->codigo }}">
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
                                                {{-- Aqui gera o do Banco --}}
                                            </tbody>
                                            <tbody id="prescricao-table-body_new">
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
                                                    {{-- Gera Material --}}
                                                </tbody>
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
                                                    {{-- Gera Taxa --}}
                                                </tbody>
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
    <!-- JS do Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
    function applySelect2(element) {
        element.select2({
            placeholder: "Selecione o Procedimento",
            allowClear: false,
            closeOnSelect: true,
            width: '100%'
        }).on('select2:select', function(e) {
            updateCodigo(this); // Chama updateCodigo ao selecionar uma opção
        });
    }

    function updateCodigo(selectElement) {
        const row = selectElement.closest('.exame-row'); // Encontra a linha mais próxima
        const codigoInput = row.querySelector('input[name="codigo[]"]'); // Campo de código
        const selectedOption = selectElement.options[selectElement.selectedIndex]; // Opção selecionada
        codigoInput.value = selectedOption.getAttribute('data-codigo'); // Define o código
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
                <td><input type="number" class="form-control dose" name="dose[]" placeholder="Dose"></td>
                <td><input type="number" class="form-control hora" name="hora[]" placeholder="Horas"></td>
                <td>
                    <button type="button" class="btn btn-success add-row">+</button>
                    <button type="button" class="btn btn-danger remove-row">-</button>
                </td>
            </tr>`;
        $('#prescricao-table-body').append(newRow);
        applySelect2($('#prescricao-table-body select:last')); // Aplica Select2 ao novo select
    }

    // Função para carregar medicamentos registrados do banco
    $.ajax({
        url: `/medicamento/${agenda_id}/${paciente_id}`,
        type: 'GET',
        success: function(response) {
            if (response.data && response.data.length > 0) {
                response.data.forEach(function(remedio) {
                    addPrescricaoRow();
                    const lastRow = $('#prescricao-table-body').find('.prescricao-row:last');
                    lastRow.find('.medicamento_id').val(remedio.medicamento_id).trigger('change'); // Dispara 'change'
                    lastRow.find('.dose').val(remedio.dose);
                    lastRow.find('.hora').val(remedio.hora);
                });
            }
        },
        error: function() {
            console.log('Erro ao carregar dados do banco.');
        }
    });

    // Adicionar e remover linhas dinamicamente
    $(document).on('click', '.add-row', function() {
        addPrescricaoRow();
    });

    $(document).on('click', '.remove-row', function() {
        $(this).closest('.prescricao-row').remove();
    });

    // Salvar medicamentos via AJAX
    $('#saveRemedioButton').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: '/medicamento/store',
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

    // Aplicar Select2 aos selects iniciais
    applySelect2($('select'));
});


        $(document).ready(function() {
            applySelect2($('select')); // Aplica Select2 aos selects existentes

            function addExameRow() {
                var newRow = `
                    <tr class="exame-row">
                        <td>
                            <select class="select2 form-control procedimento_id" name="procedimento_id[]" required>
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
                applySelect2($('#exame-table-body select:last')); // Aplica Select2 ao novo select
            }

            $(document).on('click', '.plus-row', function() {
                addExameRow();
            });

            $(document).on('click', '.delete-row', function() {
                $(this).closest('.exame-row').remove();
            });

            var agenda_id = "{{ $agendas->id }}";
            var paciente_id = "{{ $pacientes->id }}";

            $.ajax({
                url: `/procedimentos/${agenda_id}/${paciente_id}`,
                type: 'GET',
                success: function(response) {
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(item) {
                            addExameRow();
                            const lastRow = $('#exame-table-body').find('.exame-row:last');
                            lastRow.find('.procedimento_id').val(item.procedimento_id).trigger('change'); // Dispara 'change'
                            lastRow.find('.codigo').val(item.codigo);
                        });
                    }
                },
                error: function(response) {
                    console.log('Erro ao carregar dados do banco.');
                }
            });

            $('#saveExameButton').on('click', function(event) {
                event.preventDefault();
                var url = '/procedimentos/store';

                $.ajax({
                    url: url,
                    type: 'POST',
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
        var paciente_id = "{{ $pacientes->id }}";

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
            applySelect2($('#material-table-body select:last'));
        }

        function addTaxaRow() {
            var newRow = `
            <tr class="taxa-row">
                <td>
                    <select class="form-control taxa_id" name="taxa_id[]">
                        <option value="">Selecione a Taxa</option>
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
            applySelect2($('#taxa-table-body select:last'));
        }

        // Eventos para adicionar e remover linhas
        $(document).on('click', '.plus1-row', function() {
            addMaterialRow();
        });

        $(document).on('click', '.delete1-row', function() {
            $(this).closest('.material-row').remove();
        });

        $(document).on('click', '.plus2-row', function() {
            addTaxaRow();
        });

        $(document).on('click', '.delete2-row', function() {
            $(this).closest('.taxa-row').remove();
        });

        // Verificação e carregamento de dados do banco
        $.ajax({
            url: `/material/${agenda_id}/${paciente_id}`,
            type: 'GET',
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(item) {
                        addMaterialRow();
                        $('#material-table-body').find('.material-row:last').find('.material_id').val(item.material_id).trigger('change');
                    });
                }
            },
            error: function() {
                console.log('Erro ao carregar materiais.');
            }
        });

        $.ajax({
            url: `/taxa/${agenda_id}/${paciente_id}`,
            type: 'GET',
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    response.data.forEach(function(item) {
                        addTaxaRow();
                        $('#taxa-table-body').find('.taxa-row:last').find('.taxa_id').val(item.taxa_id).trigger('change');
                    });
                }
            },
            error: function() {
                console.log('Erro ao carregar taxas.');
            }
        });

        // Salvar materiais e taxas via AJAX
        $('#saveMaterialButton').on('click', function(event) {
            event.preventDefault();
            $.ajax({
                url: '/material/store',
                type: 'POST',
                data: $('#materialForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function() {
                    alert('Materiais cadastrados/atualizados com sucesso');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Erro: ' + xhr.responseText);
                }
            });
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

        // Aplicar Select2 aos selects iniciais
        applySelect2($('select'));
    });
</script>
</body>
</html>

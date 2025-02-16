@extends('layouts.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    .form-label {
        display: block;
        margin-bottom: 0.5em;
    }

    .form-control {
        width: 100%;
        padding: 0.5em;
    }

    .hidden {
        display: none;
    }
</style>
@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-ui-checks"></i> Consultar Agenda</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Consultar Agenda</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="timeline-post">
                <div class="tab-content">
                    <div class="col-md-12">
                        <div class="tile">
                            <div class="tile-body">
                                <form id="filtro-agenda" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="mb-3 col-md-3">
                                            <label for="data_inicio">Data Início:</label>
                                            <input type="date" name="data_inicio" id="data_inicio" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="data_fim">Data Fim:</label>
                                            <input type="date" name="data_fim" id="data_fim" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="profissional_id">Profissional:</label>
                                            <select name="profissional_id" id="profissional_id" class="form-control">
                                                <option value="">Selecione um Profissional</option>
                                                @foreach ($profissionais as $profissional)
                                                    <option value="{{ $profissional->id }}"> {{ $profissional->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="especialidade_id">Especialidade:</label>
                                            <select name="especialidade_id" id="especialidade_id" class="select2 form-control">
                                                <option value="">Selecione uma Especialidade</option>
                                                @foreach ($especialidades as $especialidade)
                                                    <option value="{{ $especialidade->id }}"> {{ $especialidade->especialidade }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="filtrar-btn">Filtrar</button>
                                </form>

                                <!-- Exibição das Disponibilidades -->
                                <div id="disponibilidades-agenda">
                                    <!-- Dias da Semana que o profissional atende aparecerão aqui -->
                                </div>

                                <!-- Exibição dos Resultados da Agenda -->
                                <button class="btn btn-primary mt-3" onclick="imprimirAgenda()">Imprimir Agenda</button>
                                <div id="resultados-agenda">
                                    <!-- Resultados da Agenda vão aparecer aqui -->
                                </div>

                                <!-- Exibição de mensagens de erro -->
                                <div id="mensagem-erro" class="alert alert-danger hidden"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#filtrar-btn').on('click', function() {
            const dataInicio = $('#data_inicio').val();
            const dataFim = $('#data_fim').val();
            const profissionalId = $('#profissional_id').val();
            const especialidadeId = $('#especialidade_id').val();

            $.ajax({
                url: '{{ route("agenda.filtrar") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    data_inicio: dataInicio,
                    data_fim: dataFim,
                    profissional_id: profissionalId,
                    especialidade_id: especialidadeId
                },
                success: function(response) {
                    // Limpa mensagem de erro
                    $('#mensagem-erro').addClass('hidden').html('');

                    // Mostrar os dias de disponibilidade
                    let disponibilidadeHtml = '';
                    if (response.disponibilidades) {
                        disponibilidadeHtml += '<h4>Dias de Atendimento:</h4>';
                        disponibilidadeHtml += '<table class="table table-bordered"><thead><tr>';
                        if (response.disponibilidades.dom) disponibilidadeHtml += '<th>Domingo</th>';
                        if (response.disponibilidades.seg) disponibilidadeHtml += '<th>Segunda-feira</th>';
                        if (response.disponibilidades.ter) disponibilidadeHtml += '<th>Terça-feira</th>';
                        if (response.disponibilidades.qua) disponibilidadeHtml += '<th>Quarta-feira</th>';
                        if (response.disponibilidades.qui) disponibilidadeHtml += '<th>Quinta-feira</th>';
                        if (response.disponibilidades.sex) disponibilidadeHtml += '<th>Sexta-feira</th>';
                        if (response.disponibilidades.sab) disponibilidadeHtml += '<th>Sábado</th>';
                        disponibilidadeHtml += '</tr></thead></table>';
                    } else {
                        disponibilidadeHtml = '<p>Sem disponibilidade para os dias selecionados.</p>';
                    }
                    $('#disponibilidades-agenda').html(disponibilidadeHtml);

                    // Mostrar as agendas filtradas em tabela
                    let agendaHtml = '<br>';
                    agendaHtml += '<table class="table table-bordered"><thead><tr><th>Data/Hora</th><th>Paciente</th><th>Procedimento</th><th>Convênio</th></tr></thead><tbody>';
                    if (response.agendas.length > 0) {
                        response.agendas.forEach(function(agenda) {
                            const dataFormatada = new Date(agenda.data).toLocaleDateString('pt-BR', {
                                day: '2-digit',
                                month: '2-digit',
                                year: 'numeric'
                            });
                            const pacienteNome = agenda.paciente_nome ? agenda.paciente_nome : 'Paciente não encontrado';
                            const convenioNome = agenda.convenio_id ? agenda.convenio_id : 'Convênio não encontrado';
                            agendaHtml += '<tr><td>' + dataFormatada+' - '+agenda.hora + '</td><td>' + pacienteNome + '</td><td>' + agenda.procedimento_id + '</td><td>' + convenioNome + '</td></tr>';
                        });
                    } else {
                        agendaHtml += '<tr><td colspan="3">Nenhuma agenda encontrada.</td></tr>';
                    }
                    agendaHtml += '</tbody></table>';
                    $('#resultados-agenda').html(agendaHtml);
                },
                error: function(xhr) {
                    // Exibir mensagem de erro
                    let errorResponse = JSON.parse(xhr.responseText);
                    $('#mensagem-erro').removeClass('hidden').html('<p>' + errorResponse.error + '</p>');
                }
            });
        });
    });

    function imprimirAgenda() {
    var conteudo = document.getElementById('resultados-agenda').innerHTML;
    var janelaImpressao = window.open('', '', 'width=900,height=650');

    janelaImpressao.document.write(`
        <html>
        <head>
            <title>Ficha de Agenda Médica</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    color: #333;
                    padding: 30px;
                    background: #fff;
                    line-height: 1.6;
                }

                .print-header {
                    text-align: center;
                    font-size: 24px;
                    font-weight: bold;
                    margin-bottom: 20px;
                    padding: 15px;
                    border-bottom: 3px solid #007bff;
                    color: #007bff;
                }

                .medico-info {
                    text-align: center;
                    font-size: 18px;
                    font-weight: bold;
                    margin-bottom: 20px;
                    color: #555;
                }

                .agenda-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px;
                }

                .agenda-table th, .agenda-table td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                    font-size: 14px;
                }

                .agenda-table thead th {
                    background-color: #007bff !important;
                    color: white;
                    font-size: 16px;
                    text-transform: uppercase;
                    position: sticky;
                    top: 0;
                    z-index: 1000;
                }

                .agenda-table tr:nth-child(even) {
                    background-color: #f9f9f9;
                }

                .agenda-table tr:hover {
                    background-color: #f1f1f1;
                }

                .rodape {
                    margin-top: 40px;
                    text-align: center;
                    font-size: 14px;
                    color: #777;
                    border-top: 2px solid #ddd;
                    padding-top: 10px;
                }

                .assinatura {
                    margin-top: 50px;
                    text-align: center;
                    font-size: 16px;
                    font-weight: bold;
                }

                .assinatura .linha {
                    margin-top: 40px;
                    border-top: 2px solid #333;
                    width: 250px;
                    margin-left: auto;
                    margin-right: auto;
                    padding-top: 5px;
                }

                @media print {
                    body {
                        margin: 0;
                        padding: 10px;
                    }

                    .print-header {
                        position: relative;
                        top: 0;
                        width: 100%;
                        background: white;
                        padding: 10px;
                        font-size: 22px;
                        font-weight: bold;
                        margin-bottom: 20px;
                    }

                    .agenda-table {
                        margin-top: 60px;
                    }

                    .agenda-table thead {
                        display: table-header-group;
                    }

                    .agenda-table tbody tr:first-child td {
                        border-top: 2px solid #007bff;
                    }

                    .assinatura {
                        page-break-before: always;
                    }
                }
            </style>
        </head>
        <body>
            <div class="print-header">Ficha de Atendimento Médico</div>

            <div class="medico-info">
                <p><strong>Data da Agenda:</strong> ${new Date().toLocaleDateString()}</p>
            </div>

            <table class="agenda-table">
                <thead>
                    <tr>
                        <th>Paciente</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Procedimento</th>
                    </tr>
                </thead>
                <tbody>
                    ${conteudo}
                </tbody>
            </table>

            <div class="assinatura">
                <p class="linha"></p>
                <p>Assinatura do Médico</p>
            </div>

            <div class="rodape">
                <p>Ficha gerada automaticamente pelo sistema</p>
            </div>
        </body>
        </html>
    `);

    janelaImpressao.document.close();
    janelaImpressao.print();
}

</script>
@endsection

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
            <h1><i class="bi bi-ui-checks"></i> Relatório das Guias</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item"><a href="#">Relatório das Guias</a></li>
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
                                        <div class="mb-3 col-md-2">
                                            <label for="data_inicio">Data Início:</label>
                                            <input type="date" name="data_inicio" id="data_inicio" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label for="data_fim">Data Fim:</label>
                                            <input type="date" name="data_fim" id="data_fim" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="lote">Lote:</label>
                                            <input type="text" name="lote" id="lote" class="form-control">
                                        </div>
                                        <div class="mb-3 col-md-3">
                                            <label for="convenio_id">Convênio:</label>
                                            <select name="convenio_id" id="convenio_id" class="form-control">
                                                <option value="">Selecione um convenio</option>
                                                @foreach ($convenios as $convenio)
                                                    <option value="{{ $convenio->id }}"> {{ $convenio->nome }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-2">
                                            <label for="especialidade_id">Tipo de Guia</label>
                                            <select name="tipo_guia" id="tipo_guia" class="form-control">
                                                <option value="" selected>Selecione um Tipo</option>
                                                <option value="1">SADT</option>
                                                <option value="2">Consulta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary" id="filtrar-btn">Filtrar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="timeline-post">
                <div class="tab-content">
                    <div class="col-md-12">
                        <div class="tile">
                            <div class="tile-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Guia</th>
                                            <th>Data</th>
                                            <th>Profissional</th>
                                            <th>Lote</th>
                                            <th>Paciente</th>
                                            <th>Visualizar</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabela-resultados">
                                        <!-- Os resultados serão inseridos aqui -->
                                    </tbody>
                                </table>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $("#filtrar-btn").click(function () {
        let tipoGuia = $("#tipo_guia").val();
        
        let formData = {
            _token: "{{ csrf_token() }}",
            data_inicio: $("#data_inicio").val(),
            data_fim: $("#data_fim").val(),
            lote: $("#lote").val(),
            convenio_id: $("#convenio_id").val(),
            tipo_guia: tipoGuia
        };

        $.ajax({
            url: "{{ route('relatorioGuia.result') }}", // Defina a rota no Laravel
            type: "POST",
            data: formData,
            success: function (response) {
                let tabela = $("#tabela-resultados");
                tabela.empty(); // Limpa os resultados antigos

                if (response.length > 0) {
                    response.forEach(item => {
                        let dataFormatada = new Date(item.data).toLocaleDateString('pt-BR');
                        let guiaUrl = tipoGuia == 1 
                            ? `{{ route('guia.sadt', ['id' => '__ID__']) }}`.replace('__ID__', item.agenda_id)
                            : `{{ route('guia.consulta2', ['id' => '__ID__']) }}`.replace('__ID__', item.agenda_id);

                        let linha = `
                            <tr>
                                <td>${item.id}</td>
                                <td>${dataFormatada}</td>
                                <td>${item.profissional}</td>
                                <td>${item.numeracao || 'N/A'}</td>
                                <td>${item.paciente || 'N/A'}</td>
                                <td>
                                    <a href="#" class="btn btn-success open-window" data-url="${guiaUrl}">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                        tabela.append(linha);
                    });
                } else {
                    tabela.append(`<tr><td colspan="6" class="text-center">Nenhum resultado encontrado</td></tr>`);
                }
            },
            error: function () {
                alert("Erro ao buscar dados. Tente novamente.");
            }
        });
    });

    // Ao clicar no link, abrir em uma nova janela separada
    $(document).on('click', '.open-window', function (e) {
        e.preventDefault(); // Impede o comportamento padrão do link
        let url = $(this).data('url');

        // Abrir em uma nova janela com tamanho específico
        window.open(url, '_blank', 'width=900,height=600,top=100,left=100');
    });
});

</script>


@endsection

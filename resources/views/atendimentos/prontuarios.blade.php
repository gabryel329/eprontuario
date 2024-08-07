@extends('layouts.app')

@section('styles')
    <style>
        .selected-info {
            margin-left: 15px;
            font-size: 1rem;
            color: #666;
        }
    </style>
@endsection

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Consultar Prontuários</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Atendimento</li>
                <li class="breadcrumb-item"><a href="#">Prontuários</a></li>
            </ul>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-warning">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <form method="GET" action="{{ route('atendimento.lista') }}" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label class="form-label">Data</label>
                                    <input name="data" id="data" class="form-control" type="date">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Médico</label>
                                    <select class="form-control" id="profissional_id" name="profissional_id">
                                        <option disabled selected style="font-size:18px;color: black;">Escolha</option>
                                        @foreach ($profissional as $profissional)
                                            <option value="{{ $profissional->id }}">{{ $profissional->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">Paciente</label>
                                    <a type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                                        data-bs-target="#pacienteModal">
                                        <i class="bi bi-person-add"></i>
                                    </a>
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Nome</label>
                                    <input class="form-control" id="edit-name" name="nome" type="text" readonly>
                                    <input type="hidden" id="paciente_id" name="paciente_id">
                                </div>
                            </div>
                            <div class="tile-footer mt-3">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-3">
                                        <button class="btn btn-primary" type="submit" onclick="showAdditionalFields()"><i
                                                class="bi bi-check-circle-fill me-2"></i>Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        @if ($historico->isEmpty())
                            <p>Nenhum registro encontrado.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Data</th>
                                            <th>Paciente</th>
                                            <th>Profissional</th>
                                            <th>Consulta</th>
                                            <th>Procedimento</th>
                                            <th>Visualizar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($historico as $historico)
                                            <tr>
                                                <td>{{ $historico->consulta }}</td>
                                                <td>{{ $historico->data }}</td>
                                                <td>{{ $historico->paciente }}</td>
                                                <td>{{ $historico->profissional }}</td>
                                                <td>{{ $historico->consulta }}</td>
                                                <td>{{ $historico->procedimento }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal-{{ $historico->consulta }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="exampleModal-{{ $historico->consulta }}"
                                                tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Prontuário
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="responseIA" action="{{ route('ficha') }}" method="POST" target="_blank">
                                                                @csrf
                                                                <input type="hidden" name="mae" value="{{ $historico->mae }}">
                                                                <input type="hidden" name="genero" value="{{ $historico->genero }}">
                                                                <input type="hidden" name="paciente"
                                                                    value="{{ $historico->paciente }}">
                                                                <input type="hidden" name="consulta"
                                                                    value="{{ $historico->consulta }}">
                                                                <input type="hidden" name="cpf"
                                                                    value="{{ $historico->cpf }}">
                                                                <input type="hidden" name="nasc"
                                                                    value="{{ $historico->nasc }}">
                                                                <div class="row user">
                                                                    <div class="col-md-12">
                                                                        <ul class="nav nav-tabs user-tabs">
                                                                            <li class="nav-item"><a
                                                                                    class="nav-link active"
                                                                                    href="#atendimento-anamnese-{{ $historico->consulta }}"
                                                                                    data-bs-toggle="tab">Anamnese</a></li>
                                                                            <li class="nav-item"><a class="nav-link"
                                                                                    href="#atendimento-atendimento-{{ $historico->consulta }}"
                                                                                    data-bs-toggle="tab">Atendimento</a>
                                                                            </li>
                                                                            <li class="nav-item"><a class="nav-link"
                                                                                    href="#atendimento-prescricao-{{ $historico->consulta }}"
                                                                                    data-bs-toggle="tab">Prescrição</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="tab-content">
                                                                            <div class="tab-pane active"
                                                                                id="atendimento-anamnese-{{ $historico->consulta }}">
                                                                                <div class="timeline-post">
                                                                                    <h4 class="line-head">Anamnese</h4>
                                                                                    <div class="row mb-12">
                                                                                        <div class="col-md-12">
                                                                                            <div class="tile-body">
                                                                                                <div class="row">
                                                                                                    @include(
                                                                                                        'partials.anamnese',
                                                                                                        [
                                                                                                            'historico' => $historico,
                                                                                                        ]
                                                                                                    )
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="tab-pane fade"
                                                                                id="atendimento-atendimento-{{ $historico->consulta }}">
                                                                                <div class="timeline-post">
                                                                                    <h4 class="line-head">Atendimento</h4>
                                                                                    <div class="col-md-12">
                                                                                        <ul class="nav nav-tabs user-tabs">
                                                                                            <li class="nav-item"><a
                                                                                                    class="nav-link active"
                                                                                                    href="#atendimento-queixa-{{ $historico->consulta }}"
                                                                                                    data-bs-toggle="tab">Queixa
                                                                                                    Principal</a></li>
                                                                                            <li class="nav-item"><a
                                                                                                    class="nav-link"
                                                                                                    href="#atendimento-evolucao-{{ $historico->consulta }}"
                                                                                                    data-bs-toggle="tab">Evolução</a>
                                                                                            </li>
                                                                                            {{-- <li class="nav-item"><a
                                                                                                    class="nav-link"
                                                                                                    href="#atendimento-atestado-{{ $historico->consulta }}"
                                                                                                    data-bs-toggle="tab">Solicitações</a>
                                                                                            </li> --}}
                                                                                            <li class="nav-item"><a
                                                                                                    class="nav-link"
                                                                                                    href="#atendimento-condicao-{{ $historico->consulta }}"
                                                                                                    data-bs-toggle="tab">Condição
                                                                                                    Fisica</a></li>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="tab-content">
                                                                                            <div class="tab-pane active"
                                                                                                id="atendimento-queixa-{{ $historico->consulta }}">
                                                                                                <div class="timeline-post">
                                                                                                    <h4 class="line-head">
                                                                                                        Queixa Principal
                                                                                                    </h4>
                                                                                                    <div class="row mb-12">
                                                                                                        <div
                                                                                                            class="col-md-12">
                                                                                                            <textarea class="form-control atendimentoIA" id="queixas" rows="15" name="atendimento[at_queixas]" readonly>{{ $historico->at_queixas }}</textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane fade"
                                                                                                id="atendimento-evolucao-{{ $historico->consulta }}">
                                                                                                <div class="timeline-post">
                                                                                                    <h4 class="line-head">
                                                                                                        Evolução</h4>
                                                                                                    <div class="row mb-12">
                                                                                                        <div
                                                                                                            class="col-md-12">
                                                                                                            <textarea class="form-control atendimentoIA" rows="15" id="evolucao" name="atendimento[at_evolucao]" readonly>{{ $historico->at_evolucao }}</textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            {{-- <div class="tab-pane fade"
                                                                                                id="atendimento-atestado-{{ $historico->consulta }}">
                                                                                                <div class="timeline-post">
                                                                                                    <h4 class="line-head">
                                                                                                        Solicitações</h4>
                                                                                                    <div class="row mb-12">
                                                                                                        <div
                                                                                                            class="col-md-12">
                                                                                                            <textarea class="form-control" rows="15" id="atestado" name="atendimento[at_atestado]" readonly>{{ $historico->at_atestado }}</textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div> --}}
                                                                                            <div class="tab-pane fade"
                                                                                                id="atendimento-condicao-{{ $historico->consulta }}">
                                                                                                <div class="timeline-post">
                                                                                                    <h4 class="line-head">
                                                                                                        Condição Fisica</h4>
                                                                                                    <div class="row mb-12">
                                                                                                        <div
                                                                                                            class="col-md-12">
                                                                                                            <textarea class="form-control atendimentoIA" rows="15" id="condicao" name="atendimento[at_condicao]" readonly>{{ $historico->at_condicao }}</textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="tab-pane fade"
                                                                                id="atendimento-prescricao-{{ $historico->consulta }}">
                                                                                <div class="timeline-post">
                                                                                    <h4 class="line-head">Prescrição</h4>
                                                                                    <div class="col-md-12">
                                                                                        <ul class="nav nav-tabs user-tabs">
                                                                                            <li class="nav-item"><a
                                                                                                    class="nav-link active"
                                                                                                    href="#prescricao-exame-{{ $historico->consulta }}"
                                                                                                    data-bs-toggle="tab">Exame</a>
                                                                                            </li>
                                                                                            <li class="nav-item"><a
                                                                                                    class="nav-link"
                                                                                                    href="#prescricao-remedio-{{ $historico->consulta }}"
                                                                                                    data-bs-toggle="tab">Remédio</a>
                                                                                            </li>
                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="tab-content">
                                                                                            <div class="tab-pane active"
                                                                                                id="prescricao-exame-{{ $historico->consulta }}">
                                                                                                <div class="timeline-post">
                                                                                                    <h4 class="line-head">
                                                                                                        Exames</h4>
                                                                                                    <div class="row mb-12">
                                                                                                        <div
                                                                                                            class="col-md-12">
                                                                                                            <label
                                                                                                                class="form-label"><strong>Exames</strong></label>
                                                                                                            <div
                                                                                                                class="row">
                                                                                                                @foreach ($historico->exames as $exame)
                                                                                                                    <div
                                                                                                                        class="col-md-12">
                                                                                                                        <input
                                                                                                                            type="text"
                                                                                                                            class="form-control mb-2 prescricaoIA"
                                                                                                                            value="{{ $exame }}"
                                                                                                                            name="prescricao[exames][]"
                                                                                                                            readonly>
                                                                                                                    </div>
                                                                                                                @endforeach
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="tab-pane"
                                                                                                id="prescricao-remedio-{{ $historico->consulta }}">
                                                                                                <div class="timeline-post">
                                                                                                    <h4 class="line-head">
                                                                                                        Remédios</h4>
                                                                                                    <div class="row mb-12">
                                                                                                        <div
                                                                                                            class="col-md-4">
                                                                                                            <label
                                                                                                                class="form-label"><strong>Remédios</strong></label>
                                                                                                            @foreach ($historico->remedios as $index => $remedio)
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    class="form-control mb-2 prescricaoIA"
                                                                                                                    value="{{ $remedio }}"
                                                                                                                    name="prescricao[remedios][]"
                                                                                                                    readonly>
                                                                                                            @endforeach
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-md-4">
                                                                                                            <label
                                                                                                                class="form-label"><strong>Doses</strong></label>
                                                                                                            @foreach ($historico->doses as $index => $dose)
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    class="form-control mb-2"
                                                                                                                    value="{{ $dose }}"
                                                                                                                    name="prescricao[doses][]"
                                                                                                                    readonly>
                                                                                                            @endforeach
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="col-md-4">
                                                                                                            <label
                                                                                                                class="form-label"><strong>Horas</strong></label>
                                                                                                            @foreach ($historico->horas as $index => $hora)
                                                                                                                <input
                                                                                                                    type="text"
                                                                                                                    class="form-control mb-2"
                                                                                                                    value="{{ $hora }}"
                                                                                                                    name="prescricao[horas][]"
                                                                                                                    readonly>
                                                                                                            @endforeach
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tile-footer">
                                                                    <div class="row d-print-none mt-2">
                                                                        <div class="col-12 text-end">
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Imprimir</button>
                                                                            <button type="button" id="responseIA" title="Saiba a opinião da nossa IA." class="btn btn-outline-danger" onclick="handleResponseIA()">Doctor IA</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <div id="response"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pacienteModalLabel">Selecione o Paciente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" id="pacienteSearch" type="text"
                            placeholder="Pesquisar por nome ou CPF...">
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="pacienteTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>CNS</th>
                                    <th>Ação</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paciente as $paciente)
                                    <tr>
                                        <td>{{ $paciente->id }}</td>
                                        <td>{{ $paciente->name }}</td>
                                        <td>{{ $paciente->cpf }}</td>
                                        <td>{{ $paciente->sus }}</td>
                                        <td>
                                            <button class="btn btn-primary" type="button"
                                                onclick="selectPaciente('{{ $paciente->id }}', '{{ $paciente->name }}')">Selecionar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function selectPaciente(id, nome) {
            document.getElementById('paciente_id').value = id;
            document.getElementById('edit-name').value = nome;
            $('#pacienteModal').modal('hide');
        }
    
        document.getElementById('pacienteSearch').addEventListener('keyup', function() {
            var value = this.value.toLowerCase();
            document.querySelectorAll('#pacienteTable tbody tr').forEach(function(row) {
                var text = row.textContent.toLowerCase();
                row.style.display = text.includes(value) ? '' : 'none';
            });
        });
    
        function handleResponseIA() {
        // Previne o comportamento padrão do botão se necessário
        event.preventDefault(); 

        // Define os campos do formulário que serão coletados
        const fields = [
            "peso", "altura", "imc", "classificacao", "pa", "temp", "gestante", "dextro", "spo2", "fc", "fr",
            "acolhimento", "acolhimento1", "acolhimento2", "acolhimento3", "acolhimento4",
            "alergia1", "alergia2", "alergia3", "anamnese", "evolucao", "queixas", "condicao"
        ];

        // Coleta os valores dos campos do formulário
        const values = fields.reduce((acc, field) => {
            acc[field] = $('#' + field).val();
            return acc;
        }, {});

        // Constrói o corpo da requisição
        const requestBody = `
            Com base nas seguintes informações médicas preenchidas, por favor, forneça um diagnóstico preliminar:

            Pressão Arterial(PA): ${values.pa}
            Temperatura: ${values.temp}
            Peso: ${values.peso}
            Altura: ${values.altura} cm
            Gestante: ${values.gestante}
            Dextro: ${values.dextro}
            SPO2: ${values.spo2}
            Frequência Cardíaca(FC): ${values.fc}
            Frequência Respiratória(FR): ${values.fr}

            Além disso, considere os seguintes detalhes relacionados a:

            Acolhimentos: ${values.acolhimento}
            Acolhimento 1: ${values.acolhimento1}
            Acolhimento 2: ${values.acolhimento2}
            Acolhimento 3: ${values.acolhimento3}
            Acolhimento 4: ${values.acolhimento4}

            Alergia 1: ${values.alergia1}
            Alergia 2: ${values.alergia2}
            Alergia 3: ${values.alergia3}

            Anamnese Geral: ${values.anamnese}

            Dados do Atendimento:
            Queixas: ${values.queixas}
            Evolução: ${values.evolucao}
            Condição Física: ${values.condicao}

            Considerando essas informações, qual seria um diagnóstico preliminar e recomendações para o tratamento ou acompanhamento?
        `;
        console.log(requestBody);
        // Envia a requisição AJAX
        $.ajax({
            url: '{{ route('generateIA.index') }}', // URL da rota
            method: 'POST',
            data: JSON.stringify({ text: requestBody }), // Dados da requisição
            contentType: 'application/json', // Tipo de conteúdo
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Token CSRF
            },
            success: function(data) {
                $('#response').html(data.text || 'Resposta não encontrada'); // Atualiza o conteúdo do elemento de resposta
            },
            error: function(xhr, status, error) {
                console.error('Erro:', error); // Log de erro no console
                $('#response').html('Erro ao processar a solicitação.'); // Atualiza o conteúdo do elemento de resposta com mensagem de erro
            }
        });
    }
    </script>
    

@endsection

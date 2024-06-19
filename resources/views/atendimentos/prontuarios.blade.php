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
                                <input name="data" id="data" class="form-control" type="date"
                                    required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Médico</label>
                                <select class="form-control" id="profissional_id" name="profissional_id" required>
                                    <option disabled selected style="font-size:18px;color: black;">Escolha</option>
                                    @foreach ($profissional as $profissional)
                                        <option value="{{ $profissional->id }}">{{ $profissional->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Paciente</label>
                                <a type="button" class="btn btn-primary form-control" data-bs-toggle="modal" data-bs-target="#pacienteModal">
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
                                            <td>{{ $historico->data }}</td>
                                            <td>{{ $historico->paciente }}</td>
                                            <td>{{ $historico->profissional }}</td>
                                            <td>{{ $historico->consulta }}</td>
                                            <td>{{ $historico->procedimento }}</td>
                                            <td><button class="btn btn-info"><i class="bi bi-eye-fill"></i></button></td>
                                        </tr>
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
                    <input class="form-control" id="pacienteSearch" type="text" placeholder="Pesquisar por nome ou CPF...">
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="pacienteTable">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CPF</th>
                                <th>CNS</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paciente as $paciente)
                                <tr>
                                    <td>{{ $paciente->name }}</td>
                                    <td>{{ $paciente->cpf }}</td>
                                    <td>{{ $paciente->sus }}</td>
                                    <td>
                                        <button class="btn btn-primary" type="button" onclick="selectPaciente('{{ $paciente->id }}', '{{ $paciente->name }}')">Selecionar</button>
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
</script>
@endsection

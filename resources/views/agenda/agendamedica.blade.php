@extends('layouts.app')

<style>
    .selected-info {
        margin-left: 15px;
        font-size: 1rem;
        color: #666;
    }
</style>

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-ui-checks"></i> Agenda Medica</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Atendimento</li>
            <li class="breadcrumb-item"><a href="#">Agenda Medica</a></li>
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
        <div class="col-md-3">
            <div class="tile">
                <div class="tile-body">
                    <form method="GET" action="{{ route('agenda.agendaMedica') }}" class="form-horizontal">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label class="form-label">Data</label>
                                <input name="data" id="data" class="form-control" type="date" value="{{ session('data', \Carbon\Carbon::now()->format('Y-m-d')) }}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary form-control" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Filtrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
    <div class="tile">
    <table class="table table-striped" style="text-align: center">
            <thead>
                <tr>
                    <th>Hora</th>
                    <th>Nome</th>
                    <th>Consulta</th>
                    <th>Status</th>
                    <th>Chamar</th>
                    <th>Atender</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($agendas as $item)
                    <tr>
                        <td hidden>{{ $item->id }}</td>
                        <td hidden>{{ $item->paciente_id }}</td>
                        <td>{{ $item->hora }}</td>
                        <td>{{ $item->name }} {{ $item->sobrenome }}</td>
                        <td title="{{ $item->procedimento_id }}">{{ $item->procedimento_id }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                            <a type="submit" class="btn btn-warning form-control chamar-btn" data-paciente-id="{{ $item->paciente_id }}" data-agenda-id="{{ $item->id }}" data-paciente-name="{{ $item->name }}">
                                <i class="bi bi-volume-up"></i>
                            </a>
                        </td>
                        <td>
                            <a type="button" href="{{ route('atendimento.index', [$item->id, $item->paciente_id]) }}" class="btn btn-info form-control"><i class="bi bi-file-earmark-text"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</main>
<script>
    document.querySelectorAll('.chamar-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Impede o comportamento padrão do botão

            let pacienteId = this.getAttribute('data-paciente-id');
            let agendaId = this.getAttribute('data-agenda-id');

            // Envia os dados via AJAX para o servidor
            fetch('{{ route('consultorioPainel.update') }}', { // Ajuste a rota para a função update
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    paciente_id: pacienteId,
                    agenda_id: agendaId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Paciente chamado!');
                } else {
                    alert('Erro ao atualizar os dados: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao atualizar os dados');
            });
        });
    });
</script>
@endsection

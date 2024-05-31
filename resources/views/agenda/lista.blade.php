@extends('layouts.app')
<style>
    .selected-info {
    margin-left: 15px; /* Ajuste a margem conforme necessário */
    font-size: 1rem;   /* Tamanho da fonte para ajustar a aparência */
    color: #666;      /* Cor do texto para distinção */
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
            <li class="breadcrumb-item">Agenda</li>
            <li class="breadcrumb-item"><a href="#">Consultar</a></li>
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
                    <form method="GET" action="{{ route('agenda.index1') }}" class="form-horizontal">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Data</label>
                                <input name="data" id="data" class="form-control" type="date" value="{{ session('data') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Médico</label>
                                <select class="form-control" id="profissional_id" name="profissional_id">
                                    <option disabled selected style="font-size:18px;color: black;">Escolha</option>
                                    @foreach ($profissionals as $item)
                                        <option value="{{ $item->id }}" {{ session('profissional_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="tile-footer">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-3">
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Buscar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Lista das Consultas
                    <span class="selected-info">
                        @if(session('data') || session('profissional_id'))
                            Data: {{ session('data') ?? 'N/A' }} - 
                            Médico: 
                            @if(session('profissional_id'))
                                @php
                                    $profissional = $profissionals->firstWhere('id', session('profissional_id'));
                                @endphp
                                {{ $profissional ? $profissional->name : 'N/A' }} {{ $profissional ? $profissional->sobrenome : 'N/A' }}
                            @else
                                N/A
                            @endif
                        @else
                            Nenhum filtro aplicado.
                        @endif
                    </span>
                </h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Consulta</th>
                            <th>Status</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agendas as $item)
                            <tr>
                                <td>{{ $item->hora }}</td>
                                <td>{{ $item->name }} {{ $item->sobrenome }}</td>
                                <td>{{ $item->cpf }}</td>
                                <td>{{ $item->consulta_id }}</td>
                                <td>
                                    <select class="form-control status-select" data-id="{{ $item->id }}">
                                        <option value="MARCADO" {{ $item->status == 'MARCADO' ? 'selected' : '' }}>MARCADO</option>
                                        <option value="CHEGOU" {{ $item->status == 'CHEGOU' ? 'selected' : '' }}>CHEGOU</option>
                                        <option value="CANCELADO" {{ $item->status == 'CANCELADO' ? 'selected' : '' }}>CANCELADO</option>
                                        <option value="EVADIO" {{ $item->status == 'EVADIO' ? 'selected' : '' }}>EVADIO</option>
                                    </select>
                                </td>
                                <td>
                                    <form action="{{ route('agenda.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-select').change(function() {
            var status = $(this).val();
            var id = $(this).data('id');

            $.ajax({
                url: "{{ route('agenda.updateStatus') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function(response) {
                    alert(response.success);
                },
                error: function(xhr) {
                    alert('Erro ao atualizar o status.');
                }
            });
        });
    });
</script>
@endsection

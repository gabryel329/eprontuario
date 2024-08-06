@extends('layouts.app')

@section('content')
    <main class="app-content">
        <div class="app-title d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-table"></i> Relatório de Honorários</h1>
            </div>
        </div>

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

        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <form action="{{ route('relatorioFinanceiro.index') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-md-3">
                                <label for="data_inicio">Data Início:</label>
                                <input type="date" name="data_inicio" id="data_inicio" class="form-control"
                                    value="{{ request('data_inicio') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="data_fim">Data Fim:</label>
                                <input type="date" name="data_fim" id="data_fim" class="form-control" value="{{ request('data_fim') }}">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="convenio_id">Convênio:</label>
                                <select name="convenio_id" id="convenio_id" class="form-control">
                                    <option value="">Selecione um Convênio</option>
                                    @foreach ($convenios as $id => $nome)
                                        <option value="{{ $id }}" {{ request('convenio_id') == $id ? 'selected' : '' }}>
                                            {{ $nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label for="profissional_id">Profissional:</label>
                                <select name="profissional_id" id="profissional_id" class="form-control">
                                    <option value="">Selecione um Profissional</option>
                                    @foreach ($profissionals as $id => $name)
                                        <option value="{{ $id }}" {{ request('profissional_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </form>
                </div>
            </div>
        </div>

        @if ($resultados)
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="text-align: center">
                            <thead>
                                <tr>
                                    <th>Data/Hora</th>
                                    <th>Profissional</th>
                                    <th>Procedimento</th>
                                    <th>Convênio</th>
                                    <th>% do Profissional</th>
                                    <th>Valor da Consulta</th>
                                    <th>Valor da Clínica</th>
                                    <th>Valor do Profissional</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resultados as $resultado)
                                    <tr>
                                        <td>{{ $resultado->hora }} - {{ $resultado->data }}</td>
                                        <td>{{ $resultado->name }}</td>
                                        <td>{{ $resultado->procedimento }}</td>
                                        <td>{{ $resultado->nome }}</td>
                                        <td>{{ $resultado->porcentagem }}%</td>
                                        <td>R${{ number_format($resultado->valor, 2, ',', '.') }}</td>
                                        @php
                                            $valorClinica = $resultado->valor * (1 - $resultado->porcentagem / 100);
                                            $valorProfissional = $resultado->valor * ($resultado->porcentagem / 100);
                                        @endphp
                                        <td>R${{ number_format($valorClinica, 2, ',', '.') }}</td>
                                        <td>R${{ number_format($valorProfissional, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </main>
@endsection

@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

@section('content')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Cadastro de Tabelas</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Financeiro</li>
                <li class="breadcrumb-item"><a href="#">Tabelas</a></li>
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

        <div class="timeline-post">
            <div class="col-md-12">
                <ul class="nav nav-tabs user-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#vinculo" data-bs-toggle="tab">Tabelas </a></li>
                    <li class="nav-item"><a class="nav-link" href="#tabelas" data-bs-toggle="tab">Vínculo (Convênio X Tabela)</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tile tab-pane active" id="vinculo">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="tile">
                                <h3 class="tile-title">Novo</h3>
                                <div class="tile-body">
                                    <form method="POST" action="{{ route('TabelaProcedimento.store') }}"
                                        class="form-horizontal">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Porte</label>
                                                <input name="nome" id="nome" class="form-control" type="text"
                                                    placeholder="A1" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Valor</label>
                                                <input name="valor" id="valor" class="form-control" type="text"
                                                    placeholder="0.00" required>
                                            </div>
                                        </div>
                                        <div class="tile-footer">
                                            <div class="row">
                                                <div class="col-md-8 col-md-offset-3">
                                                    <button class="btn btn-primary" type="submit"><i
                                                            class="bi bi-check-circle-fill me-2"></i>Salvar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="tile">
                                <h3 class="tile-title">Lista das Tabelas</h3>
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Porte</th>
                                                <th>Valor</th>
                                                <th>Editar</th>
                                                <th>Excluir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tabelas as $item)
                                                <tr>
                                                    <td>{{ $item->nome }}</td>
                                                    <td>R${{ number_format($item->valor, 2, ',', '.') }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}">
                                                            Editar
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('TabelaProcedimento.destroy', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Excluir</button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Modal de Edição -->
                                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editModalLabel{{ $item->id }}">
                                                                    Editar Tipo</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="{{ route('TabelaProcedimento.update', $item->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label for="nome{{ $item->id }}"
                                                                                class="form-label">Porte</label>
                                                                            <input type="text" class="form-control"
                                                                                id="nome{{ $item->id }}" name="nome"
                                                                                value="{{ $item->nome }}">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="valor{{ $item->id }}"
                                                                                class="form-label">Valor</label>
                                                                            <input type="text" class="form-control"
                                                                                id="valor{{ $item->id }}"
                                                                                name="valor"
                                                                                value="{{ $item->valor }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Salvar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tile tab-pane" id="tabelas">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="tile">
                                <h3 class="tile-title">Lista dos Vínculos</h3>
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Convênio</th>
                                                <th>Tabela</th>
                                                <th>Editar</th>
                                                <th>Excluir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tabconvenios as $item)
                                                <tr>
                                                    <td>{{ optional($item->convenio)->nome }}</td>
                                                    <td>{{ optional($item->tabela)->nome }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-info"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editModal{{ $item->id }}">
                                                            Editar
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('tabconvenios.destroy', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Excluir</button>
                                                        </form>
                                                    </td>
                                                </tr>

                                                <!-- Modal for Editing -->
                                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                                    aria-labelledby="editModalLabel{{ $item->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="editModalLabel{{ $item->id }}">
                                                                    Editar Vínculo</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="POST"
                                                                    action="{{ route('tabconvenios.update', $item->id) }}"
                                                                    enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label for="convenio_id{{ $item->id }}"
                                                                                class="form-label">Convênio</label>
                                                                            <select class="form-control"
                                                                                id="convenio_id{{ $item->id }}"
                                                                                name="convenio_id">
                                                                                @foreach ($convenios as $convenio)
                                                                                    <option value="{{ $convenio->id }}"
                                                                                        {{ $item->convenio_id == $convenio->id ? 'selected' : '' }}>
                                                                                        {{ $convenio->nome }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="tabela_id{{ $item->id }}"
                                                                                class="form-label">Tabela</label>
                                                                            <select class="form-control"
                                                                                id="tabela_id{{ $item->id }}"
                                                                                name="tabela_id">
                                                                                @foreach ($tabelas as $tabela)
                                                                                    <option value="{{ $tabela->id }}"
                                                                                        {{ $item->tabela_id == $tabela->id ? 'selected' : '' }}>
                                                                                        {{ $tabela->nome }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Cancelar</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Salvar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="tile">
                                <h3 class="tile-title">Convênio x Tabela</h3>
                                <div class="tile-body">
                                    <form method="POST" action="{{ route('tabconvenios.store') }}"
                                        class="form-horizontal">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Convênios</label>
                                                <select class="form-control" id="convenio_id" name="convenio_id"
                                                    required>
                                                    <option disabled selected style="font-size:18px;color: black;">Escolha
                                                    </option>
                                                    @foreach ($convenios as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nome }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tabela</label>
                                                <select class="form-control" id="tabela_id" name="tabela_id" required>
                                                    <option disabled selected style="font-size:18px;color: black;">Escolha
                                                    </option>
                                                    @foreach ($tabelas as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nome }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="tile-footer">
                                            <div class="row">
                                                <div class="col-md-8 col-md-offset-3">
                                                    <button class="btn btn-primary" type="submit"><i
                                                            class="bi bi-check-circle-fill me-2"></i>Salvar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            // Aplica a m�scara de valor real (moeda) no campo de valor do formul�rio principal
            $('#valor').mask('000.000.000.000.000,00', {
                reverse: true
            });

            // Aplica a m�scara de valor real (moeda) nos campos de valor de todos os modais
            @foreach ($tabelas as $item)
                $('#valor{{ $item->id }}').mask('000.000.000.000.000,00', {
                    reverse: true
                });
            @endforeach
        });
    </script>

@endsection

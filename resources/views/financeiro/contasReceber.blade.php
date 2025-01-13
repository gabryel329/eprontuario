@extends('layouts.app')

@section('content')

<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-table"></i> Contas a Receber</h1>
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
            <div class="tile-header d-flex justify-content-between align-items-center">
                <h3 class="mb-3">Cadastro de Conta a Receber</h3>
                <button id="toggleFormButton" class="btn btn-primary">
                    <i class="bi bi-chevron-down"></i> Exibir Formulário
                </button>
            </div>
            <div id="formContainer" style="display: none;">
                <div class="tile-body">
                    <form method="POST" action="{{ route('contas.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tipo_conta" value="Receber">
                        <div class="row">
                            <!-- Cliente -->
                            <div class="mb-3 col-md-12">
                                <label class="form-label"><strong>Cliente:</strong></label>
                                <select class="form-control select2" id="convenio_id" name="convenio_id" required>
                                    <option value="" selected>Nada Selecionado</option>
                                    @foreach ($clientes as $cliente)
                                        <option value="{{ $cliente->id }}">
                                            {{ $cliente->nome ?? $cliente->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Datas -->
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Emissão:</label>
                                <input class="form-control" id="data_emissao" name="data_emissao" type="date" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Competência:</label>
                                <input class="form-control" id="competencia" name="competencia" type="date" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">1º Vencimento:</label>
                                <input class="form-control" id="data_vencimento" name="data_vencimento" type="date" required>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Referência:</label>
                                <input class="form-control" id="referencia" name="referencia" type="text">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Tipo de Documento -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Tipo Doc.:</label>
                                <select class="form-control" id="tipo_documento" name="tipo_documento" required>
                                    <option value="NF">NF</option>
                                    <option value="Outro">Outro</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Documento:</label>
                                <input class="form-control" id="documento" name="documento" type="text">
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Não Contábil:</label>
                                <select class="form-control" id="nao_contabil" name="nao_contabil">
                                    <option value="Sim">Sim</option>
                                    <option value="Não">Não</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Parcelas à Gerar:</label>
                                <input class="form-control" id="parcelas" name="parcelas" type="number" min="1">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Centro de Custos:</label>
                                <input class="form-control" id="centro_custos" name="centro_custos" type="text" value="{{ $empresas->first()->name}}">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Natureza e Histórico -->
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Natureza da Operação:</label>
                                <select class="form-control select2" id="natureza_operacao" name="natureza_operacao" required>
                                    @foreach ($natureza as $natureza)
                                        <option value="{{ $natureza->id }}">{{ $natureza->descricao }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Histórico:</label>
                                <textarea class="form-control" id="historico" name="historico" rows="2"></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Valores -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Valor:</label>
                                <input class="form-control" id="valor" name="valor" type="text">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Desconto:</label>
                                <input class="form-control" id="desconto" name="desconto" type="text">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Taxa/Juros:</label>
                                <input class="form-control" id="juros" name="juros" type="text">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">ICMS:</label>
                                <input class="form-control" id="icms" name="icms" type="text">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">PIS:</label>
                                <input class="form-control" id="pis" name="pis" type="text">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">COFINS:</label>
                                <input class="form-control" id="cofins" name="cofins" type="text">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Valores adicionais -->
                            <div class="mb-3 col-md-2">
                                <label class="form-label">CSL:</label>
                                <input class="form-control" id="csl" name="csl" type="text">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">ISS:</label>
                                <input class="form-control" id="iss" name="iss" type="text">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">IRRF:</label>
                                <input class="form-control" id="irrf" name="irrf" type="text">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">INSS:</label>
                                <input class="form-control" id="inss" name="inss" type="text">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Total:</label>
                                <input class="form-control" id="total" name="total" type="text" readonly>
                            </div>
                        </div>

                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Salvar</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="tile">
        <h3 class="mb-3">Lista de Contas a Receber</h3>

    <!-- Filtros -->
    <form method="GET" action="{{ route('contasReceber.index') }}" class="mb-4">
        <div class="row g-3">
            <!-- Filtro de Mês e Ano -->
            <div class="col-md-4">
                <label class="form-label"><strong>Data (Mês e Ano):</strong></label>
                <input type="text" name="data" id="data" class="form-control" placeholder="Selecione o mês e ano">
            </div>

            <!-- Filtro de Status -->
            <div class="col-md-4">
                <label for="status" class="form-label"><strong>Status:</strong></label>
                <select name="status" id="status" class="form-control select2">
                    <option value="">Todos os Status</option>
                    <option value="Aberto" {{ request('status') == 'Aberto' ? 'selected' : '' }}>Aberto</option>
                    <option value="Pago" {{ request('status') == 'Pago' ? 'selected' : '' }}>Pago</option>
                    <option value="Atrasado" {{ request('status') == 'Atrasado' ? 'selected' : '' }}>Atrasado</option>
                </select>
            </div>

            <!-- Filtro de Fornecedor -->
            <div class="col-md-4">
                <label for="pesquisa" class="form-label"><strong>Selecionar o Cliente:</strong></label>
                <select name="pesquisa" id="pesquisa" class="form-control select2">
                    <option value="">Todos os Clientes</option>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->name }}" {{ request('pesquisa') == $cliente->name ? 'selected' : '' }}>
                            {{ $cliente->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <!-- Botão de Filtrar e Limpar -->
            <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Filtrar
                </button>
                <a href="{{ route('contasReceber.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Limpar Filtros
                </a>
            </div>
        </div>
    </form>

        <!-- Tabela -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Data de Emissão</th>
                        <th>Data de Vencimento</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contasReceber as $conta)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($conta->tipo_guia === 'Consulta')
                                Guia Consulta - Lote {{ $conta->referencia ?? 'N/A' }}
                            @elseif($conta->tipo_guia === 'SADT')
                                Guia SADT - Lote {{ $conta->referencia ?? 'N/A' }}
                            @else
                                Conta Comum - {{ $conta->convenios->nome ?? 'Nome Não Informado' }}
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($conta->data_emissao)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}</td>
                        <td>
                            R$ {{ number_format($conta->total, 2, ',', '.') }} /
                            R$ {{ number_format($conta->valor, 2, ',', '.') }}
                        </td>
                        <td>
                            <span class="badge
                                {{ $conta->status == 'Atrasado' ? 'bg-danger' : '' }}
                                {{ $conta->status == 'Pago' ? 'bg-success' : '' }}
                                {{ $conta->status == 'Parcial' ? 'bg-info' : '' }}
                                {{ in_array($conta->status, ['Atrasado', 'Pago', 'Parcial']) ? '' : 'bg-warning' }}">
                                {{ ucfirst($conta->status ?? 'Pendente') }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $conta->id }}">
                                Editar
                            </button>

                            <form action="{{ route('contas.destroy', ['tipo' => 'Receber', 'id' => $conta->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta conta?')">Excluir</button>
                            </form>

                            @if ($conta->status === 'Aberto')
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#baixaModal{{ $conta->id }}">
                                    Dar Baixa
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Nenhuma conta a receber encontrada.</td>
                    </tr>
                    @endforelse

                </tbody>
                <!-- Modal para edição -->
                    @foreach ($contasReceber as $conta)
                    <div class="modal fade" id="editModal{{ $conta->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $conta->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('contas.update', $conta->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Conta</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="data_vencimento" class="form-label">Data de Vencimento</label>
                                            <input type="date" class="form-control" id="data_vencimento" name="data_vencimento" value="{{ $conta->data_vencimento }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="valor" class="form-label">Valor</label>
                                            <input type="text" class="form-control" id="valor" name="valor" value="{{ $conta->valor }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="Aberto" {{ $conta->status == 'Aberto' ? 'selected' : '' }}>Aberto</option>
                                                <option value="Pago" {{ $conta->status == 'Pago' ? 'selected' : '' }}>Pago</option>
                                                <option value="Atrasado" {{ $conta->status == 'Atrasado' ? 'selected' : '' }}>Atrasado</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    {{-- MODAL BAIXA --}}
                    @foreach ($contasReceber as $conta)
                    <div class="modal fade" id="baixaModal{{ $conta->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $conta->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('baixas.store', $conta->id) }}">
                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title">Baixa de Conta</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="tipo_pagamento" class="form-label">Tipo de Pagamento</label>
                                            <select class="form-control" id="tipo_pagamento_{{ $conta->id }}" name="tipo_pagamento" required>
                                                <option value="Total">Total</option>
                                                <option value="Parcial">Parcial</option>
                                            </select>
                                        </div>

                                        <div class="mb-3" id="valor_pagamento_div_{{ $conta->id }}" style="display: none;">
                                            <label for="valor_pagamento" class="form-label">Valor que foi pago</label>
                                            <input type="text" class="form-control" id="valor_pagamento_{{ $conta->id }}" name="valor_pagamento">
                                        </div>

                                        @if ($conta->tipo_guia)
                                            <div class="mb-3 motivo-glosa-div" id="motivo_glosa_div_{{ $conta->id }}" style="display: none;">
                                                <label for="motivo_glosa" class="form-label">Motivo da Glosa</label>
                                                <select name="motivo_glosa" id="motivo_glosa_{{ $conta->id }}" class="form-select">
                                                    <option value="" disabled selected>Selecione um motivo</option>
                                                    @foreach ($motivosGlosa as $motivo)
                                                        <option value="{{ $motivo->descricao }}">{{ $motivo->codigo }} - {{ $motivo->descricao }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif


                                        <div class="mb-3">
                                            <label for="banco_id" class="form-label">Banco</label>
                                            <select class="form-control" id="banco_id" name="banco_id">
                                                <option value="">Selecione um Banco</option>
                                                @foreach ($bancos as $banco)
                                                <option value="{{ $banco->id }}">{{ $banco->nome }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="forma_pagamento" class="form-label">Forma de Pagamento</label>
                                            <select class="form-control" id="forma_pagamento" name="forma_pagamento" required>
                                                <option value="" selected disabled>Selecione uma opção</option>
                                                <option value="PIX">PIX</option>
                                                <option value="Boleto">Boleto</option>
                                                <option value="Transferência">Transferência</option>
                                                <option value="Dinheiro">Dinheiro</option>
                                                <option value="Cartão de Crédito">Cartão de Crédito</option>
                                                <option value="Cartão de Débito">Cartão de Débito</option>
                                                <option value="Cheque">Cheque</option>
                                                <option value="Outros">Outros</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="numero_documento" class="form-label">Número do Documento</label>
                                            <input type="text" class="form-control" id="numero_documento" name="numero_documento" placeholder="Comprovante">
                                        </div>

                                        <div class="mb-3">
                                            <label for="observacao" class="form-label">Observação</label>
                                            <textarea class="form-control" id="observacao" name="observacao" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Registrar Baixa</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    @foreach ($contasReceber as $conta)
    document.getElementById('tipo_pagamento_{{ $conta->id }}').addEventListener('change', function () {
        let pagamentoDiv = document.getElementById('valor_pagamento_div_{{ $conta->id }}');
        let motivoGlosaDiv = document.getElementById('motivo_glosa_div_{{ $conta->id }}');

        if (this.value === 'Parcial') {
            pagamentoDiv.style.display = 'block';
            if ('{{ $conta->tipo_guia }}') {
                motivoGlosaDiv.style.display = 'block';
            }
        } else {
            pagamentoDiv.style.display = 'none';
            motivoGlosaDiv.style.display = 'none';
        }
    });
    @endforeach
});
document.addEventListener('DOMContentLoaded', function() {
    $('#data').datepicker({
        format: "yyyy-mm",
        startView: "months",
        minViewMode: "months",
        autoclose: true,
        clearBtn: true
    });
});
document.addEventListener('DOMContentLoaded', function() {
// Inicialização padrão do Select2
$('.select2').select2({
    placeholder: "Selecione uma opção",
    allowClear: true,
    width: '100%'
});

// Alterna a exibição do formulário
document.getElementById('toggleFormButton').addEventListener('click', function() {
    const formContainer = document.getElementById('formContainer');
    const toggleButton = document.getElementById('toggleFormButton');

    // Verifica a exibição e alterna
    if (formContainer.style.display === 'none' || formContainer.style.display === '') {
        formContainer.style.display = 'block';
        toggleButton.innerHTML = '<i class="bi bi-chevron-up"></i> Ocultar Formulário';

        // Recarrega o Select2 quando o formulário for exibido
        $('.select2').select2({
            placeholder: "Selecione uma opção",
            allowClear: true,
            width: '100%'
        });

    } else {
        formContainer.style.display = 'none';
        toggleButton.innerHTML = '<i class="bi bi-chevron-down"></i> Exibir Formulário';
    }
});
});

</script>
@endsection

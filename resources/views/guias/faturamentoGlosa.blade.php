@extends('layouts.app')

@section('content')
<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-table"></i> Contas a Pagar</h1>
        </div>
    </div>

    <!-- Mensagens de Sucesso e Erro -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-warning">{{ session('error') }}</div>
    @endif

    <div class="tile">
        <h3 class="mb-3">Lista de Guias Glosadas</h3>

        <!-- Filtros -->
        <form method="GET" action="{{ route('faturamentoGlosa.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label"><strong>Data (Mês e Ano):</strong></label>
                    <input type="text" name="data" id="data" class="form-control" placeholder="Selecione o mês e ano">
                </div>

                <div class="col-md-4">
                    <label for="status" class="form-label"><strong>Status:</strong></label>
                    <select name="status" id="status" class="form-control select2">
                        <option value="">Todos os Status</option>
                        <option value="Aberto" {{ request('status') == 'Aberto' ? 'selected' : '' }}>Aberto</option>
                        <option value="Pago" {{ request('status') == 'Pago' ? 'selected' : '' }}>Pago</option>
                        <option value="Atrasado" {{ request('status') == 'Atrasado' ? 'selected' : '' }}>Atrasado</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="pesquisa" class="form-label"><strong>Lote:</strong></label>
                    <select name="pesquisa" id="pesquisa" class="form-control select2">
                        <option value="">Lotes</option>
                    </select>
                </div>

                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Filtrar
                    </button>
                    <a href="{{ route('contasPagar.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Limpar Filtros
                    </a>
                </div>
            </div>
        </form>

        <!-- Tabela de Contas -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Guia</th>
                        <th>Lote</th>
                        <th>Data do Atendimento</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($contas as $conta)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $conta->historico ?? 'N/A' }}</td>
                            <td>{{ $conta->referencia ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($conta->data_vencimento)->format('d/m/Y') }}</td>
                            <td>
                                R$ {{ number_format($conta->total, 2, ',', '.') }} /
                                R$ {{ number_format($conta->valor, 2, ',', '.') }}
                            </td>
                            <td>
                                <span class="badge
                                    {{ $conta->status == 'Atrasado' ? 'bg-danger' : '' }}
                                    {{ $conta->status == 'Pago' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($conta->status ?? 'Pendente') }}
                                </span>
                            </td>
                            <td>
                                <button type="button"
                                    class="btn btn-sm btn-warning btn-glosa"
                                    data-conta-id="{{ $conta->id }}"
                                    data-lote="{{ $conta->referencia }}">
                                    Glosar
                                </button>


                                <form action="{{ route('contas.destroy', ['tipo' => 'pagar', 'id' => $conta->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta conta?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Nenhuma conta a pagar encontrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>

<div class="modal fade" id="glosaModal" tabindex="-1" aria-labelledby="glosaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="glosaModalLabel">Guias Relacionadas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Filtro de Paciente -->
                <div class="mb-3">
                    <label for="filtroPaciente" class="form-label">Filtrar por Paciente</label>
                    <input type="text" id="filtroPaciente" class="form-control" placeholder="Digite o nome do paciente">
                </div>
                <input type="hidden" name="conta_financeira_id" id="contaFinanceiraId">
                <!-- Tabela de Guias -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome do Beneficiário</th>
                            <th>Tipo</th>
                            <th>Data do Atendimento</th>
                            <th>Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="guiasTableBody">
                        <!-- Os dados serão carregados via AJAX -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Referência ao campo de filtro
    const filtroPaciente = document.getElementById('filtroPaciente');
    const guiasTableBody = document.getElementById('guiasTableBody');

    // Ação ao digitar no filtro
    filtroPaciente.addEventListener('input', function () {
        const termo = filtroPaciente.value.toLowerCase();
        const linhas = guiasTableBody.querySelectorAll('tr');

        linhas.forEach(linha => {
            const nomePaciente = linha.querySelector('td:nth-child(2)').textContent.toLowerCase();

            if (nomePaciente.includes(termo)) {
                linha.style.display = ''; // Exibe a linha
            } else {
                linha.style.display = 'none'; // Oculta a linha
            }
        });
    });
});

    document.addEventListener('DOMContentLoaded', function() {
        // Configuração do DatePicker
        $('#data').datepicker({
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true,
            clearBtn: true
        });

        // Inicialização do Select2
        $('.select2').select2({
            placeholder: "Selecione uma opção",
            allowClear: true,
            width: '100%'
        });

        document.querySelectorAll('.btn-glosa').forEach(button => {
            button.addEventListener('click', async function () {
                const contaId = this.dataset.contaId;
                const lote = this.dataset.lote;

                console.log(`Iniciando busca para Conta ID: ${contaId}, Lote: ${lote}`); // DEBUG

                try {
                    // Definir o ID da conta financeira no campo oculto
                    document.getElementById('contaFinanceiraId').value = contaId;

                    const response = await fetch(`/contas-guias/${contaId}`);
                    if (!response.ok) throw new Error(`Erro ao buscar guias: ${response.statusText}`);

                    const data = await response.json();
                    const guiasTableBody = document.querySelector('#guiasTableBody');
                    guiasTableBody.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach((guia, index) => {
                            const tipoGuia = guia.tipo_guia === 'Consulta' ? 'Consulta' : 'SADT';
                            const editarURL = tipoGuia === 'Consulta'
                                ? `/guias-consulta/${guia.guia_id}/editar`
                                : `/guias-sadt/${guia.guia_id}/editar`;

                            console.log(`Guia ID: ${guia.guia_id}, Tipo: ${tipoGuia}`); // DEBUG

                            guiasTableBody.innerHTML += `
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${guia.nome_beneficiario ?? 'N/A'}</td>
                                    <td>${tipoGuia}</td>
                                    <td>${guia.data_atendimento ?? 'N/A'}</td>
                                    <td>R$ ${parseFloat(guia.valor_procedimento).toLocaleString('pt-BR', { minimumFractionDigits: 2 })}</td>
                                    <td>
                                        <a href="${editarURL}" class="btn btn-sm btn-primary">Editar</a>
                                    </td>
                                </tr>
                            `;
                        });
                    } else {
                        guiasTableBody.innerHTML = `
                            <tr>
                                <td colspan="6" class="text-center">Nenhuma guia encontrada para este lote.</td>
                            </tr>
                        `;
                    }

                    const modal = new bootstrap.Modal(document.querySelector('#glosaModal'));
                    modal.show();
                } catch (error) {
                    console.error('Erro ao buscar guias:', error);
                    alert('Erro ao buscar guias relacionadas.');
                }
            });
        });
});
</script>
@endsection

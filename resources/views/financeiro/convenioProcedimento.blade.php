@extends('layouts.app')

@section('content')
<main class="app-content">
    <div class="app-title d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="bi bi-table"></i> Lista de Convênios</h1>
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
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>ANS</th>
                                <th>Selecionar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($convenios as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->nome }}</td>
                                    <td>{{ $item->ans }}</td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                            <i class="icon bi bi-arrow-right-circle-fill"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Valor Procedimentos</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" class="ajax-form" data-convenio-id="{{ $item->id }}">
                                                    @csrf
                                                    <div id="procedimentos-container-{{ $item->id }}">
                                                        <!-- Existing Records -->
                                                        @foreach ($item->convenioProcedimentos as $convenioProcedimento)
                                                            <div class="row mb-3">
                                                                <input type="text" hidden name="convenio_id[]" value="{{ $item->id }}" class="form-control" readonly>
                                                                <div class="col-md-2">
                                                                    <label for="codigo{{ $item->id }}" class="form-label">Código</label>
                                                                    <input type="text" name="codigo[]" value="{{ $convenioProcedimento->codigo }}" class="form-control" readonly>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="procedimento{{ $item->id }}" class="form-label">Procedimento</label>
                                                                    <select name="procedimento_id[]" class="form-select" onchange="updateCodigo(this)">
                                                                        <option value="">Escolha o procedimento</option>
                                                                        @foreach ($procedimentos as $procedimento)
                                                                            <option value="{{ $procedimento->id }}" data-codigo="{{ $procedimento->codigo }}" {{ $procedimento->id == $convenioProcedimento->procedimento_id ? 'selected' : '' }}>{{ $procedimento->procedimento }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="valor" class="form-label">Valor</label>
                                                                    <input type="text" name="valor[]" value="{{ $convenioProcedimento->valor }}" class="form-control">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="acao" class="form-label">Ações</label>
                                                                    <div>
                                                                        <button type="button" class="btn btn-success" onclick="addLancamento({{ $item->id }})"><i class="icon bi bi-plus-circle"></i></button>
                                                                        <button type="button" class="btn btn-danger" onclick="removeLancamento(this)"><i class="icon bi bi-dash-circle"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                        <!-- Empty Row for New Entry -->
                                                        <div class="row mb-3">
                                                            <input type="text" hidden name="convenio_id[]" value="{{ $item->id }}" class="form-control" readonly>
                                                            <div class="col-md-2">
                                                                <label for="codigo{{ $item->id }}" class="form-label">Código</label>
                                                                <input type="text" name="codigo[]" class="form-control">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="procedimento{{ $item->id }}" class="form-label">Procedimento</label>
                                                                <select name="procedimento_id[]" class="form-select" onchange="updateCodigo(this)">
                                                                    <option value="">Escolha o procedimento</option>
                                                                    @foreach ($procedimentos as $procedimento)
                                                                        <option value="{{ $procedimento->id }}" data-codigo="{{ $procedimento->codigo }}">{{ $procedimento->procedimento }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label for="valor" class="form-label">Valor</label>
                                                                <input type="text" name="valor[]" class="form-control">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <label for="acao" class="form-label">Ações</label>
                                                                <div>
                                                                    <button type="button" class="btn btn-success" onclick="addLancamento({{ $item->id }})"><i class="icon bi bi-plus-circle"></i></button>
                                                                    <button type="button" class="btn btn-danger" onclick="removeLancamento(this)"><i class="icon bi bi-dash-circle"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-primary" onclick="submitForm({{ $item->id }})">Salvar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Confirmation Modal for Deletion -->
                                <div class="modal fade" id="confirmDeleteModal{{ $item->id }}" tabindex="-1" aria-labelledby="confirmDeleteModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel{{ $item->id }}">Confirmar Exclusão</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Tem certeza de que deseja excluir os itens selecionados?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="button" class="btn btn-danger" onclick="deleteSelected({{ $item->id }})">Excluir</button>
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
</main>

<script>
    function updateCodigo(selectElement) {
        const row = selectElement.closest('.row.mb-3');
        const codigoInput = row.querySelector('input[name="codigo[]"]');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        codigoInput.value = selectedOption.getAttribute('data-codigo');
    }

    window.addLancamento = function(convenioId) {
        const container = document.getElementById('procedimentos-container-' + convenioId);
        const newRow = container.querySelector('.row.mb-3').cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        newRow.querySelectorAll('select').forEach(select => select.value = '');
        container.appendChild(newRow);
    }

    window.removeLancamento = function(button) {
        const container = button.closest('#procedimentos-container-' + button.closest('.modal').id.replace('editModal', ''));
        const rows = container.querySelectorAll('.row.mb-3');
        if (rows.length > 1) {
            button.closest('.row.mb-3').remove();
        }
    }

    function submitForm(convenioId) {
        const formData = new FormData();
        document.querySelectorAll(`#procedimentos-container-${convenioId} .row.mb-3`).forEach((row, index) => {
            const codigo = row.querySelector(`input[name="codigo[]"]`).value;
            const procedimentoId = row.querySelector(`select[name="procedimento_id[]"]`).value;
            const valor = row.querySelector(`input[name="valor[]"]`).value;

            formData.append(`codigo[${index}]`, codigo);
            formData.append(`procedimento_id[${index}]`, procedimentoId);
            formData.append(`valor[${index}]`, valor);
            formData.append(`convenio_id[${index}]`, convenioId);
        });

        fetch("{{ route('convenioProcedimento.store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response Data:', data);
            if (data.success) {
                alert('Dados salvos com sucesso!');
                $('#editModal' + convenioId).modal('hide');
            } else {
                alert('Erro ao salvar dados!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Erro ao salvar dados!');
        });
    }

</script>
@endsection

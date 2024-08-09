@extends('layouts.app')

@section('content')
    <style>
        .larger-checkbox {
            transform: scale(1.5);
            margin: 0;
            cursor: pointer;
        }
    </style>
    <main class="app-content">
        <div class="app-title d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="bi bi-table"></i> Lista de Profissionais</h1>
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
                                    <th>Conselho</th>
                                    <th>Selecionar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($profissionais as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->conselho }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $item->id }}">
                                                <i class="icon bi bi-arrow-right-circle-fill"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Honorário
                                                        Médico</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="form-{{ $item->id }}" class="ajax-form">
                                                        @csrf
                                                        <div class="row mb-3 convenio">
                                                            <div class="col-md-12">
                                                                <select name="convenio_id" class="form-select" required>
                                                                    <option value="">Escolha o Convênio</option>
                                                                    @foreach ($convenios as $convenio)
                                                                        <option value="{{ $convenio->id }}">
                                                                            {{ $convenio->nome }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div id="procedimentos-container-{{ $item->id }}">
                                                            @foreach ($item->honorarios as $honorario)
                                                                <div class="row mb-3">
                                                                    <div
                                                                        class="col-2 d-flex justify-content-center align-items-center">
                                                                        <input type="checkbox"
                                                                            class="form-check-input larger-checkbox"
                                                                            value="{{ $honorario->id }}">
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $honorario->codigo }}" readonly
                                                                            required>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $honorario->procedimento->procedimento }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col-2">
                                                                        <input type="text"
                                                                            name="porcentagem_existente[{{ $honorario->id }}]"
                                                                            class="form-control"
                                                                            value="{{ $honorario->porcentagem }}" required>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <div class="row mb-3 linha">
                                                                <div class="col-2">
                                                                    <input type="text" name="codigo[]"
                                                                        class="form-control" placeholder="Código" readonly
                                                                        required>
                                                                </div>
                                                                <div class="col-6">
                                                                    <select name="procedimento_id[]" class="form-select"
                                                                        onchange="updateCodigo(this)" required>
                                                                        <option value="">Escolha o Procedimento
                                                                        </option>
                                                                        @foreach ($procedimentos as $procedimento)
                                                                            <option value="{{ $procedimento->id }}"
                                                                                data-codigo="{{ $procedimento->codigo }}">
                                                                                {{ $procedimento->procedimento }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-2">
                                                                    <input type="text" name="porcentagem[]"
                                                                        class="form-control" placeholder="%" required>
                                                                </div>
                                                                <div class="col-2">
                                                                    <div>
                                                                        <button type="button" class="btn btn-success"
                                                                            onclick="addLancamento({{ $item->id }})">
                                                                            <i class="icon bi bi-plus-circle"></i>
                                                                        </button>
                                                                        <button type="button" class="btn btn-danger"
                                                                            onclick="removeLancamento(this)">
                                                                            <i class="icon bi bi-dash-circle"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-primary" onclick="submitForm(1)">Salvar</button>

                                                        <button type="button" class="btn btn-danger"
                                                            onclick="deleteSelectedItems({{ $item->id }})">Excluir
                                                            Selecionados</button>
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
    </main>

    <script>
        function updateCodigo(selectElement) {
            const row = selectElement.closest('.linha');
            if (row) {
                const codigoInput = row.querySelector('input[name="codigo[]"]');
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                if (codigoInput && selectedOption) {
                    codigoInput.value = selectedOption.getAttribute('data-codigo');
                }
            }
        }

        function addLancamento(profissionalId) {
            const container = document.getElementById('procedimentos-container-' + profissionalId);
            if (container) {
                const template = container.querySelector('.linha');
                if (template) {
                    const newRow = template.cloneNode(true);
                    newRow.querySelectorAll('input').forEach(input => input.value = '');
                    const select = newRow.querySelector('select[name="procedimento_id[]"]');
                    if (select) {
                        select.value = '';
                    }
                    container.appendChild(newRow);
                }
            }
        }

        function removeLancamento(button) {
            if (confirm('Você tem certeza de que deseja remover este lançamento?')) {
                const row = button.closest('.linha');
                if (row) {
                    row.remove();
                }
            }
        }

        function deleteSelectedItems(profissionalId) {
            const selectedIds = Array.from(document.querySelectorAll(
                `#editModal${profissionalId} .larger-checkbox:checked`)).map(checkbox => checkbox.value);

            if (selectedIds.length === 0) {
                alert('Nenhum item selecionado!');
                return;
            }

            if (!confirm('Tem certeza de que deseja excluir os itens selecionados?')) {
                return;
            }

            fetch("{{ route('honorario.deleteSelected') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        ids: selectedIds
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Itens excluídos com sucesso!');
                        window.location.reload(); // Refresh the page to show updated data
                    } else {
                        alert('Erro ao excluir itens!');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erro ao excluir itens!');
                });
        }

        function submitForm(profissionalId) {
    const container = document.getElementById(`procedimentos-container-${profissionalId}`);
    const convenioId = container.closest('.modal-content').querySelector('select[name="convenio_id"]').value;

    let valid = true;
    const formData = new FormData();

    container.querySelectorAll('.linha').forEach((row, index) => {
        const codigo = row.querySelector(`input[name="codigo[]"]`);
        const procedimentoId = row.querySelector(`select[name="procedimento_id[]"]`);
        const porcentagem = row.querySelector(`input[name="porcentagem[]"]`);

        if (!codigo.value || !procedimentoId.value || !porcentagem.value) {
            valid = false;
            alert('Por favor, preencha todos os campos.');
            return;
        }

        formData.append(`codigo[${index}]`, codigo.value);
        formData.append(`procedimento_id[${index}]`, procedimentoId.value);
        formData.append(`porcentagem[${index}]`, porcentagem.value);
        formData.append(`convenio_id[${index}]`, convenioId);
        formData.append(`profissional_id[${index}]`, profissionalId);
    });

    if (!valid) {
        return;
    }

    fetch("{{ route('honorario.store') }}", {
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
                $('#editModal' + profissionalId).modal('hide');
                window.location.reload(); // Refresh the page to show updated data
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

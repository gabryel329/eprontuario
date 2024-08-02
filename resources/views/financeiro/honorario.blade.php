@extends('layouts.app')

@section('content')
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
            <h3 class="tile-title">Editar Honorários</h3>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nome</th>
                                <th>Nº Conselho</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($profissioanls as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->conselho }}</td>
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
                                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Honorários</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('honorario.store') }}" id="form-{{ $item->id }}">
                                                    @csrf
                                                    <input type="hidden" name="profissional_id" value="{{ $item->id }}">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12">
                                                            <div class="col-md-2">
                                                                <label for="convenio" class="form-label">Selecione o convênio</label>
                                                                <select name="convenio_id" class="form-select" id="convenio{{ $item->id }}">
                                                                    @foreach ($convenios as $convenio)
                                                                        <option value="{{ $convenio->id }}" {{ old('convenio_id', $item->convenio_id) == $convenio->id ? 'selected' : '' }}>{{ $convenio->nome }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <hr class="my-3">
                                                        </div>
                                                    </div>
                                
                                                    <div id="procedimentos-container-{{ $item->id }}">
                                                        @forelse ($item->honorarios ?? [] as $index => $honorario)
                                                            <div class="row mb-3">
                                                                <div class="col-md-2">
                                                                    <label for="codigo{{ $item->id }}_{{ $index }}" class="form-label">Código</label>
                                                                    <input type="text" name="codigo[]" id="codigo{{ $item->id }}_{{ $index }}" class="form-control" value="{{ $honorario->codigo }}" readonly>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="procedimento{{ $item->id }}_{{ $index }}" class="form-label">Procedimento</label>
                                                                    <select id="procedimento{{ $item->id }}_{{ $index }}" name="procedimento_id[]" class="form-select" onchange="updateCodigo(this)">
                                                                        <option value="">Escolha o procedimento</option>
                                                                        @foreach ($procedimentos as $procedimento)
                                                                            <option value="{{ $procedimento->id }}" data-codigo="{{ $procedimento->codigo }}" {{ $honorario->procedimento_id == $procedimento->id ? 'selected' : '' }}>
                                                                                {{ $procedimento->procedimento }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="porcentagem{{ $item->id }}_{{ $index }}" class="form-label">Porcentagem</label>
                                                                    <input type="text" name="porcentagem[]" id="porcentagem{{ $item->id }}_{{ $index }}" class="form-control" value="{{ $honorario->porcentagem }}">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="acao" class="form-label">Ações</label>
                                                                    <div class="d-flex justify-content-between">
                                                                        <button type="button" class="btn btn-success" onclick="addLancamento({{ $item->id }})">Adicionar</button>
                                                                        @if ($index > 0)
                                                                            <button type="button" class="btn btn-danger" onclick="removeLancamento(this)">Remover</button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="row mb-3">
                                                                <div class="col-md-2">
                                                                    <label for="codigo{{ $item->id }}_0" class="form-label">Código</label>
                                                                    <input type="text" name="codigo[]" id="codigo{{ $item->id }}_0" class="form-control" readonly>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="procedimento{{ $item->id }}_0" class="form-label">Procedimento</label>
                                                                    <select id="procedimento{{ $item->id }}_0" name="procedimento_id[]" class="form-select" onchange="updateCodigo(this)">
                                                                        <option value="">Escolha o procedimento</option>
                                                                        @foreach ($procedimentos as $procedimento)
                                                                            <option value="{{ $procedimento->id }}" data-codigo="{{ $procedimento->codigo }}">
                                                                                {{ $procedimento->procedimento }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="porcentagem{{ $item->id }}_0" class="form-label">Porcentagem</label>
                                                                    <input type="text" name="porcentagem[]" id="porcentagem{{ $item->id }}_0" class="form-control">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="acao" class="form-label">Ações</label>
                                                                    <div class="d-flex justify-content-between">
                                                                        <button type="button" class="btn btn-success" onclick="addLancamento({{ $item->id }})">Adicionar</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                    <button type="button" class="btn btn-primary" onclick="submitForm({{ $item->id }})">Salvar</button>
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
    const row = selectElement.closest('.row.mb-3');
    const codigoInput = row.querySelector('input[name="codigo[]"]');
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    codigoInput.value = selectedOption.getAttribute('data-codigo');
}

window.addLancamento = function(profissionalId) {
    const container = document.getElementById('procedimentos-container-' + profissionalId);
    const newRow = container.querySelector('.row.mb-3').cloneNode(true);
    const index = container.querySelectorAll('.row.mb-3').length;

    newRow.querySelectorAll('input').forEach(input => input.value = '');
    newRow.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
        updateCodigo(select);
    });

    newRow.querySelectorAll('[id]').forEach(element => {
        const newId = element.id.replace(/\d+$/, index);
        element.id = newId;
        if (element.name) {
            element.name = element.name.replace(/\d+$/, index);
        }
    });

    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.className = 'btn btn-danger';
    removeButton.textContent = 'Remover';
    removeButton.onclick = function() {
        newRow.remove();
    };

    newRow.querySelector('.col-md-2:last-child').appendChild(removeButton);
    container.appendChild(newRow);
};

window.removeLancamento = function(button) {
    button.closest('.row.mb-3').remove();
};

window.submitForm = function(profissionalId) {
    const form = document.getElementById('form-' + profissionalId);
    const convenio = document.getElementById('convenio' + profissionalId).value;
    const procedures = form.querySelectorAll('select[name="procedimento_id[]"]');

    procedures.forEach(procedure => {
        procedure.querySelector(`option[value="${procedure.value}"]`).dataset.codigo;
    });

    form.submit();
};
</script>
@endsection

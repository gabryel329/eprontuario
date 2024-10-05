<form id="{{ $formId }}" action="{{ route('gerar-agenda.store') }}" method="POST">
    @csrf
    <input type="hidden" name="turno" value="{{ $turno }}"> <!-- Campo hidden para o turno -->

    <div class="row">
        <div class="mb-3 col-md-6">
            <label class="form-label"><strong>Profissional:</strong></label>
            <select class="form-control" id="profissional_id" name="profissional_id" required>
                <option disabled selected>Escolha</option>
                @foreach ($profissionais as $item)
                    <option value="{{ $item->id }}" {{ request('profissional_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label"><strong>Especialidade:</strong></label>
            <select class="form-control" id="especialidade" name="especialidade_id" required>
                <option disabled selected>Escolha</option>
            </select>
        </div>
    </div>

    <div class="row">
        <div class="mb-3 col-md-4">
            <label class="form-label">Disponibilidade</label>
            <div class="d-flex align-items-center">
            @foreach (['dom' => 'D', 'seg' => 'S', 'ter' => 'T', 'qua' => 'Q', 'qui' => 'Q', 'sex' => 'S', 'sab' => 'S'] as $dia => $label)
                <div class="form-check me-3">
                    <label class="form-check-label" for="{{ $turno }}_{{ $dia }}">{{ $label }}</label>
                    <input class="form-check-input" type="checkbox" id="{{ $turno }}_{{ $dia }}" name="{{ $dia }}"
                        value="S" {{ old($dia) == 'S' ? 'checked' : '' }}>
                </div>
            @endforeach
            </div>
        </div>
        
        <div class="mb-3 col-md-2">
            <label class="form-label">Início</label>
            <input class="form-control" id="inihonorario_{{ $turno }}" name="inihonorario" type="time">
        </div>
        <div class="mb-3 col-md-2">
            <label class="form-label">Intervalo</label>
            <input class="form-control" id="interhonorario" name="interhonorario" type="text">
        </div>
        <div class="mb-3 col-md-2">
            <label class="form-label">Fim</label>
            <input class="form-control" id="fimhonorario_{{ $turno }}" name="fimhonorario" type="time">
        </div>
        <div class="mb-3 col-md-2">
            <label class="form-label">Mês</label>
            <select class="form-select" id="mes_{{ $turno }}" name="mes">
                <option value="" disabled selected>Selecione o mês</option>
                <option value="01">Janeiro</option>
                <option value="02">Fevereiro</option>
                <option value="03">Março</option>
                <option value="04">Abril</option>
                <option value="05">Maio</option>
                <option value="06">Junho</option>
                <option value="07">Julho</option>
                <option value="08">Agosto</option>
                <option value="09">Setembro</option>
                <option value="10">Outubro</option>
                <option value="11">Novembro</option>
                <option value="12">Dezembro</option>
            </select>
        </div>
        
    </div>

    <div class="row">
        <div class="mb-3 col-md-4 align-self-end">
            <button class="btn btn-primary" type="submit">
                <i class="bi bi-check-circle-fill me-2"></i>Gerar
            </button>
        </div>
    </div>
</form>

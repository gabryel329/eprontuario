@extends('layouts.app')
<style>
    .form-label {
        display: block;
        margin-bottom: 0.5em;
    }

    .form-control {
        width: 100%;
        padding: 0.5em;
    }

    .hidden {
        display: none;
    }
</style>
@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-ui-checks"></i> Profissional</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Administração</li>
                <li class="breadcrumb-item">Cadastros</li>
                <li class="breadcrumb-item"><a href="#">Profissional</a></li>
            </ul>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {!! session('success') !!}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-warning">
                {!! session('error') !!}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="mb-3 col-md-4 d-flex justify-content-start align-items-end">
                    <a class="btn btn-primary me-2" href="{{ route('profissional.index1') }}">Lista de Profissionais</a>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pacienteModal">
                        Buscar <i class="bi bi-search"></i>
                    </button>
                </div>
                
                <div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="pacienteModalLabel">Selecione o Profissional</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <input class="form-control" id="pacienteSearch" type="text"
                                        placeholder="Pesquisar por nome ou CPF...">
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover text-center" id="pacienteTable">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>CPF</th>
                                                <th>Ação</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($profissioanls as $p)
                                                <tr>
                                                    <td>{{ $p->name }}</td>
                                                    <td>{{ $p->cpf }}</td>
                                                    <td>
                                                        <a href="{{ route('profissional.edit', $p->id) }}"
                                                            class="btn btn-success">
                                                            Selecionar
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="timeline-post">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs user-tabs">
                            <li class="nav-item"><a class="nav-link active" href="#dados" data-bs-toggle="tab">Dados
                                    Pessoais</a></li>
                            <li class="nav-item"><a class="nav-link" href="#honorario" data-bs-toggle="tab">Honorário</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tile">
                        <form id="profissionalForm" action="{{ route('profissional.store') }}" method="POST"
                            enctype="multipart/form-data">
                            <div class="tab-content">
                                <div class="tile tab-pane active" id="dados">
                                    <h3 class="tile-title">Adicionar Profissional</h3>
                                    <div class="tile-body">
                                        @csrf
                                        <div class="row">
                                            <div class="mb-3 col-md-8">
                                                <label class="form-label">Nome </label>
                                                <input class="form-control" id="name" name="name" type="text"
                                                    required>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">E-mail</label>
                                                <input class="form-control" id="email" name="email" type="email"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Nascimento </label>
                                                <input class="form-control" id="nasc" name="nasc" type="date"
                                                    value="{{ old('nasc') }}" max="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">CPF: </label>
                                                <input class="form-control" id="cpf" name="cpf" type="text"
                                                    required>
                                                <small id="cpfValidationMessage" style="color:red; display:none;">CPF
                                                    inválido</small>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Gênero</label>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" id="genero_m"
                                                            name="genero" value="M" required>Masculino
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" id="genero_f"
                                                            name="genero" value="F" required>Feminino
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Foto</label>
                                                <input class="form-control" type="file" name="imagem">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Tipo de Profissional</label>
                                                <select class="form-control" id="tipo_profissional" name="tipoprof_id"
                                                    onchange="mostrarCamposEspecificos()" required>
                                                    <option disabled selected value=""
                                                        style="font-size:18px;color: black;">Escolha</option>
                                                    @foreach ($tipoprof as $item)
                                                        <option value="{{ $item->id }}"
                                                            data-conselho="{{ $item->conselho }}">{{ $item->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Por favor, selecione um tipo de profissional.
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-4 hidden" id="campo_especialidade">
                                                <label class="form-label">Especialidades</label>
                                                <select class="form-control select2" id="especialidade_id"
                                                    name="especialidade_id[]" multiple style="width: 100%;">
                                                    @foreach ($especialidades as $especialidade)
                                                        <option value="{{ $especialidade->id }}"
                                                            data-conselho="{{ $especialidade->conselho }}">{{ $especialidade->especialidade }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Por favor, selecione uma especialidade.</div>
                                            </div>
                                            <div class="mb-3 col-md-4 hidden" id="campo_conselho">
                                                <label id="label_conselho" class="form-label"></label>
                                                <input type="text" name="conselho" class="form-control"
                                                    id="input_conselho" placeholder="">
                                                <div class="invalid-feedback">Por favor, preencha o campo Conselho.</div>
                                            </div>
                                            <div class="mb-3 col-md-2 hidden" id="campo_uf_conselho">
                                                <label class="form-label">UF do Conselho</label>
                                                <input type="text" name="uf_conselho" class="form-control"
                                                    id="uf_conselho" placeholder="">
                                                <div class="invalid-feedback">Por favor, selecione a UF do Conselho.</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-4"></div>
                                            <div class="mb-3 col-md-2"></div>
                                            <div class="mb-3 col-md-4 hidden" id="campo_conselho1">
                                                <label id="label_conselho1" class="form-label"></label>
                                                <input type="text" name="conselho1" class="form-control"
                                                    id="input_conselho1" placeholder="">
                                                <div class="invalid-feedback">Por favor, preencha o campo Conselho.</div>
                                            </div>
                                            <div class="mb-3 col-md-2 hidden" id="campo_uf_conselho1">
                                                <label class="form-label">UF do Conselho</label>
                                                <input type="text" name="uf_conselho1" class="form-control"
                                                    id="uf_conselho1" placeholder="">
                                                <div class="invalid-feedback">Por favor, selecione a UF do Conselho.</div>
                                            </div>
                                        </div>
                                        <div class="row" id="campos_comuns">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">R.G.</label>
                                                <input class="form-control" id="rg" name="rg" type="text"
                                                    required>
                                                <div class="invalid-feedback">Por favor, preencha o campo RG.</div>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Étnia</label>
                                                <select class="form-control" id="cor" name="cor" required>
                                                    <option disabled selected value=""
                                                        style="font-size:18px;color: black;">Escolha</option>
                                                    <option value="Branco">Branco</option>
                                                    <option value="Preto">Preto</option>
                                                    <option value="Amarelo">Amarelo</option>
                                                    <option value="Pardo">Pardo</option>
                                                </select>
                                                <div class="invalid-feedback">Por favor, selecione uma Étnia.</div>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Telefone</label>
                                                <input class="form-control" id="telefone" name="telefone"
                                                    type="text">
                                                <div class="invalid-feedback">Por favor, preencha o campo Telefone.</div>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Celular</label>
                                                <input class="form-control" id="celular" name="celular" type="text"
                                                    required>
                                                <div class="invalid-feedback">Por favor, preencha o campo Celular.</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">CEP </label>
                                                <input class="form-control" name="cep" type="text" id="cep"
                                                    value="" size="10" maxlength="9"
                                                    onblur="pesquisacep(this.value);" required>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Rua </label>
                                                <input class="form-control" name="rua" type="text" id="rua"
                                                    size="60">
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Bairro</label>
                                                <input class="form-control" name="bairro" type="text" id="bairro"
                                                    size="40">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Cidade</label>
                                                <input class="form-control" name="cidade" type="text" id="cidade"
                                                    size="40">
                                            </div>
                                            <div class="mb-3 col-md-1">
                                                <label class="form-label">Estado</label>
                                                <input class="form-control" name="uf" type="text" id="uf"
                                                    size="2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tile tab-pane" id="honorario">
                                    <h3 class="tile-title">Honorário Médico</h3>
                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Porcentagem </label>
                                                <input class="form-control" id="porcentagem" name="porcentagem"
                                                    placeholder="%" type="text">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Valor</label>
                                                <input class="form-control" id="valor" name="valor" type="text"
                                                    placeholder="R$">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Matérial</label>
                                                <input class="form-control" id="material" name="material"
                                                    type="text">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Medicamento</label>
                                                <input class="form-control" id="medicamento" name="medicamento"
                                                    type="text">
                                            </div>
                                        </div>
                                        <hr>
                                        <h4>Atendimento</h4>
                                        <div class="tab-content">
                                            <div class="tile-body">
                                                <div class="row">
                                                    <div class="mb-3 col-md-6">
                                                        <label class="form-label">Dias</label>
                                                        <div class="d-flex align-items-center">
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_dom">D</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_dom" name="manha_dom" value="S">
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_seg">S</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_seg" name="manha_seg" value="S">
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_ter">T</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_ter" name="manha_ter" value="S">
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_qua">Q</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_qua" name="manha_qua" value="S">
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_qui">Q</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_qui" name="manha_qui" value="S">
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_sex">S</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_sex" name="manha_sex" value="S">
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="manha_sab">S</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_sab" name="manha_sab" value="S">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Inicio</label>
                                                        <input class="form-control" id="inihonorariomanha"
                                                            name="inihonorariomanha" type="time" placeholder="00:00">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Intervalo</label>
                                                        <input class="form-control" id="interhonorariomanha"
                                                            name="interhonorariomanha" type="text" placeholder="00">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Fim</label>
                                                        <input class="form-control" id="fimhonorariomanha"
                                                            name="fimhonorariomanha" type="time" placeholder="00:00">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4 align-self-end">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="bi bi-check-circle-fill me-2"></i>Salva</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#especialidade_id').select2({
                maximumSelectionLength: 2 // Limitar a seleção a 2 especialidades
            });

            // Evento de mudança no Select2
            $('#especialidade_id').on('change', function() {
            var especialidadeSelect = document.getElementById('especialidade_id');
            var campoConselho = document.getElementById('campo_conselho');
            var campoUfConselho = document.getElementById('campo_uf_conselho');
            var inputConselho = document.getElementById('input_conselho');
            var ufConselho = document.getElementById('uf_conselho');
            var labelConselho = document.getElementById('label_conselho');

            var campoConselho1 = document.getElementById('campo_conselho1');
            var campoUfConselho1 = document.getElementById('campo_uf_conselho1');
            var inputConselho1 = document.getElementById('input_conselho1');
            var ufConselho1 = document.getElementById('uf_conselho1');
            var labelConselho1 = document.getElementById('label_conselho1');

            var selectedOptions = especialidadeSelect.selectedOptions;

            // Mostrar ou esconder campos baseados no número de especialidades selecionadas
            if (selectedOptions.length >= 1) {
                var especialidade1 = selectedOptions[0].textContent.trim();
                var conselho1 = selectedOptions[0].getAttribute('data-conselho');
                labelConselho.textContent = `${especialidade1} - ${conselho1}`;
                campoConselho.classList.remove('hidden');
                campoUfConselho.classList.remove('hidden');
                inputConselho.setAttribute('required', true);
                ufConselho.setAttribute('required', true);
            } else {
                campoConselho.classList.add('hidden');
                campoUfConselho.classList.add('hidden');
                inputConselho.removeAttribute('required');
                ufConselho.removeAttribute('required');
            }

            if (selectedOptions.length === 2) {
                var especialidade2 = selectedOptions[1].textContent.trim();
                var conselho2 = selectedOptions[1].getAttribute('data-conselho');
                labelConselho1.textContent = `${especialidade2} - ${conselho2}`;
                campoConselho1.classList.remove('hidden');
                campoUfConselho1.classList.remove('hidden');
                inputConselho1.setAttribute('required', true);
                ufConselho1.setAttribute('required', true);
            } else {
                campoConselho1.classList.add('hidden');
                campoUfConselho1.classList.add('hidden');
                inputConselho1.removeAttribute('required');
                ufConselho1.removeAttribute('required');
            }
        });

        });

        function mostrarCamposEspecificos() {
            var selectTipoProfissional = document.getElementById('tipo_profissional');
            var selectedTipoProfissional = selectTipoProfissional.value;

            var campoEspecialidade = document.getElementById('campo_especialidade');
            var especialidadeSelect = document.getElementById('especialidade_id');

            // Mostrar campo de especialidades ao escolher tipo de profissional
            if (selectedTipoProfissional) {
                campoEspecialidade.classList.remove('hidden');
                especialidadeSelect.setAttribute('required', true);
            } else {
                campoEspecialidade.classList.add('hidden');
                especialidadeSelect.removeAttribute('required');
            }
        }
    </script>
@endsection

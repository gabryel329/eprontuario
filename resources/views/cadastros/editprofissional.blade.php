@extends('layouts.app')

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
                <div class="timeline-post">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs user-tabs">
                            <li class="nav-item"><a class="nav-link active" href="#dados" data-bs-toggle="tab">Dados
                                    Pessoais</a></li>
                            <li class="nav-item"><a class="nav-link" href="#convenio" data-bs-toggle="tab">Covênios</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="#honorario" data-bs-toggle="tab">Honorário</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tile">
                        <form id="profissionalForm" action="{{ route('profissional.update', $profissional->id) }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="tab-content">
                                <div class="tile tab-pane active" id="dados">
                                    <h3 class="tile-title">Editar Profissional</h3>
                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-8">
                                                <label class="form-label">Nome</label>
                                                <input class="form-control" name="name" type="text"
                                                    value="{{ old('name', $profissional->name) }}" required>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">E-mail</label>
                                                <input class="form-control" name="email" type="email"
                                                    value="{{ old('email', $profissional->email) }}" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Nascimento</label>
                                                <input class="form-control" name="nasc" type="date"
                                                    value="{{ old('nasc', $profissional->nasc) }}" max="{{ date('Y-m-d') }}"
                                                    required>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">CPF</label>
                                                <input class="form-control" id="cpf" name="cpf" type="text"
                                                    value="{{ old('cpf', $profissional->cpf) }}" required>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Gênero</label>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="genero"
                                                            value="M"
                                                            {{ old('genero', $profissional->genero) == 'M' ? 'checked' : '' }}>Masculino
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="genero"
                                                            value="F"
                                                            {{ old('genero', $profissional->genero) == 'F' ? 'checked' : '' }}>Feminino
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
                                                            data-conselho="{{ $item->conselho }}"
                                                            {{ old('tipoprof_id', $profissional->tipoprof_id) == $item->id ? 'selected' : '' }}>
                                                            {{ $item->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Por favor, selecione um tipo de profissional.
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">CBO</label>
                                                <input class="form-control" name="cbo" type="text" id="cbo"
                                                    value="{{ old('cbo', $profissional->cbo) }}">
                                            </div>
                                            <div class="mb-3 col-md-4 {{ $profissional->tipoprof_id == 1 ? '' : 'hidden' }}" id="campo_especialidade">
                                                <label class="form-label">Especialidades</label>
                                                <select class="form-control select2" id="especialidade_id"
                                                    name="especialidade_id[]" multiple style="width: 100%;">
                                                    @foreach ($especialidades as $especialidade)
                                                        <option value="{{ $especialidade->id }}"
                                                            data-conselho="{{ $especialidade->conselho }}"
                                                            {{ in_array($especialidade->id, $profissional->especialidades->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                            {{ $especialidade->especialidade }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Por favor, selecione uma especialidade.</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">R.G.</label>
                                                <input class="form-control" id="rg" name="rg" type="text"
                                                    value="{{ old('rg', $profissional->rg) }}" required>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Étnia</label>
                                                <select class="form-control" name="cor" required>
                                                    <option disabled selected value=""
                                                        style="font-size:18px;color: black;">Escolha</option>
                                                    <option value="Branco"
                                                        {{ old('cor', $profissional->cor) == 'Branco' ? 'selected' : '' }}>
                                                        Branco</option>
                                                    <option value="Preto"
                                                        {{ old('cor', $profissional->cor) == 'Preto' ? 'selected' : '' }}>
                                                        Preto</option>
                                                    <option value="Amarelo"
                                                        {{ old('cor', $profissional->cor) == 'Amarelo' ? 'selected' : '' }}>
                                                        Amarelo</option>
                                                    <option value="Pardo"
                                                        {{ old('cor', $profissional->cor) == 'Pardo' ? 'selected' : '' }}>
                                                        Pardo</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Telefone</label>
                                                <input class="form-control" id="telefone" name="telefone"
                                                    type="text"
                                                    value="{{ old('telefone', $profissional->telefone) }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Celular</label>
                                                <input class="form-control" id="celular" name="celular" type="text"
                                                    value="{{ old('celular', $profissional->celular) }}" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">CEP</label>
                                                <input class="form-control" name="cep" type="text"
                                                    value="{{ old('cep', $profissional->cep) }}" size="10"
                                                    maxlength="9" onblur="pesquisacep(this.value);" required>
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="form-label">Rua</label>
                                                <input class="form-control" name="rua" type="text"
                                                    value="{{ old('rua', $profissional->rua) }}" size="60">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Bairro</label>
                                                <input class="form-control" name="bairro" type="text"
                                                    value="{{ old('bairro', $profissional->bairro) }}" size="40">
                                            </div>
                                        </div>
                                            <div class="row">

                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Cidade</label>
                                                    <input class="form-control" name="cidade" type="text"
                                                    value="{{ old('cidade', $profissional->cidade) }}" size="40">
                                                </div>
                                                <div class="mb-3 col-md-1">
                                                    <label class="form-label">Estado</label>
                                                    <input class="form-control" name="uf" type="text"
                                                    value="{{ old('uf', $profissional->uf) }}" size="2">
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Numero</label>
                                                    <input class="form-control" name="numero" type="text"
                                                    value="{{ old('numero', $profissional->numero) }}" size="2">
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Complemento</label>
                                                    <input class="form-control" name="complemento" type="text"
                                                    value="{{ old('complemento', $profissional->complemento) }}" size="2">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="tile tab-pane" id="convenio">
                                    <h3 class="tile-title">Convênio</h3>
                                    <div class="tile-body">
                                        <div class="row d-flex align-items-center">
                                            <!-- Select2 de Convênios -->
                                            <div class="col-md-6 mb-3" id="campo_convenio">
                                                <label class="form-label">Convênios</label>
                                                <select class="form-control select2" id="convenio_id" name="convenio_id[]" multiple style="width: 100%;">
                                                    @foreach ($convenios as $convenio)
                                                        <option value="{{ $convenio->id }}"
                                                            {{ in_array($convenio->id, $profissional->convenios->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                            {{ $convenio->nome }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">Por favor, selecione ao menos um convênio.</div>
                                            </div>

                                            <!-- Campos dinâmicos de código da operadora para cada convênio selecionado -->
                                            <div class="col-md-6 d-flex flex-wrap align-items-center" id="codigo_operadora_fields">
                                                @foreach ($profissional->convenios as $convenio)
                                                    <div class="mb-3 me-2 d-flex align-items-center">
                                                        <label class="me-2">{{ $convenio->nome }} - Código Operadora:</label>
                                                        <input type="text" name="codigo_operadora[{{ $convenio->id }}]"
                                                            class="form-control" value="{{ $convenio->pivot->codigo_operadora ?? '' }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tile tab-pane" id="honorario">
                                    <h3 class="tile-title">Honorário Médico</h3>
                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Porcentagem</label>
                                                <input class="form-control" name="porcentagem" type="text"
                                                    value="{{ old('porcentagem', $profissional->porcentagem) }}"
                                                    placeholder="%">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Valor</label>
                                                <input class="form-control" name="valor" type="text"
                                                    value="{{ old('valor', $profissional->valor) }}" placeholder="R$">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Material</label>
                                                <input class="form-control" name="material" type="text"
                                                    value="{{ old('material', $profissional->material) }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Medicamento</label>
                                                <input class="form-control" name="medicamento" type="text"
                                                    value="{{ old('medicamento', $profissional->medicamento) }}">
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
                                                                    id="manha_dom" name="manha_dom" value="S"
                                                                    {{ old('manha_dom', $profissional->manha_dom) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_seg">S</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_seg" name="manha_seg" value="S"
                                                                    {{ old('manha_seg', $profissional->manha_seg) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_ter">T</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_ter" name="manha_ter" value="S"
                                                                    {{ old('manha_ter', $profissional->manha_ter) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_qua">Q</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_qua" name="manha_qua" value="S"
                                                                    {{ old('manha_qua', $profissional->manha_qua) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_qui">Q</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_qui" name="manha_qui" value="S"
                                                                    {{ old('manha_qui', $profissional->manha_qui) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_sex">S</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_sex" name="manha_sex" value="S"
                                                                    {{ old('manha_sex', $profissional->manha_sex) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="manha_sab">S</label>
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="manha_sab" name="manha_sab" value="S"
                                                                    {{ old('manha_sab', $profissional->manha_sab) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Início</label>
                                                        <input class="form-control" name="inihonorariomanha"
                                                            type="time"
                                                            value="{{ old('inihonorariomanha', $profissional->inihonorariomanha) }}"
                                                            placeholder="00:00">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Intervalo</label>
                                                        <input class="form-control" name="interhonorariomanha"
                                                            type="text"
                                                            value="{{ old('interhonorariomanha', $profissional->interhonorariomanha) }}"
                                                            placeholder="00">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Fim</label>
                                                        <input class="form-control" name="fimhonorariomanha"
                                                            type="time"
                                                            value="{{ old('fimhonorariomanha', $profissional->fimhonorariomanha) }}"
                                                            placeholder="00:00">
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
                                            class="bi bi-check-circle-fill me-2"></i>Salvar</button>
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
    <script>
        $(document).ready(function() {
            $('#cpf').mask('000.000.000-00');
            $('#telefone').mask('(00) 0000-0000');
            $('#celular').mask('(00) 00000-0000');
            $('#corem').mask('0000000-AA', {
                translation: {
                    'A': {
                        pattern: /[A-Za-z]/
                    },
                    '0': {
                        pattern: /\d/,
                        optional: true
                    }
                },
                onKeyPress: function(cep, event, currentField, options) {
                    var masks = ['000000-AA', '0000000-AA'];
                    var mask = (cep.length > 5) ? masks[1] : masks[0];
                    $('#corem').mask(mask, options);
                }
            });
            $('#crm').mask('000000-AA', {
                translation: {
                    'A': {
                        pattern: /[A-Za-z]/
                    }
                }
            });
        });

        document.querySelector('form').addEventListener('submit', function(event) {
            var generoMasculino = document.getElementById('genero_m').checked;
            var generoFeminino = document.getElementById('genero_f').checked;

            if (!generoMasculino && !generoFeminino) {
                event.preventDefault();
                alert('Por favor, selecione um gênero.');
            }
        });


        function limpa_formulário_cep() {
    // Limpa valores do formulário de CEP
    document.getElementById('rua').value = "";
    document.getElementById('bairro').value = "";
    document.getElementById('cidade').value = "";
    document.getElementById('uf').value = "";
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        // Atualiza os campos com os valores retornados
        document.getElementById('rua').value = conteudo.logradouro;
        document.getElementById('bairro').value = conteudo.bairro;
        document.getElementById('cidade').value = conteudo.localidade;
        document.getElementById('uf').value = conteudo.uf;
    } else {
        // CEP não encontrado
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function pesquisacep(valor) {
    // Nova variável "cep" somente com dígitos
    var cep = valor.replace(/\D/g, '');

    // Verifica se o campo CEP possui valor informado
    if (cep !== "") {
        // Expressão regular para validar o CEP
        var validacep = /^[0-9]{8}$/;

        // Valida o formato do CEP
        if (validacep.test(cep)) {
            // Preenche os campos com "..." enquanto consulta o webservice
            document.getElementById('rua').value = "...";
            document.getElementById('bairro').value = "...";
            document.getElementById('cidade').value = "...";
            document.getElementById('uf').value = "...";

            // Cria um elemento JavaScript
            var script = document.createElement('script');

            // Sincroniza com o callback
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            // Insere script no documento e carrega o conteúdo
            document.body.appendChild(script);
        } else {
            // CEP é inválido
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } else {
        // CEP sem valor, limpa formulário
        limpa_formulário_cep();
    }
}

        $(document).ready(function() {
    // Inicializar o Select2 com o limite de 2 seleções
    $('#especialidade_id').select2({
        maximumSelectionLength: 2, // Limitar a seleção a 2 especialidades
        allowClear: true
    });

    // Função para carregar os campos de conselho e UF ao carregar a página
    function carregarCamposDinamicos() {
        var especialidadeSelect = document.getElementById('especialidade_id');
        var selectedOptions = especialidadeSelect.selectedOptions;

        // Remove campos anteriores
        $('.campo-conselho-dinamico').remove();

        // Mostrar campos para as especialidades selecionadas (máximo de 2)
        for (var i = 0; i < selectedOptions.length && i < 2; i++) {
            var especialidade = selectedOptions[i].textContent.trim();

            // Use os valores já armazenados no banco de dados
            var conselhoExistente = i === 0 ? "{{ old('conselho_1', $profissional->conselho_1) }}" : "{{ old('conselho_2', $profissional->conselho_2) }}";
            var ufConselhoExistente = i === 0 ? "{{ old('uf_conselho_1', $profissional->uf_conselho_1) }}" : "{{ old('uf_conselho_2', $profissional->uf_conselho_2) }}";

            // Definir nome dinâmico dos campos
            var nomeConselho = i === 0 ? 'conselho_1' : 'conselho_2';
            var nomeUfConselho = i === 0 ? 'uf_conselho_1' : 'uf_conselho_2';

            // Gerar os campos com os valores preenchidos
            var conselhoHtml = `
            <div class="row campo-conselho-dinamico">
                <div class="mb-3 col-md-6">
                    <label class="form-label">${especialidade} - Conselho</label>
                    <input type="text" name="${nomeConselho}" class="form-control" value="${conselhoExistente}" placeholder="Conselho ${especialidade}" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">UF do Conselho</label>
                    <input type="text" name="${nomeUfConselho}" class="form-control" value="${ufConselhoExistente}" placeholder="UF" required>
                </div>
            </div>
            `;

            // Adiciona o campo após o último campo de especialidade
            $('#campo_especialidade').after(conselhoHtml);
        }
    }

    // Carregar campos de conselhos e UF ao abrir a página, baseado nas especialidades já selecionadas
    carregarCamposDinamicos();

    // Evento de mudança no Select2
    $('#especialidade_id').on('change', function() {
        carregarCamposDinamicos();
    });
});


    function mostrarCamposEspecificos() {
        var selectTipoProfissional = document.getElementById('tipo_profissional');
        var selectedTipoProfissional = selectTipoProfissional.value;

        var campoEspecialidade = document.getElementById('campo_especialidade');
        var especialidadeSelect = document.getElementById('especialidade_id');

        // Mostrar campo de especialidades e conselhos somente quando o tipo de profissional com ID 1 for selecionado
        if (selectedTipoProfissional === '1') {
            campoEspecialidade.classList.remove('hidden');
            especialidadeSelect.setAttribute('required', true);
            carregarCamposDinamicos(); // Chama a função de carregamento de conselhos e UF
        } else {
            // Esconder campos de especialidade e conselhos quando o tipo de profissional for diferente de 1
            campoEspecialidade.classList.add('hidden');
            especialidadeSelect.removeAttribute('required');
            $('.campo-conselho-dinamico').remove(); // Remove campos dinâmicos de conselho e UF
        }
    }

    $(document).ready(function() {
    $('#convenio_id').select2();

    $('#convenio_id').on('change', function() {
        $('#codigo_operadora_fields').empty(); // Limpa os campos atuais

        $(this).val().forEach(function(convenioId) {
            var convenioNome = $('#convenio_id option[value="' + convenioId + '"]').text();
            var campoHtml = `
                <div class="mb-3 me-2 d-flex align-items-center">
                    <label class="me-2">${convenioNome} - Código Operadora:</label>
                    <input type="text" name="codigo_operadora[${convenioId}]" class="form-control">
                </div>`;
            $('#codigo_operadora_fields').append(campoHtml);
        });
    });
});

</script>
@endsection

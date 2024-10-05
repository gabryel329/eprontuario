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
                            <li class="nav-item"><a class="nav-link active" href="#dados" data-bs-toggle="tab">Dados Pessoais</a></li>
                            <li class="nav-item"><a class="nav-link" href="#honorario" data-bs-toggle="tab">Honorário</a></li>
                        </ul>
                    </div>
                    <div class="tile">
                        <form id="profissionalForm" action="{{ route('profissional.update', $profissional->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="tab-content">
                                <div class="tile tab-pane active" id="dados">
                                    <h3 class="tile-title">Editar Profissional</h3>
                                    <div class="tile-body">
                                        <div class="row">
                                            <div class="mb-3 col-md-8">
                                                <label class="form-label">Nome</label>
                                                <input class="form-control" name="name" type="text" value="{{ old('name', $profissional->name) }}" required>
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">E-mail</label>
                                                <input class="form-control" name="email" type="email" value="{{ old('email', $profissional->email) }}" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Nascimento</label>
                                                <input class="form-control" name="nasc" type="date" value="{{ old('nasc', $profissional->nasc) }}" max="{{ date('Y-m-d') }}" required>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">CPF</label>
                                                <input class="form-control" name="cpf" type="text" value="{{ old('cpf', $profissional->cpf) }}" required>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Gênero</label>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="genero" value="M" {{ old('genero', $profissional->genero) == 'M' ? 'checked' : '' }}>Masculino
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="genero" value="F" {{ old('genero', $profissional->genero) == 'F' ? 'checked' : '' }}>Feminino
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Foto</label>
                                                <input class="form-control" type="file" name="imagem">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Tipo de Profissional</label>
                                                <select class="form-control" name="tipoprof_id" onchange="mostrarCamposEspecificos()" required>
                                                    @foreach ($tipoprof as $tipo)
                                                        <option value="{{ $tipo->id }}" {{ $profissional->tipoprof_id == $tipo->id ? 'selected' : '' }} data-conselho="{{ $tipo->conselho }}">{{ $tipo->nome }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-4 hidden" id="campo_conselho">
                                                <label class="form-label">Conselho</label>
                                                <input type="text" name="conselho" class="form-control" value="{{ old('conselho', $profissional->conselho) }}" placeholder="">
                                            </div>
                                            <div class="mb-3 col-md-4 hidden" id="campo_especialidade">
                                                <label class="form-label">Especialidades</label>
                                                <select class="form-control select2" name="especialidade_id[]" multiple style="width: 100%;">
                                                    @foreach ($especialidades as $especialidade)
                                                        <option value="{{ $especialidade->id }}" {{ $profissional->especialidades->contains($especialidade->id) ? 'selected' : '' }}>{{ $especialidade->especialidade }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">R.G.</label>
                                                <input class="form-control" name="rg" type="text" value="{{ old('rg', $profissional->rg) }}" required>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Étnia</label>
                                                <select class="form-control" name="cor" required>
                                                    <option disabled selected value="" style="font-size:18px;color: black;">Escolha</option>
                                                    <option value="Branco" {{ old('cor', $profissional->cor) == 'Branco' ? 'selected' : '' }}>Branco</option>
                                                    <option value="Preto" {{ old('cor', $profissional->cor) == 'Preto' ? 'selected' : '' }}>Preto</option>
                                                    <option value="Amarelo" {{ old('cor', $profissional->cor) == 'Amarelo' ? 'selected' : '' }}>Amarelo</option>
                                                    <option value="Pardo" {{ old('cor', $profissional->cor) == 'Pardo' ? 'selected' : '' }}>Pardo</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Telefone</label>
                                                <input class="form-control" name="telefone" type="text" value="{{ old('telefone', $profissional->telefone) }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Celular</label>
                                                <input class="form-control" name="celular" type="text" value="{{ old('celular', $profissional->celular) }}" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">CBO</label>
                                                <input class="form-control" name="cbo" type="text" id="cbo" value="{{ old('cbo', $profissional->cbo) }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">CEP</label>
                                                <input class="form-control" name="cep" type="text" value="{{ old('cep', $profissional->cep) }}" size="10" maxlength="9" onblur="pesquisacep(this.value);" required>
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Rua</label>
                                                <input class="form-control" name="rua" type="text" value="{{ old('rua', $profissional->rua) }}" size="60">
                                            </div>
                                            <div class="mb-3 col-md-2">
                                                <label class="form-label">Bairro</label>
                                                <input class="form-control" name="bairro" type="text" value="{{ old('bairro', $profissional->bairro) }}" size="40">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Cidade</label>
                                                <input class="form-control" name="cidade" type="text" value="{{ old('cidade', $profissional->cidade) }}" size="40">
                                            </div>
                                            <div class="mb-3 col-md-1">
                                                <label class="form-label">Estado</label>
                                                <input class="form-control" name="uf" type="text" value="{{ old('uf', $profissional->uf) }}" size="2">
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
                                                <input class="form-control" name="porcentagem" type="text" value="{{ old('porcentagem', $profissional->porcentagem) }}" placeholder="%">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Valor</label>
                                                <input class="form-control" name="valor" type="text" value="{{ old('valor', $profissional->valor) }}" placeholder="R$">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Material</label>
                                                <input class="form-control" name="material" type="text" value="{{ old('material', $profissional->material) }}">
                                            </div>
                                            <div class="mb-3 col-md-3">
                                                <label class="form-label">Medicamento</label>
                                                <input class="form-control" name="medicamento" type="text" value="{{ old('medicamento', $profissional->medicamento) }}">
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
                                                                <input class="form-check-input" type="checkbox" id="manha_dom" name="manha_dom" value="S" {{ old('manha_dom', $profissional->manha_dom) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_seg">S</label>
                                                                <input class="form-check-input" type="checkbox" id="manha_seg" name="manha_seg" value="S" {{ old('manha_seg', $profissional->manha_seg) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_ter">T</label>
                                                                <input class="form-check-input" type="checkbox" id="manha_ter" name="manha_ter" value="S" {{ old('manha_ter', $profissional->manha_ter) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_qua">Q</label>
                                                                <input class="form-check-input" type="checkbox" id="manha_qua" name="manha_qua" value="S" {{ old('manha_qua', $profissional->manha_qua) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_qui">Q</label>
                                                                <input class="form-check-input" type="checkbox" id="manha_qui" name="manha_qui" value="S" {{ old('manha_qui', $profissional->manha_qui) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check me-3">
                                                                <label class="form-check-label" for="manha_sex">S</label>
                                                                <input class="form-check-input" type="checkbox" id="manha_sex" name="manha_sex" value="S" {{ old('manha_sex', $profissional->manha_sex) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="form-check">
                                                                <label class="form-check-label" for="manha_sab">S</label>
                                                                <input class="form-check-input" type="checkbox" id="manha_sab" name="manha_sab" value="S" {{ old('manha_sab', $profissional->manha_sab) == 'S' ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Início</label>
                                                        <input class="form-control" name="inihonorariomanha" type="time" value="{{ old('inihonorariomanha', $profissional->inihonorariomanha) }}" placeholder="00:00">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Intervalo</label>
                                                        <input class="form-control" name="interhonorariomanha" type="text" value="{{ old('interhonorariomanha', $profissional->interhonorariomanha) }}" placeholder="00">
                                                    </div>
                                                    <div class="mb-3 col-md-2">
                                                        <label class="form-label">Fim</label>
                                                        <input class="form-control" name="fimhonorariomanha" type="time" value="{{ old('fimhonorariomanha', $profissional->fimhonorariomanha) }}" placeholder="00:00">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4 align-self-end">
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Salvar</button>
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
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
            document.getElementById('uf').value = ("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                document.getElementById('rua').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);
            } else {
                //CEP não Encontrado.
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {
            //Nova variável "cep" somente com dígitos.
            var cep = valor.replace(/\D/g, '');

            //Verifica se campo cep possui valor informado.
            if (cep != "") {
                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{8}$/;

                //Valida o formato do CEP.
                if (validacep.test(cep)) {
                    //Preenche os campos com "..." enquanto consulta webservice.
                    document.getElementById('rua').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('uf').value = "...";

                    //Cria um elemento javascript.
                    var script = document.createElement('script');

                    //Sincroniza com o callback.
                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    //Insere script no documento e carrega o conteúdo.
                    document.body.appendChild(script);
                } else {
                    //cep é inválido.
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        }

        function mostrarCamposEspecificos() {
            var selectElement = document.getElementById('tipo_profissional');
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var conselho = selectedOption.getAttribute('data-conselho');

            var campoConselho = document.getElementById('campo_conselho');
            var labelConselho = document.getElementById('label_conselho');
            var inputConselho = document.getElementById('input_conselho');
            var campoEspecialidade = document.getElementById('campo_especialidade');
            var especialidadeSelect = document.getElementById('especialidade_id');

            if (conselho && conselho !== '') {
                labelConselho.textContent = conselho;
                inputConselho.placeholder = '123456-BA';
                inputConselho.setAttribute('required', true);
                especialidadeSelect.setAttribute('required', true);
                campoConselho.classList.remove('hidden');
                campoEspecialidade.classList.remove('hidden');
            } else {
                inputConselho.removeAttribute('required');
                especialidadeSelect.removeAttribute('required');
                campoConselho.classList.add('hidden');
                campoEspecialidade.classList.add('hidden');
            }
        }

        document.getElementById('profissionalForm').addEventListener('submit', function(event) {
            var form = event.target;

            // Verificação se o Tipo de Profissional está selecionado
            var tipoProfissional = document.getElementById('tipo_profissional');
            if (!tipoProfissional.value) {
                tipoProfissional.classList.add('is-invalid');
                event.preventDefault();
            } else {
                tipoProfissional.classList.remove('is-invalid');
            }

            // Verificação se os campos Conselho e Especialidade são obrigatórios e estão preenchidos
            var conselhoRequired = !document.getElementById('campo_conselho').classList.contains('hidden');
            var inputConselho = document.getElementById('input_conselho');
            var especialidadeSelect = document.getElementById('especialidade_id');

            if (conselhoRequired) {
                if (!inputConselho.value) {
                    inputConselho.classList.add('is-invalid');
                    event.preventDefault();
                } else {
                    inputConselho.classList.remove('is-invalid');
                }
                if (!especialidadeSelect.value) {
                    especialidadeSelect.classList.add('is-invalid');
                    event.preventDefault();
                } else {
                    especialidadeSelect.classList.remove('is-invalid');
                }
            }

            // Verificação se o campo Étnia está selecionado
            var etnia = document.getElementById('cor');
            if (!etnia.value) {
                etnia.classList.add('is-invalid');
                event.preventDefault();
            } else {
                etnia.classList.remove('is-invalid');
            }
        });

        document.getElementById('tipo_profissional').addEventListener('change', function() {
            this.classList.remove('is-invalid');
        });
    </script>
@endsection

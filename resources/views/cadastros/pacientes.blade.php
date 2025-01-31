@extends('layouts.app')
@section('content')
    <main class="app-content">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-warning">
                {!! session('error') !!}
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <h3 class="tile-title">Novo Paciente</h3>
                    <div class="tile-body">
                        <form action="{{ route('paciente.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Nome Completo:</label>
                                    <input class="form-control" placeholder="*" id="name" name="name" type="text"
                                        value="{{ request('name', old('name')) }}">

                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">E-mail:</label>
                                    <input class="form-control" id="email" name="email" type="email"
                                        value="{{ old('email') }}">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Nome Social:</label>
                                    <input class="form-control" id="nome_social" name="nome_social" type="text"
                                        placeholder="Opcional" value="{{ old('nome_social') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Nascimento:</label>
                                    <input class="form-control" id="nasc" name="nasc" type="date"
                                        value="{{ old('nasc') }}" max="{{ date('Y-m-d') }}">
                                </div>
                                <div class="mb-3 col-md-1">
                                    <label class="form-label">Idade:</label>
                                    <input class="form-control" id="idade" name="idade" type="text" readonly>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">CPF: </label>
                                    <input class="form-control"  placeholder="*" id="cpf" name="cpf" type="text"
                                        value="{{ old('cpf') }}" required>
                                    <small id="cpfValidationMessage" style="color:red; display:none;">CPF inválido</small>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Gênero:</label>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="genero" name="genero"
                                                value="M" {{ old('genero') == 'M' ? 'checked' : '' }}>Masculino
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="genero" name="genero"
                                                value="F" {{ old('genero') == 'F' ? 'checked' : '' }}>Feminino
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Foto</label>
                                    <br />
                                    <button type="button" class="btn btn-primary" id="openModalButton">Tirar Foto</button>
                                    <input type="hidden" name="imagem" class="image-tag">
                                    <div id="results"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">RG</label>
                                    <input class="form-control" placeholder="*" id="rg" name="rg" type="text"
                                        value="{{ old('rg') }}" required>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Certidão de Nascimento</label>
                                    <input class="form-control" id="certidao" name="certidao" type="text"
                                        value="{{ old('certidao') }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">CNS</label>
                                    <input class="form-control" id="sus" name="sus" type="text"
                                        value="{{ old('sus') }}">
                                </div>
                            </div>
                            <div class="row">
                                <!-- Convenio Section -->
                                <div class="mb-3 col-md-6" id="convenio-container">
                                    <label class="form-label">Convênio:</label>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="convenio-sim"
                                                name="convenio_option" value="sim" onchange="toggleConvenio()">Sim
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="convenio-nao"
                                                name="convenio_option" value="nao" onchange="toggleConvenio()">Não
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-2" id="convenio-select-container" style="display:none;">
                                    <label class="form-label">Selecione:</label>
                                    <select class="form-control" id="convenio_id" name="convenio_id">
                                        <option disabled selected>Escolha</option>
                                        @foreach ($convenios as $item)
                                            <option value="{{ $item->id }}">{{ $item->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-2" id="convenio-container2" style="display:none;">
                                    <label class="form-label">Matricula</label>
                                    <input class="form-control" id="matricula" name="matricula" type="text"
                                        value="{{ old('matricula') }}">
                                </div>
                                <div class="mb-3 col-md-2" id="convenio-container3" style="display:none;">
                                    <label class="form-label">Validade</label>
                                    <input class="form-control" id="validade" name="validade" type="date"
                                        value="{{ old('validade') }}">
                                </div>
                                <div class="mb-3 col-md-2" id="convenio-container4" style="display:none;">
                                    <label class="form-label">Plano</label>
                                    <input class="form-control" id="plano" name="plano" type="text"
                                        value="{{ old('plano') }}">
                                </div>
                                <div class="mb-3 col-md-1" id="convenio-container5" style="display:none;">
                                    <label class="form-label">Produto</label>
                                    <input class="form-control" id="produto" name="produto" type="text"
                                        value="{{ old('produto') }}">
                                </div>
                                <div class="mb-3 col-md-1" id="convenio-container6" style="display:none;">
                                    <label class="form-label">Titular</label>
                                    <input class="form-control" id="titular" name="titular" type="text"
                                        value="{{ old('titular') }}">
                                </div>
                            </div>
                            <div class="row">
                                <!-- Estado Civil Section -->
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Estado Civil</label>
                                    <select class="form-control" id="estado_civil" name="estado_civil">
                                        <option disabled selected style="font-size:18px;color: black;">
                                            {{ $item->estado_civil }}</option>
                                        <option value="Solteiro(a)"
                                            {{ $item->estado_civil == 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)
                                        </option>
                                        <option value="Casado(a)"
                                            {{ $item->estado_civil == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                        <option value="Divorciado(a)"
                                            {{ $item->estado_civil == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)
                                        </option>
                                        <option value="Viuvo(a)"
                                            {{ $item->estado_civil == 'Viuvo(a)' ? 'selected' : '' }}>Viuvo(a)</option>
                                        <option value="Separado(a)"
                                            {{ $item->estado_civil == 'Separado(a)' ? 'selected' : '' }}>Separado(a)
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Etnia</label>
                                    <select class="form-control" id="cor" name="cor" required>
                                        <option disabled selected style="font-size:18px;color: black;">Escolha</option>
                                        <option value="Branco">Branco</option>
                                        <option value="Preto">Preto</option>
                                        <option value="Amarelo">Amarelo</option>
                                        <option value="Pardo">Pardo</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-4" id="pcd-container">
                                    <label class="form-label">PCD:</label>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="pcd-sim" name="pcd"
                                                onchange="togglePcd()">Sim
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" id="pcd-nao" name="pcd"
                                                onchange="togglePcd()">Não
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-2" id="pcd-container2" style="display:none;">
                                    <label class="form-label">Qual:</label>
                                    <input class="form-control" id="pcd" name="pcd" type="text"
                                        value="{{ old('pcd') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Nome do Pai</label>
                                    <input class="form-control" id="nome_pai" name="nome_pai" type="text"
                                        placeholder="Opcional" value="{{ old('nome_pai') }}">
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Nome da Mãe</label>
                                    <input class="form-control" id="nome_mae" name="nome_mae" type="text"
                                        value="{{ old('nome_mae') }}" required>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Acompanhante</label>
                                    <input class="form-control" id="acompanhante" name="acompanhante" type="text"
                                        value="{{ old('acompanhante') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Telefone</label>
                                    <input class="form-control" id="telefone" name="telefone" type="text"
                                        value="{{ old('telefone') }}">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Celular</label>
                                    <input class="form-control" id="celular" name="celular" type="text"
                                        value="{{ old('celular') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">CEP </label>
                                    <input class="form-control" placeholder="*" name="cep" type="text" id="cep"
                                        value="{{ old('cep') }}" size="10" maxlength="9"
                                        onblur="pesquisacep(this.value);" required>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Rua </label>
                                    <input class="form-control" placeholder="*" name="rua" type="text" id="rua"
                                        size="60" value="{{ old('rua') }}" required>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Bairro</label>
                                    <input class="form-control" placeholder="*" name="bairro" type="text" id="bairro"
                                        size="40" value="{{ old('bairro') }}" required>
                                </div>
                                <div class="mb-3 col-md-1">
                                    <label class="form-label">Estado</label>
                                    <input class="form-control" placeholder="*" name="uf" type="text" id="uf"
                                        size="2" value="{{ old('uf') }}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4">
                                    <label class="form-label">Cidade</label>
                                    <input class="form-control" name="cidade" type="text" id="cidade"
                                        size="40" value="{{ old('cidade') }}" required>
                                </div>
                                <div class="mb-3 col-md-2">
                                    <label class="form-label">Numero</label>
                                    <input class="form-control" name="numero" type="text" id="numero"
                                        size="40" value="{{ old('numero') }}" required>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Complemento</label>
                                    <input class="form-control" name="complemento" type="text" id="complemento"
                                        size="40" value="{{ old('complemento') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Observações</label>
                                    <textarea class="form-control" name="obs" type="text" id="obs"
                                        size="40" value="{{ old('obs') }}"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-4 align-self-end">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="bi bi-check-circle-fill me-2"></i>Salva</button>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="photoModal" tabindex="-1" role="dialog"
                                aria-labelledby="photoModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="photoModalLabel">Capturar Foto</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body d-flex flex-column align-items-center">
                                            <!-- Câmera centralizada vertical e horizontalmente -->
                                            <div id="my_camera_modal"
                                                style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                                            </div>
                                            <!-- Resultado da foto centralizado -->
                                            <div id="modal-photo-result" class="mt-3"
                                                style="width: 100%; display: flex; justify-content: center; align-items: center;">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-primary" id="snapshot-button">Tirar
                                                Foto</button>
                                            <button type="button" class="btn btn-primary d-none"
                                                id="retake-button">Tirar outra Foto</button>
                                        </div>
                                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
    <script language="JavaScript">
        $(document).ready(function() {
            // Configura a webcam
            Webcam.set({
                width: 320,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 90
            });

            // Verifica se a webcam está conectada
            function checkCameraConnection() {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(function(stream) {
                        console.log("Câmera conectada com sucesso.");
                        Webcam.attach('#my_camera_modal'); // Conecta a câmera ao elemento
                    })
                    .catch(function(err) {
                        console.error("Erro ao acessar a webcam: ", err.message);
                        displayCameraError("Não foi possível acessar a webcam. Por favor, conecte sua câmera.");

                        // Envia o erro para o backend Laravel via AJAX
                        $.ajax({
                            type: "POST",
                            url: "{{ route('webcam.check') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                error: err.message // Envia a mensagem de erro exata
                            },
                            success: function(response) {
                                if (response.status === 'error') {
                                    $('#error-container').html(
                                        '<div class="alert alert-warning">Erro ao conectar a câmera: ' +
                                        response.error + '</div>');
                                }
                            },
                            error: function(xhr) {
                                console.log("Erro na requisição AJAX.");
                            }
                        });
                    });
            }

            checkCameraConnection();
            // Função para abrir o modal e conectar a webcam
            $('#openModalButton').click(function() {
                // Abre o modal
                $('#photoModal').modal('show');
                // Conecta a webcam no modal
                Webcam.attach('#my_camera_modal');
            });

            // Função para capturar a foto e exibi-la no mesmo modal
            $('#snapshot-button').click(function() {
                Webcam.snap(function(data_uri) {
                    // Substitui o feed da câmera pela imagem capturada
                    $('#my_camera_modal').html('<img src="' + data_uri + '" class="img-fluid"/>');
                    // Coloca a imagem capturada no campo de input hidden para envio posterior
                    $('.image-tag').val(data_uri);
                    // Alterna os botões
                    $('#snapshot-button').addClass('d-none'); // Esconde o botão de tirar foto
                    $('#retake-button').removeClass('d-none'); // Mostra o botão de tirar outra foto
                });
            });

            // Função para tirar outra foto (reativar a câmera)
            $('#retake-button').click(function() {
                // Reanexar a câmera à div
                Webcam.attach('#my_camera_modal');
                // Alternar os botões de volta
                $('#retake-button').addClass('d-none'); // Esconde o botão de tirar outra foto
                $('#snapshot-button').removeClass('d-none'); // Mostra o botão de tirar foto
            });
        });
    </script>
    <script>
        function toggleConvenio() {
            if ($('#convenio-sim').is(':checked')) {
                $('#convenio-select-container').show();
                $('#convenio-container2').show();
                $('#convenio-container3').show();
                $('#convenio-container4').show();
                $('#convenio-container5').show();
                $('#convenio-container6').show();
                $('#convenio-container').removeClass('col-md-6').addClass('col-md-2');
                $('#convenio-container2').removeClass('col-md-2').addClass('col-md-2');
                $('#convenio-container3').removeClass('col-md-2').addClass('col-md-2');
                $('#convenio-container4').removeClass('col-md-2').addClass('col-md-2');
                $('#convenio-container5').removeClass('col-md-1').addClass('col-md-1');
                $('#convenio-container6').removeClass('col-md-1').addClass('col-md-1');
            } else {
                $('#convenio-select-container').hide();
                $('#convenio-container2').hide();
                $('#convenio-container3').hide();
                $('#convenio-container4').hide();
                $('#convenio-container5').hide();
                $('#convenio-container6').hide();
                $('#convenio-container').removeClass('col-md-2').addClass('col-md-6');
                $('#convenio-container2').removeClass('col-md-2').addClass('col-md-2');
                $('#convenio-container3').removeClass('col-md-2').addClass('col-md-2');
                $('#convenio-container4').removeClass('col-md-2').addClass('col-md-2');
                $('#convenio-container5').removeClass('col-md-1').addClass('col-md-1');
                $('#convenio-container6').removeClass('col-md-1').addClass('col-md-1');
            }
        }

        function togglePcd() {
            if ($('#pcd-sim').is(':checked')) {
                $('#pcd-container').removeClass('col-md-4').addClass('col-md-2');
                $('#pcd-container2').show().addClass('col-md-2');
            } else {
                $('#pcd-container').removeClass('col-md-2').addClass('col-md-4');
                $('#pcd-container2').hide().removeClass('col-md-2');
            }
        }

        $(document).ready(function() {
            // Hide the PCD container by default
            $('#pcd-container2').hide();
            togglePcd();

            // Hide the convenio select container by default
            $('#convenio-select-container').hide();
            $('#convenio-container2').hide();
        });

        function limpa_formulário_cep() {
            document.getElementById('rua').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
            document.getElementById('uf').value = ("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                document.getElementById('rua').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);
            } else {
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {
            var cep = valor.replace(/\D/g, '');

            if (cep != "") {
                var validacep = /^[0-9]{8}$/;

                if (validacep.test(cep)) {
                    document.getElementById('rua').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('uf').value = "...";

                    var script = document.createElement('script');

                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    document.body.appendChild(script);

                } else {
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                limpa_formulário_cep();
            }
        }

        $(document).ready(function() {
            // Máscaras de campos
            $('#cpf').mask('000.000.000-00');
            $('#telefone').mask('(00) 0000-0000');
            $('#celular').mask('(00) 00000-0000');
            $('#cep').mask('00000-000');
            $('#certidao').mask('00.000.000-00');
            $('#sus').mask('000.0000.0000.0000');

            // Detecta quando o CPF está completo e valida
            $('#cpf').on('input', function() {
                var cpf = $(this).val();
                if (cpf.length === 14) { // A máscara usa 14 caracteres (11 dígitos + pontos e traço)
                    if (validarCPF(cpf)) {
                        $('#cpfValidationMessage').hide(); // CPF válido
                        $(this).removeClass('is-invalid').addClass('is-valid');
                    } else {
                        $('#cpfValidationMessage').show(); // CPF inválido
                        $(this).removeClass('is-valid').addClass('is-invalid');
                    }
                }
            });

            // Verifica o CPF ao submeter o formulário
            $('form').on('submit', function(event) {
                var cpf = $('#cpf').val();
                if (!validarCPF(cpf)) {
                    event.preventDefault(); // Impede o envio do formulário
                    $('#cpfValidationMessage').show(); // Exibe a mensagem de erro
                    $('#cpf').removeClass('is-valid').addClass('is-invalid');
                    alert('CPF inválido. Por favor, verifique o número informado.');
                }
            });
        });

        document.getElementById('nasc').addEventListener('change', function() {
            var nasc = new Date(this.value);
            var today = new Date();
            var age = today.getFullYear() - nasc.getFullYear();
            var monthDifference = today.getMonth() - nasc.getMonth();
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < nasc.getDate())) {
                age--;
            }
            document.getElementById('idade').value = age;
        });
    </script>
@endsection

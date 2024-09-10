@extends('layouts.app')
@section('content')
<main class="app-content">
    @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-warning">
        {!! session('error') !!}
      </div>
    @endif
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Novo Paciente</h3>
            <div class="tile-body">
                <form action="{{route('paciente.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nome Completo:</label>
                            <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">E-mail:</label>
                            <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Nome Social:</label>
                            <input class="form-control" id="nome_social" name="nome_social" type="text" placeholder="Opcional" value="{{ old('nome_social') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Nascimento:</label>
                            <input class="form-control" id="nasc" name="nasc" type="date" value="{{ old('nasc') }}" max="{{ date('Y-m-d') }}">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">CPF: </label>
                            <input class="form-control" id="cpf" name="cpf" type="text" value="{{ old('cpf') }}" required>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Gênero:</label>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="genero" name="genero" value="M" {{ old('genero') == 'M' ? 'checked' : '' }}>Masculino
                              </label>
                            </div>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="genero" name="genero" value="F" {{ old('genero') == 'F' ? 'checked' : '' }}>Feminino
                              </label>
                            </div>
                          </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Foto</label>
                            <div id="my_camera" hidden></div>
                            <br/>
                            <button type="button" class="btn btn-primary" onclick="takeSnapshot()">Tirar Foto</button>
                            <input type="hidden" name="imagem" class="image-tag">
                            <div id="results"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">RG</label>
                            <input class="form-control" id="rg" name="rg" type="text" value="{{ old('rg') }}" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Certidão de Nascimento</label>
                            <input class="form-control" id="certidao" name="certidao" type="text" value="{{ old('certidao') }}">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">CNS</label>
                            <input class="form-control" id="sus" name="sus" type="text" value="{{ old('sus') }}">
                        </div>
                    </div>
                    <div class="row">
                        <!-- Convenio Section -->
                        <div class="mb-3 col-md-6" id="convenio-container">
                            <label class="form-label">Convênio:</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" id="convenio-sim" name="convenio_option" value="sim" onchange="toggleConvenio()">Sim
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" id="convenio-nao" name="convenio_option" value="nao" onchange="toggleConvenio()">Não
                                </label>
                            </div>
                        </div>
                        <div class="mb-3 col-md-3" id="convenio-select-container" style="display:none;">
                            <label class="form-label">Selecione:</label>
                            <select class="form-control" id="convenio" name="convenio">
                                <option disabled selected>Escolha</option>
                                @foreach ($convenios as $item)
                                    <option value="{{ $item->id }}">{{ $item->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-md-4" id="convenio-container2" style="display:none;">
                            <label class="form-label">Matricula</label>
                            <input class="form-control" id="matricula" name="matricula" type="text" value="{{ old('matricula') }}">
                        </div>
                        <div class="mb-3 col-md-6" id="convenio-container3">
                            <label class="form-label">Étnia</label>
                            <select class="form-control" id="cor" name="cor" required>
                                <option disabled selected style="font-size:18px;color: black;">Escolha</option>       
                                <option value="Branco">Branco</option>
                                <option value="Preto">Preto</option>
                                <option value="Amarelo">Amarelo</option>
                                <option value="Pardo">Pardo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6" id="pcd-container">
                            <label class="form-label">PCD:</label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" id="pcd-sim" name="pcd" onchange="togglePcd()">Sim
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" id="pcd-nao" name="pcd" onchange="togglePcd()">Não
                                </label>
                            </div>
                        </div>
                        <div class="mb-3 col-md-3" id="pcd-container2" style="display:none;">
                            <label class="form-label">Qual:</label>
                            <input class="form-control" id="pcd" name="pcd" type="text" value="{{ old('pcd') }}">
                        </div>
                        <!-- Estado Civil Section -->
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Estado Civil</label>
                            <select class="form-control" id="estado_civil" name="estado_civil">
                                <option disabled selected style="font-size:18px;color: black;">{{ $item->estado_civil }}</option>
                                <option value="Solteiro(a)" {{ $item->estado_civil == 'Solteiro(a)' ? 'selected' : '' }}>Solteiro(a)</option>
                                <option value="Casado(a)" {{ $item->estado_civil == 'Casado(a)' ? 'selected' : '' }}>Casado(a)</option>
                                <option value="Divorciado(a)" {{ $item->estado_civil == 'Divorciado(a)' ? 'selected' : '' }}>Divorciado(a)</option>
                                <option value="Viuvo(a)" {{ $item->estado_civil == 'Viuvo(a)' ? 'selected' : '' }}>Viuvo(a)</option>
                                <option value="Separado(a)" {{ $item->estado_civil == 'Separado(a)' ? 'selected' : '' }}>Separado(a)</option>
                            </select>
                        </div>
                    </div>                                                      
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Nome do Pai</label>
                            <input class="form-control" id="nome_pai" name="nome_pai" type="text" placeholder="Opcional" value="{{ old('nome_pai') }}">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Nome da Mãe</label>
                            <input class="form-control" id="nome_mae" name="nome_mae" type="text" value="{{ old('nome_mae') }}" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Acompanhante</label>
                            <input class="form-control" id="acompanhante" name="acompanhante" type="text" value="{{ old('acompanhante') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Telefone</label>
                            <input class="form-control" id="telefone" name="telefone" type="text" value="{{ old('telefone') }}">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Celular</label>
                            <input class="form-control" id="celular" name="celular" type="text" value="{{ old('celular') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label class="form-label">CEP </label>
                            <input class="form-control" name="cep" type="text" id="cep" value="{{ old('cep') }}" size="10" maxlength="9"
                            onblur="pesquisacep(this.value);" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Rua </label>
                            <input class="form-control" name="rua" type="text" id="rua" size="60" value="{{ old('rua') }}" required>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Bairro</label>
                            <input class="form-control" name="bairro" type="text" id="bairro" size="40" value="{{ old('bairro') }}" required>
                        </div>
                        <div class="mb-3 col-md-1">
                            <label class="form-label">Estado</label>
                            <input class="form-control"  name="uf" type="text" id="uf" size="2" value="{{ old('uf') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Cidade</label>
                            <input class="form-control" name="cidade" type="text" id="cidade" size="40" value="{{ old('cidade') }}" required>
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label">Numero</label>
                            <input class="form-control" name="numero" type="text" id="numero" size="40" value="{{ old('numero') }}" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Complemento</label>
                            <input class="form-control" name="complemento" type="text" id="complemento" size="40" value="{{ old('complemento') }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4 align-self-end">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Salva</button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="photoModal" tabindex="-1" role="dialog" aria-labelledby="photoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="photoModalLabel">Capturar Foto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                            <div class="modal-body">
                                <div id="my_camera_modal"></div>
                                <div id="modal-photo-result" class="text-center mt-3"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-primary" onclick="takeSnapshot()">Tirar Foto</button>
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
    Webcam.set({
        width: 320,
        height: 240,
        image_format: 'jpeg',
        jpeg_quality: 90
    });

    Webcam.on('error', function(err) {
        
        $.ajax({
            type: "POST",
            url: "{{ route('handleWebcamError') }}",
            data: {
                _token: '{{ csrf_token() }}',
                error: "Webcam não foi encontrada"
            },
            success: function(response) {
            },
            error: function(response) {
            }
        });
    });

    Webcam.attach('#my_camera');

    // Função para capturar a imagem
    window.takeSnapshot = function() {
        Webcam.snap(function(data_uri) {
            // Exibe a imagem capturada no modal
            document.getElementById('modal-photo-result').innerHTML = '<img src="'+data_uri+'"/>';
            // Armazena a imagem base64 em um input escondido
            document.querySelector('.image-tag').value = data_uri;

            // Abre o modal para mostrar a imagem capturada
            $('#photoModal').modal('show');
        });
    };
});


</script>
<script>
function toggleConvenio() {
    if ($('#convenio-sim').is(':checked')) {
        $('#convenio-select-container').show();
        $('#convenio-container2').show();
        $('#convenio-container').removeClass('col-md-6').addClass('col-md-3');
        $('#convenio-container2').removeClass('col-md-4').addClass('col-md-3');
        $('#convenio-container3').removeClass('col-md-6').addClass('col-md-3');
    } else {
        $('#convenio-select-container').hide();
        $('#convenio-container2').hide();
        $('#convenio-container').removeClass('col-md-3').addClass('col-md-6');
        $('#convenio-container2').removeClass('col-md-3').addClass('col-md-4');
        $('#convenio-container3').removeClass('col-md-3').addClass('col-md-6');
    }
}

function togglePcd() {
    if ($('#pcd-sim').is(':checked')) {
        $('#pcd-container').removeClass('col-md-6').addClass('col-md-3');
        $('#pcd-container2').show().addClass('col-md-3');
    } else {
        $('#pcd-container').removeClass('col-md-3').addClass('col-md-6');
        $('#pcd-container2').hide().removeClass('col-md-3');
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


$(document).ready(function(){
    $('#cpf').mask('000.000.000-00');
    $('#telefone').mask('(00) 0000-0000');
    $('#celular').mask('(00) 00000-0000');
    $('#cep').mask('00000-000');
    $('#rg').mask('00.000.000-0');
    $('#certidao').mask('00.000.000-00');
    $('#sus').mask('000.0000.0000.0000');
});

    function limpa_formulário_cep() {
        document.getElementById('rua').value=("");
        document.getElementById('bairro').value=("");
        document.getElementById('cidade').value=("");
        document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } else {
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }

    function pesquisacep(valor) {
        var cep = valor.replace(/\D/g, '');

        if (cep != "") {
            var validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                var script = document.createElement('script');

                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                document.body.appendChild(script);

            } else {
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } else {
            limpa_formulário_cep();
        }
    }
</script>
@endsection
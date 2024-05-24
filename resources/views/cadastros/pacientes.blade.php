@extends('layouts.app')
@section('content')
<main class="app-content">
    <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <h3 class="tile-title">Novo Paciente</h3>
            <div class="tile-body">
                <form action="{{route('paciente.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Nome </label>
                            <input class="form-control" id="name" name="name" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Sobrenome </label>
                            <input class="form-control" id="sobrenome" name="sobrenome" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">E-mail</label>
                            <input class="form-control" id="email" name="email" type="email">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Nome Social</label>
                            <input class="form-control" id="nome_social" name="nome_social" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Nascimento </label>
                            <input class="form-control" id="nasc" name="nasc" type="date">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">CPF </label>
                            <input class="form-control" id="cpf" name="cpf" type="text">
                        </div>
                        <div class="mb-3 col-md-3">
                            <label class="form-label">Gênero</label>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="genero" name="genero" value="M">Masculino
                              </label>
                            </div>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="genero" name="genero" value="F">Feminino
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
                            <label class="form-label">RG</label>
                            <input class="form-control" id="rg" name="rg" type="text">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Certidão de Nascimento</label>
                            <input class="form-control" id="certidao" name="certidao" type="text">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">SUS</label>
                            <input class="form-control" id="sus" name="sus" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Convênio</label>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="convenio" name="convenio" value="S">SIM
                              </label>
                            </div>
                            <div class="form-check">
                              <label class="form-check-label">
                                <input class="form-check-input" type="radio" id="convenio" name="convenio" value="N">NÃO
                              </label>
                            </div>
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Matricula</label>
                            <input class="form-control" id="matricula" name="matricula" type="text">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Cor</label>
                            <select class="form-control" id="cor" name="cor">
                                <option disabled selected style="font-size:18px;color: black;">Escolha</option>       
                                    <option value="Branco">Branco</option>
                                    <option value="Preto">Preto</option>
                                    <option value="Amarelo">Amarelo</option>
                                    <option value="Pardo">Pardo</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Nome do Pai</label>
                            <input class="form-control" id="nome_pai" name="nome_pai" type="text">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Nome da Mãe</label>
                            <input class="form-control" id="nome_mãe" name="nome_mãe" type="text">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Acompanhante</label>
                            <input class="form-control" id="acompanhante" name="acompanhante" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Telefone</label>
                            <input class="form-control" id="telefone" name="telefone" type="text">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Celular</label>
                            <input class="form-control" id="celular" name="celular" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-3">
                            <label class="form-label">CEP </label>
                            <input class="form-control" name="cep" type="text" id="cep" value="" size="10" maxlength="9"
                            onblur="pesquisacep(this.value);">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Rua </label>
                            <input class="form-control" name="rua" type="text" id="rua" size="60">
                        </div>
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Bairro</label>
                            <input class="form-control" name="bairro" type="text" id="bairro" size="40">
                        </div>
                        <div class="mb-3 col-md-1">
                            <label class="form-label">Estado</label>
                            <input class="form-control"  name="uf" type="text" id="uf" size="2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4">
                            <label class="form-label">Cidade</label>
                            <input class="form-control" name="cidade" type="text" id="cidade" size="40">
                        </div>
                        <div class="mb-3 col-md-2">
                            <label class="form-label">Numero</label>
                            <input class="form-control" name="numero" type="text" id="numero" size="40">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Complemento</label>
                            <input class="form-control" name="complemento" type="text" id="complemento" size="40">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-md-4 align-self-end">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Salva</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </main>
@endsection

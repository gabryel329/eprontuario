@extends('layouts.app')

@section('content')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="bi bi-ui-checks"></i> Produtos</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
            <li class="breadcrumb-item">Atendimento</li>
            <li class="breadcrumb-item"><a href="#">Produtos</a></li>
        </ul>
    </div>
    @if(session('success'))
      <div class="alert alert-success">
          {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-warning">
          {{ session('error') }}
      </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Cadastro de Produtos</h3>
                <div class="tile-body">
                    <form method="POST" action="{{ route('produtos.store') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Seção Nome e Marca -->
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Nome</label>
                                <input class="form-control" type="text" name="nome">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Marca</label>
                                <input class="form-control" type="text" name="marca">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Substancias</label>
                                <select name="substancias" id="substancias" class="form-control">

                                </select>
                            </div>
                        </div>

                        <!-- Seção Produto -->
                        <h5>Produto</h5>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Tipo</label>
                                <select class="form-control" name="tipo">
                                    <option value="MEDICAMENTO">Medicamento</option>
                                    <option value="PRODUTO">Produto</option>
                                </select>
                            </div>
                            <div class="mb-3 col-md-3">
                                <label class="form-label">Classe ABC</label>
                                <input class="form-control" type="text" name="sub_grupo">
                            </div>
                            <div class="mb-3 col-md-5">
                                <label class="form-label">Saída Por</label>
                                <input class="form-control" type="text" name="sub_grupo">
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Entrada Por</label>
                                    <input class="form-control" type="text" name="sub_grupo">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Entrada Por</label>
                                    <input class="form-control" type="text" name="sub_grupo">
                                </div>
                            </div>
                        </div>

                        <!-- Seção Faturamento -->
                        <h5>Dados Para Faturamento</h5>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Produto</label>
                                <input class="form-control" type="text" name="produto_faturamento">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Preço de Venda</label>
                                <input class="form-control" type="number" step="0.01" name="preco_venda">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Natureza</label>
                                <select class="form-control" name="natureza">
                                    <option value="NATUREZA">Natureza</option>
                                    <!-- Adicione outras opções conforme necessário -->
                                </select>
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Dt. Ultima Compra</label>
                                <input class="form-control" type="date" name="ultima_compra">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Preço Compra</label>
                                <input class="form-control" type="date" name="preco_compra">
                            </div>
                        </div>

                        <!-- Seção Outros Dados do Produto -->
                        <h5>Outros Dados do Produto</h5>
                        <div class="row">
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Ativo</label>
                                <input class="form-check-input" type="checkbox" value="SIM" name="ativo">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Controlado</label>
                                <input  class="form-check-input" type="checkbox" value="SIM" name="controlado">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Padrão</label>
                                <input class="form-check-input" type="checkbox" value="SIM" name="padrao">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">CCIH</label>
                                <input class="form-check-input" type="checkbox" value="SIM" name="ccih">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Generico</label>
                                <input class="form-check-input" type="checkbox" value="SIM" name="generico">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Antibiotico</label>
                                <input class="form-check-input" type="checkbox" value="SIM" name="antibiotico">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Consignado</label>
                                <input class="form-check-input" type="checkbox" value="SIM" name="consignado">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Disp. Emergencia</label>
                                <input class="form-check-input" type="checkbox" value="SIM" name="disp_emergencia">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Disp. Paciente</label>
                                <input class="form-check-input" type="checkbox" value="SIM" name="disp_paciente">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Fracionado</label>
                                <input class="form-check-input" type="checkbox" value="SIM" name="fracionado">
                            </div>
                            <div class="mb-3 col-md-2">
                                <label class="form-label">Imobilizado</label>
                                <input class="form-check-input" type="checkbox" value="SIM" name="imobilizado">
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="tile-footer">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

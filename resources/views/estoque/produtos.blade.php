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
                                <label class="form-label">Substâncias</label>
                                <select name="substancias" id="substancias" class="form-control">
                                    <option value="" disabled selected>Selecione a Substância</option>
                                    <option value="paracetamol">Paracetamol</option>
                                    <option value="ibuprofeno">Ibuprofeno</option>
                                    <option value="diclofenaco">Diclofenaco</option>
                                    <option value="amoxicilina">Amoxicilina</option>
                                    <option value="azitromicina">Azitromicina</option>
                                    <option value="prednisona">Prednisona</option>
                                    <option value="omeprazol">Omeprazol</option>
                                    <option value="losartana">Losartana</option>
                                    <option value="simvastatina">Simvastatina</option>
                                    <option value="metformina">Metformina</option>
                                    <option value="insulina">Insulina</option>
                                    <option value="cetoprofeno">Cetoprofeno</option>
                                    <option value="hidrocortisona">Hidrocortisona</option>
                                    <option value="cloridrato de sertralina">Cloridrato de Sertralina</option>
                                    <option value="diazepam">Diazepam</option>
                                    <option value="clonazepam">Clonazepam</option>
                                    <option value="furosemida">Furosemida</option>
                                    <option value="glibenclamida">Glibenclamida</option>
                                    <option value="levotiroxina">Levotiroxina</option>
                                    <option value="atorvastatina">Atorvastatina</option>
                                    <option value="nimesulida">Nimesulida</option>
                                    <option value="cetirizina">Cetirizina</option>
                                    <option value="morfina">Morfina</option>
                                    <option value="tramadol">Tramadol</option>
                                </select>
                            </div>
                        </div>
                        <h5>Produto</h5>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Tipo</label>
                                <select class="form-control" name="tipo">
                                    <option value="" disabled selected>Selecione o Tipo</option>
                                    <option value="MEDICAMENTO">Medicamento</option>
                                    <option value="MATERIAL">Material</option>
                                    <option value="OPME">OPME (Órteses, Próteses e Materiais Especiais)</option>
                                    <option value="SANEANTE">Saneante</option>
                                    <option value="EQUIPAMENTO">Equipamento</option>
                                    <option value="INSUMO">Insumo</option>
                                    <option value="NUTRICIONAL">Produto Nutricional</option>
                                    <option value="DISPOSITIVO MÉDICO">Dispositivo Médico</option>
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
                        <h5>Dados Para Faturamento</h5>
                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Produto</label>
                                <input class="form-control" type="text" name="produto">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Preço de Venda</label>
                                <input class="form-control" type="number" step="0.01" name="preco_venda">
                            </div>
                            <div class="mb-3 col-md-4">
                                <label class="form-label">Natureza</label>
                                <select class="form-control" name="natureza">
                                    <option value="" disabled selected>Selecione a Natureza</option>
                                    <option value="MEDICAMENTO">Medicamento</option>
                                    <option value="MATERIAL">Material</option>
                                    <option value="OPME">OPME (Órteses, Próteses e Materiais Especiais)</option>
                                    <option value="MEDICAMENTO QUIMIOTERÁPICO">Medicamento Quimioterápico</option>
                                    <option value="MEDICAMENTO RADIOFARMÁCICO">Medicamento Radiofármaco</option>
                                    <option value="EQUIPAMENTO">Equipamento</option>
                                    <option value="MATERIAL DESCARTÁVEL">Material Descartável</option>
                                    <option value="SANEANTE">Saneante</option>
                                    <option value="PRODUTO NUTRICIONAL">Produto Nutricional</option>
                                    <option value="CORRELATO">Correlato</option>
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

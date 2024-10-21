@extends('layouts.app')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="bi bi-table"></i> Lista de Medicamentos</h1>
            </div>
            <ul class="app-breadcrumb breadcrumb side">
                <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                <li class="breadcrumb-item">Administração</li>
                <li class="breadcrumb-item active"><a href="#">Medicamentos</a></li>
            </ul>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-warning">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="tile-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Editar</th>
                                        <th>Deletar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medicamentos as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->nome }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                                    Editar
                                                </button>
                                            </td>
                                            <td>
                                                <form action="{{ route('produtos.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="tipo" value="{{ $item->tipo }}">
                                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <!-- Modal de Edição -->
                                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Editar Medicamento</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('produtos.update') }}" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Nome</label>
                                                                    <input class="form-control" type="text" name="nome" value="{{ old('nome', $item->nome) }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Marca</label>
                                                                    <input class="form-control" type="text" name="marca" value="{{ old('marca', $item->marca) }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Substancias</label>
                                                                    <select name="substancias" id="substancias" class="form-control">
                                                                        <option value="" disabled selected>Selecione a Substância</option>
                                                                        <option value="paracetamol"{{ old('substancias', $item->substancias) == 'paracetamol' ? 'selected' : '' }}>Paracetamol</option>
                                                                        <option value="ibuprofeno"{{ old('substancias', $item->substancias) == 'ibuprofeno' ? 'selected' : '' }}>Ibuprofeno</option>
                                                                        <option value="diclofenaco"{{ old('substancias', $item->substancias) == 'diclofenaco' ? 'selected' : '' }}>Diclofenaco</option>
                                                                        <option value="amoxicilina"{{ old('substancias', $item->substancias) == 'amoxicilina' ? 'selected' : '' }}>Amoxicilina</option>
                                                                        <option value="azitromicina"{{ old('substancias', $item->substancias) == 'azitromicina' ? 'selected' : '' }}>Azitromicina</option>
                                                                        <option value="prednisona"{{ old('substancias', $item->substancias) == 'prednisona' ? 'selected' : '' }}>Prednisona</option>
                                                                        <option value="omeprazol"{{ old('substancias', $item->substancias) == 'omeprazol' ? 'selected' : '' }}>Omeprazol</option>
                                                                        <option value="losartana"{{ old('substancias', $item->substancias) == 'losartana' ? 'selected' : '' }}>Losartana</option>
                                                                        <option value="simvastatina"{{ old('substancias', $item->substancias) == 'simvastatina' ? 'selected' : '' }}>Simvastatina</option>
                                                                        <option value="metformina"{{ old('substancias', $item->substancias) == 'metformina' ? 'selected' : '' }}>Metformina</option>
                                                                        <option value="insulina"{{ old('substancias', $item->substancias) == 'insulina' ? 'selected' : '' }}>Insulina</option>
                                                                        <option value="cetoprofeno"{{ old('substancias', $item->substancias) == 'cetoprofeno' ? 'selected' : '' }}>Cetoprofeno</option>
                                                                        <option value="hidrocortisona"{{ old('substancias', $item->substancias) == 'hidrocortisona' ? 'selected' : '' }}>Hidrocortisona</option>
                                                                        <option value="cloridrato de sertralina"{{ old('substancias', $item->substancias) == 'cloridrato de sertralina' ? 'selected' : '' }}>Cloridrato de Sertralina</option>
                                                                        <option value="diazepam"{{ old('substancias', $item->substancias) == 'diazepam' ? 'selected' : '' }}>Diazepam</option>
                                                                        <option value="clonazepam"{{ old('substancias', $item->substancias) == 'clonazepam' ? 'selected' : '' }}>Clonazepam</option>
                                                                        <option value="furosemida"{{ old('substancias', $item->substancias) == 'furosemida' ? 'selected' : '' }}>Furosemida</option>
                                                                        <option value="glibenclamida"{{ old('substancias', $item->substancias) == 'glibenclamida' ? 'selected' : '' }}>Glibenclamida</option>
                                                                        <option value="levotiroxina"{{ old('substancias', $item->substancias) == 'levotiroxina' ? 'selected' : '' }}>Levotiroxina</option>
                                                                        <option value="atorvastatina"{{ old('substancias', $item->substancias) == 'atorvastatina' ? 'selected' : '' }}>Atorvastatina</option>
                                                                        <option value="nimesulida"{{ old('substancias', $item->substancias) == 'nimesulida' ? 'selected' : '' }}>Nimesulida</option>
                                                                        <option value="cetirizina"{{ old('substancias', $item->substancias) == 'cetirizina' ? 'selected' : '' }}>Cetirizina</option>
                                                                        <option value="morfina"{{ old('substancias', $item->substancias) == 'morfina' ? 'selected' : '' }}>Morfina</option>
                                                                        <option value="tramadol"{{ old('substancias', $item->substancias) == 'tramadol' ? 'selected' : '' }}>Tramadol</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <h5>Produto</h5>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Tipo</label>
                                                                    <select class="form-control" name="tipo">
                                                                        <option value="" disabled selected>Selecione o Tipo</option>
                                                                        <option value="MEDICAMENTO" {{ old('tipo', $item->tipo) == 'MEDICAMENTO' ? 'selected' : '' }}>Medicamento</option>
                                                                        <option value="MATERIAL" {{ old('tipo', $item->tipo) == 'MATERIAL' ? 'selected' : '' }}>Material</option>
                                                                        <option value="OPME" {{ old('tipo', $item->tipo) == 'OPME' ? 'selected' : '' }}>OPME (Órteses, Próteses e Materiais Especiais)</option>
                                                                        <option value="SANEANTE" {{ old('tipo', $item->tipo) == 'SANEANTE' ? 'selected' : '' }}>Saneante</option>
                                                                        <option value="EQUIPAMENTO" {{ old('tipo', $item->tipo) == 'EQUIPAMENTO' ? 'selected' : '' }}>Equipamento</option>
                                                                        <option value="INSUMO" {{ old('tipo', $item->tipo) == 'INSUMO' ? 'selected' : '' }}>Insumo</option>
                                                                        <option value="NUTRICIONAL" {{ old('tipo', $item->tipo) == 'NUTRICIONAL' ? 'selected' : '' }}>Produto Nutricional</option>
                                                                        <option value="DISPOSITIVO MÉDICO" {{ old('tipo', $item->tipo) == 'DISPOSITIVO MÉDICO' ? 'selected' : '' }}>Dispositivo Médico</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3 col-md-3">
                                                                    <label class="form-label">Classe ABC</label>
                                                                    <input class="form-control" type="text" name="sub_grupo" value="{{ old('sub_grupo', $item->sub_grupo) }}">
                                                                </div>
                                                                <div class="mb-3 col-md-5">
                                                                    <label class="form-label">Saída Por</label>
                                                                    <input class="form-control" type="text" name="sub_grupo" value="{{ old('sub_grupo', $item->sub_grupo) }}">
                                                                </div>
                                                                <div class="row">
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">Entrada Por</label>
                                                                        <input class="form-control" type="text" name="sub_grupo" value="{{ old('sub_grupo', $item->sub_grupo) }}">
                                                                    </div>
                                                                    <div class="mb-3 col-md-6">
                                                                        <label class="form-label">Entrada Por</label>
                                                                        <input class="form-control" type="text" name="sub_grupo" value="{{ old('sub_grupo', $item->sub_grupo) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h5>Dados Para Faturamento</h5>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Produto</label>
                                                                    <input class="form-control" type="text" name="produto" value="{{ old('produto', $item->produto) }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Preço de Venda</label>
                                                                    <input class="form-control" type="number" step="0.01" name="preco_venda" value="{{ old('preco_venda', $item->preco_venda) }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Natureza</label>
                                                                    <select class="form-control" name="natureza">
                                                                        <option value="" disabled selected>Selecione a Natureza</option>
                                                                        <option value="MEDICAMENTO" {{ old('natureza', $item->natureza) == 'MEDICAMENTO' ? 'selected' : '' }}>Medicamento</option>
                                                                        <option value="MATERIAL" {{ old('natureza', $item->natureza) == 'MATERIAL' ? 'selected' : '' }}>Material</option>
                                                                        <option value="OPME" {{ old('natureza', $item->natureza) == 'OPME' ? 'selected' : '' }}>OPME (Órteses, Próteses e Materiais Especiais)</option>
                                                                        <option value="MEDICAMENTO QUIMIOTERÁPICO" {{ old('natureza', $item->natureza) == 'MEDICAMENTO QUIMIOTERÁPICO' ? 'selected' : '' }}>Medicamento Quimioterápico</option>
                                                                        <option value="MEDICAMENTO RADIOFARMÁCICO" {{ old('natureza', $item->natureza) == 'MEDICAMENTO RADIOFARMÁCICO' ? 'selected' : '' }}>Medicamento Radiofármaco</option>
                                                                        <option value="EQUIPAMENTO" {{ old('natureza', $item->natureza) == 'EQUIPAMENTO' ? 'selected' : '' }}>Equipamento</option>
                                                                        <option value="MATERIAL DESCARTÁVEL" {{ old('natureza', $item->natureza) == 'MATERIAL DESCARTÁVEL' ? 'selected' : '' }}>Material Descartável</option>
                                                                        <option value="SANEANTE" {{ old('natureza', $item->natureza) == 'SANEANTE' ? 'selected' : '' }}>Saneante</option>
                                                                        <option value="PRODUTO NUTRICIONAL" {{ old('natureza', $item->natureza) == 'PRODUTO NUTRICIONAL' ? 'selected' : '' }}>Produto Nutricional</option>
                                                                        <option value="CORRELATO" {{ old('natureza', $item->natureza) == 'CORRELATO' ? 'selected' : '' }}>Correlato</option>
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Dt. Ultima Compra</label>
                                                                    <input class="form-control" type="date" name="ultima_compra" value="{{ old('ultima_compra', $item->ultima_compra) }}">
                                                                </div>
                                                                <div class="mb-3 col-md-4">
                                                                    <label class="form-label">Preço Compra</label>
                                                                    <input class="form-control" type="date" name="preco_compra" value="{{ old('preco_compra', $item->preco_compra) }}">
                                                                </div>
                                                            </div>
                                                            <h5>Outros Dados do Produto</h5>
                                                            <div class="row">
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">Ativo</label>
                                                                    <input class="form-check-input" type="checkbox" value="SIM" name="ativo" {{ old('ativo', $item->ativo) == 'SIM' ? 'checked' : '' }}>
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">Controlado</label>
                                                                    <input  class="form-check-input" type="checkbox" value="SIM" name="controlado" {{ old('controlado', $item->controlado) == 'SIM' ? 'checked' : '' }}>
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">Padrão</label>
                                                                    <input class="form-check-input" type="checkbox" value="SIM" name="padrao" {{ old('padrao', $item->padrao) == 'SIM' ? 'checked' : '' }}>
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">CCIH</label>
                                                                    <input class="form-check-input" type="checkbox" value="SIM" name="ccih" {{ old('ccih', $item->ccih) == 'SIM' ? 'checked' : '' }}>
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">Generico</label>
                                                                    <input class="form-check-input" type="checkbox" value="SIM" name="generico" {{ old('generico', $item->generico) == 'SIM' ? 'checked' : '' }}>
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">Antibiotico</label>
                                                                    <input class="form-check-input" type="checkbox" value="SIM" name="antibiotico" {{ old('antibiotico', $item->antibiotico) == 'SIM' ? 'checked' : '' }}>
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">Consignado</label>
                                                                    <input class="form-check-input" type="checkbox" value="SIM" name="consignado" {{ old('consignado', $item->consignado) == 'SIM' ? 'checked' : '' }}>
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">Disp. Emergencia</label>
                                                                    <input class="form-check-input" type="checkbox" value="SIM" name="disp_emergencia" {{ old('disp_emergencia', $item->disp_emergencia) == 'SIM' ? 'checked' : '' }}>
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">Disp. Paciente</label>
                                                                    <input class="form-check-input" type="checkbox" value="SIM" name="disp_paciente" {{ old('disp_paciente', $item->disp_paciente) == 'SIM' ? 'checked' : '' }}>
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">Fracionado</label>
                                                                    <input class="form-check-input" type="checkbox" value="SIM" name="fracionado" {{ old('fracionado', $item->fracionado) == 'SIM' ? 'checked' : '' }}>
                                                                </div>
                                                                <div class="mb-3 col-md-2">
                                                                    <label class="form-label">Imobilizado</label>
                                                                    <input class="form-check-input" type="checkbox" value="SIM" name="imobilizado" {{ old('imobilizado', $item->imobilizado) == 'SIM' ? 'checked' : '' }}>
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $medicamentos->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
@endsection

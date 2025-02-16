<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use App\Models\Produtos;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    public function index()
    {
        return view("estoque.produtos");
    }

    public function listaMedicamentos()
    {
        $medicamentos = Medicamento::paginate(20);
        return view("estoque.listamedicamentos", compact('medicamentos'));
    }

    public function listaProdutos()
    {
        $material = Produtos::paginate(20);
        return view("estoque.listaProdutos", compact('material'));
    }

    public function store(Request $request)
{
    $nome = ucfirst(trim($request->input('nome')));
    $marca = ucfirst(trim($request->input('marca')));
    $tipo = strtoupper(trim($request->input('tipo'))); // Para garantir que esteja sempre em caixa alta
    $grupo = trim($request->input('grupo'));
    $sub_grupo = trim($request->input('sub_grupo'));
    $preco_venda = $request->input('preco_venda') ?? 0; // Preço padrão caso não informado
    $produto = ucfirst(trim($request->input('produto')));
    $natureza = trim($request->input('natureza'));
    $substancias = $request->input('substancias');

    // Campos booleanos ajustados corretamente
    $ativo = $request->has('ativo') ? 'SIM' : 'NÃO';
    $controlado = $request->has('controlado') ? 'SIM' : 'NÃO';
    $padrao = $request->has('padrao') ? 'SIM' : 'NÃO';
    $ccih = $request->has('ccih') ? 'SIM' : 'NÃO';
    $generico = $request->has('generico') ? 'SIM' : 'NÃO';
    $antibiotico = $request->has('antibiotico') ? 'SIM' : 'NÃO';
    $consignado = $request->has('consignado') ? 'SIM' : 'NÃO';
    $disp_emergencia = $request->has('disp_emergencia') ? 'SIM' : 'NÃO';
    $disp_paciente = $request->has('disp_paciente') ? 'SIM' : 'NÃO';
    $fracionado = $request->has('fracionado') ? 'SIM' : 'NÃO';
    $imobilizado = $request->has('imobilizado') ? 'SIM' : 'NÃO';

    // Verificação de duplicidade com base no tipo
    if ($tipo === 'MEDICAMENTO') {
        $existeMedicamento = Medicamento::where('nome', $nome)->first();
        if ($existeMedicamento) {
            return redirect()->back()
                ->with('error', "Medicamento já existe: {$existeMedicamento->nome}");
        }
    } else {
        $existeProduto = Produtos::where('nome', $nome)->first();
        if ($existeProduto) {
            return redirect()->back()
                ->with('error', "Produto já existe: {$existeProduto->nome}");
        }
    }

    // Dados a serem salvos
    $dados = [
        'nome' => $nome,
        'marca' => $marca,
        'tipo' => $tipo,
        'grupo' => $grupo,
        'sub_grupo' => $sub_grupo,
        'preco_venda' => $preco_venda,
        'produto' => $produto,
        'natureza' => $natureza,
        'ativo' => $ativo,
        'controlado' => $controlado,
        'padrao' => $padrao,
        'ccih' => $ccih,
        'generico' => $generico,
        'antibiotico' => $antibiotico,
        'substancias' => $substancias,
        'consignado' => $consignado,
        'disp_emergencia' => $disp_emergencia,
        'disp_paciente' => $disp_paciente,
        'fracionado' => $fracionado,
        'imobilizado' => $imobilizado,
    ];

    // Salva no banco com base no tipo
    if ($tipo === 'MEDICAMENTO') {
        Medicamento::create($dados);
        return redirect()->back()->with('success', 'Medicamento cadastrado com sucesso!');
    } else {
        Produtos::create($dados);
        return redirect()->back()->with('success', 'Produto cadastrado com sucesso!');
    }
}

public function update(Request $request, $id)
{
    $nome = ucfirst(trim($request->input('nome')));
    $marca = ucfirst(trim($request->input('marca')));
    $tipo = trim($request->input('tipo'));
    $grupo = trim($request->input('grupo'));
    $sub_grupo = trim($request->input('sub_grupo'));
    $preco_venda = $request->input('preco_venda');
    $produto = $request->input('produto');
    $natureza = trim($request->input('natureza'));
    $ativo = $request->has('ativo');
    $controlado = $request->has('controlado');
    $padrao = $request->has('padrao');
    $ccih = $request->has('ccih');
    $generico = $request->has('generico');
    $consignado = $request->has('consignado');
    $antibiotico = $request->has('antibiotico');
    $disp_emergencia = $request->has('disp_emergencia');
    $disp_paciente = $request->has('disp_paciente');
    $fracionado = $request->has('fracionado');
    $imobilizado = $request->has('imobilizado');

    // Dados a serem atualizados
    $dadosProduto = [
        'nome' => $nome,
        'marca' => $marca,
        'tipo' => $tipo,
        'grupo' => $grupo,
        'sub_grupo' => $sub_grupo,
        'preco_venda' => $preco_venda,
        'produto' => $produto,
        'natureza' => $natureza,
        'ativo' => $ativo,
        'controlado' => $controlado,
        'padrao' => $padrao,
        'ccih' => $ccih,
        'generico' => $generico,
        'consignado' => $consignado,
        'disp_emergencia' => $disp_emergencia,
        'disp_paciente' => $disp_paciente,
        'fracionado' => $fracionado,
        'imobilizado' => $imobilizado,
        'antibiotico' => $antibiotico,
    ];

    if ($tipo == 'MEDICAMENTO') {
        $medicamento = Medicamento::find($id);

        if (!$medicamento) {
            return redirect()->back()->with('error', 'Medicamento não encontrado!');
        }

        $medicamento->update($dadosProduto);
        return redirect()->back()->with('success', 'Medicamento atualizado com sucesso!');
    } else {
        $produto = Produtos::find($id);

        if (!$produto) {
            return redirect()->back()->with('error', 'Produto não encontrado!');
        }

        $produto->update($dadosProduto);
        return redirect()->back()->with('success', 'Produto atualizado com sucesso!');
    }
}
public function destroy($id, Request $request)
{
    $tipo = strtoupper(trim($request->input('tipo'))); // Garante consistência com valores em caixa alta

    if ($tipo === 'MEDICAMENTO') {
        $medicamento = Medicamento::find($id);

        if (!$medicamento) {
            return redirect()->back()->with('error', 'Medicamento não encontrado.');
        }

        $medicamento->delete();

        return redirect()->back()->with('success', "Medicamento '{$medicamento->nome}' excluído com sucesso.");
    } elseif ($tipo === 'MATERIAL') {
        $produto = Produtos::find($id);

        if (!$produto) {
            return redirect()->back()->with('error', 'Produto não encontrado.');
        }

        $produto->delete();

        return redirect()->back()->with('success', "Produto '{$produto->nome}' excluído com sucesso.");
    } else {
        return redirect()->back()->with('error', "Tipo inválido: {$tipo}.");
    }
}



}

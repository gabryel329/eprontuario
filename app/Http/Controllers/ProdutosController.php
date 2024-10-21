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
    $tipo = trim($request->input('tipo'));
    $grupo = trim($request->input('grupo'));
    $sub_grupo = trim($request->input('sub_grupo'));
    $preco_venda = $request->input('preco_venda');
    $natureza = trim($request->input('natureza'));
    $ativo = $request->has('ativo');
    $controlado = $request->has('controlado');
    $padrao = $request->has('padrao');
    $ccih = $request->has('ccih');
    $generico = $request->has('generico');
    $consignado = $request->has('consignado');
    $antibiotico = $request->has('antibiotico');
    $substancias = $request->has('substancias');
    $disp_emergencia = $request->has('disp_emergencia');
    $disp_paciente = $request->has('disp_paciente');
    $fracionado = $request->has('fracionado');
    $imobilizado = $request->has('imobilizado');

    $existeProduto = Produtos::where('nome', $nome)->first();
    if ($existeProduto) {
        return redirect()->route('produto.index')
            ->with('error', "Produto já existe: {$existeProduto->nome}");
    }

    $existeMedicamento = Medicamento::where('nome', $nome)->first();
    if ($existeMedicamento) {
        return redirect()->back()
            ->with('error', "Medicamento já existe: {$existeMedicamento->nome}");
    }


    $dadosProduto = [
        'nome' => $nome,
        'marca' => $marca,
        'tipo' => $tipo,
        'grupo' => $grupo,
        'sub_grupo' => $sub_grupo,
        'preco_venda' => $preco_venda,
        'natureza' => $natureza,
        'ativo' => $ativo,
        'controlado' => $controlado,
        'padrao' => $padrao,
        'ccih' => $ccih,
        'generico'=> $generico,
        'antibiotico'=> $antibiotico,
        'substancias'=> $substancias,
        'consignado'=> $consignado,
        'disp_emergencia' => $disp_emergencia,
        'disp_paciente'=> $disp_paciente,
        'fracionado'=> $fracionado,
        'imobilizado'=> $imobilizado,
    ];

    if ($tipo == 'MEDICAMENTO') {
        Medicamento::create($dadosProduto);
        return redirect()->back()->with('success', 'Medicamento cadastrado com sucesso!');
    } else {
        Produtos::create($dadosProduto);
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


}

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
    $disp_emergencia = $request->has('disp_emergencia');
    $disp_paciente = $request->has('disp_paciente');
    $fracionado = $request->has('fracionado');
    $imobilizado = $request->has('imobilizado');

    $existeProduto = Produtos::where('nome', $nome)->first();
    if ($existeProduto) {
        return redirect()->route('produto.index')->with('error', 'Produto já existe!');
    }

    $existeMedicamento = Medicamento::where('nome', $nome)->first();
    if ($existeMedicamento) {
        return redirect()->back()->with('error', 'Produto já existe!');
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

}

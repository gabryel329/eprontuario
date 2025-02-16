<?php

namespace App\Http\Controllers;

use App\Models\Fornecedores;
use Illuminate\Http\Request;

class FornecedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fornecedores = Fornecedores::all();
        return view('financeiro.fornecedores', compact('fornecedores'));
    }

    public function index1()
    {
        $fornecedores = Fornecedores::all();
        return view('financeiro.listafornecedores', compact('fornecedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Captura todos os dados da requisição
        $data = $request->all();

        // Cria o fornecedor com os campos fornecidos
        Fornecedores::create([
            'cnpj' => $data['cnpj'] ?? null,
            'cpf' => $data['cpf'] ?? null,
            'name' => $data['name'] ?? null,
            'fantasia' => $data['fantasia'] ?? null,
            'insc_est' => $data['insc_est'] ?? null,
            'insc_municipal' => $data['insc_municipal'] ?? null,
            'cep' => $data['cep'] ?? null,
            'rua' => $data['rua'] ?? null,
            'numero' => $data['numero'] ?? null,
            'bairro' => $data['bairro'] ?? null,
            'cidade' => $data['cidade'] ?? null,
            'uf' => $data['uf'] ?? null,
            'tipo' => $data['tipo'] ?? null,
            'tipo_cf_a' => $data['tipo_cf_a'] ?? null,
            'grupo' => $data['grupo'] ?? null,
            'site' => $data['site'] ?? null,
            'contato_principal' => $data['contato_principal'] ?? null,
            'senha' => $data['senha'] ?? null,
            'prazo' => $data['prazo'] ?? null,
            'email' => $data['email'] ?? null,
            'telefone' => $data['telefone'] ?? null,
            'valor_mensal' => $data['valor_mensal'] ?? null,
            'ultimo_reajuste' => $data['ultimo_reajuste'] ?? null,
            'dia_vencimento' => $data['dia_vencimento'] ?? null,
            'valido_ate' => $data['valido_ate'] ?? null,
            'juros_dia' => $data['juros_dia'] ?? null,
            'multa' => $data['multa'] ?? null,
            'multa_dia' => $data['multa_dia'] ?? null,
        ]);

        // Redireciona com mensagem de sucesso
        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor criado com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Fornecedores $fornecedores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fornecedores $fornecedores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fornecedores $fornecedores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fornecedores $id)
    {
        $id->delete();

        return redirect()->route('listafornecedores.index1')->with('success', 'Fornecedor excluído com sucesso!');
    }
}

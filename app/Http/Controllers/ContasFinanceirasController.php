<?php

namespace App\Http\Controllers;

use App\Models\ContasFinanceiras;
use App\Models\Convenio;
use App\Models\Empresas;
use App\Models\Fornecedores;
use App\Models\NaturezaOperacao;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ContasFinanceirasController extends Controller
{
    public function indexContasReceber(Request $request)
    {
        // Cria a query base
        $query = ContasFinanceiras::with('fornecedores')->where('tipo_conta', 'Receber');

        // Filtro por Data
        if ($request->filled('data')) {
            $data = Carbon::createFromFormat('Y-m', $request->data)->startOfMonth();

            $query->whereMonth('data_vencimento', $data->month)
                ->whereYear('data_vencimento', $data->year);
        }

        // Filtro por Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por Nome do Fornecedor
        if ($request->filled('pesquisa')) {
            $query->whereHas('fornecedores', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->pesquisa . '%');
            });
        }

        // Atualiza contas vencidas
        $hoje = Carbon::today();
        ContasFinanceiras::where('tipo_conta', 'Receber')
            ->where('status', 'Aberto')
            ->whereDate('data_vencimento', '<', $hoje)
            ->update(['status' => 'Atrasado']);

        // Executa a consulta final
        $contasReceber = $query->get();

        // Dados adicionais
        $fornecedores = Fornecedores::all();
        $natureza = NaturezaOperacao::all();
        $empresas = Empresas::all();
        $convenios = Convenio::all();


        // Retorna a view com os filtros aplicados
        return view('financeiro.contasReceber', compact('contasReceber', 'fornecedores', 'empresas', 'natureza', 'convenios'));
    }

    public function indexContasPagar(Request $request)
    {
        // Cria a query base
        $query = ContasFinanceiras::with('fornecedores')->where('tipo_conta', 'Pagar');

        // Filtro por Data
        if ($request->filled('data')) {
            $data = Carbon::createFromFormat('Y-m', $request->data)->startOfMonth();

            $query->whereMonth('data_vencimento', $data->month)
                ->whereYear('data_vencimento', $data->year);
        }

        // Filtro por Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtro por Nome do Fornecedor
        if ($request->filled('pesquisa')) {
            $query->whereHas('fornecedores', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->pesquisa . '%');
            });
        }

        // Atualiza contas vencidas
        $hoje = Carbon::today();
        ContasFinanceiras::where('tipo_conta', 'Pagar')
            ->where('status', 'Aberto')
            ->whereDate('data_vencimento', '<', $hoje)
            ->update(['status' => 'Atrasado']);

        // Executa a consulta final
        $contasPagar = $query->get();

        // Dados adicionais
        $fornecedores = Fornecedores::all();
        $natureza = NaturezaOperacao::all();
        $empresas = Empresas::all();

        return view('financeiro.contasPagar', compact('contasPagar', 'fornecedores', 'empresas', 'natureza'));
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
        $data = $request->all();
        $numeroParcelas = (int)$data['parcelas'] ?? 1;

        // Verifica se há parcelas válidas
        if ($numeroParcelas < 1) {
            return redirect()->back()->with('error', 'Número de parcelas inválido.');
        }

        // Loop para criar registros de acordo com o número de parcelas
        for ($i = 1; $i <= $numeroParcelas; $i++) {

            // Calcula nova data de vencimento por parcela
            $dataVencimento = \Carbon\Carbon::createFromFormat('Y-m-d', $data['data_vencimento'])
                                ->addMonths($i - 1)
                                ->format('Y-m-d');

            // Calcula valor parcelado
            $valorParcela = $data['valor'] / $numeroParcelas;

            // Cria o registro da parcela
            ContasFinanceiras::create([
                'tipo_conta'        => $data['tipo_conta'],
                'status'            => 'Aberto',
                'data_emissao'      => $data['data_emissao'],
                'competencia'       => $data['competencia'],
                'data_vencimento'   => $dataVencimento,
                'referencia'        => $data['referencia'] . " - Parcela {$i}/{$numeroParcelas}",
                'tipo_doc'          => $data['tipo_documento'],
                'documento'         => $data['documento'],
                'nao_contabil'      => $data['nao_contabil'],
                'parcelas'          => "{$i}/{$numeroParcelas}",
                'centro_custos'     => $data['centro_custos'],
                'natureza_operacao' => $data['natureza_operacao'],
                'historico'         => $data['historico'],
                'fornecedor_id'     => $data['fornecedor_id'],
                // Valores financeiros
                'valor'             => number_format($valorParcela, 2, '.', ''),
                'desconto'          => $data['desconto'],
                'taxa_juros'        => $data['juros'],
                'icms'              => $data['icms'],
                'pis'               => $data['pis'],
                'cofins'            => $data['cofins'],
                'csl'               => $data['csl'],
                'iss'               => $data['iss'],
                'irrf'              => $data['irrf'],
                'inss'              => $data['inss'],
                'total'             => number_format($valorParcela, 2, '.', ''),
            ]);
        }

        return redirect()->back()->with('success', 'Conta cadastrada com sucesso!');
    }




    /**
     * Display the specified resource.
     */
    public function show(ContasFinanceiras $contasFinanceiras)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContasFinanceiras $contasFinanceiras)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $conta = ContasFinanceiras::findOrFail($id);

        // Atualiza apenas os campos relevantes
        $conta->update($request->only([
            'data_vencimento', 'valor', 'status'
        ]));

        return redirect()->back()->with('success', 'Conta atualizada com sucesso!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tipo, $id)
    {
        $conta = ContasFinanceiras::findOrFail($id);

        if ($conta->tipo_conta === $tipo) {
            $conta->delete();
            return redirect()->route('contas' . $tipo . '.index')->with('success', 'Conta excluída com sucesso!');
        }

        return redirect()->back()->with('error', 'Conta não encontrada.');
    }

}

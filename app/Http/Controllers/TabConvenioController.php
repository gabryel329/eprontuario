<?php

namespace App\Http\Controllers;

use App\Models\TabConvenio;
use Illuminate\Http\Request;

class TabConvenioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        // Validação dos campos
        $request->validate([
            'convenio_id' => 'required|exists:convenios,id',
            'tabela_id' => 'required|exists:tabelas,id',
        ]);
    
        // Verifica se já existe um vínculo com o convenio_id
        $existe = TabConvenio::where('convenio_id', $request->convenio_id)
                             ->first();
    
        if ($existe) {
            return redirect()->back()->with('error', 'O vínculo desse Convênio já existe.');
        }
    
        // Cria o novo vínculo se não existir
        TabConvenio::create([
            'convenio_id' => $request->convenio_id,
            'tabela_id' => $request->tabela_id,
        ]);
    
        return redirect()->back()->with('success', 'Vínculo entre Convênio e Tabela criado com sucesso.');
    }
    

    // Fun��o para atualizar um relacionamento existente (update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'convenio_id' => 'required|exists:convenios,id',
            'tabela_id' => 'required|exists:tabelas,id',
        ]);

        $tabConvenio = TabConvenio::findOrFail($id);
        $tabConvenio->update([
            'convenio_id' => $request->convenio_id,
            'tabela_id' => $request->tabela_id,
        ]);

        return redirect()->back()->with('success', 'Vínculo atualizado com sucesso.');
    }

    // Fun��o para deletar um relacionamento existente (destroy)
    public function destroy($id)
    {
        $tabConvenio = TabConvenio::findOrFail($id);
        $tabConvenio->delete();

        return redirect()->back()->with('success', 'Vínculo excluído com sucesso.');
    }
}

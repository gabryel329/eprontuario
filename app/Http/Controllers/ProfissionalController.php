<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Permisoes;
use App\Models\Profissional;
use App\Models\TipoProf;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfissionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $profissioanls = Profissional::all();
        $permissoes = Permisoes::all();
        $especialidades = Especialidade::all();
        $tipoprof = TipoProf::all();
    
        return view('cadastros.profissional', compact('profissioanls', 'permissoes', 'especialidades', 'tipoprof'));
    }
    

    public function index1()
    {
        $profissioanls = Profissional::orderBy('id', 'asc')->paginate(10);
        $permissoes = Permisoes::all();
        $tipoprof = TipoProf::all();
        $especialidades = Especialidade::all();

        return view('cadastros.listaprofissional', compact(['profissioanls', 'permissoes', 'especialidades', 'tipoprof']));
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
        // Capitalize the input
        $nome = ucfirst($request->input('name'));
        $sobrenome = ucfirst($request->input('sobrenome'));

        // Get the other inputs
        $email = $request->input('email');
        $nasc = $request->input('nasc');
        $cpf = $request->input('cpf');
        $genero = $request->input('genero');
        $rg = $request->input('rg');
        $cor = $request->input('cor');
        $imagem = $request->file('imagem');
        $permisoes_id = $request->input('permisoes_id');
        $especialidade_ids = $request->input('especialidade_id'); // Este é agora um array de IDs de especialidade
        $tipoprof_id = $request->input('tipoprof_id');
        $conselho = $request->input('conselho');
        $cep = $request->input('cep');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');
        $telefone = $request->input('telefone');
        $celular = $request->input('celular');
        $valor = $request->input('valor');
        $porcentagem = $request->input('porcentagem');
        $material = $request->input('material');
        $medicamento = $request->input('medicamento');

        // Get day and schedule inputs
        $manha_dom = $request->input('manha_dom');
        $manha_seg = $request->input('manha_seg');
        $manha_ter = $request->input('manha_ter');
        $manha_qua = $request->input('manha_qua');
        $manha_qui = $request->input('manha_qui');
        $manha_sex = $request->input('manha_sex');
        $manha_sab = $request->input('manha_sab');
        $inihonorariomanha = $request->input('inihonorariomanha');
        $interhonorariomanha = $request->input('interhonorariomanha');
        $fimhonorariomanha = $request->input('fimhonorariomanha');

        $tarde_dom = $request->input('tarde_dom');
        $tarde_seg = $request->input('tarde_seg');
        $tarde_ter = $request->input('tarde_ter');
        $tarde_qua = $request->input('tarde_qua');
        $tarde_qui = $request->input('tarde_qui');
        $tarde_sex = $request->input('tarde_sex');
        $tarde_sab = $request->input('tarde_sab');
        $inihonorariotarde = $request->input('inihonorariotarde');
        $interhonorariotarde = $request->input('interhonorariotarde');
        $fimhonorariotarde = $request->input('fimhonorariotarde');

        $noite_dom = $request->input('noite_dom');
        $noite_seg = $request->input('noite_seg');
        $noite_ter = $request->input('noite_ter');
        $noite_qua = $request->input('noite_qua');
        $noite_qui = $request->input('noite_qui');
        $noite_sex = $request->input('noite_sex');
        $noite_sab = $request->input('noite_sab');
        $inihonorarionoite = $request->input('inihonorarionoite');
        $interhonorarionoite = $request->input('interhonorarionoite');
        $fimhonorarionoite = $request->input('fimhonorarionoite');
        
        // Check if the user already exists
        $existeProfissional = Profissional::where('cpf', $cpf)->first();

        if ($existeProfissional) {
            return redirect()->route('profissional.index')->with('error', 'Profissional já existe!');
        }

        $existeEmail = Profissional::where('email', $email)->first();

        if ($existeEmail) {
            return redirect()->route('profissional.index')->with('error', 'Email já cadastrado!');
        }

        if ($imagem && $imagem->isValid()) {
            $filenameWithExt = $imagem->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get just ext
            $extension = $imagem->getClientOriginalExtension();
            // Filename to store
            $imageName = $filename . '.' . $extension;

            // Upload Image to the 'public/images/' directory
            $imagem->move(public_path('images/'), $imageName);

            // Create a new user
            $profissional = Profissional::create([
                'name' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'nasc' => $nasc,
                'cpf' => $cpf,
                'genero' => $genero,
                'rg' => $rg,
                'cor' => $cor,
                'imagem' => $imageName,
                'permisoes_id' => $permisoes_id,
                'conselho' => $conselho,
                'tipoprof_id' => $tipoprof_id,
                'cep' => $cep,
                'rua' => $rua,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'uf' => $uf,
                'numero' => $numero,
                'complemento' => $complemento,
                'telefone' => $telefone,
                'celular' => $celular,
                'material' => $material,
                'medicamento' => $medicamento,
                'valor' => $valor,
                'porcentagem' => $porcentagem,
                
                // Manhã
                'manha_dom' => $manha_dom,
                'manha_seg' => $manha_seg,
                'manha_ter' => $manha_ter,
                'manha_qua' => $manha_qua,
                'manha_qui' => $manha_qui,
                'manha_sex' => $manha_sex,
                'manha_sab' => $manha_sab,
                'inihonorariomanha' => $inihonorariomanha,
                'interhonorariomanha' => $interhonorariomanha,
                'fimhonorariomanha' => $fimhonorariomanha,

                // Tarde
                'tarde_dom' => $tarde_dom,
                'tarde_seg' => $tarde_seg,
                'tarde_ter' => $tarde_ter,
                'tarde_qua' => $tarde_qua,
                'tarde_qui' => $tarde_qui,
                'tarde_sex' => $tarde_sex,
                'tarde_sab' => $tarde_sab,
                'inihonorariotarde' => $inihonorariotarde,
                'interhonorariotarde' => $interhonorariotarde,
                'fimhonorariotarde' => $fimhonorariotarde,

                // Noite
                'noite_dom' => $noite_dom,
                'noite_seg' => $noite_seg,
                'noite_ter' => $noite_ter,
                'noite_qua' => $noite_qua,
                'noite_qui' => $noite_qui,
                'noite_sex' => $noite_sex,
                'noite_sab' => $noite_sab,
                'inihonorarionoite' => $inihonorarionoite,
                'interhonorarionoite' => $interhonorarionoite,
                'fimhonorarionoite' => $fimhonorarionoite,
            ]);

            // Attach especialidades
            $profissional->especialidades()->attach($especialidade_ids);
        } else {
            // Se nenhuma imagem foi enviada, crie o produto sem o campo de imagem
            $profissional = Profissional::create([
                'name' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'nasc' => $nasc,
                'cpf' => $cpf,
                'genero' => $genero,
                'rg' => $rg,
                'cor' => $cor,
                'permisoes_id' => $permisoes_id,
                'conselho' => $conselho,
                'tipoprof_id' => $tipoprof_id,
                'cep' => $cep,
                'rua' => $rua,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'uf' => $uf,
                'numero' => $numero,
                'complemento' => $complemento,
                'telefone' => $telefone,
                'celular' => $celular,
                'material' => $material,
                'medicamento' => $medicamento,
                'valor' => $valor,
                'porcentagem' => $porcentagem,

                // Manhã
                'manha_dom' => $manha_dom,
                'manha_seg' => $manha_seg,
                'manha_ter' => $manha_ter,
                'manha_qua' => $manha_qua,
                'manha_qui' => $manha_qui,
                'manha_sex' => $manha_sex,
                'manha_sab' => $manha_sab,
                'inihonorariomanha' => $inihonorariomanha,
                'interhonorariomanha' => $interhonorariomanha,
                'fimhonorariomanha' => $fimhonorariomanha,

                // Tarde
                'tarde_dom' => $tarde_dom,
                'tarde_seg' => $tarde_seg,
                'tarde_ter' => $tarde_ter,
                'tarde_qua' => $tarde_qua,
                'tarde_qui' => $tarde_qui,
                'tarde_sex' => $tarde_sex,
                'tarde_sab' => $tarde_sab,
                'inihonorariotarde' => $inihonorariotarde,
                'interhonorariotarde' => $interhonorariotarde,
                'fimhonorariotarde' => $fimhonorariotarde,

                // Noite
                'noite_dom' => $noite_dom,
                'noite_seg' => $noite_seg,
                'noite_ter' => $noite_ter,
                'noite_qua' => $noite_qua,
                'noite_qui' => $noite_qui,
                'noite_sex' => $noite_sex,
                'noite_sab' => $noite_sab,
                'inihonorarionoite' => $inihonorarionoite,
                'interhonorarionoite' => $interhonorarionoite,
                'fimhonorarionoite' => $fimhonorarionoite,
            ]);
            // Attach especialidades
            $profissional->especialidades()->attach($especialidade_ids);
        }

        return redirect()->route('profissional.index')->with('success', 'Profissional cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Find the user by ID
        $profissional = Profissional::find($id);

        if (!$profissional) {
            return redirect()->route('profissional.index')->with('error', 'Profissional não encontrado!');
        }

        // Return the view with the user data
        return view('profissional.show', compact('profissional'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{
    $profissional = Profissional::findOrFail($id);
    $tipoprof = TipoProf::all(); // Se necessário
    $especialidades = Especialidade::all(); // Se necessário

    return view('cadastros.editprofissional', compact('profissional', 'tipoprof', 'especialidades'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Capitalize the input
        $nome = ucfirst($request->input('name'));
        $sobrenome = ucfirst($request->input('sobrenome'));

        // Get the other inputs
        $email = $request->input('email');
        $nasc = $request->input('nasc');
        $cpf = $request->input('cpf');
        $genero = $request->input('genero');
        $rg = $request->input('rg');
        $cor = $request->input('cor');
        $imagem = $request->file('imagem');
        $permisoes_id = $request->input('permisoes_id');
        $especialidade_ids = $request->input('especialidade_id'); // Este é um array de IDs de especialidade
        $tipoprof_id = $request->input('tipoprof_id');
        $conselho = $request->input('conselho');
        $cep = $request->input('cep');
        $rua = $request->input('rua');
        $bairro = $request->input('bairro');
        $cidade = $request->input('cidade');
        $uf = $request->input('uf');
        $numero = $request->input('numero');
        $complemento = $request->input('complemento');
        $telefone = $request->input('telefone');
        $celular = $request->input('celular');
        $valor = $request->input('valor');
        $porcentagem = $request->input('porcentagem');
        $material = $request->input('material');
        $medicamento = $request->input('medicamento');

        // Horários
        // Manhã
        $manha_dom = $request->input('manha_dom');
        $manha_seg = $request->input('manha_seg');
        $manha_ter = $request->input('manha_ter');
        $manha_qua = $request->input('manha_qua');
        $manha_qui = $request->input('manha_qui');
        $manha_sex = $request->input('manha_sex');
        $manha_sab = $request->input('manha_sab');
        $inihonorariomanha = $request->input('inihonorariomanha');
        $interhonorariomanha = $request->input('interhonorariomanha');
        $fimhonorariomanha = $request->input('fimhonorariomanha');

        // Tarde
        $tarde_dom = $request->input('tarde_dom');
        $tarde_seg = $request->input('tarde_seg');
        $tarde_ter = $request->input('tarde_ter');
        $tarde_qua = $request->input('tarde_qua');
        $tarde_qui = $request->input('tarde_qui');
        $tarde_sex = $request->input('tarde_sex');
        $tarde_sab = $request->input('tarde_sab');
        $inihonorariotarde = $request->input('inihonorariotarde');
        $interhonorariotarde = $request->input('interhonorariotarde');
        $fimhonorariotarde = $request->input('fimhonorariotarde');

        // Noite
        $noite_dom = $request->input('noite_dom');
        $noite_seg = $request->input('noite_seg');
        $noite_ter = $request->input('noite_ter');
        $noite_qua = $request->input('noite_qua');
        $noite_qui = $request->input('noite_qui');
        $noite_sex = $request->input('noite_sex');
        $noite_sab = $request->input('noite_sab');
        $inihonorarionoite = $request->input('inihonorarionoite');
        $interhonorarionoite = $request->input('interhonorarionoite');
        $fimhonorarionoite = $request->input('fimhonorarionoite');

        // Verificar se já existe um profissional com o mesmo CPF ou email
        $existeProfissional = Profissional::where('cpf', $cpf)->where('id', '!=', $id)->first();
        if ($existeProfissional) {
            return redirect()->route('profissional.index')->with('error', 'Outro profissional com este CPF já existe!');
        }

        $existeEmail = Profissional::where('email', $email)->where('id', '!=', $id)->first();
        if ($existeEmail) {
            return redirect()->route('profissional.index')->with('error', 'Outro profissional com este email já existe!');
        }

        // Buscar o profissional existente
        $profissional = Profissional::findOrFail($id);

        // Atualizar a imagem se houver
        if ($imagem && $imagem->isValid()) {
            $filenameWithExt = $imagem->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $imagem->getClientOriginalExtension();
            $imageName = $filename . '.' . $extension;

            $imagem->move(public_path('images/'), $imageName);

            $profissional->update([
                'name' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'nasc' => $nasc,
                'cpf' => $cpf,
                'genero' => $genero,
                'rg' => $rg,
                'cor' => $cor,
                'imagem' => $imageName,
                'permisoes_id' => $permisoes_id,
                'conselho' => $conselho,
                'tipoprof_id' => $tipoprof_id,
                'cep' => $cep,
                'rua' => $rua,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'uf' => $uf,
                'numero' => $numero,
                'complemento' => $complemento,
                'telefone' => $telefone,
                'celular' => $celular,
                'material' => $material,
                'medicamento' => $medicamento,
                'valor' => $valor,
                'porcentagem' => $porcentagem,

                // Manhã
                'manha_dom' => $manha_dom,
                'manha_seg' => $manha_seg,
                'manha_ter' => $manha_ter,
                'manha_qua' => $manha_qua,
                'manha_qui' => $manha_qui,
                'manha_sex' => $manha_sex,
                'manha_sab' => $manha_sab,
                'inihonorariomanha' => $inihonorariomanha,
                'interhonorariomanha' => $interhonorariomanha,
                'fimhonorariomanha' => $fimhonorariomanha,

                // Tarde
                'tarde_dom' => $tarde_dom,
                'tarde_seg' => $tarde_seg,
                'tarde_ter' => $tarde_ter,
                'tarde_qua' => $tarde_qua,
                'tarde_qui' => $tarde_qui,
                'tarde_sex' => $tarde_sex,
                'tarde_sab' => $tarde_sab,
                'inihonorariotarde' => $inihonorariotarde,
                'interhonorariotarde' => $interhonorariotarde,
                'fimhonorariotarde' => $fimhonorariotarde,

                // Noite
                'noite_dom' => $noite_dom,
                'noite_seg' => $noite_seg,
                'noite_ter' => $noite_ter,
                'noite_qua' => $noite_qua,
                'noite_qui' => $noite_qui,
                'noite_sex' => $noite_sex,
                'noite_sab' => $noite_sab,
                'inihonorarionoite' => $inihonorarionoite,
                'interhonorarionoite' => $interhonorarionoite,
                'fimhonorarionoite' => $fimhonorarionoite,
            ]);
        } else {
            // Atualizar o usuário sem a imagem
            $profissional->update([
                'name' => $nome,
                'sobrenome' => $sobrenome,
                'email' => $email,
                'nasc' => $nasc,
                'cpf' => $cpf,
                'genero' => $genero,
                'rg' => $rg,
                'cor' => $cor,
                'permisoes_id' => $permisoes_id,
                'conselho' => $conselho,
                'tipoprof_id' => $tipoprof_id,
                'cep' => $cep,
                'rua' => $rua,
                'bairro' => $bairro,
                'cidade' => $cidade,
                'uf' => $uf,
                'numero' => $numero,
                'complemento' => $complemento,
                'telefone' => $telefone,
                'celular' => $celular,
                'material' => $material,
                'medicamento' => $medicamento,
                'valor' => $valor,
                'porcentagem' => $porcentagem,

                // Manhã
                'manha_dom' => $manha_dom,
                'manha_seg' => $manha_seg,
                'manha_ter' => $manha_ter,
                'manha_qua' => $manha_qua,
                'manha_qui' => $manha_qui,
                'manha_sex' => $manha_sex,
                'manha_sab' => $manha_sab,
                'inihonorariomanha' => $inihonorariomanha,
                'interhonorariomanha' => $interhonorariomanha,
                'fimhonorariomanha' => $fimhonorariomanha,

                // Tarde
                'tarde_dom' => $tarde_dom,
                'tarde_seg' => $tarde_seg,
                'tarde_ter' => $tarde_ter,
                'tarde_qua' => $tarde_qua,
                'tarde_qui' => $tarde_qui,
                'tarde_sex' => $tarde_sex,
                'tarde_sab' => $tarde_sab,
                'inihonorariotarde' => $inihonorariotarde,
                'interhonorariotarde' => $interhonorariotarde,
                'fimhonorariotarde' => $fimhonorariotarde,

                // Noite
                'noite_dom' => $noite_dom,
                'noite_seg' => $noite_seg,
                'noite_ter' => $noite_ter,
                'noite_qua' => $noite_qua,
                'noite_qui' => $noite_qui,
                'noite_sex' => $noite_sex,
                'noite_sab' => $noite_sab,
                'inihonorarionoite' => $inihonorarionoite,
                'interhonorarionoite' => $interhonorarionoite,
                'fimhonorarionoite' => $fimhonorarionoite,
            ]);
        }

        // Atualizar as especialidades do profissional
        $profissional->especialidades()->sync($especialidade_ids);

        return redirect()->back()->with('success', 'Profissional atualizado com sucesso!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the user by ID
        $profissional = Profissional::find($id);

        if (!$profissional) {
            return redirect()->route('profissional.index1')->with('error', 'Profissional não encontrado!');
        }

        // Delete the user
        $profissional->delete();

        return redirect()->route('profissional.index1')->with('success', 'Profissional excluído com Sucesso!');
    }
}

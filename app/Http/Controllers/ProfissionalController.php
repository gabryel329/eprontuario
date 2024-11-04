<?php

namespace App\Http\Controllers;

use App\Models\Convenio;
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
        $convenios = Convenio::all();
        $profissioanls = Profissional::all();
        $permissoes = Permisoes::all();
        $especialidades = Especialidade::all();
        $tipoprof = TipoProf::all();

        return view('cadastros.profissional', compact('profissioanls', 'permissoes', 'especialidades', 'tipoprof','convenios'));
    }


    public function index1()
    {
        $convenios = Convenio::all();
        $profissioanls = Profissional::orderBy('id', 'asc')->paginate(10);
        $permissoes = Permisoes::all();
        $tipoprof = TipoProf::all();
        $especialidades = Especialidade::all();

        return view('cadastros.listaprofissional', compact(['profissioanls', 'permissoes', 'especialidades', 'tipoprof','convenios']));
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

    // Retrieve other inputs
    $email = $request->input('email');
    $cbo = $request->input('cbo');
    $nasc = $request->input('nasc');
    $cpf = $request->input('cpf');
    $genero = $request->input('genero');
    $rg = $request->input('rg');
    $cor = $request->input('cor');
    $imagem = $request->file('imagem');
    $permisoes_id = $request->input('permisoes_id');
    $especialidade_ids = $request->input('especialidade_id');
    $tipoprof_id = $request->input('tipoprof_id');
    $ufconselho2 = $request->input('uf_conselho_2');
    $conselho2 = $request->input('conselho_2');
    $ufconselho1 = $request->input('uf_conselho_1');
    $conselho1 = $request->input('conselho_1');
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
    $convenios = $request->input('convenio_id'); // Array de convênios com codigo_operadora

    // Campos de disponibilidade de horários
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
        return redirect()->back()->withInput()->with('error', "CPF já cadastrado: <strong> Código: {$existeProfissional->id} / Nome: {$existeProfissional->name}. </strong> Tente novamente.");
    }

    $existeEmail = Profissional::where('email', $email)->first();
    if ($existeEmail) {
        return redirect()->back()->withInput()->with('error', "Email já cadastrado: <strong> Código: {$existeEmail->id} / Nome: {$existeEmail->name}. </strong> Tente novamente.");
    }

    // Handle image upload if available
    $imageName = null;
    if ($imagem && $imagem->isValid()) {
        $filenameWithExt = $imagem->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $imagem->getClientOriginalExtension();
        $imageName = $filename . '.' . $extension;
        $imagem->move(public_path('images/'), $imageName);
    }

    // Create the professional
    $profissional = Profissional::create([
        'name' => $nome,
        'sobrenome' => $sobrenome,
        'email' => $email,
        'nasc' => $nasc,
        'cpf' => $cpf,
        'genero' => $genero,
        'rg' => $rg,
        'cor' => $cor,
        'cbo' => $cbo,
        'imagem' => $imageName,
        'permisoes_id' => $permisoes_id,
        'conselho_2' => $conselho2,
        'uf_conselho_2' => $ufconselho2,
        'conselho_1' => $conselho1,
        'uf_conselho_1' => $ufconselho1,
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

        // Horários - Manhã
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

        // Horários - Tarde
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

        // Horários - Noite
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

    // Attach convenios with codigo_operadora
    if ($convenios) {
        $convenioData = [];
        foreach ($convenios as $convenio_id) {
            $codigo_operadora = $request->input("codigo_operadora_{$convenio_id}");
            $convenioData[$convenio_id] = ['codigo_operadora' => $codigo_operadora];
        }
        $profissional->convenios()->sync($convenioData);
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
    $convenios = Convenio::all();
    $profissional = Profissional::findOrFail($id);
    $tipoprof = TipoProf::all(); // Se necessário
    $especialidades = Especialidade::all(); // Se necessário

    return view('cadastros.editprofissional', compact('profissional', 'tipoprof', 'especialidades','convenios'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Capitalizar o nome e sobrenome
    $nome = ucfirst($request->input('name'));
    $sobrenome = ucfirst($request->input('sobrenome'));

    // Obtenha os demais campos
    $email = $request->input('email');
    $nasc = $request->input('nasc');
    $cpf = preg_replace('/\D/', '', $request->input('cpf')); // Remover formatação do CPF
    $genero = $request->input('genero');
    $rg = $request->input('rg');
    $cor = $request->input('cor');
    $cbo = $request->input('cbo');
    $imagem = $request->file('imagem');
    $permisoes_id = $request->input('permisoes_id');
    $especialidade_ids = $request->input('especialidade_id');
    $tipoprof_id = $request->input('tipoprof_id');
    $ufconselho2 = $request->input('uf_conselho_2');
    $conselho2 = $request->input('conselho_2');
    $ufconselho1 = $request->input('uf_conselho_1');
    $conselho1 = $request->input('conselho_1');
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

    // Verificação de duplicidade de CPF e email
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
        $profissional->imagem = $imageName;
    }

    // Atualizar informações do profissional
    $profissional->update([
        'name' => $nome,
        'sobrenome' => $sobrenome,
        'email' => $email,
        'nasc' => $nasc,
        'cpf' => $cpf,
        'genero' => $genero,
        'rg' => $rg,
        'cor' => $cor,
        'cbo' => $cbo,
        'permisoes_id' => $permisoes_id,
        'uf_conselho_2' => $ufconselho2,
        'conselho_2' => $conselho2,
        'conselho_1' => $conselho1,
        'uf_conselho_1' => $ufconselho1,
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
    ]);

    // Atualizar especialidades do profissional
    $profissional->especialidades()->sync($especialidade_ids);

    // Atualizar convênios e código da operadora
    $convenios = $request->input('convenio_id', []);
    $codigoOperadoras = $request->input('codigo_operadora', []);
    $pivotData = [];
    foreach ($convenios as $convenioId) {
        $pivotData[$convenioId] = ['codigo_operadora' => $codigoOperadoras[$convenioId] ?? null];
    }
    $profissional->convenios()->sync($pivotData);

    return redirect()->route('profissional.index')->with('success', 'Profissional atualizado com sucesso!');
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

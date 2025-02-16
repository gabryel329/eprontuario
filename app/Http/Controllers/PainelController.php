<?php

namespace App\Http\Controllers;

use App\Models\Painel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PainelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $painelTudo = Painel::all();
        $painelUnico = Painel::orderBy('updated_at', 'desc')->first(); // Pega o último registro atualizado baseado na coluna updated_at

        return view('painel.consultorio', compact('painelTudo', 'painelUnico'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Painel $painel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Painel $painel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Painel $painel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Painel $painel)
    {
        //
    }
}

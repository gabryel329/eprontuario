<?php

namespace App\Http\Controllers;

use App\Models\GuiaTiss;
use Illuminate\Http\Request;

class GuiaTissController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guiatiss = Guiatiss::all();

        return view('financeiro.guiatiss', compact('guiatiss'));
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
    public function show(GuiaTiss $guiaTiss)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GuiaTiss $guiaTiss)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GuiaTiss $guiaTiss)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GuiaTiss $guiaTiss)
    {
        //
    }
}

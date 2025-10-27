<?php

namespace App\Http\Controllers;

use App\Http\Requests\GrupoRequest;
Use Illuminate\Http\Request;
use App\Models\GrupoEconomico as grupo;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $grupos = GrupoEconomico::all();
        return view('grupos.index', compact('grupos'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('grupos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        GrupoEconomico::create($request->validated());
        return redirect()->route('grupos.index')->with('success', 'Grupo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json($grupo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('grupos.edit', compact('grupo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $grupo->update($request->validated());
        return redirect()->route('grupos.index')->with('success', 'Grupo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $grupo->delete();
        return redirect()->route('grupos.index')->with('success', 'Grupo deletado com sucesso!');
    }
}

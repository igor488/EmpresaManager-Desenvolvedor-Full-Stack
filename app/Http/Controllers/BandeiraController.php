<?php

namespace App\Http\Controllers;

use App\Http\Requests\BandeiraRequest;
Use Illuminate\Http\Request;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;


class BandeiraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bandeiras = Bandeira::with('grupoEconomico')->get();
        return response()->json($bandeiras);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grupos = GrupoEconomico::all();
        return view('bandeiras.create', compact('grupos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         Bandeira::create($request->validated());
        return redirect()->route('bandeiras.index')->with('success', 'Bandeira criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bandeira->load('grupoEconomico');
        return response()->json($bandeira);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
          $grupos = GrupoEconomico::all();
        return view('bandeiras.edit', compact('bandeira','grupos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $bandeira->update($request->validated());
        return redirect()->route('bandeiras.index')->with('success', 'Bandeira atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bandeira->delete();
        return redirect()->route('bandeiras.index')->with('success', 'Bandeira deletada com sucesso!');
    }
}

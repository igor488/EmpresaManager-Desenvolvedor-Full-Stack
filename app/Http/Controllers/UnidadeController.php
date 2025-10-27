<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnidadeRequest;
use Illuminate\Http\Request;
use App\Models\Unidade;
use App\Models\Bandeira;

class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $unidades = Unidade::with('bandeira')->get();
        return view('unidades.index', compact('unidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bandeiras = Bandeira::all();
        return view('unidades.create', compact('bandeiras'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         Unidade::create($request->validated());
        return redirect()->route('unidades.index')->with('success', 'Unidade criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unidade->load('bandeira');
        return response()->json($unidade);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bandeiras = Bandeira::all();
        return view('unidades.edit', compact('unidade','bandeiras'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unidade->update($request->validated());
        return redirect()->route('unidades.index')->with('success', 'Unidade atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unidade->delete();
        return redirect()->route('unidades.index')->with('success', 'Unidade deletada com sucesso!');
    }
}

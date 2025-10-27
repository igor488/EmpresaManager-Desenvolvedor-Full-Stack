<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Unidade;
use App\Http\Requests\FuncionarioRequest;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index()
    {
        $funcionarios = Funcionario::with('unidade')->get();
        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create()
    {
        $unidades = Unidade::all();
        return view('funcionarios.create', compact('unidades'));
    }

    public function store(FuncionarioRequest $request)
    {
        Funcionario::create($request->validated());
        return redirect()->route('funcionarios.index')->with('success', 'Colaborador criado com sucesso!');
    }

    public function edit(Funcionario $funcionario)
    {
        $unidades = Unidade::all();
        return view('funcionarios.edit', compact('funcionario','unidades'));
    }

    public function update(FuncionarioRequest $request, Funcionario $funcionario)
    {
        $funcionario->update($request->validated());
        return redirect()->route('funcionarios.index')->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy(Funcionario $funcionario)
    {
        $funcionario->delete();
        return redirect()->route('funcionarios.index')->with('success', 'Colaborador deletado com sucesso!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('produtos')->orderBy('nome')->paginate(20);
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string', 'max:1000'],
            'ativo'     => ['boolean'],
        ]);

        $validated['ativo'] = $request->boolean('ativo', true);

        Categoria::create($validated);
        return redirect()->route('admin.categorias.index')
            ->with('msg_sucesso', 'Categoria criada com sucesso!');
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $validated = $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string', 'max:1000'],
            'ativo'     => ['boolean'],
        ]);

        $validated['ativo'] = $request->boolean('ativo');

        $categoria->update($validated);
        return redirect()->route('admin.categorias.index')
            ->with('msg_sucesso', 'Categoria atualizada!');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('admin.categorias.index')
            ->with('msg_sucesso', 'Categoria removida.');
    }
}

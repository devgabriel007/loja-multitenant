<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::with('categoria')->orderBy('nome')->paginate(15);
        return view('admin.produtos.index', compact('produtos'));
    }

    public function create()
    {
        $categorias = Categoria::where('ativo', true)->orderBy('nome')->get();
        return view('admin.produtos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'         => ['required', 'string', 'max:255'],
            'descricao'    => ['nullable', 'string', 'max:5000'],
            'preco'        => ['required', 'numeric', 'min:0'],
            'preco_antigo' => ['nullable', 'numeric', 'min:0'],
            'estoque'      => ['required', 'integer', 'min:0'],
            'categoria_id' => ['nullable', 'exists:categorias,id'],
            'imagem_url'   => ['nullable', 'url', 'max:500'],
            'destaque'     => ['boolean'],
            'ativo'        => ['boolean'],
        ]);

        $validated['destaque'] = $request->boolean('destaque');
        $validated['ativo']    = $request->boolean('ativo', true);

        Produto::create($validated);
        return redirect()->route('admin.produtos.index')
            ->with('msg_sucesso', 'Produto criado com sucesso!');
    }

    public function show(Produto $produto)
    {
        return view('admin.produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        $categorias = Categoria::where('ativo', true)->orderBy('nome')->get();
        return view('admin.produtos.edit', compact('produto', 'categorias'));
    }

    public function update(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'nome'         => ['required', 'string', 'max:255'],
            'descricao'    => ['nullable', 'string', 'max:5000'],
            'preco'        => ['required', 'numeric', 'min:0'],
            'preco_antigo' => ['nullable', 'numeric', 'min:0'],
            'estoque'      => ['required', 'integer', 'min:0'],
            'categoria_id' => ['nullable', 'exists:categorias,id'],
            'imagem_url'   => ['nullable', 'url', 'max:500'],
            'destaque'     => ['boolean'],
            'ativo'        => ['boolean'],
        ]);

        $validated['destaque'] = $request->boolean('destaque');
        $validated['ativo']    = $request->boolean('ativo');

        $produto->update($validated);
        return redirect()->route('admin.produtos.index')
            ->with('msg_sucesso', 'Produto atualizado com sucesso!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('admin.produtos.index')
            ->with('msg_sucesso', 'Produto removido.');
    }
}

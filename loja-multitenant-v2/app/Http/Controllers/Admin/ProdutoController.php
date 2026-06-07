<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::orderBy('nome')->paginate(10);
        return view('admin.produtos.index', compact('produtos'));
    }

    public function create()
    {
        return view('admin.produtos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string', 'max:2000'],
            'preco'     => ['required', 'numeric', 'min:0'],
            'estoque'   => ['required', 'integer', 'min:0'],
            'ativo'     => ['boolean'],
        ]);
        Produto::create($validated);
        return redirect()->route('admin.produtos.index')->with('msg_sucesso', 'Produto criado com sucesso!');
    }

    public function show(Produto $produto)
    {
        return view('admin.produtos.show', compact('produto'));
    }

    public function edit(Produto $produto)
    {
        return view('admin.produtos.edit', compact('produto'));
    }

    public function update(Request $request, Produto $produto)
    {
        $validated = $request->validate([
            'nome'      => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string', 'max:2000'],
            'preco'     => ['required', 'numeric', 'min:0'],
            'estoque'   => ['required', 'integer', 'min:0'],
            'ativo'     => ['boolean'],
        ]);
        $produto->update($validated);
        return redirect()->route('admin.produtos.index')->with('msg_sucesso', 'Produto atualizado!');
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('admin.produtos.index')->with('msg_sucesso', 'Produto removido.');
    }
}

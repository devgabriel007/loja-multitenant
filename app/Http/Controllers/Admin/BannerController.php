<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('ordem')->get();
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo'    => ['required', 'string', 'max:255'],
            'subtitulo' => ['nullable', 'string', 'max:255'],
            'url_link'  => ['nullable', 'url', 'max:500'],
            'imagem_url'=> ['nullable', 'url', 'max:500'],
            'cor_fundo' => ['required', 'string', 'max:7'],
            'ordem'     => ['integer', 'min:0'],
            'ativo'     => ['boolean'],
        ]);

        $validated['ativo'] = $request->boolean('ativo', true);

        Banner::create($validated);
        return redirect()->route('admin.banners.index')
            ->with('msg_sucesso', 'Banner criado com sucesso!');
    }

    public function show(Banner $banner)
    {
        return view('admin.banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'titulo'    => ['required', 'string', 'max:255'],
            'subtitulo' => ['nullable', 'string', 'max:255'],
            'url_link'  => ['nullable', 'url', 'max:500'],
            'imagem_url'=> ['nullable', 'url', 'max:500'],
            'cor_fundo' => ['required', 'string', 'max:7'],
            'ordem'     => ['integer', 'min:0'],
            'ativo'     => ['boolean'],
        ]);

        $validated['ativo'] = $request->boolean('ativo');

        $banner->update($validated);
        return redirect()->route('admin.banners.index')
            ->with('msg_sucesso', 'Banner atualizado com sucesso!');
    }

    public function destroy(Banner $banner)
    {
        $banner->delete();
        return redirect()->route('admin.banners.index')
            ->with('msg_sucesso', 'Banner removido.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * ConfigController — Permite ao dono da loja editar tudo sobre sua empresa:
 * nome, cor, logo, descrição, contato, domínio e outras opções.
 */
class ConfigController extends Controller
{
    public function index()
    {
        $empresa = auth('empresa')->user();
        return view('admin.config.index', compact('empresa'));
    }

    public function update(Request $request)
    {
        $empresa = auth('empresa')->user();

        $validated = $request->validate([
            'nome'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:empresas,email,' . $empresa->id],
            'usuario'       => ['required', 'string', 'max:60', 'unique:empresas,usuario,' . $empresa->id],
            'descricao'     => ['nullable', 'string', 'max:1000'],
            'telefone'      => ['nullable', 'string', 'max:20'],
            'endereco'      => ['nullable', 'string', 'max:255'],
            'logo_url'      => ['nullable', 'url', 'max:500'],
            'cor_primaria'  => ['required', 'string', 'max:7', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'dominio'       => ['nullable', 'string', 'max:255', 'unique:empresas,dominio,' . $empresa->id],
            'slug'          => ['nullable', 'string', 'max:100', 'alpha_dash', 'unique:empresas,slug,' . $empresa->id],
            'banner_rodape' => ['boolean'],
        ]);

        $validated['banner_rodape'] = $request->boolean('banner_rodape');

        $empresa->update($validated);

        return redirect()->route('admin.config.index')
            ->with('msg_sucesso', 'Configurações da loja atualizadas com sucesso!');
    }

    public function updateSenha(Request $request)
    {
        $request->validate([
            'password'              => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ], [
            'password.min'       => 'A senha deve ter pelo menos 8 caracteres.',
            'password.confirmed' => 'A confirmação de senha não confere.',
        ]);

        auth('empresa')->user()->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.config.index')
            ->with('msg_sucesso', 'Senha alterada com sucesso!');
    }
}

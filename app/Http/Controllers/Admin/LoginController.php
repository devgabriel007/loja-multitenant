<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tenant\TenantResolver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(protected TenantResolver $resolver) {}

    public function index()
    {
        if (auth('empresa')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function logar(Request $request)
    {
        $request->validate([
            'usuario'  => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'usuario.required'  => 'O campo usuário é obrigatório.',
            'password.required' => 'O campo senha é obrigatório.',
        ]);

        if (Auth::guard('empresa')->attempt($request->only('usuario', 'password'), $request->boolean('lembrar'))) {

            $empresaLogada = auth('empresa')->user();
            $empresaTenant = $this->resolver->resolveFromRequest($request);

            if (!$empresaTenant || $empresaLogada->id !== $empresaTenant->id) {
                Auth::guard('empresa')->logout();
                return back()->withInput($request->only('usuario'))
                    ->with('msg_erro', 'Este usuário não pertence a esta loja.');
            }

            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withInput($request->only('usuario'))
            ->with('msg_erro', 'Usuário ou senha inválidos.');
    }

    public function logout(Request $request)
    {
        Auth::guard('empresa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('msg_sucesso', 'Você saiu com segurança.');
    }
}

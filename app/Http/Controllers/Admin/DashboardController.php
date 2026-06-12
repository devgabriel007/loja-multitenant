<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Categoria;
use App\Models\Produto;

class DashboardController extends Controller
{
    public function index()
    {
        $empresa         = auth('empresa')->user();
        $totalProdutos   = Produto::count();
        $totalBanners    = Banner::count();
        $totalCategorias = Categoria::count();
        $produtosRecentes = Produto::orderByDesc('created_at')->limit(5)->get();

        return view('admin.dashboard', compact(
            'empresa',
            'totalProdutos',
            'totalBanners',
            'totalCategorias',
            'produtosRecentes'
        ));
    }
}

<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use App\Models\Banner;

class DashboardController extends Controller
{
    public function index()
    {
        $empresa       = auth('empresa')->user();
        $totalProdutos = Produto::count();
        $totalBanners  = Banner::count();
        $produtosRecentes = Produto::latest()->limit(5)->get();
        return view('admin.dashboard', compact('empresa', 'totalProdutos', 'totalBanners', 'produtosRecentes'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Veiculo;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // ========== LOGIN ==========
    public function login()
    {
        return view('admin.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    // ========== DASHBOARD ==========
    public function dashboard()
    {
        $totalVeiculos = \App\Models\Veiculo::count();
        $disponiveis = \App\Models\Veiculo::where('status', 'disponivel')->count();
        $vendidos = \App\Models\Veiculo::where('status', 'vendido')->count();
        $totalMarcas = \App\Models\Marca::count();

        $veiculosNaVitrine = \App\Models\Veiculo::where('ativo', true)->count();
        $veiculosOcultos = \App\Models\Veiculo::where('ativo', false)->count();
        $valorTotalEstoque = \App\Models\Veiculo::sum('preco');

        $ultimosVeiculos = \App\Models\Veiculo::with('marca')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalVeiculos',
            'disponiveis',
            'vendidos',
            'totalMarcas',
            'veiculosNaVitrine',
            'veiculosOcultos',
            'valorTotalEstoque',
            'ultimosVeiculos'
        ));
    }
}

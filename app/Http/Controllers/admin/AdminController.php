<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Marca;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function auth(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()
            ->withErrors([
                'email' => 'Credenciais inválidas.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        $totalVeiculos = Veiculo::count();
        $disponiveis = Veiculo::where('status', 'disponivel')->count();
        $vendidos = Veiculo::where('status', 'vendido')->count();
        $totalMarcas = Marca::count();

        $veiculosNaVitrine = Veiculo::where('ativo', true)->count();
        $veiculosOcultos = Veiculo::where('ativo', false)->count();
        $valorTotalEstoque = Veiculo::sum('preco');

        $ultimosVeiculos = Veiculo::with('marca')
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
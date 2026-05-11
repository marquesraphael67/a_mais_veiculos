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
        // Cards
        $totalVeiculos = Veiculo::count();
        $disponiveis = Veiculo::where('status', 'disponivel')->count();
        $vendidos = Veiculo::where('status', 'vendido')->count();
        $totalMarcas = Marca::count();
        
        // Últimos veículos
        $ultimosVeiculos = Veiculo::with('fotos', 'marca')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();
        
        // Dados para gráfico de tipos
        $tipos = Veiculo::select('tipo_veiculo', DB::raw('count(*) as total'))
            ->groupBy('tipo_veiculo')
            ->get();
        
        $tiposLabels = $tipos->map(function($item) {
            $labels = [
                'carro' => '🚗 Carro',
                'moto' => '🏍️ Moto',
                'caminhao' => '🚛 Caminhão',
                'jetski' => '🌊 Jet Ski',
                'lancha' => '⛵ Lancha'
            ];
            return $labels[$item->tipo_veiculo] ?? $item->tipo_veiculo;
        });
        
        $tiposData = $tipos->pluck('total');
        
        // Top marcas
        $topMarcas = Marca::withCount('veiculos')
            ->having('veiculos_count', '>', 0)
            ->orderBy('veiculos_count', 'desc')
            ->limit(5)
            ->get();
        
        // Vendas mensais (últimos 12 meses)
        $vendasMensais = [];
        $cadastrosMensais = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $data = now()->subMonths($i);
            
            $vendidosCount = Veiculo::where('status', 'vendido')
                ->whereYear('updated_at', $data->year)
                ->whereMonth('updated_at', $data->month)
                ->count();
            
            $cadastradosCount = Veiculo::whereYear('created_at', $data->year)
                ->whereMonth('created_at', $data->month)
                ->count();
            
            $vendasMensais[] = $vendidosCount;
            $cadastrosMensais[] = $cadastradosCount;
        }
        
        return view('admin.dashboard', compact(
            'totalVeiculos',
            'disponiveis',
            'vendidos',
            'totalMarcas',
            'ultimosVeiculos',
            'tiposLabels',
            'tiposData',
            'topMarcas',
            'vendasMensais',
            'cadastrosMensais'
        ));
    }
}
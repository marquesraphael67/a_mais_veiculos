<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Mostrar tela de login
    public function login()
    {
        return view('admin.login');
    }
    
    // Processar login
    public function auth(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        // Pega o IP do servidor para redirecionar corretamente
        $serverIp = $_SERVER['SERVER_ADDR'] ?? 'localhost';
        $port = $_SERVER['SERVER_PORT'] ?? '8000';
        
        return redirect()->to("http://{$serverIp}:{$port}/admin");
    }
    
    return back()->withErrors([
        'email' => 'Credenciais inválidas.',
    ]);
}
    
    // Dashboard
    public function dashboard()
{
    $totalVeiculos = Veiculo::count();
    $totalDisponiveis = Veiculo::where('status', 'disponivel')->count();
    $totalVendidos = Veiculo::where('status', 'vendido')->count();
    $totalMarcas = Marca::count();
    $ultimosVeiculos = Veiculo::with('marca')->orderBy('id', 'desc')->limit(5)->get();
    
    return view('admin.dashboard', compact('totalVeiculos', 'totalDisponiveis', 'totalVendidos', 'totalMarcas', 'ultimosVeiculos'));
}
    
    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
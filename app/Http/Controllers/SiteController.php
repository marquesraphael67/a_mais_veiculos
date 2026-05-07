<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Marca;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        // Removemos o 'com fotos' por enquanto
        $veiculos = Veiculo::with('marca')->where('status', 'disponivel')->get();
        $marcas = Marca::all();
        return view('site.home', compact('veiculos', 'marcas'));
    }
    
    public function show($id)
{
    // Carregar o veículo com as fotos da galeria
    $veiculo = Veiculo::with('marca', 'fotos')->findOrFail($id);
    return view('site.detalhes', compact('veiculo'));
}
    
    public function filtrar(Request $request)
    {
        $query = Veiculo::with('marca')->where('status', 'disponivel');
        
        if ($request->marca_id) {
            $query->where('marca_id', $request->marca_id);
        }
        if ($request->preco_max) {
            $query->where('preco', '<=', $request->preco_max);
        }
        if ($request->ano_min) {
            $query->where('ano', '>=', $request->ano_min);
        }
        
        $veiculos = $query->get();
        return response()->json($veiculos);
    }
}
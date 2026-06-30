<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $veiculos = Veiculo::with('marca')
            ->where('status', 'disponivel')
            ->where('ativo', true)
            ->latest()
            ->get();

        $marcas = Marca::orderBy('nome')->get();

        return view('site.home', compact('veiculos', 'marcas'));
    }

    public function show($id)
    {
        $veiculo = Veiculo::with('marca', 'fotos')
            ->where('ativo', true)
            ->findOrFail($id);

        return view('site.detalhes', compact('veiculo'));
    }

    public function filtrar(Request $request)
    {
        $query = Veiculo::with('marca')
            ->where('status', 'disponivel')
            ->where('ativo', true);

        if ($request->filled('marca_id')) {
            $query->where('marca_id', $request->marca_id);
        }

        if ($request->filled('preco_max')) {
            $query->where('preco', '<=', $request->preco_max);
        }

        if ($request->filled('ano_min')) {
            $query->where('ano', '>=', $request->ano_min);
        }

        $veiculos = $query
            ->latest()
            ->get();

        return response()->json($veiculos);
    }
}
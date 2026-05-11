<?php

namespace App\Http\Controllers\Admin;  // ← IMPORTANTE: com Admin

use App\Http\Controllers\Controller;
use App\Models\Marca;
use Illuminate\Http\Request;

class AdminMarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::withCount('veiculos')->get();
        return view('admin.marcas.index', compact('marcas'));
    }
    
    public function create()
    {
        return view('admin.marcas.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:marcas',
            'descricao' => 'nullable|string'
        ]);
        
        Marca::create($request->all());
        
        return redirect()->route('admin.marcas.index')
            ->with('success', 'Marca cadastrada com sucesso!');
    }
    
    public function edit($id)
    {
        $marca = Marca::findOrFail($id);
        return view('admin.marcas.edit', compact('marca'));
    }
    
    public function update(Request $request, $id)
    {
        $marca = Marca::findOrFail($id);
        
        $request->validate([
            'nome' => 'required|string|max:100|unique:marcas,nome,' . $id,
            'descricao' => 'nullable|string'
        ]);
        
        $marca->update($request->all());
        
        return redirect()->route('admin.marcas.index')
            ->with('success', 'Marca atualizada com sucesso!');
    }
    
    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);
        
        // Verificar se tem veículos vinculados
        if ($marca->veiculos()->count() > 0) {
            return redirect()->route('admin.marcas.index')
                ->with('error', 'Não é possível excluir esta marca pois ela possui veículos vinculados.');
        }
        
        $marca->delete();
        
        return redirect()->route('admin.marcas.index')
            ->with('success', 'Marca excluída com sucesso!');
    }
}
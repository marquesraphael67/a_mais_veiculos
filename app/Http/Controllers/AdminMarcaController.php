<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class AdminMarcaController extends Controller
{
    public function index()
    {
        $marcas = Marca::orderBy('nome', 'asc')->paginate(15);
        return view('admin.marcas.index', compact('marcas'));
    }
    
    public function create()
    {
        return view('admin.marcas.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:50|unique:marcas',
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
            'nome' => 'required|string|max:50|unique:marcas,nome,' . $id,
        ]);
        
        $marca->update($request->all());
        
        return redirect()->route('admin.marcas.index')
            ->with('success', 'Marca atualizada com sucesso!');
    }
    
    public function destroy($id)
    {
        $marca = Marca::findOrFail($id);
        
        if ($marca->veiculos()->count() > 0) {
            return redirect()->route('admin.marcas.index')
                ->with('error', 'Não é possível excluir esta marca pois existem veículos vinculados.');
        }
        
        $marca->delete();
        
        return redirect()->route('admin.marcas.index')
            ->with('success', 'Marca excluída com sucesso!');
    }
}
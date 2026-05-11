<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Veiculo;
use App\Models\Marca;
use App\Models\FotoVeiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminVeiculoController extends Controller
{
    public function index()
    {
        $veiculos = Veiculo::with('fotos', 'marca')->orderBy('id', 'desc')->paginate(15);
        return view('admin.veiculos.index', compact('veiculos'));
    }
    
    public function observacoes()
    {
        $veiculos = Veiculo::with('marca')
            ->orderBy('id', 'desc')
            ->get();
        
        return view('admin.veiculos.observacoes', compact('veiculos'));
    }
    
    public function create()
    {
        $marcas = Marca::all();
        return view('admin.veiculos.create', compact('marcas'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'marca_id' => 'nullable|exists:marcas,id',
            'modelo' => 'required|string|max:255',
            'ano' => 'required|integer',
            'preco' => 'required|numeric',
            'preco_antigo' => 'nullable|numeric',
            'desconto_maximo' => 'nullable|numeric',
            'km' => 'nullable|numeric',
            'horas_uso' => 'nullable|numeric',
            'cor' => 'nullable|string|max:50',
            'combustivel' => 'nullable|string|max:50',
            'portas' => 'nullable|integer',
            'descricao' => 'nullable|string',
            'obs_admin' => 'nullable|string',
            'status' => 'required|in:disponivel,vendido',
            'tipo_veiculo' => 'required|in:carro,moto,caminhao,jetski,lancha',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|max:20480',
            'imagem_destaque' => 'nullable|image|max:20480'
        ]);
        
        // Criar o veículo
        $veiculo = Veiculo::create($request->except('fotos', 'imagem_destaque'));
        
        // Processar imagem de destaque se houver
        if ($request->hasFile('imagem_destaque')) {
            $destaque = $request->file('imagem_destaque');
            $nomeDestaque = 'destaque_' . $veiculo->id . '_' . Str::random(10) . '.jpg';
            $caminhoDestaque = $destaque->storeAs('veiculos/destaques', $nomeDestaque, 'public');
            $veiculo->update(['imagem_destaque' => $caminhoDestaque]);
        } else {
            // Se não tiver imagem destaque, coloca um valor padrão
            $veiculo->update(['imagem_destaque' => null]);
        }
        
        // Processar fotos adicionais
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $index => $foto) {
                $nome = Str::uuid() . '.jpg';
                $caminho = $foto->storeAs('veiculos', $nome, 'public');
                
                // CORRIGIDO: usando 'foto_path' em vez de 'caminho'
                FotoVeiculo::create([
                    'veiculo_id' => $veiculo->id,
                    'foto_path' => $caminho,
                    'ordem' => $index,
                    'principal' => ($index == 0)
                ]);
            }
        }
        
        return redirect()->route('admin.veiculos.index')
            ->with('success', 'Veículo cadastrado com sucesso!');
    }
    
    public function edit($id)
    {
        $veiculo = Veiculo::with('fotos', 'marca')->findOrFail($id);
        $marcas = Marca::all();
        return view('admin.veiculos.edit', compact('veiculo', 'marcas'));
    }
    
    public function update(Request $request, $id)
    {
        $veiculo = Veiculo::findOrFail($id);
        
        $request->validate([
            'marca_id' => 'nullable|exists:marcas,id',
            'modelo' => 'required|string|max:255',
            'ano' => 'required|integer',
            'preco' => 'required|numeric',
            'preco_antigo' => 'nullable|numeric',
            'desconto_maximo' => 'nullable|numeric',
            'km' => 'nullable|numeric',
            'horas_uso' => 'nullable|numeric',
            'cor' => 'nullable|string|max:50',
            'combustivel' => 'nullable|string|max:50',
            'portas' => 'nullable|integer',
            'descricao' => 'nullable|string',
            'obs_admin' => 'nullable|string',
            'status' => 'required|in:disponivel,vendido',
            'tipo_veiculo' => 'required|in:carro,moto,caminhao,jetski,lancha',
            'fotos' => 'nullable|array',
            'fotos.*' => 'image|max:20480',
            'imagem_destaque' => 'nullable|image|max:20480'
        ]);
        
        // Atualizar veículo
        $veiculo->update($request->except('fotos', 'imagem_destaque'));
        
        // Processar nova imagem de destaque
        if ($request->hasFile('imagem_destaque')) {
            // Deletar imagem antiga se existir
            if ($veiculo->imagem_destaque && Storage::disk('public')->exists($veiculo->imagem_destaque)) {
                Storage::disk('public')->delete($veiculo->imagem_destaque);
            }
            
            $destaque = $request->file('imagem_destaque');
            $nomeDestaque = 'destaque_' . $veiculo->id . '_' . Str::random(10) . '.jpg';
            $caminhoDestaque = $destaque->storeAs('veiculos/destaques', $nomeDestaque, 'public');
            $veiculo->update(['imagem_destaque' => $caminhoDestaque]);
        }
        
        // Adicionar novas fotos
        if ($request->hasFile('fotos')) {
            $ultimaOrdem = $veiculo->fotos()->max('ordem') ?? -1;
            
            foreach ($request->file('fotos') as $index => $foto) {
                $nome = Str::uuid() . '.jpg';
                $caminho = $foto->storeAs('veiculos', $nome, 'public');
                
                // CORRIGIDO: usando 'foto_path' em vez de 'caminho'
                FotoVeiculo::create([
                    'veiculo_id' => $veiculo->id,
                    'foto_path' => $caminho,
                    'ordem' => $ultimaOrdem + $index + 1,
                    'principal' => false
                ]);
            }
        }
        
        return redirect()->route('admin.veiculos.index')
            ->with('success', 'Veículo atualizado com sucesso!');
    }
    
    public function destroy($id)
    {
        $veiculo = Veiculo::findOrFail($id);
        
        // Deletar imagem de destaque
        if ($veiculo->imagem_destaque && Storage::disk('public')->exists($veiculo->imagem_destaque)) {
            Storage::disk('public')->delete($veiculo->imagem_destaque);
        }
        
        // Deletar todas as fotos
        foreach ($veiculo->fotos as $foto) {
            // CORRIGIDO: usando 'foto_path' em vez de 'caminho'
            if ($foto->foto_path && Storage::disk('public')->exists($foto->foto_path)) {
                Storage::disk('public')->delete($foto->foto_path);
            }
            $foto->delete();
        }
        
        $veiculo->delete();
        
        return redirect()->route('admin.veiculos.index')
            ->with('success', 'Veículo excluído com sucesso!');
    }
    
    // Método para deletar uma foto específica
    public function deleteFoto($id)
    {
        $foto = FotoVeiculo::findOrFail($id);
        
        // CORRIGIDO: usando 'foto_path' em vez de 'caminho'
        if ($foto->foto_path && Storage::disk('public')->exists($foto->foto_path)) {
            Storage::disk('public')->delete($foto->foto_path);
        }
        
        $foto->delete();
        
        return response()->json(['success' => true]);
    }
}
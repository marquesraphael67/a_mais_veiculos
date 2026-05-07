<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Marca;
use App\Models\FotoVeiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminVeiculoController extends Controller
{
    public function index()
    {
        $veiculos = Veiculo::with('marca')->orderBy('id', 'desc')->paginate(10);
        return view('admin.veiculos.index', compact('veiculos'));
    }
    
    public function create()
    {
        $marcas = Marca::orderBy('nome', 'asc')->get();
        return view('admin.veiculos.create', compact('marcas'));
    }
    
    public function store(Request $request)
    {
        $rules = [
            'marca_id' => 'required|exists:marcas,id',
            'modelo' => 'required|string|max:100',
            'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'preco' => 'required|numeric|min:0',
            'preco_antigo' => 'nullable|numeric|min:0',
            'desconto_maximo' => 'nullable|numeric|min:0',
            'cor' => 'required|string|max:30',
            'combustivel' => 'required|string|max:20',
            'descricao' => 'required|string',
            'obs_admin' => 'nullable|string',
            'foto_destaque' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:disponivel,vendido',
            'tipo_veiculo' => 'required|in:carro,moto,caminhao,jetski,lancha'
        ];
        
        if (in_array($request->tipo_veiculo, ['jetski', 'lancha'])) {
            $rules['horas_uso'] = 'required|integer|min:0';
            $rules['portas'] = 'nullable';
        } else {
            $rules['km'] = 'required|integer|min:0';
            $rules['portas'] = 'required|integer|min:2|max:5';
        }
        
        $request->validate($rules);
        
        $veiculo = new Veiculo();
        $veiculo->marca_id = $request->marca_id;
        $veiculo->modelo = $request->modelo;
        $veiculo->ano = $request->ano;
        $veiculo->preco = $request->preco;
        $veiculo->preco_antigo = $request->preco_antigo;
        $veiculo->desconto_maximo = $request->desconto_maximo;
        $veiculo->cor = $request->cor;
        $veiculo->combustivel = $request->combustivel;
        $veiculo->descricao = $request->descricao;
        $veiculo->obs_admin = $request->obs_admin;
        $veiculo->status = $request->status;
        $veiculo->tipo_veiculo = $request->tipo_veiculo;
        
        if (in_array($request->tipo_veiculo, ['jetski', 'lancha'])) {
            $veiculo->horas_uso = $request->horas_uso;
            $veiculo->km = null;
            $veiculo->portas = null;
        } else {
            $veiculo->km = $request->km;
            $veiculo->horas_uso = null;
            $veiculo->portas = $request->portas;
        }
        
        if ($request->hasFile('foto_destaque')) {
            $path = $request->file('foto_destaque')->store('veiculos', 'public');
            $veiculo->imagem_destaque = $path;
        } else {
            $veiculo->imagem_destaque = 'veiculos/default.jpg';
        }
        
        $veiculo->save();
        
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $index => $foto) {
                if ($foto && $foto->isValid()) {
                    $path = $foto->store('veiculos', 'public');
                    FotoVeiculo::create([
                        'veiculo_id' => $veiculo->id,
                        'foto_path' => $path,
                        'ordem' => $index
                    ]);
                }
            }
        }
        
        return redirect()->route('admin.veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
    }
    
    public function edit($id)
    {
        $veiculo = Veiculo::with('fotos')->findOrFail($id);
        $marcas = Marca::orderBy('nome', 'asc')->get();
        return view('admin.veiculos.edit', compact('veiculo', 'marcas'));
    }
    
    public function update(Request $request, $id)
    {
        $veiculo = Veiculo::findOrFail($id);
        
        $rules = [
            'marca_id' => 'required|exists:marcas,id',
            'modelo' => 'required|string|max:100',
            'ano' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'preco' => 'required|numeric|min:0',
            'preco_antigo' => 'nullable|numeric|min:0',
            'desconto_maximo' => 'nullable|numeric|min:0',
            'cor' => 'required|string|max:30',
            'combustivel' => 'required|string|max:20',
            'descricao' => 'required|string',
            'obs_admin' => 'nullable|string',
            'foto_destaque' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:disponivel,vendido',
            'tipo_veiculo' => 'required|in:carro,moto,caminhao,jetski,lancha'
        ];
        
        if (in_array($request->tipo_veiculo, ['jetski', 'lancha'])) {
            $rules['horas_uso'] = 'required|integer|min:0';
            $rules['portas'] = 'nullable';
        } else {
            $rules['km'] = 'required|integer|min:0';
            $rules['portas'] = 'required|integer|min:2|max:5';
        }
        
        $request->validate($rules);
        
        $veiculo->marca_id = $request->marca_id;
        $veiculo->modelo = $request->modelo;
        $veiculo->ano = $request->ano;
        $veiculo->preco = $request->preco;
        $veiculo->preco_antigo = $request->preco_antigo;
        $veiculo->desconto_maximo = $request->desconto_maximo;
        $veiculo->cor = $request->cor;
        $veiculo->combustivel = $request->combustivel;
        $veiculo->descricao = $request->descricao;
        $veiculo->obs_admin = $request->obs_admin;
        $veiculo->status = $request->status;
        $veiculo->tipo_veiculo = $request->tipo_veiculo;
        
        if (in_array($request->tipo_veiculo, ['jetski', 'lancha'])) {
            $veiculo->horas_uso = $request->horas_uso;
            $veiculo->km = null;
            $veiculo->portas = null;
        } else {
            $veiculo->km = $request->km;
            $veiculo->horas_uso = null;
            $veiculo->portas = $request->portas;
        }
        
        if ($request->hasFile('foto_destaque')) {
            if ($veiculo->imagem_destaque && $veiculo->imagem_destaque != 'veiculos/default.jpg') {
                Storage::disk('public')->delete($veiculo->imagem_destaque);
            }
            $path = $request->file('foto_destaque')->store('veiculos', 'public');
            $veiculo->imagem_destaque = $path;
        }
        
        $veiculo->save();
        
        if ($request->hasFile('fotos')) {
            $ordemAtual = $veiculo->fotos()->count();
            foreach ($request->file('fotos') as $index => $foto) {
                if ($foto && $foto->isValid()) {
                    $path = $foto->store('veiculos', 'public');
                    FotoVeiculo::create([
                        'veiculo_id' => $veiculo->id,
                        'foto_path' => $path,
                        'ordem' => $ordemAtual + $index
                    ]);
                }
            }
        }
        
        return redirect()->route('admin.veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
    }
    
    public function destroy($id)
    {
        $veiculo = Veiculo::findOrFail($id);
        
        if ($veiculo->imagem_destaque && $veiculo->imagem_destaque != 'veiculos/default.jpg') {
            Storage::disk('public')->delete($veiculo->imagem_destaque);
        }
        
        foreach ($veiculo->fotos as $foto) {
            Storage::disk('public')->delete($foto->foto_path);
            $foto->delete();
        }
        
        $veiculo->delete();
        
        return redirect()->route('admin.veiculos.index')->with('success', 'Veículo excluído com sucesso!');
    }
    
    public function deleteFoto($id)
    {
        $foto = FotoVeiculo::findOrFail($id);
        $veiculo_id = $foto->veiculo_id;
        
        if ($foto->foto_path && Storage::disk('public')->exists($foto->foto_path)) {
            Storage::disk('public')->delete($foto->foto_path);
        }
        
        $foto->delete();
        
        return redirect()->route('admin.veiculos.edit', $veiculo_id)->with('success', 'Foto removida com sucesso!');
    }
}
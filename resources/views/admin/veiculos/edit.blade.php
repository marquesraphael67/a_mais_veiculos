@extends('layouts.admin')

@section('title', 'Editar Veículo')
@section('header', 'Editar Veículo')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.veiculos.update', $veiculo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Marca *</label>
                    <select name="marca_id" class="form-control" required>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca->id }}" {{ $veiculo->marca_id == $marca->id ? 'selected' : '' }}>
                                {{ $marca->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Modelo *</label>
                    <input type="text" name="modelo" class="form-control" value="{{ $veiculo->modelo }}" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label>Tipo *</label>
                    <select name="tipo_veiculo" id="tipo_veiculo" class="form-control" required>
                        <option value="carro" {{ $veiculo->tipo_veiculo == 'carro' ? 'selected' : '' }}>Carro</option>
                        <option value="moto" {{ $veiculo->tipo_veiculo == 'moto' ? 'selected' : '' }}>Moto</option>
                        <option value="caminhao" {{ $veiculo->tipo_veiculo == 'caminhao' ? 'selected' : '' }}>Caminhão</option>
                        <option value="jetski" {{ $veiculo->tipo_veiculo == 'jetski' ? 'selected' : '' }}>Jet Ski</option>
                        <option value="lancha" {{ $veiculo->tipo_veiculo == 'lancha' ? 'selected' : '' }}>Lancha</option>
                    </select>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label>Ano *</label>
                    <input type="number" name="ano" class="form-control" value="{{ $veiculo->ano }}" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label>Cor *</label>
                    <input type="text" name="cor" class="form-control" value="{{ $veiculo->cor }}" required>
                </div>
                
                <div class="col-md-3 mb-3" id="campo_km">
                    <label>KM</label>
                    <input type="number" name="km" class="form-control" value="{{ $veiculo->km }}">
                </div>
                
                <div class="col-md-3 mb-3" id="campo_horas" style="display: none;">
                    <label>Horas Uso</label>
                    <input type="number" name="horas_uso" class="form-control" value="{{ $veiculo->horas_uso }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label>Combustível</label>
                    <select name="combustivel" class="form-control" required>
                        <option value="Flex" {{ $veiculo->combustivel == 'Flex' ? 'selected' : '' }}>Flex</option>
                        <option value="Gasolina" {{ $veiculo->combustivel == 'Gasolina' ? 'selected' : '' }}>Gasolina</option>
                        <option value="Diesel" {{ $veiculo->combustivel == 'Diesel' ? 'selected' : '' }}>Diesel</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3" id="campo_portas">
                    <label>Portas</label>
                    <select name="portas" class="form-control">
                        <option value="2" {{ $veiculo->portas == 2 ? 'selected' : '' }}>2</option>
                        <option value="4" {{ $veiculo->portas == 4 ? 'selected' : '' }}>4</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control" required>
                        <option value="disponivel" {{ $veiculo->status == 'disponivel' ? 'selected' : '' }}>Disponível</option>
                        <option value="vendido" {{ $veiculo->status == 'vendido' ? 'selected' : '' }}>Vendido</option>
                    </select>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label>Preço</label>
                    <input type="number" step="0.01" name="preco" class="form-control" value="{{ $veiculo->preco }}" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label>Preço Antigo</label>
                    <input type="number" step="0.01" name="preco_antigo" class="form-control" value="{{ $veiculo->preco_antigo }}">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label>Desconto Max</label>
                    <input type="number" step="0.01" name="desconto_maximo" class="form-control" value="{{ $veiculo->desconto_maximo }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Foto Destaque</label>
                    @if($veiculo->imagem_destaque)
                        <div><img src="{{ asset('storage/' . $veiculo->imagem_destaque) }}" style="height: 50px;"></div>
                    @endif
                    <input type="file" name="foto_destaque" class="form-control" accept="image/*">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Fotos Extras</label>
                    <input type="file" name="fotos[]" class="form-control" accept="image/*" multiple>
                </div>
                
                @if($veiculo->fotos && $veiculo->fotos->count() > 0)
                <div class="col-12 mb-3">
                    <label>Galeria</label>
                    <div class="row">
                        @foreach($veiculo->fotos as $foto)
                        <div class="col-md-2">
                            <img src="{{ asset('storage/' . $foto->foto_path) }}" style="height: 50px;">
                            <a href="{{ route('admin.veiculos.delete-foto', $foto->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Remover?')">X</a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="col-12 mb-3">
                    <label>Observação (Admin)</label>
                    <textarea name="obs_admin" rows="3" class="form-control">{{ $veiculo->obs_admin }}</textarea>
                </div>
                
                <div class="col-12 mb-3">
                    <label>Descrição</label>
                    <textarea name="descricao" rows="6" class="form-control" required style="white-space: pre-wrap;">{{ $veiculo->descricao }}</textarea>
                </div>
            </div>
            
            <div class="text-end">
                <a href="{{ route('admin.veiculos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Atualizar</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleCampos() {
    var tipo = document.getElementById('tipo_veiculo').value;
    var km = document.getElementById('campo_km');
    var horas = document.getElementById('campo_horas');
    var portas = document.getElementById('campo_portas');
    
    if (tipo === 'jetski' || tipo === 'lancha') {
        if (km) km.style.display = 'none';
        if (horas) horas.style.display = 'block';
        if (portas) portas.style.display = 'none';
    } else {
        if (km) km.style.display = 'block';
        if (horas) horas.style.display = 'none';
        if (portas) portas.style.display = 'block';
    }
}

// No edit, após carregar, executar a função também
document.addEventListener('DOMContentLoaded', function() {
    toggleCamposPorTipo();
});
document.getElementById('tipo_veiculo')?.addEventListener('change', toggleCampos);
</script>
@endsection
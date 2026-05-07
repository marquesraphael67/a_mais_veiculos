@extends('layouts.admin')

@section('title', 'Novo Veículo')
@section('header', 'Cadastrar Novo Veículo')

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.veiculos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Marca *</label>
                    <select name="marca_id" class="form-control" required>
                        <option value="">Selecione uma marca</option>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nome }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Modelo *</label>
                    <input type="text" name="modelo" class="form-control" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo do Veículo *</label>
                    <select name="tipo_veiculo" id="tipo_veiculo" class="form-control" required>
                        <option value="carro">🚗 Carro</option>
                        <option value="moto">🏍️ Moto</option>
                        <option value="caminhao">🚛 Caminhão</option>
                        <option value="jetski">🌊 Jet Ski</option>
                        <option value="lancha">⛵ Lancha</option>
                    </select>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Ano *</label>
                    <input type="number" name="ano" class="form-control" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cor *</label>
                    <input type="text" name="cor" class="form-control" required>
                </div>
                
                <div class="col-md-3 mb-3" id="campo_km">
                    <label class="form-label">KM *</label>
                    <input type="number" name="km" class="form-control">
                </div>
                
                <div class="col-md-3 mb-3" id="campo_horas" style="display: none;">
                    <label class="form-label">Horas de Uso *</label>
                    <input type="number" name="horas_uso" class="form-control">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label class="form-label">Combustível *</label>
                    <select name="combustivel" class="form-control" required>
                        <option value="Flex">Flex</option>
                        <option value="Gasolina">Gasolina</option>
                        <option value="Diesel">Diesel</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3" id="campo_portas">
                    <label class="form-label">Portas *</label>
                    <select name="portas" class="form-control">
                        <option value="2">2 portas</option>
                        <option value="4">4 portas</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="disponivel">Disponível</option>
                        <option value="vendido">Vendido</option>
                    </select>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Preço * (R$)</label>
                    <input type="number" step="0.01" name="preco" class="form-control" required>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Preço Antigo (R$)</label>
                    <input type="number" step="0.01" name="preco_antigo" class="form-control">
                    <small>Mostrar preço com desconto</small>
                </div>
                
                <div class="col-md-4 mb-3">
                    <label class="form-label">Desconto Máximo (R$)</label>
                    <input type="number" step="0.01" name="desconto_maximo" class="form-control">
                    <small>Controle interno</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Foto Destaque (Capa)</label>
                    <input type="file" name="foto_destaque" class="form-control" accept="image/*">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fotos Extras</label>
                    <input type="file" name="fotos[]" class="form-control" accept="image/*" multiple>
                    <small>Ctrl para selecionar várias</small>
                </div>
                
                <div class="col-12 mb-3">
                    <label class="form-label">Observação (Admin)</label>
                    <textarea name="obs_admin" rows="3" class="form-control"></textarea>
                    <small class="text-danger">⚠️ Só você vê</small>
                </div>
                
                <div class="col-12 mb-3">
                    <label class="form-label">Descrição *</label>
                    <textarea name="descricao" rows="6" class="form-control" required style="white-space: pre-wrap;"></textarea>
                </div>
            </div>
            
            <div class="text-end">
                <a href="{{ route('admin.veiculos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar</button>
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

document.addEventListener('DOMContentLoaded', toggleCampos);
document.getElementById('tipo_veiculo')?.addEventListener('change', toggleCampos);
</script>
@endsection
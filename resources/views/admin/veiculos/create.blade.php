@extends('layouts.admin')

@section('title', 'Novo Veículo')

@section('content')
<div class="form-container">
    <div class="page-header mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-plus-circle me-2"></i>
                Cadastrar Novo Veículo
            </h2>
            <p class="text-muted mb-0">Adicione as informações do veículo e suas fotos.</p>
        </div>

        <a href="{{ route('admin.veiculos.index') }}" class="btn btn-light border">
            <i class="fas fa-arrow-left me-1"></i> Voltar
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger rounded-4">
            <strong>Corrija os erros abaixo:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.veiculos.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-section">
            <h5>Informações principais</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Marca</label>
                    <select name="marca_id" class="form-select">
                        <option value="">Selecione uma marca</option>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca->id }}" @selected(old('marca_id') == $marca->id)>
                                {{ $marca->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Modelo <span class="text-danger">*</span></label>
                    <input type="text" name="modelo" class="form-control" required value="{{ old('modelo') }}" placeholder="Ex: Civic, Onix, Corolla">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Ano <span class="text-danger">*</span></label>
                    <input type="number" name="ano" class="form-control" required value="{{ old('ano') }}" placeholder="2024">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="disponivel" @selected(old('status') == 'disponivel')>Disponível</option>
                        <option value="vendido" @selected(old('status') == 'vendido')>Vendido</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Tipo <span class="text-danger">*</span></label>
                    <select name="tipo_veiculo" id="tipo_veiculo" class="form-select" required>
                        <option value="carro" @selected(old('tipo_veiculo') == 'carro')>Carro</option>
                        <option value="moto" @selected(old('tipo_veiculo') == 'moto')>Moto</option>
                        <option value="caminhao" @selected(old('tipo_veiculo') == 'caminhao')>Caminhão</option>
                        <option value="jetski" @selected(old('tipo_veiculo') == 'jetski')>Jet Ski</option>
                        <option value="lancha" @selected(old('tipo_veiculo') == 'lancha')>Lancha</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h5>Valores</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Preço <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" step="0.01" name="preco" class="form-control" required value="{{ old('preco') }}" placeholder="0,00">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Preço Antigo</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" step="0.01" name="preco_antigo" class="form-control" value="{{ old('preco_antigo') }}" placeholder="0,00">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h5>Detalhes do veículo</h5>

            <div class="row g-3">
                <div class="col-md-6" id="campo_km">
                    <label class="form-label">KM</label>
                    <input type="number" name="km" class="form-control" value="{{ old('km') }}" placeholder="Ex: 50000">
                </div>

                <div class="col-md-6" id="campo_horas" style="display:none;">
                    <label class="form-label">Horas de Uso</label>
                    <input type="number" name="horas_uso" class="form-control" value="{{ old('horas_uso') }}" placeholder="Ex: 150">
                </div>

                <div class="col-md-4" id="campo_portas">
                    <label class="form-label">Portas</label>
                    <input type="number" name="portas" class="form-control" value="{{ old('portas') }}" placeholder="Ex: 4">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Cor</label>
                    <input type="text" name="cor" class="form-control" value="{{ old('cor') }}" placeholder="Ex: Preto">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Combustível</label>
                    <select name="combustivel" class="form-select">
                        <option value="">Selecione</option>
                        <option value="Gasolina" @selected(old('combustivel') == 'Gasolina')>Gasolina</option>
                        <option value="Etanol" @selected(old('combustivel') == 'Etanol')>Etanol</option>
                        <option value="Flex" @selected(old('combustivel') == 'Flex')>Flex</option>
                        <option value="Diesel" @selected(old('combustivel') == 'Diesel')>Diesel</option>
                        <option value="Elétrico" @selected(old('combustivel') == 'Elétrico')>Elétrico</option>
                        <option value="Híbrido" @selected(old('combustivel') == 'Híbrido')>Híbrido</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="5" placeholder="Descreva opcionais, estado de conservação, histórico e diferenciais...">{{ old('descricao') }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Observações Internas</label>
                    <textarea name="obs_admin" class="form-control" rows="4" placeholder="Informações internas. Não aparece para o cliente.">{{ old('obs_admin') }}</textarea>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h5>Imagens do veículo</h5>

            <div class="row g-4">
                <div class="col-12">
                    <label class="form-label">Imagem Destaque</label>

                    <div class="upload-box">
                        <input type="file" name="imagem_destaque" id="imagem_destaque" class="form-control" accept="image/*">
                        <small class="text-muted">Essa será a imagem principal do veículo.</small>
                    </div>

                    <div id="preview_destaque" class="image-preview mt-3"></div>
                </div>

                <div class="col-12">
                    <label class="form-label">Fotos Adicionais</label>

                    <div class="upload-box">
                        <input type="file" name="fotos[]" id="fotos_input" class="form-control" accept="image/*" multiple>
                        <small class="text-muted">Envie até 10 fotos adicionais. Você pode remover clicando no X.</small>
                    </div>

                    <div id="preview_imagens" class="image-preview mt-3"></div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between flex-wrap gap-2 mt-4">
            <a href="{{ route('admin.veiculos.index') }}" class="btn btn-secondary px-4">
                Cancelar
            </a>

            <button type="submit" class="btn btn-primary px-5">
                <i class="fas fa-save me-1"></i> Cadastrar Veículo
            </button>
        </div>
    </form>
</div>

<style>
    body {
        background: #f5f7fb;
    }

    .form-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .page-header {
        background: linear-gradient(135deg, #111827, #1e3c72);
        color: white;
        border-radius: 24px;
        padding: 26px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
        box-shadow: 0 14px 35px rgba(17,24,39,.18);
    }

    .page-header h2 {
        font-weight: 800;
    }

    .page-header p {
        color: rgba(255,255,255,.75) !important;
    }

    .form-section {
        background: white;
        border-radius: 22px;
        padding: 24px;
        margin-bottom: 18px;
        border: 1px solid #eef0f5;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
    }

    .form-section h5 {
        font-weight: 800;
        color: #111827;
        margin-bottom: 18px;
        border-left: 4px solid #1e3c72;
        padding-left: 12px;
    }

    .form-label {
        font-weight: 700;
        color: #374151;
        font-size: 14px;
    }

    .form-control,
    .form-select {
        border-radius: 13px;
        border: 1px solid #dce3ee;
        padding: 11px 13px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1e3c72;
        box-shadow: 0 0 0 4px rgba(30,60,114,.12);
    }

    .input-group-text {
        border-radius: 13px 0 0 13px;
        background: #f8fafc;
        font-weight: 700;
    }

    .upload-box {
        border: 2px dashed #cfd8e3;
        background: #f8fafc;
        border-radius: 18px;
        padding: 18px;
        transition: .2s;
    }

    .upload-box:hover {
        border-color: #1e3c72;
        background: #f1f5f9;
    }

    .image-preview {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .preview-item {
        position: relative;
        width: 135px;
        height: 115px;
        border-radius: 16px;
        overflow: hidden;
        background: #f1f5f9;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 20px rgba(0,0,0,.08);
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .preview-item span {
        position: absolute;
        left: 7px;
        bottom: 7px;
        background: rgba(0,0,0,.68);
        color: white;
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
    }

    .remove-img {
        position: absolute;
        top: 6px;
        right: 6px;
        width: 27px;
        height: 27px;
        border: none;
        border-radius: 50%;
        background: #dc3545;
        color: white;
        font-size: 20px;
        font-weight: bold;
        line-height: 22px;
        z-index: 10;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(0,0,0,.25);
    }

    .remove-img:hover {
        background: #b91c1c;
    }

    .btn {
        border-radius: 13px;
        font-weight: 700;
        padding: 11px 20px;
    }

    .btn-primary {
        background: #1e3c72;
        border: none;
    }

    .btn-primary:hover {
        background: #2a5298;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background: #6b7280;
        border: none;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 20px;
        }

        .form-section {
            padding: 18px;
        }

        .preview-item {
            width: 105px;
            height: 95px;
        }
    }
</style>

<script>
let fotosSelecionadas = [];

function toggleCamposPorTipo() {
    const tipo = document.getElementById('tipo_veiculo')?.value;
    const campoKm = document.getElementById('campo_km');
    const campoHoras = document.getElementById('campo_horas');
    const campoPortas = document.getElementById('campo_portas');

    if (campoKm) campoKm.style.display = 'none';
    if (campoHoras) campoHoras.style.display = 'none';
    if (campoPortas) campoPortas.style.display = 'block';

    if (tipo === 'carro') {
        if (campoKm) campoKm.style.display = 'block';
        if (campoPortas) campoPortas.style.display = 'block';
    }

    if (tipo === 'moto' || tipo === 'caminhao') {
        if (campoKm) campoKm.style.display = 'block';
        if (campoPortas) campoPortas.style.display = 'none';
    }

    if (tipo === 'jetski' || tipo === 'lancha') {
        if (campoHoras) campoHoras.style.display = 'block';
        if (campoPortas) campoPortas.style.display = 'none';
    }
}

function removerDestaque() {
    const input = document.getElementById('imagem_destaque');
    const preview = document.getElementById('preview_destaque');

    if (input) input.value = '';
    if (preview) preview.innerHTML = '';
}

function renderPreviewDestaque() {
    const input = document.getElementById('imagem_destaque');
    const preview = document.getElementById('preview_destaque');

    if (!input || !preview) return;

    preview.innerHTML = '';

    const file = input.files[0];

    if (!file) return;

    if (!file.type.startsWith('image/')) {
        alert('Selecione apenas imagens.');
        removerDestaque();
        return;
    }

    const reader = new FileReader();

    reader.onload = function(e) {
        preview.innerHTML = `
            <div class="preview-item">
                <button type="button" class="remove-img" onclick="removerDestaque()">×</button>
                <img src="${e.target.result}" alt="Imagem destaque">
                <span>Destaque</span>
            </div>
        `;
    };

    reader.readAsDataURL(file);
}

function atualizarInputFotos() {
    const input = document.getElementById('fotos_input');
    const dataTransfer = new DataTransfer();

    fotosSelecionadas.forEach(file => {
        dataTransfer.items.add(file);
    });

    input.files = dataTransfer.files;
}

function renderPreviewFotos() {
    const preview = document.getElementById('preview_imagens');

    if (!preview) return;

    preview.innerHTML = '';

    fotosSelecionadas.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'preview-item';

            div.innerHTML = `
                <button type="button" class="remove-img" onclick="removerFotoNova(${index})">×</button>
                <img src="${e.target.result}" alt="Foto ${index + 1}">
                <span>${index + 1}</span>
            `;

            preview.appendChild(div);
        };

        reader.readAsDataURL(file);
    });

    atualizarInputFotos();
}

function removerFotoNova(index) {
    fotosSelecionadas.splice(index, 1);
    renderPreviewFotos();
}

document.addEventListener('DOMContentLoaded', function () {
    toggleCamposPorTipo();

    document.getElementById('tipo_veiculo')?.addEventListener('change', toggleCamposPorTipo);

    document.getElementById('imagem_destaque')?.addEventListener('change', function () {
        renderPreviewDestaque();
    });

    document.getElementById('fotos_input')?.addEventListener('change', function () {
        const novasFotos = Array.from(this.files);

        novasFotos.forEach(file => {
            if (file.type.startsWith('image/')) {
                fotosSelecionadas.push(file);
            }
        });

        if (fotosSelecionadas.length > 10) {
            alert('Você pode enviar no máximo 10 fotos adicionais.');
            fotosSelecionadas = fotosSelecionadas.slice(0, 10);
        }

        renderPreviewFotos();
    });
});
</script>
@endsection
@extends('layouts.admin')

@section('title', 'Editar Veículo')

@section('content')
<div class="form-container">
    <div class="page-header mb-4">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-pen-to-square me-2"></i>
                Editar Veículo
            </h2>
            <p class="text-muted mb-0">Atualize as informações e fotos do veículo.</p>
        </div>

        <a href="{{ route('admin.veiculos.index') }}" class="btn btn-light border">
            <i class="fas fa-arrow-left me-1"></i> Voltar
        </a>
    </div>

    <form action="{{ route('admin.veiculos.update', $veiculo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-section">
            <h5>Informações principais</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Marca *</label>
                    <select name="marca_id" class="form-select" required>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca->id }}" @selected(old('marca_id', $veiculo->marca_id) == $marca->id)>
                                {{ $marca->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Modelo *</label>
                    <input type="text" name="modelo" class="form-control" value="{{ old('modelo', $veiculo->modelo) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tipo *</label>
                    <select name="tipo_veiculo" id="tipo_veiculo" class="form-select" required>
                        <option value="carro" @selected(old('tipo_veiculo', $veiculo->tipo_veiculo) == 'carro')>Carro</option>
                        <option value="moto" @selected(old('tipo_veiculo', $veiculo->tipo_veiculo) == 'moto')>Moto</option>
                        <option value="caminhao" @selected(old('tipo_veiculo', $veiculo->tipo_veiculo) == 'caminhao')>Caminhão</option>
                        <option value="jetski" @selected(old('tipo_veiculo', $veiculo->tipo_veiculo) == 'jetski')>Jet Ski</option>
                        <option value="lancha" @selected(old('tipo_veiculo', $veiculo->tipo_veiculo) == 'lancha')>Lancha</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Ano *</label>
                    <input type="number" name="ano" class="form-control" value="{{ old('ano', $veiculo->ano) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Cor *</label>
                    <input type="text" name="cor" class="form-control" value="{{ old('cor', $veiculo->cor) }}" required>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h5>Detalhes</h5>

            <div class="row g-3">
                <div class="col-md-4" id="campo_km">
                    <label class="form-label">KM</label>
                    <input type="number" name="km" class="form-control" value="{{ old('km', $veiculo->km) }}">
                </div>

                <div class="col-md-4" id="campo_horas" style="display:none;">
                    <label class="form-label">Horas de Uso</label>
                    <input type="number" name="horas_uso" class="form-control" value="{{ old('horas_uso', $veiculo->horas_uso) }}">
                </div>

                <div class="col-md-4" id="campo_portas">
                    <label class="form-label">Portas</label>
                    <select name="portas" class="form-select">
                        <option value="">Selecione</option>
                        <option value="2" @selected(old('portas', $veiculo->portas) == 2)>2</option>
                        <option value="4" @selected(old('portas', $veiculo->portas) == 4)>4</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Combustível</label>
                    <select name="combustivel" class="form-select">
                        <option value="Flex" @selected(old('combustivel', $veiculo->combustivel) == 'Flex')>Flex</option>
                        <option value="Gasolina" @selected(old('combustivel', $veiculo->combustivel) == 'Gasolina')>Gasolina</option>
                        <option value="Etanol" @selected(old('combustivel', $veiculo->combustivel) == 'Etanol')>Etanol</option>
                        <option value="Diesel" @selected(old('combustivel', $veiculo->combustivel) == 'Diesel')>Diesel</option>
                        <option value="Elétrico" @selected(old('combustivel', $veiculo->combustivel) == 'Elétrico')>Elétrico</option>
                        <option value="Híbrido" @selected(old('combustivel', $veiculo->combustivel) == 'Híbrido')>Híbrido</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="disponivel" @selected(old('status', $veiculo->status) == 'disponivel')>Disponível</option>
                        <option value="vendido" @selected(old('status', $veiculo->status) == 'vendido')>Vendido</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h5>Valores</h5>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Preço *</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" step="0.01" name="preco" class="form-control" value="{{ old('preco', $veiculo->preco) }}" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Preço Antigo</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input type="number" step="0.01" name="preco_antigo" class="form-control" value="{{ old('preco_antigo', $veiculo->preco_antigo) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h5>Imagens</h5>

            <label class="form-label">Imagem Destaque Atual</label>
            <div class="image-preview mb-3" id="preview_destaque_atual">
                @if($veiculo->imagem_destaque)
                    <div class="preview-item">
                        <img src="{{ asset('storage/' . $veiculo->imagem_destaque) }}" alt="Destaque atual">
                        <span>Atual</span>
                    </div>
                @else
                    <p class="text-muted">Nenhuma imagem destaque cadastrada.</p>
                @endif
            </div>

            <label class="form-label">Trocar Imagem Destaque</label>
            <div class="upload-box mb-3">
                <input type="file" name="imagem_destaque" id="imagem_destaque" class="form-control" accept="image/*">
                <small class="text-muted">Só selecione se quiser trocar a imagem principal.</small>
            </div>
            <div id="preview_destaque" class="image-preview mb-4"></div>

            <label class="form-label">Galeria Atual</label>
            <div class="image-preview mb-4">
                @forelse($veiculo->fotos as $foto)
                    <div class="preview-item">
                        <a href="{{ route('admin.veiculos.delete-foto', $foto->id) }}"
                           class="remove-img"
                           onclick="return confirm('Remover esta foto?')">×</a>

                        <img src="{{ asset('storage/' . ($foto->foto_path ?? $foto->caminho)) }}" alt="Foto">
                        <span>Atual</span>
                    </div>
                @empty
                    <p class="text-muted">Nenhuma foto extra cadastrada.</p>
                @endforelse
            </div>

            <label class="form-label">Adicionar Novas Fotos</label>
            <div class="upload-box">
                <input type="file" name="fotos[]" id="fotos_input" class="form-control" accept="image/*" multiple>
                <small class="text-muted">As novas fotos serão adicionadas junto das atuais.</small>
            </div>
            <div id="preview_imagens" class="image-preview mt-3"></div>
        </div>

        <div class="form-section">
            <h5>Textos</h5>

            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Observação Interna</label>
                    <textarea name="obs_admin" rows="3" class="form-control">{{ old('obs_admin', $veiculo->obs_admin) }}</textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" rows="6" class="form-control" required>{{ old('descricao', $veiculo->descricao) }}</textarea>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between flex-wrap gap-2 mt-4">
            <a href="{{ route('admin.veiculos.index') }}" class="btn btn-secondary px-4">Cancelar</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="fas fa-save me-1"></i> Atualizar Veículo
            </button>
        </div>
    </form>
</div>

<style>
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

    .upload-box {
        border: 2px dashed #cfd8e3;
        background: #f8fafc;
        border-radius: 18px;
        padding: 18px;
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
        line-height: 24px;
        text-align: center;
        text-decoration: none;
        z-index: 10;
    }

    .remove-img:hover {
        background: #b91c1c;
        color: white;
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

function toggleCampos() {
    const tipo = document.getElementById('tipo_veiculo')?.value;
    const km = document.getElementById('campo_km');
    const horas = document.getElementById('campo_horas');
    const portas = document.getElementById('campo_portas');

    if (km) km.style.display = 'none';
    if (horas) horas.style.display = 'none';
    if (portas) portas.style.display = 'block';

    if (tipo === 'carro') {
        if (km) km.style.display = 'block';
        if (portas) portas.style.display = 'block';
    }

    if (tipo === 'moto' || tipo === 'caminhao') {
        if (km) km.style.display = 'block';
        if (portas) portas.style.display = 'none';
    }

    if (tipo === 'jetski' || tipo === 'lancha') {
        if (horas) horas.style.display = 'block';
        if (portas) portas.style.display = 'none';
    }
}

function removerDestaqueNova() {
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

    const reader = new FileReader();

    reader.onload = function(e) {
        preview.innerHTML = `
            <div class="preview-item">
                <button type="button" class="remove-img" onclick="removerDestaqueNova()">×</button>
                <img src="${e.target.result}">
                <span>Nova</span>
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
    preview.innerHTML = '';

    fotosSelecionadas.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'preview-item';

            div.innerHTML = `
                <button type="button" class="remove-img" onclick="removerFotoNova(${index})">×</button>
                <img src="${e.target.result}">
                <span>Nova ${index + 1}</span>
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
    toggleCampos();

    document.getElementById('tipo_veiculo')?.addEventListener('change', toggleCampos);
    document.getElementById('imagem_destaque')?.addEventListener('change', renderPreviewDestaque);

    document.getElementById('fotos_input')?.addEventListener('change', function () {
        const novasFotos = Array.from(this.files);

        novasFotos.forEach(file => {
            if (file.type.startsWith('image/')) {
                fotosSelecionadas.push(file);
            }
        });

        renderPreviewFotos();
    });
});
</script>
@endsection
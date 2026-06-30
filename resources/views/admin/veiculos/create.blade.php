@extends('layouts.admin')

@section('title', 'Novo Veículo')

@section('content')
<div class="form-container">
    <div class="page-header mb-4">
        <div>
            <h2 class="mb-1"><i class="fas fa-plus-circle me-2"></i>Cadastrar Novo Veículo</h2>
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
                        <input
                            type="text"
                            id="preco_formatado"
                            class="form-control money-mask"
                            required
                            value="{{ old('preco') ? number_format((float) old('preco'), 2, ',', '.') : '' }}"
                            placeholder="0,00"
                            inputmode="numeric"
                        >
                        <input type="hidden" name="preco" id="preco" value="{{ old('preco') }}">
                    </div>
                    <small class="text-muted">Digite apenas números. Ex: 5499000 vira 54.990,00.</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Preço Antigo</label>
                    <div class="input-group">
                        <span class="input-group-text">R$</span>
                        <input
                            type="text"
                            id="preco_antigo_formatado"
                            class="form-control money-mask"
                            value="{{ old('preco_antigo') ? number_format((float) old('preco_antigo'), 2, ',', '.') : '' }}"
                            placeholder="0,00"
                            inputmode="numeric"
                        >
                        <input type="hidden" name="preco_antigo" id="preco_antigo" value="{{ old('preco_antigo') }}">
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

            <div class="upload-area mb-4" id="dropDestaque">
                <input type="file" name="imagem_destaque" id="imagem_destaque" accept="image/*" hidden>
                <div class="upload-content">
                    <i class="fas fa-star"></i>
                    <strong>Imagem destaque</strong>
                    <span>Clique ou arraste a foto principal aqui</span>
                </div>
            </div>

            <div id="preview_destaque" class="image-preview mb-4"></div>

            <div class="upload-area" id="dropFotos">
                <input type="file" name="fotos[]" id="fotos_input" accept="image/*" multiple hidden>
                <div class="upload-content">
                    <i class="fas fa-images"></i>
                    <strong>Fotos adicionais</strong>
                    <span>Clique ou arraste várias fotos aqui</span>
                </div>
            </div>

            <small class="text-muted d-block mt-2">
                Você pode adicionar fotos aos poucos, remover e arrastar para mudar a ordem.
            </small>

            <div id="preview_imagens" class="image-preview mt-3"></div>
        </div>

        <div class="d-flex justify-content-between flex-wrap gap-2 mt-4">
            <a href="{{ route('admin.veiculos.index') }}" class="btn btn-secondary px-4">Cancelar</a>

            <button type="submit" class="btn btn-primary px-5">
                <i class="fas fa-save me-1"></i> Cadastrar Veículo
            </button>
        </div>
    </form>
</div>

<style>
    body { background: #f5f7fb; }

    .form-container { max-width: 1100px; margin: 0 auto; }

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

    .page-header h2 { font-weight: 800; }
    .page-header p { color: rgba(255,255,255,.75) !important; }

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

    .form-label { font-weight: 700; color: #374151; font-size: 14px; }

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

    .upload-area {
        border: 2px dashed #cfd8e3;
        background: #f8fafc;
        border-radius: 20px;
        padding: 28px;
        text-align: center;
        cursor: pointer;
        transition: .2s;
    }

    .upload-area:hover,
    .upload-area.dragover {
        border-color: #1e3c72;
        background: #eef4ff;
    }

    .upload-content i {
        font-size: 32px;
        color: #1e3c72;
        display: block;
        margin-bottom: 10px;
    }

    .upload-content strong {
        display: block;
        color: #111827;
        font-weight: 900;
    }

    .upload-content span {
        color: #6b7280;
        font-size: 14px;
    }

    .image-preview {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
    }

    .preview-item {
        position: relative;
        width: 145px;
        height: 120px;
        border-radius: 16px;
        overflow: hidden;
        background: #f1f5f9;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 20px rgba(0,0,0,.08);
        cursor: grab;
    }

    .preview-item.dragging {
        opacity: .45;
        transform: scale(.96);
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
        font-weight: 800;
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
        box-shadow: 0 5px 15px rgba(0,0,0,.25);
    }

    .remove-img:hover { background: #b91c1c; }

    .btn {
        border-radius: 13px;
        font-weight: 700;
        padding: 11px 20px;
    }

    .btn-primary { background: #1e3c72; border: none; }
    .btn-primary:hover { background: #2a5298; transform: translateY(-2px); }
    .btn-secondary { background: #6b7280; border: none; }

    @media (max-width: 768px) {
        .page-header { padding: 20px; }
        .form-section { padding: 18px; }
        .preview-item { width: 105px; height: 95px; }
    }
</style>

<script>
let fotosSelecionadas = [];
let draggedIndex = null;


function formatMoney(value) {
    value = String(value || '').replace(/\D/g, '');

    if (!value) {
        return '';
    }

    const numero = Number(value) / 100;

    return numero.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function unformatMoney(value) {
    if (!value) return '';

    return String(value)
        .replace(/\./g, '')
        .replace(',', '.');
}

function setupMoneyMask(visibleId, hiddenId) {
    const visible = document.getElementById(visibleId);
    const hidden = document.getElementById(hiddenId);

    if (!visible || !hidden) return;

    visible.addEventListener('input', function () {
        visible.value = formatMoney(visible.value);
        hidden.value = unformatMoney(visible.value);
    });

    visible.addEventListener('blur', function () {
        hidden.value = unformatMoney(visible.value);
    });

    hidden.value = unformatMoney(visible.value);
}

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

function setupDrop(areaId, inputId, callback) {
    const area = document.getElementById(areaId);
    const input = document.getElementById(inputId);

    if (!area || !input) return;

    area.addEventListener('click', () => input.click());

    area.addEventListener('dragover', e => {
        e.preventDefault();
        area.classList.add('dragover');
    });

    area.addEventListener('dragleave', () => area.classList.remove('dragover'));

    area.addEventListener('drop', e => {
        e.preventDefault();
        area.classList.remove('dragover');
        callback(Array.from(e.dataTransfer.files));
    });

    input.addEventListener('change', () => callback(Array.from(input.files)));
}

function renderDestaque(files) {
    const input = document.getElementById('imagem_destaque');
    const preview = document.getElementById('preview_destaque');
    const file = files[0];

    if (!file || !file.type.startsWith('image/')) return;

    const dt = new DataTransfer();
    dt.items.add(file);
    input.files = dt.files;

    const reader = new FileReader();

    reader.onload = e => {
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

function removerDestaque() {
    document.getElementById('imagem_destaque').value = '';
    document.getElementById('preview_destaque').innerHTML = '';
}

function adicionarFotos(files) {
    files.forEach(file => {
        if (file.type.startsWith('image/')) {
            fotosSelecionadas.push(file);
        }
    });

    if (fotosSelecionadas.length > 15) {
        alert('Você pode enviar no máximo 15 fotos adicionais.');
        fotosSelecionadas = fotosSelecionadas.slice(0, 15);
    }

    renderFotos();
}

function atualizarInputFotos() {
    const input = document.getElementById('fotos_input');
    const dt = new DataTransfer();

    fotosSelecionadas.forEach(file => dt.items.add(file));
    input.files = dt.files;
}

function renderFotos() {
    const preview = document.getElementById('preview_imagens');
    preview.innerHTML = '';

    fotosSelecionadas.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'preview-item';
            div.draggable = true;
            div.dataset.index = index;

            div.innerHTML = `
                <button type="button" class="remove-img" onclick="removerFoto(${index})">×</button>
                <img src="${e.target.result}" alt="Foto ${index + 1}">
                <span>${index + 1}</span>
            `;

            div.addEventListener('dragstart', () => {
                draggedIndex = index;
                div.classList.add('dragging');
            });

            div.addEventListener('dragend', () => {
                draggedIndex = null;
                div.classList.remove('dragging');
            });

            div.addEventListener('dragover', e => e.preventDefault());

            div.addEventListener('drop', e => {
                e.preventDefault();
                const targetIndex = Number(div.dataset.index);

                if (draggedIndex === null || draggedIndex === targetIndex) return;

                const moved = fotosSelecionadas.splice(draggedIndex, 1)[0];
                fotosSelecionadas.splice(targetIndex, 0, moved);

                renderFotos();
            });

            preview.appendChild(div);
        };

        reader.readAsDataURL(file);
    });

    atualizarInputFotos();
}

function removerFoto(index) {
    fotosSelecionadas.splice(index, 1);
    renderFotos();
}

document.addEventListener('DOMContentLoaded', function () {
    setupMoneyMask('preco_formatado', 'preco');
    setupMoneyMask('preco_antigo_formatado', 'preco_antigo');

    toggleCamposPorTipo();

    document.getElementById('tipo_veiculo')?.addEventListener('change', toggleCamposPorTipo);

    setupDrop('dropDestaque', 'imagem_destaque', renderDestaque);
    setupDrop('dropFotos', 'fotos_input', adicionarFotos);
});
</script>
@endsection
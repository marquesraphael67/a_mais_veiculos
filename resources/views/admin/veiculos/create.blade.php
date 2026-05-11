@extends('layouts.admin')

@section('title', 'Novo Veículo')

@section('content')
<div class="form-container">
    <h2 class="mb-4 pb-2 border-bottom">
        <i class="fas fa-plus-circle me-2" style="color: #1e3c72;"></i>
        Cadastrar Novo Veículo
    </h2>
    
    <form method="POST" action="{{ route('admin.veiculos.store') }}" enctype="multipart/form-data">
        @csrf
        
        <!-- LINHA 1: Marca + Modelo -->
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="fas fa-trademark me-1 text-primary"></i> Marca
                </label>
                <select name="marca_id" class="form-select">
                    <option value="">Selecione uma marca</option>
                    @foreach($marcas as $marca)
                        <option value="{{ $marca->id }}">{{ $marca->nome }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="fas fa-car me-1 text-primary"></i> Modelo <span class="text-danger">*</span>
                </label>
                <input type="text" name="modelo" class="form-control" required placeholder="Ex: Onix, Civic, Uno" value="{{ old('modelo') }}">
            </div>
        </div>
        
        <!-- LINHA 2: Ano + Status + Tipo -->
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">
                    <i class="fas fa-calendar me-1 text-primary"></i> Ano <span class="text-danger">*</span>
                </label>
                <input type="number" name="ano" class="form-control" required placeholder="2024" value="{{ old('ano') }}">
            </div>
            
            <div class="col-md-3">
                <label class="form-label fw-semibold">
                    <i class="fas fa-chart-line me-1 text-primary"></i> Status <span class="text-danger">*</span>
                </label>
                <select name="status" class="form-select" required>
                    <option value="disponivel">✅ Disponível</option>
                    <option value="vendido">❌ Vendido</option>
                </select>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="fas fa-tag me-1 text-primary"></i> Tipo <span class="text-danger">*</span>
                </label>
                <select name="tipo_veiculo" id="tipo_veiculo" class="form-select" required>
                    <option value="carro">🚗 Carro</option>
                    <option value="moto">🏍️ Moto</option>
                    <option value="caminhao">🚛 Caminhão</option>
                    <option value="jetski">🌊 Jet Ski</option>
                    <option value="lancha">⛵ Lancha</option>
                </select>
            </div>
        </div>
        
        <!-- LINHA 3: Preço + Preço Antigo -->
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-dollar-sign me-1 text-primary"></i> Preço <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="number" step="0.01" name="preco" class="form-control" required placeholder="0,00" value="{{ old('preco') }}">
                </div>
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-dollar-sign me-1 text-muted"></i> Preço Antigo
                </label>
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="number" step="0.01" name="preco_antigo" class="form-control" placeholder="0,00" value="{{ old('preco_antigo') }}">
                </div>
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-percent me-1 text-muted"></i> Desconto Máximo
                </label>
                <div class="input-group">
                    <input type="number" step="0.01" name="desconto_maximo" class="form-control" placeholder="0,00" value="{{ old('desconto_maximo') }}">
                    <span class="input-group-text">%</span>
                </div>
            </div>
        </div>
        
        <!-- LINHA 4: KM (aparece para carro, moto, caminhão) -->
        <div class="row g-3 mb-3" id="campo_km">
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="fas fa-road me-1 text-primary"></i> KM
                </label>
                <input type="number" name="km" class="form-control" placeholder="Ex: 50.000" value="{{ old('km') }}">
                <small class="text-muted">Quilometragem do veículo</small>
            </div>
        </div>
        
        <!-- LINHA 5: Horas (aparece para jetski/lancha) -->
        <div class="row g-3 mb-3" id="campo_horas" style="display: none;">
            <div class="col-md-6">
                <label class="form-label fw-semibold">
                    <i class="fas fa-hourglass-half me-1 text-primary"></i> Horas de Uso
                </label>
                <input type="number" name="horas_uso" class="form-control" placeholder="Ex: 150" value="{{ old('horas_uso') }}">
                <small class="text-muted">Horas de uso (para Jet Ski / Lancha)</small>
            </div>
        </div>
        
        <!-- LINHA 6: Portas + Cor + Combustível -->
        <div class="row g-3 mb-3">
            <div class="col-md-4" id="campo_portas">
                <label class="form-label fw-semibold">
                    <i class="fas fa-door-open me-1 text-primary"></i> Portas
                </label>
                <input type="number" name="portas" class="form-control" placeholder="Ex: 2, 4" value="{{ old('portas') }}">
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-palette me-1 text-primary"></i> Cor
                </label>
                <input type="text" name="cor" class="form-control" placeholder="Ex: Preto, Branco, Vermelho" value="{{ old('cor') }}">
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-semibold">
                    <i class="fas fa-gas-pump me-1 text-primary"></i> Combustível
                </label>
                <select name="combustivel" class="form-select">
                    <option value="">Selecione</option>
                    <option value="Gasolina">⛽ Gasolina</option>
                    <option value="Etanol">🌽 Etanol</option>
                    <option value="Flex">🔄 Flex</option>
                    <option value="Diesel">🛢️ Diesel</option>
                    <option value="Elétrico">⚡ Elétrico</option>
                    <option value="Híbrido">🔋 Híbrido</option>
                </select>
            </div>
        </div>
        
        <!-- LINHA 7: Descrição -->
        <div class="row g-3 mb-4">
            <div class="col-12">
                <label class="form-label fw-semibold">
                    <i class="fas fa-align-left me-1 text-primary"></i> Descrição
                </label>
                <textarea name="descricao" class="form-control" rows="5" placeholder="Descreva o veículo com detalhes...">{{ old('descricao') }}</textarea>
                <small class="text-muted">Informações como opcionais, itens de série, estado de conservação, etc.</small>
            </div>
        </div>

        <!-- LINHA: Observações Internas (só admin vê) -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <label class="form-label fw-semibold">
            <i class="fas fa-lock me-1 text-warning"></i> Observações Internas (Admin)
        </label>
        <textarea name="obs_admin" class="form-control" rows="4" placeholder="Informações internas para a equipe. Ex: Histórico do veículo, negociações anteriores, detalhes de manutenção, observações do vendedor...">{{ old('obs_admin') }}</textarea>
        <small class="text-muted">
            <i class="fas fa-info-circle me-1"></i>
            Estas observações são visíveis apenas para administradores e vendedores. Não aparecem para o cliente.
        </small>
    </div>
</div>
        
        <!-- LINHA 8: Imagem Destaque -->
        <div class="row g-3 mb-4">
            <div class="col-12">
                <label class="form-label fw-semibold">
                    <i class="fas fa-star me-1 text-warning"></i> Imagem Destaque
                </label>
                <input type="file" name="imagem_destaque" id="imagem_destaque" class="form-control" accept="image/*">
                <div id="preview_destaque" class="image-preview mt-2"></div>
                <small class="text-muted">Esta será a imagem principal do veículo</small>
            </div>
        </div>
        
        <!-- LINHA 9: Fotos Adicionais -->
        <div class="row g-3 mb-4">
            <div class="col-12">
                <label class="form-label fw-semibold">
                    <i class="fas fa-images me-1 text-success"></i> Fotos Adicionais
                </label>
                <input type="file" name="fotos[]" id="fotos_input" class="form-control" accept="image/*" multiple>
                <div id="preview_imagens" class="image-preview mt-2"></div>
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    As imagens serão automaticamente comprimidas sem perder qualidade. Máximo 20MB por imagem.
                </small>
            </div>
        </div>
        
        <!-- BOTÕES -->
        <div class="row g-3 mt-2">
            <div class="col-12 d-flex justify-content-between">
                <a href="{{ route('admin.veiculos.index') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-arrow-left me-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary px-5">
                    <i class="fas fa-save me-1"></i> Cadastrar Veículo
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    .form-container {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.05);
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .form-label {
        font-size: 14px;
        margin-bottom: 8px;
        color: #333;
    }
    
    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        padding: 10px 12px;
        transition: all 0.2s;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #1e3c72;
        box-shadow: 0 0 0 3px rgba(30, 60, 114, 0.1);
    }
    
    .input-group-text {
        background: #f8f9fa;
        border-radius: 10px 0 0 10px;
    }
    
    .image-preview {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 10px;
    }
    
    .preview-item {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 10px;
        overflow: hidden;
        background: #f5f5f5;
        border: 2px solid #e0e0e0;
    }
    
    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .preview-item small {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,0.6);
        color: white;
        font-size: 10px;
        text-align: center;
        padding: 2px;
    }
    
    .btn {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-primary {
        background: #1e3c72;
        border: none;
    }
    
    .btn-primary:hover {
        background: #2a5298;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(30, 60, 114, 0.3);
    }
    
    .btn-secondary {
        background: #6c757d;
        border: none;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
    
    .border-bottom {
        border-bottom: 2px solid #e9ecef !important;
    }
    
    .text-danger {
        color: #dc3545 !important;
    }
    
    @media (max-width: 768px) {
        .form-container {
            padding: 20px;
        }
        
        .btn {
            padding: 8px 16px;
        }
    }
</style>

<script>
    // Função para mostrar/esconder campos conforme o tipo de veículo
    function toggleCamposPorTipo() {
        const tipo = document.getElementById('tipo_veiculo')?.value;
        
        const campoKm = document.getElementById('campo_km');
        const campoHoras = document.getElementById('campo_horas');
        const campoPortas = document.getElementById('campo_portas');
        
        // Esconder todos
        if (campoKm) campoKm.style.display = 'none';
        if (campoHoras) campoHoras.style.display = 'none';
        if (campoPortas) campoPortas.style.display = 'flex';
        
        // Mostrar conforme o tipo
        if (tipo === 'carro') {
            if (campoKm) campoKm.style.display = 'flex';
            if (campoPortas) campoPortas.style.display = 'flex';
        } 
        else if (tipo === 'moto') {
            if (campoKm) campoKm.style.display = 'flex';
            if (campoPortas) campoPortas.style.display = 'none';
        }
        else if (tipo === 'caminhao') {
            if (campoKm) campoKm.style.display = 'flex';
            if (campoPortas) campoPortas.style.display = 'none';
        }
        else if (tipo === 'jetski' || tipo === 'lancha') {
            if (campoHoras) campoHoras.style.display = 'flex';
            if (campoPortas) campoPortas.style.display = 'none';
        }
    }
    
    // Event listener
    document.getElementById('tipo_veiculo')?.addEventListener('change', toggleCamposPorTipo);
    toggleCamposPorTipo();
    
    // Preview imagem destaque
    document.getElementById('imagem_destaque')?.addEventListener('change', function(e) {
        const preview = document.getElementById('preview_destaque');
        preview.innerHTML = '';
        
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `<img src="${e.target.result}" alt="preview">`;
                preview.appendChild(div);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    
    // Preview múltiplas imagens com compressão
    async function compressImage(file, maxWidth = 1200, quality = 0.85) {
        return new Promise((resolve, reject) => {
            if (!file.type.startsWith('image/')) {
                resolve(file);
                return;
            }
            
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = (e) => {
                const img = new Image();
                img.src = e.target.result;
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;
                    
                    if (width > maxWidth) {
                        height = (height * maxWidth) / width;
                        width = maxWidth;
                    }
                    
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    canvas.toBlob((blob) => {
                        const compressedFile = new File([blob], file.name.replace(/\.[^/.]+$/, '.jpg'), {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });
                        resolve(compressedFile);
                    }, 'image/jpeg', quality);
                };
                img.onerror = reject;
            };
            reader.onerror = reject;
        });
    }
    
    document.getElementById('fotos_input')?.addEventListener('change', async function(e) {
        const previewDiv = document.getElementById('preview_imagens');
        previewDiv.innerHTML = '';
        
        const files = Array.from(this.files);
        if (files.length === 0) return;
        
        const dataTransfer = new DataTransfer();
        
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            let processedFile = file;
            
            if (file.type.startsWith('image/')) {
                processedFile = await compressImage(file);
            }
            
            dataTransfer.items.add(processedFile);
            
            const reader = new FileReader();
            reader.readAsDataURL(processedFile);
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'preview-item';
                div.innerHTML = `<img src="${e.target.result}" alt="preview"><small>${(processedFile.size / 1024).toFixed(0)}KB</small>`;
                previewDiv.appendChild(div);
            };
        }
        
        this.files = dataTransfer.files;
    });
</script>
@endsection
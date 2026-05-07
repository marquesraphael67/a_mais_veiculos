@extends('layouts.app')

@section('title', $veiculo->modelo . ' - ' . $veiculo->marca->nome)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Galeria de Fotos -->
        <div class="col-md-6">
            @php
                $todasFotos = collect();
                
                if($veiculo->imagem_destaque) {
                    $todasFotos->push([
                        'path' => $veiculo->imagem_destaque,
                        'is_destaque' => true
                    ]);
                }
                
                foreach($veiculo->fotos as $foto) {
                    $todasFotos->push([
                        'path' => $foto->foto_path,
                        'is_destaque' => false
                    ]);
                }
            @endphp
            
            <!-- Foto Principal -->
            <div class="mb-3">
                <img src="{{ asset('storage/' . ($todasFotos->first()['path'] ?? 'veiculos/default.jpg')) }}" 
                     id="fotoPrincipal"
                     class="img-fluid rounded shadow" 
                     style="width: 100%; height: 400px; object-fit: cover; cursor: pointer;"
                     onclick="window.open(this.src)">
            </div>
            
            <!-- Miniaturas -->
            @if($todasFotos->count() > 1)
            <div class="row g-2 mt-2">
                @foreach($todasFotos as $index => $foto)
                <div class="col-3">
                    <img src="{{ asset('storage/' . $foto['path']) }}" 
                         class="img-fluid rounded thumb-foto"
                         style="height: 80px; width: 100%; object-fit: cover; cursor: pointer; border: 2px solid {{ $index == 0 ? '#dc3545' : 'transparent' }}"
                         onclick="trocarFoto('{{ asset('storage/' . $foto['path']) }}', this)"
                         onmouseover="this.style.opacity='0.8'"
                         onmouseout="this.style.opacity='1'">
                </div>
                @endforeach
            </div>
            @endif
            
            <div class="mt-2">
                <small class="text-muted">
                    <i class="fas fa-images me-1"></i> 
                    Total de {{ $todasFotos->count() }} foto(s) deste veículo
                </small>
            </div>
        </div>
        
        <!-- Informações do Veículo -->
        <div class="col-md-6">
            <h1 class="display-5 fw-bold text-primary">{{ $veiculo->marca->nome }} {{ $veiculo->modelo }}</h1>
            <p class="text-muted">
                @if($veiculo->tipo_veiculo == 'carro') 🚗 Carro
                @elseif($veiculo->tipo_veiculo == 'moto') 🏍️ Moto
                @elseif($veiculo->tipo_veiculo == 'caminhao') 🚛 Caminhão
                @elseif($veiculo->tipo_veiculo == 'jetski') 🌊 Jet Ski
                @elseif($veiculo->tipo_veiculo == 'lancha') ⛵ Lancha
                @endif
            </p>
            
            @if($veiculo->preco_antigo && $veiculo->preco_antigo > $veiculo->preco)
                <p class="text-muted">
                    <s>De: R$ {{ number_format($veiculo->preco_antigo, 2, ',', '.') }}</s>
                </p>
                <p class="text-danger display-6 fw-bold">
                    Por: R$ {{ number_format($veiculo->preco, 2, ',', '.') }}
                </p>
            @else
                <p class="text-danger display-6 fw-bold mt-3">R$ {{ number_format($veiculo->preco, 2, ',', '.') }}</p>
            @endif
            
            <div class="mt-4">
                <div class="row g-3">
                    <!-- Ano -->
                    <div class="col-6">
                        <div class="bg-light p-3 rounded">
                            <i class="fas fa-calendar text-primary"></i>
                            <strong>Ano:</strong> {{ $veiculo->ano }}
                        </div>
                    </div>
                    
                    <!-- KM ou Horas -->
                    @if($veiculo->tipo_veiculo == 'jetski' || $veiculo->tipo_veiculo == 'lancha')
                        <div class="col-6">
                            <div class="bg-light p-3 rounded">
                                <i class="fas fa-hourglass-half text-primary"></i>
                                <strong>Horas de Uso:</strong> {{ number_format($veiculo->horas_uso ?? 0, 0, ',', '.') }} horas
                            </div>
                        </div>
                    @else
                        <div class="col-6">
                            <div class="bg-light p-3 rounded">
                                <i class="fas fa-tachometer-alt text-primary"></i>
                                <strong>KM:</strong> {{ number_format($veiculo->km ?? 0, 0, ',', '.') }} km
                            </div>
                        </div>
                    @endif
                    
                    <!-- Cor -->
                    <div class="col-6">
                        <div class="bg-light p-3 rounded">
                            <i class="fas fa-palette text-primary"></i>
                            <strong>Cor:</strong> {{ $veiculo->cor }}
                        </div>
                    </div>
                    
                    <!-- Combustível -->
                    <div class="col-6">
                        <div class="bg-light p-3 rounded">
                            <i class="fas fa-gas-pump text-primary"></i>
                            <strong>Combustível:</strong> {{ $veiculo->combustivel }}
                        </div>
                    </div>
                    
                    <!-- Portas (apenas para carros, motos e caminhões) -->
                    @if($veiculo->tipo_veiculo != 'jetski' && $veiculo->tipo_veiculo != 'lancha')
                    <div class="col-6">
                        <div class="bg-light p-3 rounded">
                            <i class="fas fa-car text-primary"></i>
                            <strong>Portas:</strong> {{ $veiculo->portas }}
                        </div>
                    </div>
                    @endif
                    
                    <!-- Status -->
                    <div class="col-6">
                        <div class="bg-light p-3 rounded">
                            <i class="fas fa-tag text-primary"></i>
                            <strong>Status:</strong> 
                            <span class="badge bg-{{ $veiculo->status == 'disponivel' ? 'success' : 'danger' }}">
                                {{ $veiculo->status == 'disponivel' ? 'Disponível' : 'Vendido' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <!-- Descrição COM quebras de linha (sem espaços extras) -->
<div class="mt-4">
    <h4>Descrição</h4>
    <div class="text-muted" style="white-space: pre-line; line-height: 1.6;">
        {{ trim($veiculo->descricao) }}
    </div>
</div>
            
            @if($veiculo->status == 'disponivel')
                <div class="mt-4">
                    <a href="https://wa.me/5511999999999?text=Olá! Tenho interesse no veículo {{ $veiculo->marca->nome }} {{ $veiculo->modelo }} - Ano {{ $veiculo->ano }}" 
                       class="btn btn-success btn-lg w-100" target="_blank">
                        <i class="fab fa-whatsapp me-2"></i> Tenho Interesse
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function trocarFoto(url, elemento) {
    document.getElementById('fotoPrincipal').src = url;
    
    var thumbs = document.querySelectorAll('.thumb-foto');
    thumbs.forEach(function(thumb) {
        thumb.style.border = '2px solid transparent';
    });
    
    elemento.style.border = '2px solid #dc3545';
}
</script>

<style>
    .thumb-foto {
        transition: all 0.3s ease;
    }
    
    .thumb-foto:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    #fotoPrincipal {
        transition: transform 0.3s ease;
    }
    
    #fotoPrincipal:hover {
        transform: scale(1.02);
    }
</style>
@endsection
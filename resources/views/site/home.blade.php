@extends('layouts.app')

@section('title', 'Home - Encontre seu veículo')

@section('content')
<!-- Filtros -->
<section class="filtros-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="filtro-card">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Marca</label>
                            <select id="filtroMarca" class="form-control">
                                <option value="">Todas as marcas</option>
                                @foreach($marcas as $marca)
                                    <option value="{{ $marca->id }}">{{ $marca->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Preço Máximo</label>
                            <input type="number" id="filtroPreco" class="form-control" placeholder="R$ 0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Ano Mínimo</label>
                            <input type="number" id="filtroAno" class="form-control" placeholder="Ex: 2020">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button id="btnFiltrar" class="btn-filtrar w-100 me-2">Filtrar</button>
                            <button id="btnLimpar" class="btn-limpar w-100">Limpar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Veículos -->
<section class="veiculos-section" id="veiculos">
    <div class="container">
        <h2 class="section-title">Veículos em Destaque</h2>
        <div class="row" id="listaVeiculos">
            @foreach($veiculos as $veiculo)
            <div class="col-lg-4 col-md-6">
                <div class="card-veiculo" onclick="location.href='/veiculo/{{ $veiculo->id }}'">
                    <div style="position: relative;">
                        <img src="{{ asset('storage/' . $veiculo->imagem_destaque) }}" class="card-img" alt="{{ $veiculo->modelo }}">
                        @if($veiculo->status == 'vendido')
                            <div class="badge-status">VENDIDO</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $veiculo->modelo }}</h3>
                        <p class="card-marca">{{ $veiculo->marca->nome }}</p>
                        <div class="card-detalhes">
                            <span><i class="fas fa-calendar"></i> {{ $veiculo->ano }}</span>
                            
                            @if($veiculo->tipo_veiculo == 'jetski' || $veiculo->tipo_veiculo == 'lancha')
                                <span><i class="fas fa-hourglass-half"></i> {{ number_format($veiculo->horas_uso ?? 0, 0, ',', '.') }} h</span>
                            @else
                                <span><i class="fas fa-tachometer-alt"></i> {{ number_format($veiculo->km ?? 0, 0, ',', '.') }} km</span>
                            @endif
                            
                            <span><i class="fas fa-gas-pump"></i> {{ $veiculo->combustivel }}</span>
                        </div>
                        <div class="card-preco">
                            R$ {{ number_format($veiculo->preco, 2, ',', '.') }}
                        </div>
                        <button class="btn-detalhes">
                            Ver Detalhes <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
document.getElementById('btnFiltrar')?.addEventListener('click', function() {
    const marca = document.getElementById('filtroMarca').value;
    const preco = document.getElementById('filtroPreco').value;
    const ano = document.getElementById('filtroAno').value;
    
    fetch('/filtrar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            marca_id: marca,
            preco_max: preco,
            ano_min: ano
        })
    })
    .then(response => response.json())
    .then(veiculos => {
        const container = document.getElementById('listaVeiculos');
        if (veiculos.length === 0) {
            container.innerHTML = '<div class="col-12 text-center"><p class="text-muted">Nenhum veículo encontrado</p></div>';
            return;
        }
        
        container.innerHTML = veiculos.map(veiculo => `
            <div class="col-lg-4 col-md-6">
                <div class="card-veiculo" onclick="location.href='/veiculo/${veiculo.id}'">
                    <div style="position: relative;">
                        <img src="/storage/${veiculo.imagem_destaque}" class="card-img" alt="${veiculo.modelo}">
                        ${veiculo.status === 'vendido' ? '<div class="badge-status">VENDIDO</div>' : ''}
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">${veiculo.modelo}</h3>
                        <p class="card-marca">${veiculo.marca.nome}</p>
                        <div class="card-detalhes">
                            <span><i class="fas fa-calendar"></i> ${veiculo.ano}</span>
                            ${veiculo.tipo_veiculo === 'jetski' || veiculo.tipo_veiculo === 'lancha' 
                                ? `<span><i class="fas fa-hourglass-half"></i> ${veiculo.horas_uso?.toLocaleString() || 0} h</span>`
                                : `<span><i class="fas fa-tachometer-alt"></i> ${veiculo.km?.toLocaleString() || 0} km</span>`
                            }
                            <span><i class="fas fa-gas-pump"></i> ${veiculo.combustivel}</span>
                        </div>
                        <div class="card-preco">
                            R$ ${veiculo.preco.toLocaleString('pt-BR')}
                        </div>
                        <button class="btn-detalhes">
                            Ver Detalhes <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    });
});

document.getElementById('btnLimpar')?.addEventListener('click', function() {
    document.getElementById('filtroMarca').value = '';
    document.getElementById('filtroPreco').value = '';
    document.getElementById('filtroAno').value = '';
    location.reload();
});
</script>
@endsection
@extends('layouts.app')

@section('title', 'Home - Encontre seu veículo')

@section('content')
<section class="filtros-section">
    <div class="container">
        <div class="filtro-card">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Marca</label>
                    <select id="filtroMarca" class="form-control">
                        <option value="">Todas as marcas</option>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca->id }}">{{ $marca->nome }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Preço máximo</label>
                    <input type="number" id="filtroPreco" class="form-control" placeholder="R$ 0">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Ano mínimo</label>
                    <input type="number" id="filtroAno" class="form-control" placeholder="Ex: 2020">
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button id="btnFiltrar" class="btn-filtrar w-100">Filtrar</button>
                    <button id="btnLimpar" class="btn-limpar w-100">Limpar</button>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="veiculos-section" id="veiculos">
    <div class="container">
        <div class="section-head">
            <span>Estoque disponível</span>
            <h2>Veículos em destaque</h2>
            <p>Escolha seu próximo veículo com qualidade e atendimento profissional.</p>
        </div>

        <div class="row g-4" id="listaVeiculos">
            @foreach($veiculos as $veiculo)
                <div class="col-xl-4 col-lg-4 col-md-6 d-flex justify-content-center">
                    <div class="vehicle-card" onclick="location.href='/veiculo/{{ $veiculo->id }}'">
                        <div class="vehicle-img-box">
                            @if($veiculo->imagem_destaque)
                                <img src="{{ asset('storage/' . $veiculo->imagem_destaque) }}" alt="{{ $veiculo->modelo }}">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-car"></i>
                                </div>
                            @endif

                            <div class="badge-type">
                                {{ ucfirst($veiculo->tipo_veiculo ?? 'Veículo') }}
                            </div>

                            @if($veiculo->status == 'vendido')
                                <div class="badge-status sold">Vendido</div>
                            @else
                                <div class="badge-status available">Disponível</div>
                            @endif
                        </div>

                        <div class="vehicle-content">
                            <div class="brand-line">{{ $veiculo->marca->nome ?? 'Sem marca' }}</div>

                            <h3>{{ $veiculo->modelo }}</h3>

                            <div class="spec-grid">
                                <div>
                                    <i class="fas fa-calendar"></i>
                                    <strong>{{ $veiculo->ano }}</strong>
                                    <small>Ano</small>
                                </div>

                                <div>
                                    @if($veiculo->tipo_veiculo == 'jetski' || $veiculo->tipo_veiculo == 'lancha')
                                        <i class="fas fa-hourglass-half"></i>
                                        <strong>{{ number_format($veiculo->horas_uso ?? 0, 0, ',', '.') }}</strong>
                                        <small>Horas</small>
                                    @else
                                        <i class="fas fa-tachometer-alt"></i>
                                        <strong>{{ number_format($veiculo->km ?? 0, 0, ',', '.') }}</strong>
                                        <small>KM</small>
                                    @endif
                                </div>

                                <div>
                                    <i class="fas fa-gas-pump"></i>
                                    <strong>{{ $veiculo->combustivel ?? 'N/I' }}</strong>
                                    <small>Comb.</small>
                                </div>
                            </div>

                            <div class="price-box">
                                <small>Preço</small>
                                <strong>R$ {{ number_format($veiculo->preco, 2, ',', '.') }}</strong>
                            </div>

                            <button class="btn-detalhes">
                                Ver detalhes <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
    .filtros-section {
        margin-top: -38px;
        position: relative;
        z-index: 10;
        padding-bottom: 35px;
    }

    .filtro-card {
        max-width: 1050px;
        margin: 0 auto;
        background: #fff;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 20px 55px rgba(15, 23, 42, .14);
        border: 1px solid #eef2f7;
    }

    .filtro-card .form-label {
        font-weight: 900;
        font-size: 13px;
        color: #0f172a;
    }

    .filtro-card .form-control {
        border-radius: 14px;
        padding: 12px 14px;
        border: 1px solid #dce3ee;
    }

    .btn-filtrar,
    .btn-limpar {
        border: none;
        border-radius: 14px;
        padding: 12px;
        font-weight: 900;
        transition: .2s;
    }

    .btn-filtrar {
        background: #dc3545;
        color: #fff;
    }

    .btn-filtrar:hover {
        background: #b91c1c;
    }

    .btn-limpar {
        background: #e5e7eb;
        color: #111827;
    }

    .btn-limpar:hover {
        background: #d1d5db;
    }

    .veiculos-section {
        padding: 35px 0 40px;
    }

    .section-head {
        text-align: center;
        margin-bottom: 42px;
    }

    .section-head span {
        color: #dc3545;
        font-weight: 950;
        font-size: 13px;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .section-head h2 {
        font-size: clamp(32px, 4vw, 46px);
        font-weight: 950;
        color: #0f172a;
        margin: 8px 0;
    }

    .section-head p {
        color: #64748b;
        margin: 0;
        font-size: 17px;
    }

    .vehicle-card {
        width: 100%;
        max-width: 370px;
        background: white;
        border-radius: 24px;
        overflow: hidden;
        cursor: pointer;
        border: 1px solid #e9eef5;
        box-shadow: 0 14px 35px rgba(15, 23, 42, .09);
        transition: .25s ease;
    }

    .vehicle-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 25px 58px rgba(15, 23, 42, .16);
    }

    .vehicle-img-box {
        height: 235px;
        position: relative;
        overflow: hidden;
        background: #e5e7eb;
    }

    .vehicle-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: .35s ease;
    }

    .vehicle-card:hover .vehicle-img-box img {
        transform: scale(1.06);
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 55px;
    }

    .badge-type,
    .badge-status {
        position: absolute;
        top: 14px;
        padding: 7px 12px;
        border-radius: 999px;
        color: white;
        font-size: 12px;
        font-weight: 950;
        backdrop-filter: blur(8px);
    }

    .badge-type {
        left: 14px;
        background: rgba(15, 23, 42, .85);
    }

    .badge-status {
        right: 14px;
    }

    .badge-status.available {
        background: rgba(22, 163, 74, .95);
    }

    .badge-status.sold {
        background: rgba(220, 53, 69, .95);
    }

    .vehicle-content {
        padding: 20px;
    }

    .brand-line {
        color: #dc3545;
        font-size: 13px;
        font-weight: 950;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .vehicle-content h3 {
        color: #0f172a;
        font-size: 25px;
        font-weight: 950;
        margin-bottom: 16px;
        line-height: 1.05;
    }

    .spec-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-bottom: 17px;
    }

    .spec-grid div {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 15px;
        padding: 10px 7px;
        text-align: center;
    }

    .spec-grid i {
        color: #1e3c72;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .spec-grid strong {
        display: block;
        color: #0f172a;
        font-size: 13px;
        font-weight: 900;
    }

    .spec-grid small {
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
    }

    .price-box {
        border-top: 1px solid #eef2f7;
        padding-top: 15px;
        margin-bottom: 16px;
    }

    .price-box small {
        display: block;
        color: #64748b;
        font-weight: 800;
    }

    .price-box strong {
        color: #dc3545;
        font-size: 28px;
        font-weight: 950;
        letter-spacing: -.5px;
    }

    .btn-detalhes {
        width: 100%;
        border: none;
        background: #0f172a;
        color: white;
        border-radius: 16px;
        padding: 14px;
        font-weight: 950;
        transition: .2s ease;
    }

    .btn-detalhes:hover {
        background: #1e3c72;
    }

    @media (max-width: 768px) {
        .filtros-section {
            margin-top: -25px;
        }

        .filtro-card {
            padding: 18px;
        }

        .col-md-2.d-flex {
            flex-direction: column;
        }

        .vehicle-card {
            max-width: 100%;
        }

        .vehicle-img-box {
            height: 220px;
        }

        .spec-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<script>
function formatarPreco(valor) {
    const numero = Number(valor || 0);
    return numero.toLocaleString('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    });
}

function criarCardVeiculo(veiculo) {
    const isNautico = veiculo.tipo_veiculo === 'jetski' || veiculo.tipo_veiculo === 'lancha';

    const usoValor = isNautico
        ? `${Number(veiculo.horas_uso || 0).toLocaleString('pt-BR')}`
        : `${Number(veiculo.km || 0).toLocaleString('pt-BR')}`;

    const usoLabel = isNautico ? 'Horas' : 'KM';
    const usoIcone = isNautico ? 'fa-hourglass-half' : 'fa-tachometer-alt';

    return `
        <div class="col-xl-4 col-lg-4 col-md-6 d-flex justify-content-center">
            <div class="vehicle-card" onclick="location.href='/veiculo/${veiculo.id}'">
                <div class="vehicle-img-box">
                    ${
                        veiculo.imagem_destaque
                            ? `<img src="/storage/${veiculo.imagem_destaque}" alt="${veiculo.modelo}">`
                            : `<div class="no-image"><i class="fas fa-car"></i></div>`
                    }

                    <div class="badge-type">${veiculo.tipo_veiculo ?? 'Veículo'}</div>
                    <div class="badge-status ${veiculo.status === 'vendido' ? 'sold' : 'available'}">
                        ${veiculo.status === 'vendido' ? 'Vendido' : 'Disponível'}
                    </div>
                </div>

                <div class="vehicle-content">
                    <div class="brand-line">${veiculo.marca?.nome ?? 'Sem marca'}</div>
                    <h3>${veiculo.modelo}</h3>

                    <div class="spec-grid">
                        <div>
                            <i class="fas fa-calendar"></i>
                            <strong>${veiculo.ano}</strong>
                            <small>Ano</small>
                        </div>

                        <div>
                            <i class="fas ${usoIcone}"></i>
                            <strong>${usoValor}</strong>
                            <small>${usoLabel}</small>
                        </div>

                        <div>
                            <i class="fas fa-gas-pump"></i>
                            <strong>${veiculo.combustivel ?? 'N/I'}</strong>
                            <small>Comb.</small>
                        </div>
                    </div>

                    <div class="price-box">
                        <small>Preço</small>
                        <strong>${formatarPreco(veiculo.preco)}</strong>
                    </div>

                    <button class="btn-detalhes">
                        Ver detalhes <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
}

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
            container.innerHTML = `
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-car"></i>
                        <h4>Nenhum veículo encontrado</h4>
                        <p>Tente alterar os filtros da busca.</p>
                    </div>
                </div>
            `;
            return;
        }

        container.innerHTML = veiculos.map(criarCardVeiculo).join('');
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
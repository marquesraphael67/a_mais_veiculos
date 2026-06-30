@extends('layouts.app')

@section('title', 'Início')

@section('content')
<section class="filtros-section" id="veiculos">
    <div class="container">
        <div class="filter-card">
            <form action="{{ route('filtrar') }}" method="POST">
                @csrf

                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Marca</label>
                        <select name="marca_id" class="form-select">
                            <option value="">Todas as marcas</option>
                            @foreach($marcas ?? [] as $marca)
                                <option value="{{ $marca->id }}">{{ $marca->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tipo</label>
                        <select name="tipo_veiculo" class="form-select">
                            <option value="">Todos</option>
                            <option value="carro">Carro</option>
                            <option value="moto">Moto</option>
                            <option value="caminhao">Caminhão</option>
                            <option value="jetski">Jet Ski</option>
                            <option value="lancha">Lancha</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Preço mín.</label>
                        <input type="number" name="preco_min" class="form-control" placeholder="R$ 0">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Preço máx.</label>
                        <input type="number" name="preco_max" class="form-control" placeholder="R$ 100000">
                    </div>

                    <div class="col-md-2 d-grid">
                        <button class="btn btn-filter">
                            <i class="fas fa-search me-1"></i> Filtrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="veiculos-section">
    <div class="container">
        <div class="section-head">
            <span>Estoque disponível</span>
            <h2>Veículos em destaque</h2>
            <p>Escolha seu próximo veículo com segurança, qualidade e atendimento profissional.</p>
        </div>

        <div class="row g-4">
            @forelse($veiculos ?? [] as $veiculo)
                <div class="col-xl-4 col-lg-4 col-md-6 d-flex justify-content-center">
                    <article class="vehicle-card">
                        <a href="{{ route('veiculo.show', $veiculo->id) }}" class="vehicle-image">
                            @if($veiculo->imagem_destaque)
                                <img src="{{ asset('storage/' . $veiculo->imagem_destaque) }}" alt="{{ $veiculo->modelo }}">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-car"></i>
                                </div>
                            @endif

                            <span class="status-badge {{ $veiculo->status == 'disponivel' ? 'available' : 'sold' }}">
                                {{ $veiculo->status == 'disponivel' ? 'Disponível' : 'Vendido' }}
                            </span>

                            @if($veiculo->preco_antigo && $veiculo->preco_antigo > $veiculo->preco)
                                <span class="offer-badge">Oferta</span>
                            @endif
                        </a>

                        <div class="vehicle-body">
                            <div class="brand-row">
                                <span>{{ $veiculo->marca->nome ?? 'Sem marca' }}</span>
                                <small>{{ ucfirst($veiculo->tipo_veiculo ?? 'veículo') }}</small>
                            </div>

                            <h3>{{ $veiculo->modelo }}</h3>

                            <div class="vehicle-specs">
                                <div>
                                    <i class="fas fa-calendar"></i>
                                    <strong>{{ $veiculo->ano }}</strong>
                                    <small>Ano</small>
                                </div>

                                <div>
                                    @if(in_array($veiculo->tipo_veiculo, ['jetski', 'lancha']))
                                        <i class="fas fa-clock"></i>
                                        <strong>{{ $veiculo->horas_uso ?? 0 }}h</strong>
                                        <small>Uso</small>
                                    @else
                                        <i class="fas fa-road"></i>
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

                            <div class="price-area">
                                @if($veiculo->preco_antigo && $veiculo->preco_antigo > $veiculo->preco)
                                    <small>De R$ {{ number_format($veiculo->preco_antigo, 2, ',', '.') }}</small>
                                @endif

                                <strong>R$ {{ number_format($veiculo->preco, 2, ',', '.') }}</strong>
                            </div>

                            <div class="vehicle-actions">
                                <a href="{{ route('veiculo.show', $veiculo->id) }}" class="btn-details">
                                    Ver detalhes
                                    <i class="fas fa-arrow-right ms-1"></i>
                                </a>

                                <a href="https://wa.me/5518996737473?text=Olá, tenho interesse no {{ urlencode($veiculo->modelo) }}" target="_blank" class="btn-whats">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-car"></i>
                        <h4>Nenhum veículo encontrado</h4>
                        <p>Cadastre veículos no painel administrativo para aparecerem aqui.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    .filtros-section {
        margin-top: -38px;
        position: relative;
        z-index: 5;
        padding-bottom: 32px;
    }

    .filter-card {
        background: #fff;
        border-radius: 24px;
        padding: 24px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, .13);
        border: 1px solid #edf1f7;
    }

    .filter-card .form-label {
        font-weight: 800;
        color: #0f172a;
        font-size: 13px;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        border-radius: 14px;
        padding: 12px 14px;
        border: 1px solid #dce3ee;
    }

    .btn-filter {
        background: #dc3545;
        color: white;
        border-radius: 14px;
        padding: 12px;
        font-weight: 900;
    }

    .btn-filter:hover {
        background: #b91c1c;
        color: white;
    }

    .veiculos-section {
        padding: 42px 0 30px;
    }

    .section-head {
        text-align: center;
        margin-bottom: 42px;
    }

    .section-head span {
        color: #dc3545;
        font-weight: 900;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
    }

    .section-head h2 {
        font-size: clamp(30px, 4vw, 44px);
        font-weight: 950;
        color: #0f172a;
        margin: 8px 0;
    }

    .section-head p {
        color: #64748b;
        font-size: 17px;
        margin: 0;
    }

    .vehicle-card {
        width: 100%;
        max-width: 370px;
        background: white;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid #e9eef5;
        box-shadow: 0 14px 35px rgba(15, 23, 42, .09);
        transition: .25s ease;
    }

    .vehicle-card:hover {
        transform: translateY(-7px);
        box-shadow: 0 24px 58px rgba(15, 23, 42, .16);
    }

    .vehicle-image {
        display: block;
        height: 230px;
        position: relative;
        overflow: hidden;
        background: #e5e7eb;
    }

    .vehicle-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: .35s ease;
    }

    .vehicle-card:hover .vehicle-image img {
        transform: scale(1.06);
    }

    .no-image {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 54px;
    }

    .status-badge,
    .offer-badge {
        position: absolute;
        top: 14px;
        border-radius: 999px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 900;
        color: white;
        backdrop-filter: blur(8px);
    }

    .status-badge {
        left: 14px;
    }

    .status-badge.available {
        background: rgba(22, 163, 74, .95);
    }

    .status-badge.sold {
        background: rgba(220, 53, 69, .95);
    }

    .offer-badge {
        right: 14px;
        background: rgba(220, 53, 69, .95);
    }

    .vehicle-body {
        padding: 20px;
    }

    .brand-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }

    .brand-row span {
        color: #dc3545;
        font-weight: 950;
        font-size: 13px;
        text-transform: uppercase;
    }

    .brand-row small {
        background: #f1f5f9;
        color: #475569;
        border-radius: 999px;
        padding: 5px 9px;
        font-size: 11px;
        font-weight: 800;
    }

    .vehicle-body h3 {
        color: #0f172a;
        font-size: 25px;
        font-weight: 950;
        margin-bottom: 16px;
        line-height: 1.05;
    }

    .vehicle-specs {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        margin-bottom: 17px;
    }

    .vehicle-specs div {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 15px;
        padding: 10px 7px;
        text-align: center;
    }

    .vehicle-specs i {
        color: #1e3c72;
        font-size: 14px;
        margin-bottom: 4px;
    }

    .vehicle-specs strong {
        display: block;
        color: #0f172a;
        font-size: 13px;
        font-weight: 900;
        line-height: 1.1;
    }

    .vehicle-specs small {
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
    }

    .price-area {
        border-top: 1px solid #eef2f7;
        padding-top: 15px;
        margin-bottom: 16px;
    }

    .price-area small {
        display: block;
        color: #94a3b8;
        text-decoration: line-through;
        font-weight: 800;
        margin-bottom: 2px;
    }

    .price-area strong {
        display: block;
        color: #dc3545;
        font-size: 27px;
        font-weight: 950;
        letter-spacing: -.5px;
    }

    .vehicle-actions {
        display: flex;
        gap: 10px;
    }

    .btn-details {
        flex: 1;
        background: #0f172a;
        color: white;
        border-radius: 16px;
        padding: 13px;
        text-align: center;
        font-weight: 950;
        transition: .2s ease;
    }

    .btn-details:hover {
        background: #1e3c72;
        color: white;
    }

    .btn-whats {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: #25d366;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        transition: .2s ease;
        flex-shrink: 0;
    }

    .btn-whats:hover {
        color: white;
        transform: scale(1.05);
    }

    .empty-state {
        background: white;
        border-radius: 24px;
        padding: 50px;
        text-align: center;
        border: 1px solid #eef0f5;
        box-shadow: 0 12px 35px rgba(0,0,0,.08);
    }

    .empty-state i {
        font-size: 55px;
        color: #cbd5e1;
        margin-bottom: 15px;
    }

    .empty-state h4 {
        font-weight: 900;
        color: #0f172a;
    }

    .empty-state p {
        color: #6b7280;
        margin: 0;
    }

    @media (max-width: 768px) {
        .filtros-section {
            margin-top: -26px;
        }

        .filter-card {
            padding: 18px;
        }

        .vehicle-card {
            max-width: 100%;
        }

        .vehicle-image {
            height: 220px;
        }

        .vehicle-specs {
            grid-template-columns: 1fr;
        }

        .price-area strong {
            font-size: 24px;
        }
    }
</style>
@endsection
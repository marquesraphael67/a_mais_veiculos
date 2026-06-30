@extends('layouts.app')

@section('title', $veiculo->modelo . ' - ' . $veiculo->marca->nome)

@section('content')
@php
    $todasFotos = collect();

    if ($veiculo->imagem_destaque) {
        $todasFotos->push([
            'path' => $veiculo->imagem_destaque,
            'is_destaque' => true
        ]);
    }

    foreach ($veiculo->fotos as $foto) {
        $todasFotos->push([
            'path' => $foto->foto_path ?? $foto->caminho,
            'is_destaque' => false
        ]);
    }

    $fotoPrincipal = $todasFotos->first()['path'] ?? null;
@endphp

<div class="vehicle-show-page">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('home') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                Voltar para os veículos
            </a>
        </div>

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="gallery-card">
                    <div class="main-photo-box">
                        @if($fotoPrincipal)
                            <img src="{{ asset('storage/' . $fotoPrincipal) }}" id="fotoPrincipal" alt="{{ $veiculo->modelo }}">
                        @else
                            <div class="no-photo">
                                <i class="fas fa-car"></i>
                                <p>Sem imagem cadastrada</p>
                            </div>
                        @endif
                    </div>

                    @if($todasFotos->count() > 1)
                        <div class="thumbs-row">
                            @foreach($todasFotos as $index => $foto)
                                <button type="button"
                                        class="thumb-btn {{ $index == 0 ? 'active' : '' }}"
                                        onclick="trocarFoto('{{ asset('storage/' . $foto['path']) }}', this)">
                                    <img src="{{ asset('storage/' . $foto['path']) }}" alt="Foto {{ $index + 1 }}">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-5">
                <div class="info-card">
                    <h1>{{ $veiculo->marca->nome }} {{ $veiculo->modelo }}</h1>

                    <div class="price-box">
                        @if($veiculo->preco_antigo && $veiculo->preco_antigo > $veiculo->preco)
                            <small>De R$ {{ number_format($veiculo->preco_antigo, 2, ',', '.') }}</small>
                            <strong>Por R$ {{ number_format($veiculo->preco, 2, ',', '.') }}</strong>
                        @else
                            <strong>R$ {{ number_format($veiculo->preco, 2, ',', '.') }}</strong>
                        @endif
                    </div>

                    <div class="spec-grid">
                        <div class="spec-item">
                            <i class="fas fa-calendar"></i>
                            <small>Ano</small>
                            <strong>{{ $veiculo->ano }}</strong>
                        </div>

                        @if($veiculo->tipo_veiculo == 'jetski' || $veiculo->tipo_veiculo == 'lancha')
                            <div class="spec-item">
                                <i class="fas fa-hourglass-half"></i>
                                <small>Horas de uso</small>
                                <strong>{{ number_format($veiculo->horas_uso ?? 0, 0, ',', '.') }} h</strong>
                            </div>
                        @else
                            <div class="spec-item">
                                <i class="fas fa-tachometer-alt"></i>
                                <small>Quilometragem</small>
                                <strong>{{ number_format($veiculo->km ?? 0, 0, ',', '.') }} km</strong>
                            </div>
                        @endif

                        <div class="spec-item">
                            <i class="fas fa-palette"></i>
                            <small>Cor</small>
                            <strong>{{ $veiculo->cor ?? 'N/I' }}</strong>
                        </div>

                        <div class="spec-item">
                            <i class="fas fa-gas-pump"></i>
                            <small>Combustível</small>
                            <strong>{{ $veiculo->combustivel ?? 'N/I' }}</strong>
                        </div>

                        @if($veiculo->tipo_veiculo != 'jetski' && $veiculo->tipo_veiculo != 'lancha')
                            <div class="spec-item">
                                <i class="fas fa-car-side"></i>
                                <small>Portas</small>
                                <strong>{{ $veiculo->portas ?? 'N/I' }}</strong>
                            </div>
                        @endif

                        <div class="spec-item">
                            <i class="fas fa-tag"></i>
                            <small>Status</small>
                            <strong>{{ $veiculo->status == 'disponivel' ? 'Disponível' : 'Vendido' }}</strong>
                        </div>
                    </div>

                    @if($veiculo->status == 'disponivel')
                        <a href="https://wa.me/5518996737473?text=Olá! Tenho interesse no veículo {{ urlencode($veiculo->marca->nome . ' ' . $veiculo->modelo . ' - Ano ' . $veiculo->ano) }}"
                           class="btn-interest"
                           target="_blank">
                            <i class="fab fa-whatsapp"></i>
                            Tenho interesse
                        </a>
                    @else
                        <button class="btn-sold" disabled>
                            Veículo vendido
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="description-card">
            <h3>Descrição do veículo</h3>
            <div class="description-text">
                {{ trim($veiculo->descricao) ?: 'Nenhuma descrição cadastrada.' }}
            </div>
        </div>
    </div>
</div>

<style>
    .vehicle-show-page {
        padding: 45px 0;
        background: #f5f7fb;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #1e3c72;
        font-weight: 900;
        font-size: 15px;
        padding: 12px 18px;
        background: #fff;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 20px rgba(0,0,0,.06);
        transition: .25s;
    }

    .btn-back:hover {
        transform: translateX(-4px);
        color: #dc3545;
        border-color: #dc3545;
    }

    .gallery-card,
    .info-card,
    .description-card {
        background: white;
        border-radius: 26px;
        border: 1px solid #e9eef5;
        box-shadow: 0 14px 35px rgba(15, 23, 42, .08);
    }

    .gallery-card {
        padding: 16px;
    }

    .main-photo-box {
        height: 470px;
        border-radius: 22px;
        overflow: hidden;
        position: relative;
        background: #e5e7eb;
    }

    .main-photo-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: .35s ease;
        cursor: zoom-in;
    }

    .main-photo-box img:hover {
        transform: scale(1.03);
    }

    .thumbs-row {
        display: flex;
        gap: 10px;
        margin-top: 14px;
        overflow-x: auto;
        padding-bottom: 5px;
    }

    .thumb-btn {
        border: 3px solid transparent;
        background: none;
        padding: 0;
        border-radius: 15px;
        overflow: hidden;
        flex: 0 0 95px;
        height: 75px;
        cursor: pointer;
        opacity: .78;
        transition: .2s;
    }

    .thumb-btn img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .thumb-btn.active {
        border-color: #dc3545;
        opacity: 1;
    }

    .info-card {
        padding: 28px;
        position: sticky;
        top: 95px;
    }

    .info-card h1 {
        font-size: clamp(30px, 4vw, 44px);
        font-weight: 950;
        color: #0f172a;
        line-height: 1.05;
        margin-bottom: 18px;
    }

    .price-box {
        border-top: 1px solid #eef2f7;
        border-bottom: 1px solid #eef2f7;
        padding: 18px 0;
        margin-bottom: 20px;
    }

    .price-box small {
        display: block;
        color: #94a3b8;
        text-decoration: line-through;
        font-weight: 800;
    }

    .price-box strong {
        display: block;
        color: #dc3545;
        font-size: 34px;
        font-weight: 950;
        letter-spacing: -.6px;
    }

    .spec-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 22px;
    }

    .spec-item {
        background: #f8fafc;
        border: 1px solid #edf2f7;
        border-radius: 18px;
        padding: 14px;
    }

    .spec-item i {
        color: #1e3c72;
        font-size: 18px;
        margin-bottom: 8px;
    }

    .spec-item small {
        display: block;
        color: #64748b;
        font-weight: 800;
        font-size: 12px;
    }

    .spec-item strong {
        display: block;
        color: #0f172a;
        font-weight: 950;
        font-size: 15px;
    }

    .btn-interest,
    .btn-sold {
        width: 100%;
        border: none;
        border-radius: 18px;
        padding: 16px;
        font-size: 17px;
        font-weight: 950;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        text-decoration: none;
    }

    .btn-interest {
        background: #25d366;
        color: white;
    }

    .btn-interest:hover {
        background: #16a34a;
        color: white;
    }

    .btn-sold {
        background: #e5e7eb;
        color: #64748b;
    }

    .description-card {
        margin-top: 24px;
        padding: 28px;
    }

    .description-card h3 {
        color: #0f172a;
        font-weight: 950;
        margin-bottom: 14px;
    }

    .description-text {
        white-space: pre-line;
        color: #475569;
        line-height: 1.8;
        font-size: 16px;
    }

    .no-photo {
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 55px;
    }

    .no-photo p {
        font-size: 16px;
        margin-top: 10px;
    }

    @media (max-width: 991px) {
        .info-card {
            position: static;
        }

        .main-photo-box {
            height: 360px;
        }
    }

    @media (max-width: 768px) {
        .vehicle-show-page {
            padding: 30px 0;
        }

        .main-photo-box {
            height: 300px;
        }

        .info-card,
        .description-card {
            padding: 20px;
        }

        .spec-grid {
            grid-template-columns: 1fr;
        }

        .price-box strong {
            font-size: 28px;
        }
    }
</style>

<script>
function trocarFoto(url, elemento) {
    const principal = document.getElementById('fotoPrincipal');

    if (principal) {
        principal.src = url;
    }

    document.querySelectorAll('.thumb-btn').forEach(function(thumb) {
        thumb.classList.remove('active');
    });

    elemento.classList.add('active');
}

document.getElementById('fotoPrincipal')?.addEventListener('click', function () {
    window.open(this.src, '_blank');
});
</script>
@endsection
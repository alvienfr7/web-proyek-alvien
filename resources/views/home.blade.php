@extends('layouts.app')

@section('title', 'Beranda - Badan Pusat Statistik')

{{-- Beranda tidak perlu jarak bawah navbar, karena hero section punya padding sendiri --}}
@section('main-class', '')

@push('styles')
<style>
    .navbar-custom { margin-bottom: 0 !important; }

    .hero-section { background-color: #f4f6f9; padding: 80px 0; }
    .hero-title { font-size: 2.8rem; font-weight: bold; color: #000; line-height: 1.2; margin-bottom: 20px; }
    .btn-eksplorasi { background-color: #0067b8; color: white; font-weight: bold; padding: 12px 24px; transition: 0.3s; border-radius: 5px; text-decoration: none; }
    .btn-eksplorasi:hover { background-color: #005da6; color: white; }
    .hero-img { width: 100%; max-height: 380px; object-fit: cover; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); }

    .indikator-section {
        background: linear-gradient(135deg, #0a4275, #175a8f);
        padding: 60px 0;
        color: white;
        text-align: center;
    }
    .indikator-card {
        background: white;
        border-radius: 12px;
        padding: 25px 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: #333;
        transition: transform 0.2s;
    }
    .indikator-card:hover { transform: translateY(-5px); }
    .indikator-icon { font-size: 2rem; margin-bottom: 10px; }
    .indikator-title { font-size: 0.95rem; font-weight: bold; color: #175a8f; margin-bottom: 15px; min-height: 40px; }
    .indikator-value { font-size: 2.2rem; font-weight: 900; margin-bottom: 0; line-height: 1; color: #333; }
    .indikator-unit { font-size: 0.85rem; color: #666; margin-top: 5px; }
    .indikator-period { font-size: 0.85rem; color: #999; margin-top: 5px; }

    .infographic-card { background: #fff; border-radius: 8px; padding: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: transform 0.2s; height: 100%; border: 1px solid #e1e8f0; text-align: center; }
    .infographic-card:hover { transform: translateY(-5px); box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
    .infographic-card img { width: 100%; height: 280px; object-fit: contain; margin-bottom: 15px; border-radius: 5px; }
    .infographic-title { font-size: 14px; color: #333; margin: 0; line-height: 1.4; }
</style>
@endpush

@section('content')
    {{-- Sesi 1: Hero --}}
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center mb-4 mb-md-0">
                    <img src="{{ asset('images/gambar-hero.jpg') }}"
                         alt="Ilustrasi Data BPS"
                         class="hero-img">
                </div>
                <div class="col-md-6">
                    <h1 class="hero-title">Produktivitas Data Anda makin optimal</h1>
                    <p style="font-size: 1.1rem; color: #333; margin-bottom: 30px;">
                        BPS menghadirkan kemudahan akses data, publikasi statistik, dan infografis akurat dalam satu portal web terpadu.
                    </p>
                    <a href="{{ route('publikasi.index') }}" class="btn-eksplorasi">Eksplorasi Publikasi</a>
                </div>
            </div>
        </div>
    </div>

    {{-- Sesi 2: Indikator Strategis dari API BPS --}}
    <div class="indikator-section">
        <div class="container-fluid px-5">
            <h3 class="fw-bold mb-4 text-white">Lembaga yang Independen, Tepercaya, dan Berperan Aktif</h3>
            <p class="mb-5 text-white-50">dalam Mendukung Perumusan Kebijakan Berbasis Data</p>

            <div class="row g-3 justify-content-center">
                @foreach ($dataIndikator as $indikator)
                    <div class="col-md-2 col-sm-6" style="width: 20%; min-width: 200px;">
                        <div class="indikator-card">
                            <div class="indikator-icon">{{ $indikator['icon'] }}</div>
                            <div class="indikator-title">{{ $indikator['title'] }}</div>
                            <div class="indikator-value">{{ $indikator['nilai'] }}</div>
                            <div class="indikator-unit">{{ $indikator['unit'] }}</div>
                            <div class="indikator-period">{{ $indikator['period'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Sesi 3: Infografis --}}
    <div class="container py-5 mb-5 mt-4">
        <h2 class="text-center fw-bold mb-5" style="color: #175a8f;">Infografis Terkini BPS</h2>

        <div class="row g-4 justify-content-center">
            @forelse (array_slice($infografisList, 0, 8) as $item)
                <div class="col-md-3 col-sm-6">
                    <div class="infographic-card">
                        <img src="{{ $item['img'] }}" alt="Infografis">
                        <h3 class="infographic-title">{{ $item['title'] }}</h3>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-danger fw-bold py-4">
                    Gagal memproses data dari API BPS (Pastikan koneksi internet aktif).
                </div>
            @endforelse
        </div>
    </div>
@endsection
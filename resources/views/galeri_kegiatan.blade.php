@extends('layouts.app')

@section('title', 'Galeri Kegiatan - BPS')

@push('styles')
<style>
    .thumbnail-img:hover {
        opacity: 0.7;
        border-color: #175a8f;
    }

    .thumbnail-container {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 10px;
    }
</style>
@endpush

@section('content')
<div class="container bg-white p-4 shadow-sm rounded mb-5 text-center">
    @if (count($gambars) > 0)
        <div class="mb-4 d-flex justify-content-center">
            <img id="mainImage"
                 src="{{ asset('images/' . $gambars[0]) }}"
                 alt="Gambar Utama"
                 class="img-fluid rounded shadow-sm"
                 style="max-height: 500px; width: auto; object-fit: contain;">
        </div>

        <div class="thumbnail-container justify-content-center">
            @foreach ($gambars as $gambar)
                <img src="{{ asset('images/' . $gambar) }}"
                     class="img-thumbnail thumbnail-img shadow-sm"
                     alt="{{ $gambar }}"
                     style="width: 120px; height: 80px; object-fit: cover; cursor: pointer;"
                     data-src="{{ asset('images/' . $gambar) }}"
                     onclick="changeImage(this.getAttribute('data-src'))">
            @endforeach
        </div>
    @else
        <h5 class="text-muted text-center py-5">Belum ada gambar di galeri.</h5>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function changeImage(imageSrc) {
        document.getElementById('mainImage').src = imageSrc;
    }
</script>
@endpush
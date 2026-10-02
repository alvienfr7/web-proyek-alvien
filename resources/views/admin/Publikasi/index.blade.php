@extends('layouts.app')

@section('title', 'Daftar Publikasi Admin - BPS')

@push('styles')
<style>
    .action-link {
        text-decoration: none;
        color: #333;
        margin-right: 10px;
        font-weight: 500;
    }

    .action-link:hover {
        color: #175a8f;
    }
</style>
@endpush

@section('content')
<div class="container bg-white p-5 shadow-sm rounded mb-5">
    <h3 class="fw-bold mb-4">Daftar Publikasi BADAN PUSAT STATISTIK</h3>

    {{-- Form pencarian. method GET agar kata kunci ikut di URL dan bisa di-bookmark --}}
    <div class="card mb-4 border-light shadow-sm" style="background-color: #fcfcfc;">
        <div class="card-body">
            <form action="{{ route('admin.publikasi.index') }}" method="GET">
                <div class="row align-items-center g-2">
                    <div class="col-md-2 text-primary fw-bold">Cari Judul<br>Publikasi :</div>
                    <div class="col-md-8">
                        <input type="text"
                               name="cari"
                               class="form-control"
                               placeholder="Ketik kata kunci pencarian di sini..."
                               value="{{ request('cari') }}">
                    </div>
                    <div class="col-md-2 d-grid gap-2">
                        <button type="submit" class="btn text-white fw-bold" style="background-color: #175a8f;">
                            Cari
                        </button>
                        @if (request('cari'))
                            <a href="{{ route('admin.publikasi.index') }}" class="btn btn-outline-secondary btn-sm">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (request('cari'))
        <p class="text-muted">
            Menampilkan {{ $publikasi->total() }} hasil untuk "<strong>{{ request('cari') }}</strong>".
        </p>
    @endif

    <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-header-custom">
            <tr>
                <th width="5%">No</th>
                <th class="text-start">Judul</th>
                <th width="20%">Tanggal Rilis</th>
                <th width="15%">Sampul</th>
                <th width="15%">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($publikasi as $item)
                <tr>
                    {{-- firstItem() membuat nomor tetap benar di halaman 2, 3, dst --}}
                    <td class="fw-bold">{{ $publikasi->firstItem() + $loop->index }}</td>
                    <td class="text-start">{{ $item->judul }}</td>
                    <td>{{ $item->tanggal_rilis->translatedFormat('d F Y') }}</td>
                    <td>
                        @if (Str::endsWith(strtolower($item->sampul), '.pdf'))
                            <a href="{{ asset('images/' . $item->sampul) }}" target="_blank" class="text-decoration-none">
                                📄 Lihat PDF
                            </a>
                        @else
                            <img src="{{ asset('images/' . $item->sampul) }}"
                                 alt="{{ $item->judul }}"
                                 width="60"
                                 class="img-thumbnail border-0 shadow-sm">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.publikasi.edit', $item->id) }}" class="action-link">✏️ Edit</a>

                        <form action="{{ route('admin.publikasi.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn btn-link action-link p-0 text-dark"
                                    onclick="return confirm('Yakin ingin menghapus?')">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-muted py-4">
                        {{ request('cari') ? 'Tidak ada publikasi yang cocok.' : 'Belum ada data publikasi.' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Tombol halaman. links() otomatis menyembunyikan diri kalau cuma 1 halaman --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $publikasi->links() }}
    </div>
</div>
@endsection
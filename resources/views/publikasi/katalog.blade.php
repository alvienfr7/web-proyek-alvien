@extends('layouts.app')

@section('title', 'Daftar Publikasi BPS')

@section('content')
<div class="container bg-white p-5 shadow-sm rounded mb-5">
    <h3 class="fw-bold mb-4">Daftar Publikasi BADAN PUSAT STATISTIK</h3>

    <form action="{{ route('publikasi.index') }}" method="GET" class="mb-4">
        <div class="row g-2">
            <div class="col-md-10">
                <input type="text"
                       name="cari"
                       class="form-control"
                       placeholder="Cari judul publikasi..."
                       value="{{ request('cari') }}">
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" class="btn text-white fw-bold" style="background-color: #175a8f;">Cari</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-header-custom text-center">
            <tr>
                <th width="5%">No</th>
                <th>Judul</th>
                <th width="20%">Tanggal Rilis</th>
                <th width="15%">Sampul</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($publikasi as $item)
                <tr>
                    <td class="text-center fw-bold">{{ $publikasi->firstItem() + $loop->index }}</td>
                    <td>{{ $item->judul }}</td>
                    <td class="text-center">{{ $item->tanggal_rilis->translatedFormat('d F Y') }}</td>
                    <td class="text-center">
                        @if (Str::endsWith(strtolower($item->sampul), '.pdf'))
                            <a href="{{ asset('images/' . $item->sampul) }}" target="_blank" class="text-decoration-none">
                                📄 Unduh
                            </a>
                        @else
                            <img src="{{ asset('images/' . $item->sampul) }}"
                                 alt="{{ $item->judul }}"
                                 width="80"
                                 class="img-thumbnail border-0 shadow-sm">
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-4">
                        {{ request('cari') ? 'Tidak ada publikasi yang cocok.' : 'Belum ada publikasi.' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $publikasi->links() }}
    </div>
</div>
@endsection
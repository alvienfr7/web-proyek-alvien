@extends('layouts.app')

@section('title', 'Edit Publikasi Admin - BPS')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-sm border-0" style="width: 600px; padding: 20px;">
        <div class="card-body">
            <h4 class="text-center fw-bold mb-4" style="color: #175a8f;">Form Edit Publikasi</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.publikasi.update', $publikasi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="judul" class="form-label text-dark fw-medium">Judul Publikasi:</label>
                    <input type="text" name="judul" id="judul" class="form-control"
                           value="{{ old('judul', $publikasi->judul) }}" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_rilis" class="form-label text-dark fw-medium">Tanggal Rilis:</label>
                    <input type="date" name="tanggal_rilis" id="tanggal_rilis" class="form-control"
                           value="{{ old('tanggal_rilis', \Carbon\Carbon::parse($publikasi->tanggal_rilis)->format('Y-m-d')) }}"
                           required>
                </div>

                <div class="mb-4">
                    <label class="form-label text-dark fw-medium d-block">File Publikasi Saat Ini:</label>
                    <div class="p-2 border rounded bg-light mb-2">
                        {{ $publikasi->sampul }}
                    </div>

                    <label for="sampul" class="form-label text-dark fw-medium d-block mt-2">
                        Pilih File Baru (kosongkan jika tidak ingin diganti):
                    </label>
                    <input type="file" name="sampul" id="sampul" class="form-control"
                           accept=".jpg,.jpeg,.png,.webp,.pdf">
                    <div class="form-text">Format: JPG, JPEG, PNG, WEBP, atau PDF. Maksimal 5 MB.</div>
                </div>

                <button type="submit" class="btn w-100 fw-bold text-white py-2" style="background-color: #175a8f;">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.publikasi.index') }}" class="btn btn-secondary w-100 mt-2 py-2 fw-bold">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Tambah Publikasi Admin - BPS')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-sm border-0" style="width: 600px; padding: 20px;">
        <div class="card-body">
            <h4 class="text-center fw-bold mb-4" style="color: #175a8f;">Form Menambahkan Publikasi Baru</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.publikasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="judul" class="form-label text-dark fw-medium">Judul Publikasi:</label>
                    {{-- old() menjaga isian tetap ada kalau validasi gagal --}}
                    <input type="text" name="judul" id="judul" class="form-control"
                           value="{{ old('judul') }}" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_rilis" class="form-label text-dark fw-medium">Tanggal Rilis:</label>
                    <input type="date" name="tanggal_rilis" id="tanggal_rilis" class="form-control"
                           value="{{ old('tanggal_rilis') }}" required>
                </div>

                <div class="mb-4">
                    <label for="sampul" class="form-label text-dark fw-medium">File Publikasi:</label>
                    <input type="file" name="sampul" id="sampul" class="form-control"
                           accept=".jpg,.jpeg,.png,.webp,.pdf" required>
                    <div class="form-text">Format: JPG, JPEG, PNG, WEBP, atau PDF. Maksimal 5 MB.</div>
                </div>

                <button type="submit" class="btn w-100 fw-bold text-white py-2" style="background-color: #175a8f;">
                    Simpan Publikasi
                </button>
                <a href="{{ route('admin.publikasi.index') }}" class="btn btn-secondary w-100 mt-2 py-2 fw-bold">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
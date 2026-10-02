@extends('layouts.app')

@section('title', 'Login Admin - BPS')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow-sm border-0" style="width: 400px; padding: 20px;">
        <div class="card-body">
            <h4 class="text-center fw-bold mb-4" style="color: #175a8f;">Silakan Login</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.attempt') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label text-secondary">Email</label>
                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           style="background-color: #eef3fc;"
                           value="{{ old('email') }}"
                           required
                           autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label text-secondary">Password</label>
                    {{-- Password tidak pernah diisi ulang ke dalam HTML --}}
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                    <label class="form-check-label text-secondary" for="remember">Ingat Saya</label>
                </div>

                <button type="submit" class="btn w-100 fw-bold text-white py-2" style="background-color: #175a8f;">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
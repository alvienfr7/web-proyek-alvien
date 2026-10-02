<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Badan Pusat Statistik')</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f4f6f9;
        }

        .navbar-custom {
            background-color: #175a8f;
        }

        /* Dipakai untuk menandai menu yang sedang aktif */
        .nav-link-active {
            background-color: #fff;
            color: #212529 !important;
            padding-left: 1rem;
            padding-right: 1rem;
            font-weight: bold;
            border-radius: 4px;
        }

        .table-header-custom {
            background-color: #0b5394;
            color: white;
        }

        /* Agar tombol logout di dalam <form> tampak sama dengan link navbar lain */
        .btn-nav-link {
            background: none;
            border: none;
            padding: 0.5rem 1rem;
            color: rgba(255, 255, 255, 0.55);
        }

        .btn-nav-link:hover {
            color: rgba(255, 255, 255, 0.75);
        }
    </style>

    {{-- Tempat view anak menyisipkan CSS khusus miliknya sendiri --}}
    @stack('styles')
</head>

<body>
    @include('partials.navbar')

    <main class="@yield('main-class', 'pb-5')">
        {{-- Notifikasi dari redirect()->with('success', ...) --}}
        @if (session('success'))
            <div class="container mt-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>
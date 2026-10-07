{{--
    Navbar tunggal untuk seluruh situs.
    @auth  = blok dijalankan hanya kalau user sudah login
    @guest = blok dijalankan hanya kalau user belum login
    request()->routeIs() = mendeteksi route yang sedang dibuka, untuk menandai menu aktif
--}}
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom mb-4">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('images/gambar-logo-bps.png') }}" alt="Logo BPS" height="36">
            BADAN PUSAT STATISTIK
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="mainNav">
            <ul class="navbar-nav align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'nav-link-active' : '' }}"
                       href="{{ route('home') }}">Home</a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.publikasi.index', 'admin.publikasi.edit') ? 'nav-link-active' : '' }}"
                           href="{{ route('admin.publikasi.index') }}">Daftar Publikasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.publikasi.create') ? 'nav-link-active' : '' }}"
                           href="{{ route('admin.publikasi.create') }}">Tambah Publikasi</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('publikasi.index') ? 'nav-link-active' : '' }}"
                           href="{{ route('publikasi.index') }}">Daftar Publikasi</a>
                    </li>
                @endauth

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('galeri-kegiatan.index') ? 'nav-link-active' : '' }}"
                       href="{{ route('galeri-kegiatan.index') }}">Galeri Kegiatan</a>
                </li>

                @auth
                    {{-- Logout wajib POST agar session benar-benar dihapus --}}
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="nav-link btn-nav-link">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'nav-link-active' : '' }}"
                           href="{{ route('login') }}">Login</a>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
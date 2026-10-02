<?php

namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PublikasiController extends Controller
{
    /** Whitelist ekstensi file sampul. Inilah yang mencegah upload skrip berbahaya. */
    private const MIMES_SAMPUL = 'jpg,jpeg,png,webp,pdf';

    /** Ukuran maksimal file dalam kilobyte. */
    private const MAX_SIZE_KB = 5120;

    /** Jumlah baris per halaman. */
    private const PER_PAGE = 10;

    public function home()
    {
        return view('home', [
            'infografisList' => $this->ambilInfografis(),
            'dataIndikator'  => $this->ambilIndikator(),
        ]);
    }

    public function index(Request $request)
    {
        $publikasi = Publikasi::query()
            ->cari($request->input('cari'))
            ->latest('tanggal_rilis')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('publikasi.katalog', compact('publikasi'));
    }

    /*
    |--------------------------------------------------------------------------
    | Area admin
    |--------------------------------------------------------------------------
    */

    public function adminIndex(Request $request)
    {
        $publikasi = Publikasi::query()
            ->cari($request->input('cari'))
            ->latest('tanggal_rilis')
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('admin.publikasi.index', compact('publikasi'));
    }

    public function create()
    {
        return view('admin.publikasi.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'         => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
            'sampul'        => 'required|file|mimes:' . self::MIMES_SAMPUL . '|max:' . self::MAX_SIZE_KB,
        ], $this->pesanValidasi());

        Publikasi::create([
            'judul'         => $data['judul'],
            'tanggal_rilis' => $data['tanggal_rilis'],
            'sampul'        => $this->simpanFile($request->file('sampul')),
        ]);

        return redirect()->route('admin.publikasi.index')
            ->with('success', 'Publikasi berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $publikasi = Publikasi::findOrFail($id);

        return view('admin.publikasi.edit', compact('publikasi'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'judul'         => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
            'sampul'        => 'nullable|file|mimes:' . self::MIMES_SAMPUL . '|max:' . self::MAX_SIZE_KB,
        ], $this->pesanValidasi());

        $publikasi = Publikasi::findOrFail($id);

        if ($request->hasFile('sampul')) {
            $this->hapusFile($publikasi->sampul);
            $publikasi->sampul = $this->simpanFile($request->file('sampul'));
        }

        $publikasi->judul = $data['judul'];
        $publikasi->tanggal_rilis = $data['tanggal_rilis'];
        $publikasi->save();

        return redirect()->route('admin.publikasi.index')
            ->with('success', 'Publikasi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $publikasi = Publikasi::findOrFail($id);

        $this->hapusFile($publikasi->sampul);
        $publikasi->delete();

        return redirect()->route('admin.publikasi.index')
            ->with('success', 'Publikasi berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | Pengambilan data dari Web API BPS
    |--------------------------------------------------------------------------
    */

    /**
     * Hasil API disimpan di cache supaya beranda tidak menembak API
     * setiap kali halaman dibuka. Tanpa ini, satu kunjungan = 6 request HTTP.
     */
    private function ambilInfografis(): array
    {
        return Cache::remember('bps.infografis', config('bps.cache_ttl'), function () {
            $url = sprintf(
                'https://webapi.bps.go.id/v1/api/list/model/infographic/lang/ind/domain/%s/key/%s/',
                config('bps.domain_infografis'),
                config('bps.key')
            );

            $data = $this->requestApi($url);

            // Struktur respons BPS: data[0] = metadata halaman, data[1] = isi
            return $data['data'][1] ?? [];
        });
    }

    private function ambilIndikator(): array
    {
        return Cache::remember('bps.indikator', config('bps.cache_ttl'), function () {
            $hasil = [];

            foreach (config('bps.indikator') as $item) {
                $url = sprintf(
                    'https://webapi.bps.go.id/v1/api/list/model/data/lang/ind/domain/%s/var/%s/th/%s/key/%s/',
                    config('bps.domain_indikator'),
                    $item['var'],
                    config('bps.tahun'),
                    config('bps.key')
                );

                $data = $this->requestApi($url);

                $nilai = isset($data['datacontent']) && is_array($data['datacontent'])
                    ? reset($data['datacontent'])
                    : '...';

                $hasil[] = [
                    'title'  => $item['title'],
                    'nilai'  => $nilai,
                    'unit'   => $item['unit'],
                    'period' => $item['period'],
                    'icon'   => $item['icon'],
                ];
            }

            return $hasil;
        });
    }

    private function requestApi(string $url): array
    {
        try {
            $response = Http::timeout(10);

            // Verifikasi SSL hanya dimatikan saat development di localhost.
            // Di hosting, sertifikat harus diverifikasi seperti biasa.
            if (app()->environment('local')) {
                $response = $response->withoutVerifying();
            }

            $response = $response->get($url);

            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();

            return (isset($data['status']) && $data['status'] === 'OK') ? $data : [];
        } catch (\Throwable $e) {
            report($e); // tercatat di storage/logs/laravel.log

            return [];
        }
    }

    private function simpanFile(UploadedFile $file): string
    {
        $namaFile = time() . '_' . Str::random(10) . '.' . $file->extension();

        $file->move(public_path('images'), $namaFile);

        return $namaFile;
    }

    private function hapusFile(?string $namaFile): void
    {
        if (!$namaFile) {
            return;
        }

        // basename() mencegah path traversal kalau isi kolom pernah dimanipulasi
        $path = public_path('images/' . basename($namaFile));

        if (is_file($path)) {
            unlink($path);
        }
    }

    private function pesanValidasi(): array
    {
        return [
            'judul.required'         => 'Judul publikasi wajib diisi.',
            'tanggal_rilis.required' => 'Tanggal rilis wajib diisi.',
            'sampul.required'        => 'File publikasi wajib diunggah.',
            'sampul.mimes'           => 'File harus berformat JPG, JPEG, PNG, WEBP, atau PDF.',
            'sampul.max'             => 'Ukuran file maksimal 5 MB.',
        ];
    }
}
<?php
return [

    // API key dari https://webapi.bps.go.id
    'key' => env('BPS_API_KEY'),

    // Kode domain wilayah. 3200 = Jawa Barat, 0000 = Nasional
    'domain_infografis' => env('BPS_DOMAIN_INFOGRAFIS', '3200'),
    'domain_indikator'  => env('BPS_DOMAIN_INDIKATOR', '0000'),

    // Kode tahun pada Web API BPS
    'tahun' => env('BPS_TAHUN', '126'),

    // Lama hasil API disimpan di cache, dalam detik (3600 = 1 jam)
    'cache_ttl' => (int) env('BPS_CACHE_TTL', 3600),

    'indikator' => [
        ['title' => 'Inflasi Year on Year',         'var' => '2263', 'icon' => '📈', 'unit' => 'Persen', 'period' => 'Terbaru'],
        ['title' => 'Inflasi Month to Month',       'var' => '2262', 'icon' => '📉', 'unit' => 'Persen', 'period' => 'Terbaru'],
        ['title' => 'Pertumbuhan Ekonomi',          'var' => '104',  'icon' => '📊', 'unit' => 'Persen', 'period' => 'Terbaru'],
        ['title' => 'Persentase Penduduk Miskin',   'var' => '192',  'icon' => '👥', 'unit' => 'Persen', 'period' => 'Terbaru'],
        ['title' => 'Tingkat Pengangguran Terbuka', 'var' => '543',  'icon' => '💼', 'unit' => 'Persen', 'period' => 'Terbaru'],
    ],

];
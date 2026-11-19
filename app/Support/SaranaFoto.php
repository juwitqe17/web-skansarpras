<?php

namespace App\Support;

/**
 * Menentukan URL gambar sebuah sarana.
 *
 * 1. Pakai foto sarana kalau file-nya benar-benar ada.
 * 2. Kalau tidak ada, pakai gambar bawaan sesuai jenis barang (dibaca dari nama sarana).
 *
 * Gambar bawaan ada di public/images/sarana/*.svg
 */
class SaranaFoto
{
    private const JENIS = [
        'laptop'    => '/laptop|macbook|notebook|chromebook/',
        'mouse'     => '/mouse/',
        'headphone' => '/headphone|headset|earphone|earbud/',
        'mikrofon'  => '/mikrofon|microphone|\bmic\b/',
        'proyektor' => '/proyektor|projector|infocus/',
        'kamera'    => '/kamera|camera|dslr/',
        'wajan'     => '/wajan|panci|kompor|penggorengan|alat masak|spatula/',
        'cangkul'   => '/cangkul|pacul|sekop|arit|garpu tanah/',
        'helm'      => '/helm|topi keselamatan|safety/',
        'katelpak'  => '/katelpak|katelpack|wearpack|wear pack|coverall|overall|baju kerja/',
    ];

    public static function url($sarana): string
    {
        $gambar = data_get($sarana, 'gambar') ?? data_get($sarana, 'foto');

        if ($gambar) {
            if (preg_match('#^(https?:)?//#', $gambar)) {
                return $gambar;
            }

            $path = ltrim($gambar, '/');

            if (file_exists(public_path('storage/' . $path))) {
                return asset('storage/' . $path);
            }
            if (file_exists(public_path($path))) {
                return asset($path);
            }
        }

        $nama = data_get($sarana, 'nama_sarana') ?? data_get($sarana, 'nama');

        return asset('images/sarana/' . self::jenis($nama) . '.svg');
    }

    public static function jenis(?string $nama): string
    {
        $nama = strtolower((string) $nama);

        foreach (self::JENIS as $jenis => $pola) {
            if (preg_match($pola, $nama)) {
                return $jenis;
            }
        }

        return 'generik';
    }
}
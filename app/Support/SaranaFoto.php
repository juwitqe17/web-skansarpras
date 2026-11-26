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
        'helm-las'  => '/helm las|topi las|mesin las|las listrik|welding/',
        'helm'      => '/helm|topi keselamatan|safety/',
        'katelpak'  => '/katelpak|katelpack|wearpack|wear pack|coverall|overall|baju kerja/',
        'robot'     => '/robot|\bplc\b|arduino|mekatronika/',
        'router'    => '/router|switch|modem|access point|kabel lan|crimping|\butp\b|mikrotik/',
        'jangka-sorong' => '/jangka sorong|mikrometer|caliper|bubut|frais/',
        'kunci'     => '/kunci|obeng|\btang\b|toolbox|toolkit/',
        'spray'     => '/spray|kompresor|\bcat\b|dempul|amplas/',
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
        $jenis = self::jenis($nama);

        // Foto sendiri per jenis (mis. public/images/sarana/laptop.png) menggantikan ilustrasi bawaan
        foreach (['png', 'webp', 'jpg', 'jpeg'] as $ext) {
            if (file_exists(public_path("images/sarana/{$jenis}.{$ext}"))) {
                return asset("images/sarana/{$jenis}.{$ext}");
            }
        }

        return asset("images/sarana/{$jenis}.svg");
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
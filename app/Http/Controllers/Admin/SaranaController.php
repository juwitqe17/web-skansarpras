<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Sarana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SaranaController extends Controller
{
    public function index(Request $request)
    {
        $jurusans = Jurusan::all();
        $selectedJurusan = null;
        $items = collect();
        $stats = [
            'total' => 0,
            'available' => 0,
            'maintenance' => 0,
            'available_percentage' => 0
        ];

        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $selectedJurusan = Jurusan::find($request->jurusan_id);

            if ($selectedJurusan) {
                $query = Sarana::where('jurusan_id', $selectedJurusan->id);

                // Filter Pencarian
                if ($request->filled('search')) {
                    $query->where(function($q) use ($request) {
                        $q->where('nama_sarana', 'like', '%' . $request->search . '%')
                          ->orWhere('kode_sarana', 'like', '%' . $request->search . '%');
                    });
                }

                // Filter Kondisi
                if ($request->filled('kondisi')) {
                    $query->where('kondisi', $request->kondisi);
                }

                // Filter Status
                if ($request->filled('status')) {
                    $query->where('status', $request->status);
                }

                // Hitung Statistik
                $stats['total'] = (clone $query)->sum('jumlah');
                $stats['available'] = (clone $query)->sum('jumlah_tersedia');
                $stats['maintenance'] = (clone $query)->where('kondisi', '!=', 'baik')->sum('jumlah');
                $stats['available_percentage'] = $stats['total'] > 0 ? round(($stats['available'] / $stats['total']) * 100) : 0;

                $items = $query->paginate(10)->withQueryString();
            }
        }

        return view('admin.sarana.index', compact('jurusans', 'selectedJurusan', 'items', 'stats'));
    }

    /**
     * Halaman Form Buat Sarana Baru (Sesuai Screenshot UI)
     */
    public function create(Request $request)
    {
        $jurusanId = $request->query('jurusan_id');
        $selectedJurusan = Jurusan::find($jurusanId);

        if (!$selectedJurusan) {
            return redirect()->route('admin.sarana.index')
                ->with('error', 'Pilih jurusan terlebih dahulu sebelum menambahkan sarana.');
        }

        return view('admin.sarana.create', compact('selectedJurusan'));
    }

    /**
     * Simpan Data Sarana Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'nama_sarana' => 'required|string|max:255',
            'kode_sarana' => 'required|string|max:100|unique:saranas,kode_sarana',
            'jumlah' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'status' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handling Upload Gambar
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('sarana', 'public');
        }

        // Set jumlah_tersedia secara awal sama dengan jumlah total
        $validated['jumlah_tersedia'] = $validated['jumlah'];

        Sarana::create($validated);

        return redirect()->route('admin.sarana.index', ['jurusan_id' => $validated['jurusan_id']])
            ->with('success', 'Data sarana berhasil ditambahkan!');
    }

    /**
     * Halaman Edit Sarana
     */
    public function edit(Sarana $sarana)
    {
        $selectedJurusan = $sarana->jurusan;
        return view('admin.sarana.edit', compact('sarana', 'selectedJurusan'));
    }

    /**
     * Update Data Sarana
     */
    public function update(Request $request, Sarana $sarana)
    {
        $validated = $request->validate([
            'nama_sarana' => 'required|string|max:255',
            'kode_sarana' => 'required|string|max:100|unique:saranas,kode_sarana,' . $sarana->id,
            'jumlah' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kondisi' => 'required|in:baik,rusak_ringan,rusak_berat',
            'status' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Handling Update Gambar
        if ($request->hasFile('gambar')) {
            if ($sarana->gambar && Storage::disk('public')->exists($sarana->gambar)) {
                Storage::disk('public')->delete($sarana->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('sarana', 'public');
        }

        // Menyesuaikan jumlah_tersedia jika jumlah total diubah
        $selisihJumlah = $validated['jumlah'] - $sarana->jumlah;
        $validated['jumlah_tersedia'] = max(0, $sarana->jumlah_tersedia + $selisihJumlah);

        $sarana->update($validated);

        return redirect()->route('admin.sarana.index', ['jurusan_id' => $sarana->jurusan_id])
            ->with('success', 'Data sarana berhasil diperbarui!');
    }

    /**
     * Hapus Data Sarana
     */
    public function destroy(Sarana $sarana)
    {
        if ($sarana->gambar && Storage::disk('public')->exists($sarana->gambar)) {
            Storage::disk('public')->delete($sarana->gambar);
        }

        $sarana->delete();

        return redirect()->back()->with('success', 'Data sarana berhasil dihapus!');
    }

    /**
     * Export Data Sarana ke CSV
     */
    public function export(Request $request)
    {
        $filename = 'data-sarana-' . date('Y-m-d') . '.csv';

        $query = Sarana::with('jurusan');
        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        $saranas = $query->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($saranas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Kode Sarana', 'Nama Sarana', 'Jurusan', 'Jumlah', 'Tersedia', 'Kondisi', 'Status', 'Lokasi']);

            foreach ($saranas as $index => $item) {
                fputcsv($file, [
                    $index + 1,
                    $item->kode_sarana,
                    $item->nama_sarana,
                    $item->jurusan->nama_jurusan ?? '-',
                    $item->jumlah,
                    $item->jumlah_tersedia,
                    ucfirst(str_replace('_', ' ', $item->kondisi)),
                    ucfirst($item->status),
                    $item->lokasi
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    /**
     * Unduh Template CSV untuk Impor Sarana
     */
    public function downloadTemplate()
    {
        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=template-impor-sarana.csv",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header kolom wajib
            fputcsv($file, ['kode_sarana', 'nama_sarana', 'jumlah', 'kondisi', 'status', 'lokasi', 'deskripsi']);
            // Contoh baris data
            fputcsv($file, ['RPL-NET-001', 'Laptop Axioo Hype 5', '15', 'baik', 'tersedia', 'Lab Komputer RPL 1', 'Core i5 Gen 12, RAM 16GB, SSD 512GB']);
            fputcsv($file, ['RPL-PRJ-002', 'Proyektor Epson EB-X500', '3', 'rusak_ringan', 'tersedia', 'Ruang Toolman RPL', 'Kabel VGA agak longgar']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Proses Impor Data Sarana dari File CSV/Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'file_excel' => 'required|file|mimes:csv,txt|max:2048',
        ], [
            'file_excel.mimes' => 'Format file harus berupa .csv (Save As CSV dari Excel).'
        ]);

        $file = $request->file('file_excel');
        $handle = fopen($file->getRealPath(), 'r');

        // Deteksi delimiter koma (,) atau titik koma (;) dari Excel
        $firstLine = fgets($handle);
        $delimiter = str_contains($firstLine, ';') ? ';' : ',';
        rewind($handle);

        // Lewati baris header
        fgetcsv($handle, 1000, $delimiter);

        $importedCount = 0;
        $skippedCount = 0;

        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            if (count($row) < 2 || empty(trim($row[0])) || empty(trim($row[1]))) {
                continue;
            }

            $kodeSarana = trim($row[0]);
            $namaSarana = trim($row[1]);
            $jumlah     = !empty($row[2]) && is_numeric(trim($row[2])) ? (int) trim($row[2]) : 1;
            
            $rawKondisi = !empty($row[3]) ? strtolower(trim($row[3])) : 'baik';
            $kondisi    = in_array($rawKondisi, ['baik', 'rusak_ringan', 'rusak_berat']) ? $rawKondisi : 'baik';

            $rawStatus  = !empty($row[4]) ? strtolower(trim($row[4])) : 'tersedia';
            $status     = in_array($rawStatus, ['tersedia', 'tidak_tersedia', 'dipinjam']) ? $rawStatus : 'tersedia';

            $lokasi     = !empty($row[5]) ? trim($row[5]) : '-';
            $deskripsi  = !empty($row[6]) ? trim($row[6]) : null;

            // Lewati jika kode_sarana sudah terdaftar di database
            if (Sarana::where('kode_sarana', $kodeSarana)->exists()) {
                $skippedCount++;
                continue;
            }

            Sarana::create([
                'jurusan_id'      => $request->jurusan_id,
                'kode_sarana'     => $kodeSarana,
                'nama_sarana'     => $namaSarana,
                'jumlah'          => $jumlah,
                'jumlah_tersedia' => $jumlah,
                'kondisi'         => $kondisi,
                'status'          => $status,
                'lokasi'          => $lokasi,
                'deskripsi'       => $deskripsi,
            ]);

            $importedCount++;
        }

        fclose($handle);

        $message = "Berhasil mengimpor {$importedCount} data sarana.";
        if ($skippedCount > 0) {
            $message .= " ({$skippedCount} data dilewati karena kode unit sudah ada).";
        }

        return redirect()->route('admin.sarana.index', ['jurusan_id' => $request->jurusan_id])
            ->with('success', $message);
    }
}
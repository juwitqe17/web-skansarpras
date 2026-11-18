<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Sarana;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JurusanController extends Controller
{
    /**
     * Menampilkan daftar jurusan.
     */
    public function index(Request $request)
    {
        // Ringkasan data statistik
        $totalJurusan = Jurusan::count();
        $akumulasiUnit = Sarana::sum('jumlah');
        $sedangDipinjam = Peminjaman::where('status', 'dipinjam')->count();

        // Gunakan relasi 'sarana' (sesuai nama method di Model Jurusan.php)
        $query = Jurusan::withCount('sarana')
            ->withSum('sarana', 'jumlah');

        // Pencarian
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_jurusan', 'like', "%{$search}%")
                    ->orWhere('kode_jurusan', 'like', "%{$search}%")
                    ->orWhere('kompetensi_keahlian', 'like', "%{$search}%");
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jurusans = $query
            ->orderBy('nama_jurusan')
            ->paginate(10)
            ->withQueryString();

        return view('admin.jurusan.index', compact(
            'jurusans', 
            'totalJurusan', 
            'akumulasiUnit', 
            'sedangDipinjam'
        ));
    }

    /**
     * Form tambah jurusan.
     */
    public function create()
    {
        return view('admin.jurusan.create');
    }

    /**
     * Simpan jurusan baru.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama_jurusan' => 'required|string|max:255',
            'kode_jurusan' => 'required|string|max:50|unique:jurusans,kode_jurusan',
            'deskripsi'    => 'nullable|string',
            'status'       => 'required|in:aktif,tidak_aktif',
        ]);

        // Simpan ke database
        Jurusan::create([
            'nama_jurusan' => $request->nama_jurusan,
            'kode_jurusan' => $request->kode_jurusan,
            'deskripsi'    => $request->deskripsi,
            'status'       => $request->status,
        ]);

        // Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('admin.jurusan.index')->with('success', 'Data departemen/jurusan berhasil ditambahkan.');
    }

    /**
     * Form edit jurusan.
     */
    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    /**
     * Update jurusan.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate([
            'nama_jurusan'        => 'required|string|max:255',
            'kode_jurusan'        => 'required|string|max:50|unique:jurusans,kode_jurusan,' . $jurusan->id,
            'kompetensi_keahlian' => 'nullable|string|max:255',
            'status'              => 'required|in:aktif,tidak_aktif',
            'deskripsi'           => 'nullable|string',
            'gambar'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($jurusan->gambar && Storage::disk('public')->exists($jurusan->gambar)) {
                Storage::disk('public')->delete($jurusan->gambar);
            }

            $validated['gambar'] = $request->file('gambar')->store('jurusan', 'public');
        }

        $jurusan->update($validated);

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    /**
     * Hapus jurusan.
     */
    public function destroy(Jurusan $jurusan)
    {
        // Cegah penghapusan jika masih memiliki sarana
        if ($jurusan->sarana()->exists()) {
            return redirect()->back()->with('error', 'Jurusan tidak dapat dihapus karena masih memiliki data sarana.');
        }

        // Cegah penghapusan jika masih memiliki user
        if ($jurusan->users()->exists()) {
            return redirect()->back()->with('error', 'Jurusan tidak dapat dihapus karena masih memiliki pengguna.');
        }

        if ($jurusan->gambar && Storage::disk('public')->exists($jurusan->gambar)) {
            Storage::disk('public')->delete($jurusan->gambar);
        }

        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
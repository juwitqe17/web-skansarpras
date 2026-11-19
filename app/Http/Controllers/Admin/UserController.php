<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $jurusans = Jurusan::all();
        $selectedJurusan = null;
        $users = collect();
        $stats = [
            'total' => 0,
            'peminjam' => 0,
            'admin' => 0,
        ];

        if ($request->filled('jurusan_id')) {
            $selectedJurusan = Jurusan::find($request->jurusan_id);

            if ($selectedJurusan) {
                $query = User::where('jurusan_id', $selectedJurusan->id);

                // Hitung statistik sebelum filter search/role diterapkan
                $stats['total'] = (clone $query)->count();
                $stats['peminjam'] = (clone $query)->where('role', 'peminjam')->count();
                $stats['admin'] = (clone $query)->where('role', 'admin')->count();

                // Filter Pencarian (Nama, Email, atau Kelas)
                if ($request->filled('search')) {
                    $query->where(function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%')
                          ->orWhere('email', 'like', '%' . $request->search . '%')
                          ->orWhere('kelas', 'like', '%' . $request->search . '%');
                    });
                }

                // Filter Role
                if ($request->filled('role')) {
                    $query->where('role', $request->role);
                }

                $users = $query->latest()->paginate(10)->withQueryString();
            }
        }

        return view('admin.user.index', compact('jurusans', 'selectedJurusan', 'users', 'stats'));
    }

    public function create(Request $request)
    {
        $selectedJurusan = Jurusan::find($request->query('jurusan_id'));

        if (!$selectedJurusan) {
            return redirect()->route('admin.user.index')
                ->with('error', 'Pilih jurusan terlebih dahulu sebelum menambahkan user.');
        }

        return view('admin.user.create', compact('selectedJurusan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,peminjam',
            'kelas' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
        ]);

        // Password otomatis di-hash oleh cast 'hashed' di User.php
        User::create($validated);

        return redirect()->route('admin.user.index', ['jurusan_id' => $validated['jurusan_id']])
            ->with('success', 'user baru berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        $selectedJurusan = $user->jurusan;
        $jurusans = Jurusan::all();

        return view('admin.user.edit', compact('user', 'selectedJurusan', 'jurusans'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'jurusan_id' => 'required|exists:jurusans,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,peminjam',
            'kelas' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
        ]);

        // Hapus key password jika kosong agar password lama tidak tertimpa null
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.user.index', ['jurusan_id' => $validated['jurusan_id']])
            ->with('success', 'Data user berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        // Cegah admin menghapus akunnya sendiri yang sedang login
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Data user berhasil dihapus!');
    }

    /**
     * Ekspor Data Pengguna per Jurusan ke CSV (Bisa dibuka di Excel)
     */
    public function export(Request $request)
    {
        $jurusan = Jurusan::findOrFail($request->jurusan_id);
        $users = User::where('jurusan_id', $jurusan->id)->get();

        $filename = 'data-pengguna-' . strtolower($jurusan->kode_jurusan) . '-' . date('Y-m-d') . '.csv';

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($users, $jurusan) {
            $file = fopen('php://output', 'w');
            // Tambahkan BOM agar Excel membaca karakter UTF-8 dengan benar
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, ['No', 'Nama Lengkap', 'Email', 'Role', 'Kelas', 'No HP', 'Jurusan']);

            foreach ($users as $index => $user) {
                fputcsv($file, [
                    $index + 1,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->kelas ?? '-',
                    $user->no_hp ?? '-',
                    $jurusan->kode_jurusan,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Unduh Template CSV untuk Impor Pengguna
     */
    public function downloadTemplate()
    {
        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=template-impor-pengguna.csv",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Header kolom wajib
            fputcsv($file, ['nama', 'email', 'password', 'role', 'kelas', 'no_hp']);
            // Contoh baris data
            fputcsv($file, ['Budi Santoso', 'budi.rpl@smkn1purwosari.sch.id', 'rahasia123', 'peminjam', 'XI RPL 1', '081234567890']);
            fputcsv($file, ['Siti Aminah', 'siti.admin@smkn1purwosari.sch.id', 'admin123', 'admin', '', '089876543210']);
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Proses Impor Data Pengguna dari File CSV/Excel
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

        // Deteksi pemisah (koma ',' atau titik koma ';' tergantung setting regional Excel)
        $firstLine = fgets($handle);
        $delimiter = str_contains($firstLine, ';') ? ';' : ',';
        rewind($handle);

        // Lewati baris pertama (Header)
        fgetcsv($handle, 1000, $delimiter);

        $importedCount = 0;
        $skippedCount = 0;

        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
            // Pastikan minimal ada nama dan email
            if (count($row) < 2 || empty(trim($row[0])) || empty(trim($row[1]))) {
                continue;
            }

            $nama     = trim($row[0]);
            $email    = trim($row[1]);
            $password = !empty($row[2]) ? trim($row[2]) : 'password123'; // Default password jika kosong
            $role     = (!empty($row[3]) && in_array(strtolower(trim($row[3])), ['admin', 'peminjam'])) 
                        ? strtolower(trim($row[3])) 
                        : 'peminjam';
            $kelas    = !empty($row[4]) ? trim($row[4]) : null;
            $noHp     = !empty($row[5]) ? trim($row[5]) : null;

            // Cek apakah email sudah terdaftar agar tidak error duplicate
            if (User::where('email', $email)->exists()) {
                $skippedCount++;
                continue;
            }

            User::create([
                'jurusan_id' => $request->jurusan_id,
                'name'       => $nama,
                'email'      => $email,
                'password'   => $password, // Otomatis di-hash oleh cast User.php
                'role'       => $role,
                'kelas'      => $kelas,
                'no_hp'      => $noHp,
            ]);

            $importedCount++;
        }

        fclose($handle);

        $message = "Berhasil mengimpor {$importedCount} akun pengguna.";
        if ($skippedCount > 0) {
            $message .= " ({$skippedCount} data dilewati karena email sudah terdaftar).";
        }

        return redirect()->route('admin.user.index', ['jurusan_id' => $request->jurusan_id])
            ->with('success', $message);
    }
}
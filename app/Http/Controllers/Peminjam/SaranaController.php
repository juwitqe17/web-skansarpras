<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Sarana;
use Illuminate\Http\Request;

class SaranaController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Sarana::where('jurusan_id', $user->jurusan_id);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_sarana', 'like', "%{$search}%")
                    ->orWhere('kode_sarana', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $saranas = $query
            ->orderBy('nama_sarana')
            ->paginate(10)
            ->withQueryString();

        return view('peminjam.sarana.index', compact('saranas'));
    }

    public function show(Sarana $sarana)
    {
        // Jangan sampai user membuka sarana dari jurusan lain
        abort_unless(
            $sarana->jurusan_id === auth()->user()->jurusan_id,
            403
        );

        return view('peminjam.sarana.show', compact('sarana'));
    }
}

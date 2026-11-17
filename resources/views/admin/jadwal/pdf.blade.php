<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Jadwal Penggunaan Sarana Prasarana</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #0f2e24;
            padding-bottom: 15px;
        }
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            color: #0f2e24;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .header p {
            font-size: 11px;
            color: #666;
            margin: 0;
        }
        .meta-info {
            margin-bottom: 20px;
            font-size: 11px;
        }
        .meta-info table {
            width: 100%;
            border: none;
        }
        .meta-info td {
            padding: 2px 0;
            border: none;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }
        table.data-table th {
            background-color: #0f2e24;
            color: #ffffff;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 4px;
        }
        .badge-berlangsung {
            background-color: #e6f4ea;
            color: #137333;
        }
        .badge-selesai {
            background-color: #f1f3f4;
            color: #5f6368;
        }
        .badge-terjadwal {
            background-color: #e8f0fe;
            color: #1a73e8;
        }
        .footer {
            width: 100%;
            margin-top: 50px;
            page-break-inside: avoid;
        }
        .signature-section {
            float: right;
            text-align: center;
            width: 200px;
            font-size: 11px;
        }
        .signature-space {
            height: 60px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    {{-- KOP LAPORAN --}}
    <div class="header">
        <h1>Laporan Jadwal Penggunaan Sarana & Prasarana</h1>
        <p>SMK Negeri 1 Purwosari • Periode: {{ $bulan->translatedFormat('F Y') }}</p>
    </div>

    {{-- INFORMASI FILTER AKTIF --}}
    <div class="meta-info">
        <table>
            <tr>
                <td style="width: 15%;"><strong>Dicetak Pada:</strong></td>
                <td>{{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i') }} WIB</td>
                <td style="width: 15%; text-align: right;"><strong>Status:</strong></td>
                <td style="width: 20%;">{{ $selectedStatus ? ucfirst($selectedStatus) : 'Semua Status' }}</td>
            </tr>
            <tr>
                <td><strong>Filter Jurusan:</strong></td>
                <td>
                    @if($selectedJurusan)
                        {{ optional($jurusans->firstWhere('id', $selectedJurusan))->nama_jurusan ?? 'Pilihan Jurusan' }}
                    @else
                        Semua Jurusan
                    @endif
                </td>
                <td style="text-align: right;"><strong>Pencarian:</strong></td>
                <td>{{ $search ?: '-' }}</td>
            </tr>
        </table>
    </div>

    {{-- TABEL DATA JADWAL --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 15%;">Waktu</th>
                <th style="width: 22%;">Sarana / Ruangan</th>
                <th style="width: 18%;">Peminjam</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 10%; text-align: center;">Keperluan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($jadwals as $index => $jadwal)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->translatedFormat('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}</td>
                    <td>
                        <strong>{{ $jadwal->sarana->nama_sarana ?? '-' }}</strong><br>
                        <span style="font-size: 10px; color: #666;">{{ $jadwal->sarana->kode_sarana ?? '' }}</span>
                    </td>
                    <td>{{ $jadwal->peminjaman->user->name ?? '-' }}</td>
                    <td>
                        @php
                            $status = $jadwal->status;
                        @endphp
                        <span class="badge {{ $status === 'berlangsung' ? 'badge-berlangsung' : ($status === 'selesai' ? 'badge-selesai' : 'badge-terjadwal') }}">
                            {{ ucfirst($status) }}
                        </span>
                    </td>
                    <td style="font-size: 10px;">{{ $jadwal->peminjaman->keperluan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #777; padding: 20px;">
                        Tidak ada data jadwal pada periode atau filter yang dipilih.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TANDA TANGAN ADMIN / PETUGAS --}}
    <div class="footer">
        <div class="signature-section">
            <p>Pasuruan, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
            <p>Penanggung Jawab Sarpras,</p>
            <div class="signature-space"></div>
            <p class="signature-name">Administrator Sarpras</p>
            <p style="font-size: 9px; color: #666; margin-top: 2px;">SMK Negeri 1 Purwosari</p>
        </div>
    </div>

</body>
</html>

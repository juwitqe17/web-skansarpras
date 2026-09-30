@extends('layouts.admin')

@section('page-content')
<div class="space-y-6 text-gray-800">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Dasbor Admin</h1>
        <p class="mt-1 text-sm text-gray-500">Ringkasan pengajuan serta peminjaman sarana.</p>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
        <!-- Card 1: Total Sarana -->
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between relative overflow-hidden">
            <div class="absolute left-0 top-0 bottom-0 w-2 bg-[#0F392B]"></div>
            <div class="pl-2">
                <div class="flex items-center space-x-2 text-gray-600 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Total Sarana</span>
                </div>
                <div class="flex items-baseline space-x-2">
                    <span class="text-3xl font-bold text-gray-900">1.240</span>
                    <span class="text-xs text-gray-500">unit</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Sarana Tersedia -->
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-2 text-gray-600 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Sarana Tersedia</span>
                </div>
                <div class="flex items-baseline space-x-2">
                    <span class="text-3xl font-bold text-gray-900">230</span>
                    <span class="text-xs text-gray-500">unit</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Sedang Dipinjam -->
        <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-2 text-gray-600 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">Sedang Dipinjam</span>
                </div>
                <div class="flex items-baseline space-x-2">
                    <span class="text-3xl font-bold text-gray-900">1.010</span>
                    <span class="text-xs text-gray-500">unit</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Pengajuan (Dark Highlight) -->
        <div class="bg-[#0A261D] text-white p-5 rounded-xl shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center space-x-2 mb-3 text-emerald-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-xs font-medium leading-tight">Pengajuan<br><span class="text-gray-300 font-normal">(Menunggu Persetujuan)</span></span>
                </div>
                <div class="flex items-baseline space-x-2 my-1">
                    <span class="text-3xl font-bold">34</span>
                    <span class="text-xs text-emerald-200">pengajuan</span>
                </div>
            </div>
            <div class="text-right mt-2">
                <a href="#" class="text-xs text-emerald-200 hover:text-white flex items-center justify-end space-x-1 transition-colors">
                    <span>Lihat antrean</span>
                    <span>&gt;</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Content Layout (Chart + Sidebar Widgets) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Section: Chart -->
        <div class="lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <h2 class="text-center text-base font-semibold text-gray-900 mb-6">Tren Peminjaman & Ketersediaan Sarana dan Prasarana</h2>
            
            <div class="relative h-72 w-full">
                <canvas id="sarprasChart"></canvas>
            </div>
        </div>

        <!-- Right Section: Info Widgets -->
        <div class="space-y-4">
            
            <!-- Tenggat Pengembalian -->
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm space-y-3">
                <div class="flex items-center space-x-2 text-gray-700 font-semibold text-xs border-b pb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Tenggat Pengembalian</span>
                </div>
                
                <!-- Item Overdue -->
                <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-100 text-xs space-y-1">
                    <div class="flex items-center space-x-2">
                        <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded">Overdue</span>
                        <span class="font-bold text-gray-800">Proyektor Epson EB-X400</span>
                    </div>
                    <p class="text-gray-500 text-[11px]"><span class="font-medium text-gray-700">Peminjam :</span> Budi (XII-RPL1)</p>
                    <p class="text-gray-500 text-[11px]"><span class="font-medium text-gray-700">Status :</span> Terlambat 1 Hari</p>
                </div>

                <!-- Item Hari ini -->
                <div class="p-2.5 bg-gray-50 rounded-lg border border-gray-100 text-xs space-y-1">
                    <div class="flex items-center space-x-2">
                        <span class="bg-yellow-400 text-gray-900 text-[10px] font-bold px-1.5 py-0.5 rounded">Hari ini</span>
                        <span class="font-bold text-gray-800">Laptop ASUS ROG</span>
                    </div>
                    <p class="text-gray-500 text-[11px]"><span class="font-medium text-gray-700">Peminjam :</span> Aris (XI-RPL1)</p>
                    <p class="text-gray-500 text-[11px]"><span class="font-medium text-gray-700">Tenggat :</span> 15.00 WIB</p>
                </div>
            </div>

            <!-- Aktivitas Terbaru -->
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm space-y-3">
                <div class="flex items-center space-x-2 text-gray-700 font-semibold text-xs border-b pb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Aktivitas Terbaru</span>
                </div>

                <div class="space-y-3 text-xs pl-2 relative border-l-2 border-gray-200 ml-1">
                    <div class="relative pl-3">
                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full absolute -left-[18px] top-1"></span>
                        <p class="text-gray-700"><span class="font-bold">[10.15] Anto (RPL)</span> mengembalikan 1 Proyektor Epson</p>
                    </div>
                    <div class="relative pl-3">
                        <span class="w-2.5 h-2.5 bg-yellow-400 rounded-full absolute -left-[18px] top-1"></span>
                        <p class="text-gray-700"><span class="font-bold">[09.30] Bu Siti (AP)</span> mengajukan 2 Tenda Kegiatan</p>
                    </div>
                    <div class="relative pl-3">
                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full absolute -left-[18px] top-1"></span>
                        <p class="text-gray-700"><span class="font-bold">[08.00] Admin</span> menyetujui Sound System</p>
                    </div>
                </div>
            </div>

            <!-- Kondisi Sarpras -->
            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm space-y-2">
                <div class="flex items-center space-x-2 text-gray-700 font-semibold text-xs border-b pb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Kondisi Sarpras</span>
                </div>
                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between items-center text-gray-700">
                        <span class="font-bold">Rusak :</span>
                        <span class="text-gray-600">15 barang</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-700">
                        <span class="font-bold">Perbaikan :</span>
                        <span class="text-gray-600">5 barang</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-700">
                        <span class="font-bold">Hilang :</span>
                        <span class="text-gray-600">2 barang</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Chart.js Library & Initialization Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('sarprasChart').getContext('2d');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Juni', 'Juli', 'Agustus'],
                datasets: [
                    {
                        label: 'Jumlah Peminjam',
                        data: [400, 720, 30],
                        backgroundColor: '#A2A392',
                        borderRadius: 2,
                        barPercentage: 0.5,
                        categoryPercentage: 0.6
                    },
                    {
                        label: 'Sisa Stok Tersedia',
                        data: [610, 150, 330],
                        backgroundColor: '#A2D28A',
                        borderRadius: 2,
                        barPercentage: 0.5,
                        categoryPercentage: 0.6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 10,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        max: 800,
                        ticks: {
                            stepSize: 200
                        },
                        grid: {
                            color: '#E5E7EB'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
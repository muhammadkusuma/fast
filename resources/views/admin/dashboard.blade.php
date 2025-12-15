<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <nav class="bg-blue-900 p-4 shadow-lg text-white sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl tracking-wider">ADMIN PANEL</h1>
            <div class="space-x-4 flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-400 font-semibold">Dashboard</a>
                <a href="{{ route('admin.master.alumni') }}" class="hover:text-yellow-400">Data Alumni</a>
                <a href="{{ route('admin.master.prodi') }}" class="hover:text-yellow-400">Data Prodi</a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-1 px-3 rounded ml-4">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 px-4 pb-12">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500 flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-bold uppercase">Total Alumni</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalAlumni }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500 flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-bold uppercase">Sudah Isi Tracer</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalTracer }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-indigo-500 flex items-center justify-between">
                <div>
                    <h3 class="text-gray-500 text-sm font-bold uppercase">Total Prodi</h3>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalProdi }}</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-full text-indigo-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Jumlah Alumni per Prodi</h2>
                <div class="relative h-72 w-full">
                    <canvas id="prodiChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Status Pekerjaan Alumni</h2>
                <div class="relative h-64 w-full flex justify-center">
                    <canvas id="tracerChart"></canvas>
                </div>
                <div class="mt-4 text-center">
                    <p class="text-xs text-gray-500">Berdasarkan data tracer study tahun ini</p>
                </div>
            </div>

        </div>

        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4 text-gray-700">Kelola Pengumuman</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <form action="{{ route('admin.announcement.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="block text-sm font-bold mb-1">Judul</label>
                        <input type="text" name="judul" class="border rounded w-full py-2 px-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-bold mb-1">Isi</label>
                        <textarea name="isi" rows="3" class="border rounded w-full py-2 px-3" required></textarea>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded">Posting</button>
                </form>

                <div class="overflow-y-auto h-48 border rounded p-2 bg-gray-50">
                    @foreach ($announcements as $info)
                        <div class="mb-2 p-2 bg-white border rounded shadow-sm flex justify-between items-start">
                            <div>
                                <p class="font-bold text-sm">{{ $info->judul }}</p>
                                <p class="text-xs text-gray-600">{{ Str::limit($info->isi, 40) }}</p>
                            </div>
                            <form action="{{ route('admin.announcement.delete', $info->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class="text-red-500 text-xs font-bold px-2">Hapus</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

    <script>
        // 1. Chart Prodi (Batang)
        const ctxProdi = document.getElementById('prodiChart').getContext('2d');
        new Chart(ctxProdi, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labelsProdi) !!},
                datasets: [{
                    label: 'Jumlah Alumni',
                    data: {!! json_encode($dataCountProdi) !!},
                    backgroundColor: '#3b82f6',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // 2. Chart Tracer (Pie)
        const ctxTracer = document.getElementById('tracerChart').getContext('2d');
        new Chart(ctxTracer, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($labelsTracer) !!},
                datasets: [{
                    data: {!! json_encode($dataCountTracer) !!},
                    backgroundColor: [
                        '#10b981', // Emerald (Bekerja)
                        '#f59e0b', // Amber (Wiraswasta)
                        '#3b82f6', // Blue (Kuliah)
                        '#ef4444', // Red (Tidak kerja)
                        '#6b7280', // Gray (Lainnya)
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>

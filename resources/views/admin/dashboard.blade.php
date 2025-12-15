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

    <nav class="bg-blue-800 p-4 shadow-lg text-white">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl">Admin Dashboard</h1>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">Logout</button>
            </form>
        </div>
    </nav>

    <div class="container mx-auto mt-8 px-4">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
                <h3 class="text-gray-500 text-sm uppercase font-bold">Total Alumni</h3>
                <p class="text-3xl font-bold text-gray-800">{{ $totalAlumni }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
                <h3 class="text-gray-500 text-sm uppercase font-bold">Total Program Studi</h3>
                <p class="text-3xl font-bold text-gray-800">{{ $totalProdi }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Statistik Alumni per Prodi</h2>
                <div class="relative h-64 w-full">
                    <canvas id="alumniChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4 text-gray-700">Buat Pengumuman</h2>

                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.announcement.store') }}" method="POST" class="mb-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul</label>
                        <input type="text" name="judul"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Isi Pengumuman</label>
                        <textarea name="isi" rows="3"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required></textarea>
                    </div>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded w-full">
                        Kirim Pengumuman
                    </button>
                </form>

                <hr class="mb-4">

                <h3 class="font-bold text-gray-600 mb-2">Daftar Pengumuman Aktif</h3>
                <div class="overflow-y-auto h-64">
                    @forelse($announcements as $info)
                        <div class="mb-3 p-3 bg-gray-50 border rounded relative">
                            <form action="{{ route('admin.announcement.delete', $info->id) }}" method="POST"
                                class="absolute top-2 right-2">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Hapus?')"
                                    class="text-red-500 hover:text-red-700 text-xs">x</button>
                            </form>
                            <p class="font-bold text-sm text-blue-600">{{ $info->judul }}</p>
                            <p class="text-xs text-gray-600 mb-1">{{ $info->created_at->format('d M Y') }}</p>
                            <p class="text-sm text-gray-800">{{ Str::limit($info->isi, 50) }}</p>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm text-center">Belum ada pengumuman.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('alumniChart').getContext('2d');
        const alumniChart = new Chart(ctx, {
            type: 'bar', // Bisa diganti 'pie', 'line', dll
            data: {
                labels: {!! json_encode($labels) !!}, // Data dari Controller
                datasets: [{
                    label: 'Jumlah Alumni',
                    data: {!! json_encode($dataCount) !!}, // Data dari Controller
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>

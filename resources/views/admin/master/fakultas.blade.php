<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Fakultas - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <nav class="bg-blue-900 p-4 shadow-lg text-white sticky top-0 z-50">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="font-bold text-xl tracking-wider">ADMIN PANEL</h1>
            <div class="space-x-4 flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-400">Dashboard</a>
                <a href="{{ route('admin.master.alumni') }}" class="hover:text-yellow-400">Data Alumni</a>
                <a href="{{ route('admin.master.prodi') }}" class="hover:text-yellow-400">Data Prodi</a>
                <a href="{{ route('admin.master.fakultas') }}"
                    class="hover:text-yellow-400 font-semibold text-yellow-400">Data Fakultas</a>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white text-sm font-bold py-1 px-3 rounded ml-4">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 px-4 pb-12">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden w-full md:w-3/4 mx-auto">
            <div class="p-6 bg-white border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800">Master Data Fakultas</h2>
                <button class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2 px-4 rounded shadow">
                    + Tambah Fakultas
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/12 py-3 px-4 uppercase font-semibold text-sm text-center">No</th>
                            <th class="w-2/12 py-3 px-4 uppercase font-semibold text-sm text-left">Kode</th>
                            <th class="w-9/12 py-3 px-4 uppercase font-semibold text-sm text-left">Nama Fakultas</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse($fakultas as $index => $f)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }} hover:bg-blue-50 transition">
                                <td class="py-3 px-4 text-center">{{ $index + 1 }}</td>
                                <td class="py-3 px-4 font-mono text-sm font-bold text-blue-600">{{ $f->kode_fakultas }}
                                </td>
                                <td class="py-3 px-4 font-semibold">{{ $f->nama_fakultas }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-8 text-center text-gray-500">
                                    Belum ada data Fakultas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>

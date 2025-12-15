<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Alumni</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Data Master Alumni</h1>
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Kembali ke Dashboard</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">NIM</th>
                        <th class="py-3 px-6 text-left">Nama Lengkap</th>
                        <th class="py-3 px-6 text-left">Prodi</th>
                        <th class="py-3 px-6 text-center">Tahun Lulus</th>
                        <th class="py-3 px-6 text-center">IPK</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($alumni as $mhs)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-6 text-left whitespace-nowrap font-medium">{{ $mhs->nim }}</td>
                            <td class="py-3 px-6 text-left">{{ $mhs->nama_lengkap }}</td>
                            <td class="py-3 px-6 text-left">{{ $mhs->prodi->nama_prodi ?? '-' }}</td>
                            <td class="py-3 px-6 text-center">{{ $mhs->tahun_lulus }}</td>
                            <td class="py-3 px-6 text-center">{{ $mhs->ipk ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-3 px-6 text-center">Tidak ada data alumni.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $alumni->links() }}
        </div>
    </div>
</body>

</html>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Operasional Gudang (Serah Terima & Pengembalian)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Section 1: Antrean Serah Terima (Siap Diambil) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-md mb-3 text-indigo-700 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 002 2h2a2 2 0 002-2"></path></svg>
                        1. Antrean Serah Terima Barang (Status: Disetujui Admin)
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Peminjam</th>
                                    <th class="px-4 py-3">Aset</th>
                                    <th class="px-4 py-3">Jadwal Pinjam</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siapSerah as $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">
                                            {{ $item->user->nama_lengkap }}
                                            <span class="block text-xs text-gray-400">ID: {{ $item->user->identitas }}</span>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-800">
                                            {{ $item->aset->nama_aset }}
                                            <span class="block text-xs text-gray-400">Kode: {{ $item->aset->kode_aset }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-xs">
                                            {{ $item->waktu_mulai->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('petugas.serah_terima.form', $item->id_peminjaman) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded text-xs font-semibold shadow">
                                                📷 Inspeksi & Serahkan
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-400">
                                            Tidak ada antrean barang yang siap diserahkan saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Section 2: Antrean Pengembalian (Sedang Dipinjam) -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-md mb-3 text-green-700 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        2. Antrean Pengembalian Barang (Status: Sedang Dipinjam)
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Peminjam</th>
                                    <th class="px-4 py-3">Aset</th>
                                    <th class="px-4 py-3">Batas Tenggat Kembali</th>
                                    <th class="px-4 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siapKembali as $item)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">
                                            {{ $item->user->nama_lengkap }}
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-800">
                                            {{ $item->aset->nama_aset }}
                                        </td>
                                        <td class="px-4 py-3 text-xs font-semibold {{ now()->greaterThan($item->waktu_selesai) ? 'text-red-600' : 'text-gray-700' }}">
                                            {{ $item->waktu_selesai->format('d M Y H:i') }}
                                            @if(now()->greaterThan($item->waktu_selesai))
                                                <span class="block text-xs font-bold text-red-600">(Terlambat!)</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <a href="{{ route('petugas.pengembalian.form', $item->id_peminjaman) }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded text-xs font-semibold shadow">
                                                🔍 Verifikasi Pengembalian
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-400">
                                            Tidak ada barang yang sedang dipinjam saat ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
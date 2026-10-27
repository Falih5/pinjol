<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Executive & Analitik Smart University') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Card Metric Agregat -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 border-indigo-500">
                    <span class="text-xs font-bold text-gray-400 uppercase">Tingkat Utilisasi Aset</span>
                    <p class="text-3xl font-extrabold text-indigo-600 mt-1">{{ $persentaseUtilisasi }}%</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <span class="text-xs font-bold text-gray-400 uppercase">Total Transaksi Selesai</span>
                    <p class="text-3xl font-extrabold text-gray-800 mt-1">{{ $totalPeminjaman }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 border-red-500">
                    <span class="text-xs font-bold text-gray-400 uppercase">Total Pelanggaran</span>
                    <p class="text-3xl font-extrabold text-red-600 mt-1">{{ $totalPelanggaran }} Kasus</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow-sm border-l-4 border-green-500">
                    <span class="text-xs font-bold text-gray-400 uppercase">Total Aset Terdaftar</span>
                    <p class="text-3xl font-extrabold text-green-600 mt-1">{{ $totalAsetAktif }} Aset</p>
                </div>
            </div>

            <!-- Filter Laporan -->
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <form action="{{ route('pimpinan.dashboard') }}" method="GET" class="flex flex-wrap items-center gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Filter Kategori Aset</label>
                        <select name="kategori" class="text-xs border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Kategori</option>
                            <option value="Fasilitas" {{ request('kategori') == 'Fasilitas' ? 'selected' : '' }}>Fasilitas (Ruangan)</option>
                            <option value="Barang" {{ request('kategori') == 'Barang' ? 'selected' : '' }}>Barang Inventaris</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Filter Unit Organisasi</label>
                        <input type="text" name="unit" value="{{ request('unit') }}" placeholder="S1 Sistem Informasi..." class="text-xs border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="flex items-end space-x-2 pt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-4 rounded shadow">
                            Terapkan Filter
                        </button>
                        <a href="{{ route('pimpinan.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold py-2 px-3 rounded">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabel 1: Laporan Utilisasi Aset Kampus -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-md mb-3 text-gray-800">1. Laporan Frekuensi Pemakaian (Utilisasi Aset)</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Kode Aset</th>
                                    <th class="px-4 py-3">Nama Aset / Fasilitas</th>
                                    <th class="px-4 py-3">Kategori</th>
                                    <th class="px-4 py-3">Kondisi Terkini</th>
                                    <th class="px-4 py-3 text-center">Total Pemakaian (Selesai)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($utilisasiAset as $aset)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-mono text-xs font-bold text-gray-700">{{ $aset->kode_aset }}</td>
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $aset->nama_aset }}</td>
                                        <td class="px-4 py-3">{{ $aset->kategori }}</td>
                                        <td class="px-4 py-3">
                                            @if($aset->kondisi_saat_ini == 'Baik')
                                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2 py-0.5 rounded">Baik</span>
                                            @elseif($aset->kondisi_saat_ini == 'Rusak Ringan')
                                                <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2 py-0.5 rounded">Rusak Ringan</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded">Rusak Berat</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center font-bold text-indigo-600">
                                            {{ $aset->peminjaman_count }} kali
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-center text-gray-400">Tidak ada data aset.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tabel 2: Laporan Riwayat Pelanggaran Peminjam -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-md mb-3 text-red-700">2. Laporan Rekam Jejak Pelanggaran Peminjam</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Peminjam</th>
                                    <th class="px-4 py-3">Aset Terkait</th>
                                    <th class="px-4 py-3">Jenis Pelanggaran</th>
                                    <th class="px-4 py-3">Rincian Keterangan</th>
                                    <th class="px-4 py-3">Status Sinkronisasi Keuangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($daftarPelanggaran as $p)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">
                                            {{ $p->user->nama_lengkap }}
                                            <span class="block text-xs text-gray-400">NIM/NIP: {{ $p->user->identitas }} | {{ $p->user->unit_organisasi }}</span>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-800">
                                            {{ $p->peminjaman->aset->nama_aset }}
                                        </td>
                                        <td class="px-4 py-3 font-bold text-red-600">
                                            {{ $p->jenis_pelanggaran }}
                                        </td>
                                        <td class="px-4 py-3 text-xs">{{ $p->keterangan }}</td>
                                        <td class="px-4 py-3">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded">
                                                {{ $p->status_keuangan }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-4 text-center text-gray-400">Belum ada catatan pelanggaran.</td>
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
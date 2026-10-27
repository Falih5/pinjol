<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Approval & Pengelolaan Aset (Admin Sarpras)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alert -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Metric Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-yellow-500">
                    <p class="text-sm text-gray-500 font-medium">Menunggu Persetujuan</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPengajuanMenunggu }} Tiket</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 font-medium">Total Aset Aktif</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalAsetAktif }} Unit</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <p class="text-sm text-gray-500 font-medium">Aset Sedang Dipinjam</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalAsetDipinjam }} Unit</p>
                </div>
            </div>

            <!-- Tabel Antrean Approval SLA -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-md mb-4 text-gray-700">Daftar Pengajuan Masuk (Membutuhkan Otorisasi)</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Peminjam</th>
                                    <th class="px-4 py-3">Aset / Fasilitas</th>
                                    <th class="px-4 py-3">Jadwal Pinjam</th>
                                    <th class="px-4 py-3">Tujuan</th>
                                    <th class="px-4 py-3">Sisa Waktu SLA</th>
                                    <th class="px-4 py-3 text-center">Aksi Otorisasi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuanMasuk as $item)
                                    @php
                                        // Hitung Sisa Waktu SLA 24 Jam
                                        $sisaSla = now()->diff($item->batas_sla_admin);
                                        $isTerlewat = now()->greaterThan($item->batas_sla_admin);
                                    @endphp
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium text-gray-900">
                                            {{ $item->user->nama_lengkap }}
                                            <span class="block text-xs text-gray-400">ID: {{ $item->user->identitas }} | {{ $item->user->unit_organisasi }}</span>
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-800">
                                            {{ $item->aset->nama_aset }}
                                            <span class="block text-xs text-gray-400">Kode: {{ $item->aset->kode_aset }}</span>
                                        </td>
                                        <td class="px-4 py-3 text-xs">
                                            {{ $item->waktu_mulai->format('d M Y H:i') }} <br>
                                            s.d. {{ $item->waktu_selesai->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-4 py-3">{{ $item->tujuan_penggunaan }}</td>
                                        <td class="px-4 py-3">
                                            @if($isTerlewat)
                                                <span class="text-xs font-bold text-white bg-red-600 px-2 py-1 rounded">SLA Terlewat!</span>
                                            @else
                                                <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded">
                                                    {{ $sisaSla->h }} Jam {{ $sisaSla->i }} Menit
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <!-- Form Approve -->
                                                <form action="{{ route('admin.pengajuan.approve', $item->id_peminjaman) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-semibold shadow">
                                                        Approve
                                                    </button>
                                                </form>

                                                <!-- Form Reject -->
                                                <form action="{{ route('admin.pengajuan.reject', $item->id_peminjaman) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold shadow" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                                            Tidak ada antrean pengajuan yang membutuhkan persetujuan saat ini.
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
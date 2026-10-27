<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Peminjam') }}
            </h2>
            <a href="{{ route('peminjam.pengajuan.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm shadow">
                + Cari & Ajukan Peminjaman
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Flash Alert -->
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
            @endif

            <!-- Informasi Profile Peminjam -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Selamat datang, {{ Auth::user()->nama_lengkap }}!</h3>
                    <p class="text-sm text-gray-500">Identitas (NIM/NIP): {{ Auth::user()->identitas }} | Unit: {{ Auth::user()->unit_organisasi }}</p>
                </div>
                <div>
                    @if(Auth::user()->is_banned)
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Status: Diblokir</span>
                    @else
                    <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Status: Aktif</span>
                    @endif
                </div>
            </div>

            <!-- Tabel Dinamis Riwayat Peminjaman -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="font-bold text-md mb-4 text-gray-700">Riwayat Pengajuan Peminjaman Saya</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Aset / Fasilitas</th>
                                    <th class="px-4 py-3">Waktu Mulai</th>
                                    <th class="px-4 py-3">Waktu Selesai</th>
                                    <th class="px-4 py-3">Tujuan Kegiatan</th>
                                    <th class="px-4 py-3">Status Pengajuan</th>
                                    <th class="px-4 py-3">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $item)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        {{ $item->aset->nama_aset }}
                                        <span class="block text-xs text-gray-400">Kode: {{ $item->aset->kode_aset }}</span>
                                    </td>
                                    <td class="px-4 py-3">{{ $item->waktu_mulai->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-3">{{ $item->waktu_selesai->format('d M Y H:i') }}</td>
                                    <td class="px-4 py-3">{{ $item->tujuan_penggunaan }}</td>
                                    <td class="px-4 py-3">
                                        @if($item->status_pengajuan == 'Menunggu')
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Menunggu Approval</span>
                                        @elseif($item->status_pengajuan == 'Disetujui')
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Disetujui</span>
                                        @elseif($item->status_pengajuan == 'Dipinjam')
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Sedang Dipinjam</span>
                                        @elseif($item->status_pengajuan == 'Selesai')
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Selesai</span>
                                        @else
                                        <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Ditolak</span>
                                        @endif
                                    </td>
                                    <td> <a href="{{ route('peminjam.pengajuan.show', $item->id_peminjaman) }}" class="text-indigo-600 hover:underline font-bold text-xs">
                                            Detail Tiket →
                                        </a></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                                        Belum ada riwayat pengajuan peminjaman.
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
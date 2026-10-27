<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Tiket Peminjaman #PMJ-') }}{{ $peminjaman->id_peminjaman }}
            </h2>
            <a href="{{ route('peminjam.dashboard') }}" class="text-sm text-indigo-600 hover:underline font-bold">
                ← Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 rounded-lg shadow-sm space-y-6">
                <!-- Status Bar -->
                <div class="flex justify-between items-center border-b pb-4">
                    <div>
                        <span class="text-xs text-gray-400 font-bold uppercase block">Status Pengajuan</span>
                        @if($peminjaman->status_pengajuan == 'Menunggu')
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-3 py-1 rounded-full">Menunggu Approval Admin</span>
                        @elseif($peminjaman->status_pengajuan == 'Disetujui')
                            <span class="bg-green-100 text-green-800 text-xs font-bold px-3 py-1 rounded-full">Disetujui (Siap Diambil di Gudang)</span>
                        @elseif($peminjaman->status_pengajuan == 'Dipinjam')
                            <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full">Sedang Dipinjam</span>
                        @elseif($peminjaman->status_pengajuan == 'Selesai')
                            <span class="bg-gray-100 text-gray-800 text-xs font-bold px-3 py-1 rounded-full">Selesai</span>
                        @else
                            <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full">Ditolak</span>
                        @endif
                    </div>

                    @if($peminjaman->status_pengajuan == 'Menunggu')
                        <form action="{{ route('peminjam.pengajuan.cancel', $peminjaman->id_peminjaman) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin membatalkan pengajuan ini?')" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded shadow">
                                Batalkan Pengajuan
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Detail Informasi -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Informasi Aset</h4>
                        <p class="text-lg font-bold text-gray-800">{{ $peminjaman->aset->nama_aset }}</p>
                        <p class="text-xs text-gray-500">Kode Aset: {{ $peminjaman->aset->kode_aset }} | Kategori: {{ $peminjaman->aset->kategori }}</p>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">Jadwal Penggunaan</h4>
                        <p class="text-sm font-semibold text-gray-800">Mulai: {{ $peminjaman->waktu_mulai->format('d M Y H:i') }}</p>
                        <p class="text-sm font-semibold text-gray-800">Selesai: {{ $peminjaman->waktu_selesai->format('d M Y H:i') }}</p>
                    </div>
                </div>

                <div class="border-t pt-4">
                    <h4 class="text-xs font-bold text-gray-400 uppercase mb-1">Tujuan Penggunaan Kegiatan</h4>
                    <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded">{{ $peminjaman->tujuan_penggunaan }}</p>
                </div>

                <!-- Foto Bukti Serah Terima & Pengembalian (Jika Ada) -->
                @if($peminjaman->inspeksi)
                    <div class="border-t pt-4">
                        <h4 class="text-xs font-bold text-gray-400 uppercase mb-3">Rekam Jejak Inspeksi Gudang</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($peminjaman->inspeksi->foto_baseline_url)
                                <div>
                                    <p class="text-xs font-bold text-gray-600 mb-1">Foto Kondisi Awal (Serah Terima):</p>
                                    <img src="{{ asset('storage/' . $peminjaman->inspeksi->foto_baseline_url) }}" class="w-full h-40 object-cover rounded border">
                                    <span class="text-xs text-gray-500 block mt-1">Kondisi: {{ $peminjaman->inspeksi->kondisi_baseline }}</span>
                                </div>
                            @endif

                            @if($peminjaman->inspeksi->foto_akhir_url)
                                <div>
                                    <p class="text-xs font-bold text-gray-600 mb-1">Foto Kondisi Akhir (Pengembalian):</p>
                                    <img src="{{ asset('storage/' . $peminjaman->inspeksi->foto_akhir_url) }}" class="w-full h-40 object-cover rounded border">
                                    <span class="text-xs text-gray-500 block mt-1">Kondisi: {{ $peminjaman->inspeksi->kondisi_akhir }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
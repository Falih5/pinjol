<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Komparasi Verifikasi Pengembalian Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                
                <!-- Komparasi Side-By-Side Baseline -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-6 border-b mb-6">
                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">1. Data Baseline Serah Terima Awal</h4>
                        <img src="{{ asset('storage/' . $peminjaman->inspeksi->foto_baseline_url) }}" class="w-full h-48 object-cover rounded border mb-2">
                        <p class="text-sm font-semibold text-gray-800">Kondisi Awal: <span class="text-indigo-600">{{ $peminjaman->inspeksi->kondisi_baseline }}</span></p>
                        <p class="text-xs text-gray-500">Diserahkan: {{ $peminjaman->inspeksi->waktu_serah->format('d M Y H:i') }}</p>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold text-gray-400 uppercase mb-2">2. Informasi Pengembalian</h4>
                        <p class="text-sm font-bold text-gray-800">{{ $peminjaman->aset->nama_aset }}</p>
                        <p class="text-xs text-gray-500 mb-2">Peminjam: {{ $peminjaman->user->nama_lengkap }}</p>
                        
                        <div class="p-3 bg-gray-50 rounded border text-xs space-y-1">
                            <p><strong>Batas Tenggat Kembali:</strong> {{ $peminjaman->waktu_selesai->format('d M Y H:i') }}</p>
                            <p><strong>Waktu Dikembalikan Saat Ini:</strong> {{ now()->format('d M Y H:i') }}</p>
                            @if(now()->greaterThan($peminjaman->waktu_selesai))
                                <p class="text-red-600 font-bold">⚠️ Terindikasi Keterlambatan Pengembalian!</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Form Input Kondisi Akhir -->
                <form action="{{ route('petugas.pengembalian.process', $peminjaman->id_peminjaman) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Checklist Kondisi Fisik Akhir</label>
                        <select name="kondisi_akhir" class="w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                            <option value="Baik">Baik (Sama Seperti Baseline)</option>
                            <option value="Rusak Ringan">Rusak Ringan (Terdapat Kerusakan/Cacat Fisik Baru)</option>
                            <option value="Rusak Berat">Rusak Berat (Hilang / Tidak Berfungsi)</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Unggah Foto Bukti Fisik Pengembalian</label>
                        <input type="file" name="foto_akhir" accept="image/*" class="w-full text-sm border border-gray-300 rounded-md p-2" required>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('petugas.dashboard') }}" class="text-sm text-gray-600 hover:underline">← Batal</a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm shadow">
                            Proses Verifikasi Pengembalian
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
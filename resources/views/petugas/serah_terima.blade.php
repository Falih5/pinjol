<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Form Serah Terima & Rekam Baseline Kondisi Aset') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                
                <div class="border-b pb-4 mb-4">
                    <h3 class="font-bold text-lg text-gray-800">{{ $peminjaman->aset->nama_aset }}</h3>
                    <p class="text-sm text-gray-500">Peminjam: {{ $peminjaman->user->nama_lengkap }} ({{ $peminjaman->user->identitas }})</p>
                    <p class="text-sm text-gray-500">Jadwal: {{ $peminjaman->waktu_mulai->format('d M Y H:i') }} s.d. {{ $peminjaman->waktu_selesai->format('d M Y H:i') }}</p>
                </div>

                <form action="{{ route('petugas.serah_terima.process', $peminjaman->id_peminjaman) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Checklist Kondisi Baseline Awal</label>
                        <select name="kondisi_baseline" class="w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                            <option value="Baik">Baik (Fungsi Normal)</option>
                            <option value="Rusak Ringan">Rusak Ringan (Ada Cacat Fisik Minor)</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Unggah Foto Bukti Fisik Baseline</label>
                        <input type="file" name="foto_baseline" accept="image/*" class="w-full text-sm border border-gray-300 rounded-md p-2" required>
                        <p class="text-xs text-gray-400 mt-1">Gunakan kamera perangkat untuk memfoto fisik barang saat diserahkan.</p>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('petugas.dashboard') }}" class="text-sm text-gray-600 hover:underline">← Batal</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-sm shadow">
                            Konfirmasi Serah Terima
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
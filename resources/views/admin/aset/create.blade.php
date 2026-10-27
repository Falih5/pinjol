<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Master Data Aset Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                
                <form action="{{ route('admin.aset.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kode Aset / Kode Inventaris</label>
                        <input type="text" name="kode_aset" value="{{ old('kode_aset') }}" placeholder="Contoh: AST-INV-004 / RUA-402" class="w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                        @error('kode_aset') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Aset / Fasilitas</label>
                        <input type="text" name="nama_aset" value="{{ old('nama_aset') }}" placeholder="Contoh: Kamera Canon EOS 80D / Lab Komputer 2" class="w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                        @error('nama_aset') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kategori</label>
                        <select name="kategori" class="w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                            <option value="Fasilitas">Fasilitas (Ruangan / Lapangan / GOR)</option>
                            <option value="Barang">Barang Inventaris (Elektronik / Alat)</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kondisi Awal Barang</label>
                        <select name="kondisi_saat_ini" class="w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                            <option value="Baik">Baik (Siap Pakai)</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('admin.aset.index') }}" class="text-sm text-gray-600 hover:underline">← Batal</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded text-sm shadow">
                            Simpan Aset Baru
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
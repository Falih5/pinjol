<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Aset: ') }}{{ $aset->nama_aset }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-sm">
                
                <form action="{{ route('admin.aset.update', $aset->id_aset) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kode Aset</label>
                        <input type="text" name="kode_aset" value="{{ old('kode_aset', $aset->kode_aset) }}" class="w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                        @error('kode_aset') <span class="text-xs text-red-600">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nama Aset / Fasilitas</label>
                        <input type="text" name="nama_aset" value="{{ old('nama_aset', $aset->nama_aset) }}" class="w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kategori</label>
                        <select name="kategori" class="w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                            <option value="Fasilitas" {{ $aset->kategori == 'Fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                            <option value="Barang" {{ $aset->kategori == 'Barang' ? 'selected' : '' }}>Barang Inventaris</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kondisi Terkini</label>
                        <select name="kondisi_saat_ini" class="w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                            <option value="Baik" {{ $aset->kondisi_saat_ini == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ $aset->kondisi_saat_ini == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ $aset->kondisi_saat_ini == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Status Operasional</label>
                        <select name="status_aktif" class="w-full text-sm border-gray-300 rounded-md shadow-sm" required>
                            <option value="1" {{ $aset->status_aktif == 1 ? 'selected' : '' }}>Aktif (Dapat Dipinjam)</option>
                            <option value="0" {{ $aset->status_aktif == 0 ? 'selected' : '' }}>Nonaktif (Disembunyikan dari Peminjaman)</option>
                        </select>
                    </div>

                    <div class="flex justify-between items-center">
                        <a href="{{ route('admin.aset.index') }}" class="text-sm text-gray-600 hover:underline">← Batal</a>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-5 rounded text-sm shadow">
                            Perbarui Data Aset
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
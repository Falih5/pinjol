<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Master Data Aset & Fasilitas') }}
            </h2>
            <a href="{{ route('admin.aset.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg text-sm shadow">
                + Tambah Aset Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filter Card -->
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <form action="{{ route('admin.aset.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Filter Kategori</label>
                        <select name="kategori" class="text-xs border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Kategori</option>
                            <option value="Fasilitas" {{ request('kategori') == 'Fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                            <option value="Barang" {{ request('kategori') == 'Barang' ? 'selected' : '' }}>Barang Inventaris</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Filter Status</label>
                        <select name="status" class="text-xs border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="flex items-end space-x-2 pt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-4 rounded shadow">
                            Filter
                        </button>
                        <a href="{{ route('admin.aset.index') }}" class="bg-gray-200 text-gray-700 text-xs font-bold py-2 px-3 rounded">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabel Master Data Aset -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Kode Aset</th>
                                <th class="px-4 py-3">Nama Aset / Fasilitas</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Kondisi Fisik</th>
                                <th class="px-4 py-3">Status Operasional</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($asets as $aset)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 font-mono font-bold text-gray-800">{{ $aset->kode_aset }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $aset->nama_aset }}</td>
                                    <td class="px-4 py-3">{{ $aset->kategori }}</td>
                                    <td class="px-4 py-3">
                                        @if($aset->kondisi_saat_ini == 'Baik')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Baik</span>
                                        @elseif($aset->kondisi_saat_ini == 'Rusak Ringan')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Rusak Ringan</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Rusak Berat</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($aset->status_aktif == 1)
                                            <span class="text-xs font-semibold text-green-700">● Aktif</span>
                                        @else
                                            <span class="text-xs font-semibold text-gray-400">○ Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('admin.aset.edit', $aset->id_aset) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-2.5 py-1 rounded text-xs font-semibold">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.aset.toggleStatus', $aset->id_aset) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                @if($aset->status_aktif == 1)
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2.5 py-1 rounded text-xs font-semibold" onclick="return confirm('Nonaktifkan aset ini?')">
                                                        Nonaktifkan
                                                    </button>
                                                @else
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-2.5 py-1 rounded text-xs font-semibold">
                                                        Aktifkan
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                                        Belum ada data aset yang tersimpan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
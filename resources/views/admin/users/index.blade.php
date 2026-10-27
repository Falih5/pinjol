<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Pengguna & Status Hak Akses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Alert Messages -->
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

            <!-- Filter & Search Bar -->
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Cari Nama / Identitas</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIM/NIP/Nama..." class="text-xs border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Filter Role</label>
                        <select name="role" class="text-xs border-gray-300 rounded-md shadow-sm">
                            <option value="">Semua Role</option>
                            <option value="Peminjam" {{ request('role') == 'Peminjam' ? 'selected' : '' }}>Peminjam</option>
                            <option value="Petugas" {{ request('role') == 'Petugas' ? 'selected' : '' }}>Petugas Gudang</option>
                            <option value="Admin" {{ request('role') == 'Admin' ? 'selected' : '' }}>Admin Sarpras</option>
                            <option value="Pimpinan" {{ request('role') == 'Pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                        </select>
                    </div>

                    <div class="flex items-end space-x-2 pt-4">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2 px-4 rounded shadow">
                            Cari & Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="bg-gray-200 text-gray-700 text-xs font-bold py-2 px-3 rounded">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabel Daftar User -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Identitas (NIM/NIP)</th>
                                <th class="px-4 py-3">Nama Lengkap</th>
                                <th class="px-4 py-3">Role</th>
                                <th class="px-4 py-3">Unit / Prodi</th>
                                <th class="px-4 py-3">Status Akun</th>
                                <th class="px-4 py-3 text-center">Aksi Otorisasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $u)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 font-mono font-bold text-gray-800">{{ $u->identitas }}</td>
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $u->nama_lengkap }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 text-xs font-semibold rounded bg-gray-100 text-gray-800">
                                            {{ $u->role }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ $u->unit_organisasi ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if($u->is_banned)
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded">Diblokir</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded">Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($u->id_user !== Auth::user()->id_user)
                                            <form action="{{ route('admin.users.toggleBanned', $u->id_user) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                @if($u->is_banned)
                                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-semibold shadow">
                                                        Buka Blokir
                                                    </button>
                                                @else
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold shadow" onclick="return confirm('Apakah Anda yakin ingin memblokir akses pengguna ini?')">
                                                        Blokir Akun
                                                    </button>
                                                @endif
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 font-italic">(Akun Anda)</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                                        Tidak ada data pengguna yang sesuai.
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
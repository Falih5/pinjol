<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pelanggaran & Catatan Sanksi Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-md mb-2 text-red-700">Catatan Pelanggaran Pribadi</h3>
                <p class="text-xs text-gray-500 mb-4">Setiap keterlambatan atau kerusakan aset akan dicatat secara otomatis dan diteruskan ke Modul Keuangan Kampus[cite: 11, 12].</p>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Aset Terkait</th>
                                <th class="px-4 py-3">Jenis Pelanggaran</th>
                                <th class="px-4 py-3">Rincian Keterangan</th>
                                <th class="px-4 py-3">Status Sinkronisasi Keuangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelanggaran as $p)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-3 font-medium text-gray-900">
                                        {{ $p->peminjaman->aset->nama_aset }}
                                    </td>
                                    <td class="px-4 py-3 font-bold text-red-600">
                                        {{ $p->jenis_pelanggaran }}
                                    </td>
                                    <td class="px-4 py-3 text-xs">{{ $p->keterangan }}</td>
                                    <td class="px-4 py-3">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                            {{ $p->status_keuangan }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                                        Selamat! Anda tidak memiliki riwayat pelanggaran atau denda.
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
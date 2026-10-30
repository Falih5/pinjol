<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links (DESKTOP) -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <!-- <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard Utama') }}
                    </x-nav-link> -->

                    <!-- Menu Khusus Admin Sarpras -->
                    @if(auth()->user()->hasRole('Admin'))
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Persetujuan Peminjaman' ) }}
                    </x-nav-link>
                    <!-- Navigation Link Sendiri untuk Kelola Aset -->
                    <x-nav-link :href="route('admin.aset.index')" :active="request()->routeIs('admin.aset.*')">
                        {{ __('Kelola Aset') }}
                    </x-nav-link>
                    <!-- Navigation Link Kelola User -->
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        {{ __('Kelola User') }}
                    </x-nav-link>
                    @endif

                    <!-- Menu Khusus Petugas Gudang -->
                    @if(auth()->user()->hasRole('Petugas'))
                    <x-nav-link :href="route('petugas.dashboard')" :active="request()->routeIs('petugas.*')">
                        {{ __('Serah Terima Barang') }}
                    </x-nav-link>
                    @endif

                    <!-- Menu Khusus Peminjam -->
                    @if(auth()->user()->hasRole('Peminjam'))
                    <x-nav-link :href="route('peminjam.dashboard')" :active="request()->routeIs('peminjam.dashboard')">
                        {{ __('Pengajuan Peminjaman') }}
                    </x-nav-link>
                    <x-nav-link :href="route('peminjam.pelanggaran')" :active="request()->routeIs('peminjam.pelanggaran')">
                        {{ __('Pelanggaran Saya') }}
                    </x-nav-link>
                    @endif

                    <!-- Menu Khusus Pimpinan -->
                    @if(auth()->user()->hasRole('Pimpinan'))
                    <x-nav-link :href="route('pimpinan.dashboard')" :active="request()->routeIs('pimpinan.*')">
                        {{ __('Laporan Utilisasi') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>
            <!-- Notification Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-3">
                <x-dropdown align="right" width="80">
                    <x-slot name="trigger">
                        <button class="relative p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                            <!-- Icon Lonceng -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>

                            <!-- Badge Counter (Kuning/Red) -->
                            @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-3 border-b border-gray-100 flex justify-between items-center text-xs">
                            <span class="font-bold text-gray-700">Notifikasi System</span>
                            @if(Auth::user()->unreadNotifications->count() > 0)
                            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:underline">Tandai semua dibaca</button>
                            </form>
                            @endif
                        </div>

                        <div class="max-h-60 overflow-y-auto divide-y divide-gray-100">
                            @forelse(Auth::user()->notifications as $notification)
                            <a href="{{ route('notifications.read', $notification->id) }}" class="block p-3 text-xs text-gray-700 hover:bg-gray-50 {{ $notification->read_at ? 'opacity-60' : 'bg-blue-50/50 font-semibold' }}">
                                <p class="text-gray-800">{{ $notification->data['pesan'] }}</p>
                                <span class="text-[10px] text-gray-400 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                            </a>
                            @empty
                            <div class="p-4 text-center text-xs text-gray-400">
                                Tidak ada notifikasi baru.
                            </div>
                            @endforelse
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
            <!-- Tombol Toggle Dark Mode (Alpine.js) -->
            <div class="hidden sm:flex sm:items-center sm:ms-3">
                <button
                    x-data="{ 
            darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) 
        }"
                    @click="
            darkMode = !darkMode; 
            if (darkMode) { 
                document.documentElement.classList.add('dark'); 
                localStorage.setItem('theme', 'dark'); 
            } else { 
                document.documentElement.classList.remove('dark'); 
                localStorage.setItem('theme', 'light'); 
            }
        "
                    class="p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none rounded-lg text-sm"
                    title="Ubah Mode Tampilan">
                    <!-- Ikon Matahari (Muncul saat Dark Mode aktif) -->
                    <svg x-show="darkMode" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 100 2h1z" clip-rule="evenodd"></path>
                    </svg>

                    <!-- Ikon Bulan (Muncul saat Light Mode aktif) -->
                    <svg x-show="!darkMode" class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                </button>
            </div>
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->nama_lengkap }} ({{ Auth::user()->role }})</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Button (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (MOBILE) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard Utama') }}
            </x-responsive-nav-link>

            <!-- Responsive Links Khusus Per Role -->
            @if(auth()->user()->hasRole('Admin'))
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Persetujuan Peminjaman') }}
            </x-responsive-nav-link>
            <!-- Navigation Link Sendiri untuk Kelola Aset (Mobile) -->
            <x-responsive-nav-link :href="route('admin.aset.index')" :active="request()->routeIs('admin.aset.*')">
                {{ __('Kelola Aset') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                {{ __('Kelola User') }}
            </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole('Petugas'))
            <x-responsive-nav-link :href="route('petugas.dashboard')" :active="request()->routeIs('petugas.*')">
                {{ __('Serah Terima Barang') }}
            </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole('Peminjam'))
            <x-responsive-nav-link :href="route('peminjam.dashboard')" :active="request()->routeIs('peminjam.dashboard')">
                {{ __('Pengajuan Peminjaman') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('peminjam.pelanggaran')" :active="request()->routeIs('peminjam.pelanggaran')">
                {{ __('Pelanggaran Saya') }}
            </x-responsive-nav-link>
            @endif

            @if(auth()->user()->hasRole('Pimpinan'))
            <x-responsive-nav-link :href="route('pimpinan.dashboard')" :active="request()->routeIs('pimpinan.*')">
                {{ __('Laporan Utilisasi') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->nama_lengkap }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->identitas }} ({{ Auth::user()->role }})</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
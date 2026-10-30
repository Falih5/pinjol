<x-guest-layout>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes floaty {
            0%, 100% { transform: translateY(0) scale(1); }
            50%      { transform: translateY(-24px) scale(1.06); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .anim-floaty  { animation: floaty 9s ease-in-out infinite; }
        .anim-floaty2 { animation: floaty 12s ease-in-out infinite reverse; }
        .anim-fade-up { animation: fadeUp .7s ease-out both; }
        .grid-pattern {
            background-image:
                linear-gradient(to right, rgba(255,255,255,.06) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,.06) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        @media (prefers-reduced-motion: reduce) {
            .anim-floaty, .anim-floaty2, .anim-fade-up { animation: none; }
        }
    </style>

    {{-- Wrapper full layar (keluar dari batas lebar guest layout) --}}
    <div class="fixed inset-0 z-50 overflow-y-auto bg-slate-950">
        <div class="min-h-full grid lg:grid-cols-2">

            {{-- ================= PANEL KIRI (Branding, desktop) ================= --}}
            <aside class="relative hidden lg:flex flex-col justify-between
                          overflow-hidden p-12 xl:p-16 text-white
                          bg-gradient-to-br from-slate-950 via-blue-950 to-indigo-800">

                <div class="absolute inset-0 grid-pattern"></div>
                <div class="anim-floaty absolute -top-24 -left-24 w-96 h-96
                            rounded-full bg-blue-500/30 blur-3xl"></div>
                <div class="anim-floaty2 absolute -bottom-32 -right-24 w-[28rem] h-[28rem]
                            rounded-full bg-indigo-500/30 blur-3xl"></div>

                {{-- Logo --}}
                <div class="relative flex items-center gap-3">
                    <div class="flex items-center justify-center w-11 h-11 rounded-xl
                                bg-white/10 border border-white/20 backdrop-blur-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-200"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 3L4.5 7v5c0 4.5 3.2 7.5 7.5 9 4.3-1.5 7.5-4.5 7.5-9V7L12 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                        </svg>
                    </div>
                    <span class="text-lg font-semibold tracking-tight">Sistem Informasi</span>
                </div>

                {{-- Tagline --}}
                <div class="relative max-w-lg">
                    <span class="inline-flex items-center gap-2 px-3 py-1 mb-6 text-xs font-medium
                                 rounded-full bg-white/10 border border-white/15 text-blue-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        Portal Resmi
                    </span>

                    <h2 class="text-4xl xl:text-5xl font-bold leading-tight tracking-tight">
                        Akses sistem Anda
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-indigo-300">
                            lebih cepat &amp; aman.
                        </span>
                    </h2>

                    <p class="mt-5 text-base leading-7 text-blue-100/75">
                        Satu pintu masuk terpadu untuk mahasiswa dan dosen.
                        Kelola aktivitas akademik Anda kapan saja dan di mana saja.
                    </p>

                    <ul class="mt-9 space-y-4 text-sm text-blue-100/90">
                        <li class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white/10 border border-white/15">
                                <svg class="w-4 h-4 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            Login aman dengan akun resmi
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white/10 border border-white/15">
                                <svg class="w-4 h-4 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            Tampilan responsif di semua perangkat
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-white/10 border border-white/15">
                                <svg class="w-4 h-4 text-blue-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            Data Anda terlindungi
                        </li>
                    </ul>
                </div>

                <p class="relative text-xs text-blue-100/50">
                    &copy; {{ date('Y') }} Sistem Informasi. All rights reserved.
                </p>
            </aside>


            {{-- ================= PANEL KANAN (Form Login) ================= --}}
            <main class="relative flex items-center justify-center px-4 py-10 sm:px-8
                         bg-gradient-to-br from-slate-950 via-blue-950 to-indigo-900
                         lg:bg-none lg:bg-slate-50">

                {{-- Dekorasi untuk mobile/tablet --}}
                <div class="lg:hidden pointer-events-none absolute inset-0 overflow-hidden">
                    <div class="anim-floaty absolute -top-20 -left-20 w-72 h-72 rounded-full bg-blue-500/25 blur-3xl"></div>
                    <div class="anim-floaty2 absolute -bottom-24 -right-16 w-80 h-80 rounded-full bg-indigo-500/25 blur-3xl"></div>
                </div>

                <div class="relative w-full max-w-md anim-fade-up">

                    {{-- Header (mobile/tablet) --}}
                    <div class="lg:hidden text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20
                                    rounded-2xl bg-white/10 border border-white/20
                                    shadow-xl backdrop-blur-md mb-5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 sm:w-10 sm:h-10 text-blue-300"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 3L4.5 7v5c0 4.5 3.2 7.5 7.5 9 4.3-1.5 7.5-4.5 7.5-9V7L12 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                            </svg>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-white">Selamat Datang</h1>
                        <p class="mt-2 text-sm leading-6 text-blue-100/80">
                            Silakan masuk menggunakan akun Anda untuk melanjutkan.
                        </p>
                    </div>

                    {{-- Login Card --}}
                    <div class="bg-white rounded-3xl shadow-2xl shadow-black/20
                                ring-1 ring-slate-900/5 overflow-hidden">

                        <div class="p-6 sm:p-9">

                            <div class="mb-7">
                                <h2 class="text-2xl font-bold tracking-tight text-slate-800">
                                    Masuk ke Akun
                                </h2>
                                <p class="mt-1.5 text-sm text-slate-500">
                                    Masukkan identitas dan password Anda.
                                </p>
                            </div>

                            {{-- Session Status --}}
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            {{-- Login Form --}}
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                {{-- Identitas --}}
                                <div>
                                    <x-input-label
                                        for="identitas"
                                        :value="__('Identitas (NIM / NIP)')"
                                        class="!text-sm !font-semibold !text-slate-700"
                                    />

                                    <div class="relative mt-2">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M4 21v-2a8 8 0 0116 0v2" />
                                            </svg>
                                        </div>

                                        <x-text-input
                                            id="identitas"
                                            class="block w-full !pl-12 !pr-4 !py-3.5
                                                   !rounded-xl !border-slate-200
                                                   !bg-slate-50 !text-slate-800 !text-base sm:!text-sm
                                                   placeholder:!text-slate-400
                                                   focus:!border-blue-500 focus:!bg-white
                                                   focus:!ring-4 focus:!ring-blue-500/10
                                                   transition duration-200"
                                            type="text"
                                            name="identitas"
                                            :value="old('identitas')"
                                            placeholder="Masukkan NIM atau NIP"
                                            required
                                            autofocus
                                            autocomplete="username"
                                        />
                                    </div>

                                    <x-input-error :messages="$errors->get('identitas')" class="mt-2" />
                                </div>

                                {{-- Password --}}
                                <div class="mt-5">
                                    <x-input-label
                                        for="password"
                                        :value="__('Password')"
                                        class="!text-sm !font-semibold !text-slate-700"
                                    />

                                    <div class="relative mt-2">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-slate-400"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                                <rect x="5" y="10" width="14" height="11" rx="2" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M8 10V7a4 4 0 118 0v3" />
                                            </svg>
                                        </div>

                                        <x-text-input
                                            id="password"
                                            class="block w-full !pl-12 !pr-12 !py-3.5
                                                   !rounded-xl !border-slate-200
                                                   !bg-slate-50 !text-slate-800 !text-base sm:!text-sm
                                                   placeholder:!text-slate-400
                                                   focus:!border-blue-500 focus:!bg-white
                                                   focus:!ring-4 focus:!ring-blue-500/10
                                                   transition duration-200"
                                            type="password"
                                            name="password"
                                            placeholder="Masukkan password"
                                            required
                                            autocomplete="current-password"
                                        />

                                        {{-- Toggle Password --}}
                                        <button
                                            type="button"
                                            id="togglePassword"
                                            class="absolute inset-y-0 right-0 flex items-center px-4
                                                   text-slate-400 hover:text-blue-600 transition"
                                            aria-label="Tampilkan password"
                                            aria-pressed="false"
                                        >
                                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z" />
                                                <circle cx="12" cy="12" r="3" />
                                            </svg>
                                        </button>
                                    </div>

                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                {{-- Remember Me dan Forgot Password --}}
                                <div class="flex flex-wrap items-center justify-between gap-x-3 gap-y-2 mt-5">
                                    <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                                        <input
                                            id="remember_me"
                                            type="checkbox"
                                            name="remember"
                                            class="w-4 h-4 rounded border-slate-300 text-blue-600
                                                   shadow-sm focus:ring-blue-500"
                                        >
                                        <span class="text-sm text-slate-600">Ingat saya</span>
                                    </label>

                                    @if (Route::has('password.request'))
                                        <a
                                            class="text-sm font-medium text-blue-600
                                                   hover:text-blue-800 hover:underline transition"
                                            href="{{ route('password.request') }}"
                                        >
                                            Lupa password?
                                        </a>
                                    @endif
                                </div>

                                {{-- Tombol Login --}}
                                <div class="mt-7">
                                    <x-primary-button
                                        class="w-full !justify-center !py-3.5 !rounded-xl
                                               !bg-gradient-to-r !from-blue-600 !to-indigo-600
                                               hover:!from-blue-700 hover:!to-indigo-700
                                               active:scale-[.99]
                                               focus:!ring-4 focus:!ring-blue-500/30
                                               transition duration-200
                                               shadow-lg shadow-blue-600/25"
                                    >
                                        <span class="flex items-center justify-center gap-2 text-sm font-semibold">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 17l5-5-5-5" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H3" />
                                            </svg>
                                            {{ __('Log in') }}
                                        </span>
                                    </x-primary-button>
                                </div>

                            </form>
                        </div>

                        {{-- Footer Card --}}
                        <div class="px-6 sm:px-9 py-4 bg-slate-50 border-t border-slate-100">
                            <p class="flex items-center justify-center gap-1.5 text-center text-xs text-slate-500">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="1.8">
                                    <rect x="5" y="10" width="14" height="11" rx="2" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7a4 4 0 118 0v3" />
                                </svg>
                                Gunakan akun resmi Anda untuk mengakses sistem.
                            </p>
                        </div>
                    </div>

                    {{-- Footer Halaman (mobile/tablet) --}}
                    <div class="lg:hidden mt-7 text-center">
                        <p class="text-xs text-blue-100/60">
                            &copy; {{ date('Y') }} Sistem Informasi. All rights reserved.
                        </p>
                    </div>

                </div>
            </main>

        </div>
    </div>


    {{-- JavaScript Tampilkan / Sembunyikan Password --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput && togglePassword && eyeIcon) {
                togglePassword.addEventListener('click', function () {
                    const isPassword = passwordInput.type === 'password';

                    passwordInput.type = isPassword ? 'text' : 'password';

                    togglePassword.setAttribute('aria-pressed', String(isPassword));
                    togglePassword.setAttribute(
                        'aria-label',
                        isPassword ? 'Sembunyikan password' : 'Tampilkan password'
                    );

                    eyeIcon.innerHTML = isPassword
                        ? `
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 3l18 18M10.6 10.6a2 2 0 002.8 2.8" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.9 5.2A10.8 10.8 0 0112 5c6 0 9.5 7 9.5 7a15 15 0 01-4 4.8M6.2 6.2C3.8 7.8 2.5 12 2.5 12s3.5 7 9.5 7c1.2 0 2.3-.3 3.3-.7" />
                        `
                        : `
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7z" />
                            <circle cx="12" cy="12" r="3" />
                        `;
                });
            }
        });
    </script>
</x-guest-layout>

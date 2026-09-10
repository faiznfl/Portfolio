@extends('layouts.admin')

@section('title', 'Faiz Naufal Putra Permana - Pengaturan Akun Admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Breadcrumb & Header -->
        <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-gray-400">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-ps-primary">Dashboard</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-gray-200">Pengaturan Akun</span>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                    Pengaturan Akun &amp; Kredensial
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-gray-400 mt-1">
                    Kelola alamat email login dan perbarui kata sandi untuk keamanan panel admin.
                </p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold text-slate-700 dark:text-slate-300 bg-white/70 dark:bg-white/5 hover:bg-white dark:hover:bg-white/10 border border-slate-300 dark:border-white/10 transition-all self-start sm:self-auto">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

        <!-- 1. KARTU INFORMASI PROFIL & EMAIL -->
        <div class="ps-card-dark p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-white/10 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-500/10 text-blue-600 dark:text-cyan-400 border border-blue-500/20 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white tracking-tight">Informasi Profil &amp; Email Login</h2>
                        <p class="text-xs text-slate-500 dark:text-gray-400">Email ini digunakan sebagai kredensial utama saat masuk ke Control Hub.</p>
                    </div>
                </div>
                <span class="hidden sm:inline-flex px-2.5 py-1 rounded-full text-[10px] font-mono font-bold uppercase bg-ps-primary/10 text-ps-primary dark:text-cyan-300 border border-ps-primary/20">
                    Aktif
                </span>
            </div>

            @if(session('profile_success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('profile_success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.account.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap / Display Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-gray-300">
                        Nama Admin <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $user->name) }}" 
                           required 
                           class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                    @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Email -->
                <div class="space-y-2">
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-gray-300">
                        Alamat Email Login <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           required 
                           class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                    @error('email')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-[11px] text-slate-500 dark:text-gray-400">
                        Pastikan email ini aktif dan dapat Anda akses karena digunakan saat login admin.
                    </p>
                </div>

                <div class="flex items-center justify-end pt-2">
                    <button type="submit" class="btn-ps-primary !py-2.5 !px-6 !text-xs !font-bold flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Simpan Perubahan Email</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- 2. KARTU GANTI KATA SANDI -->
        <div class="ps-card-dark p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 dark:border-white/10 pb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white tracking-tight">Perbarui Kata Sandi (Password)</h2>
                        <p class="text-xs text-slate-500 dark:text-gray-400">Gunakan kata sandi kuat yang mengandung kombinasi huruf, angka, dan simbol.</p>
                    </div>
                </div>
                <span class="hidden sm:inline-flex px-2.5 py-1 rounded-full text-[10px] font-mono font-bold uppercase bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20">
                    Keamanan
                </span>
            </div>

            @if(session('password_success'))
                <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('password_success') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.account.password.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Current Password -->
                <div class="space-y-2">
                    <label for="current_password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-gray-300">
                        Kata Sandi Saat Ini <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="current_password" 
                               name="current_password" 
                               required 
                               placeholder="Masukkan kata sandi lama Anda"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary pr-11">
                        <button type="button" onclick="togglePasswordVisibility('current_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1" title="Lihat/Sembunyikan">
                            <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- New Password -->
                    <div class="space-y-2">
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-gray-300">
                            Kata Sandi Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   placeholder="Minimal 8 karakter"
                                   class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary pr-11">
                            <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1" title="Lihat/Sembunyikan">
                                <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Confirmation -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-gray-300">
                            Ulangi Kata Sandi Baru <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required 
                                   placeholder="Ketik ulang kata sandi baru"
                                   class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary pr-11">
                            <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-1" title="Lihat/Sembunyikan">
                                <svg class="w-4 h-4 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-xl bg-slate-100/60 dark:bg-white/[0.03] border border-slate-200/80 dark:border-white/5 space-y-1 text-xs text-slate-500 dark:text-gray-400">
                    <span class="font-semibold text-slate-700 dark:text-slate-300">Persyaratan Kata Sandi:</span>
                    <ul class="list-disc list-inside space-y-0.5">
                        <li>Panjang minimal 8 karakter.</li>
                        <li>Pastikan konfirmasi kata sandi sama persis.</li>
                        <li>Setelah kata sandi diubah, Anda dapat menggunakannya langsung untuk sesi login berikutnya.</li>
                    </ul>
                </div>

                <div class="flex items-center justify-end pt-2">
                    <button type="submit" class="btn-ps-primary !py-2.5 !px-6 !text-xs !font-bold flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>Perbarui Kata Sandi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(fieldId, btn) {
        const input = document.getElementById(fieldId);
        if (!input) return;
        
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>`;
        } else {
            input.type = 'password';
            btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>`;
        }
    }
</script>
@endsection

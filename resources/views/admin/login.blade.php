@extends('layouts.app')

@section('title', 'Faiz Naufal Putra Permana - Admin Login')
@section('hide_navbar', true)
@section('hide_footer', true)

@section('content')
<div class="min-h-[calc(100vh-5rem)] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full ps-card-dark p-8 sm:p-10 space-y-8 shadow-2xl">
        <!-- Brand Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-ps-primary/15 text-ps-primary dark:text-cyan-300 border border-ps-primary/25 mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Portal Manajemen Admin</h1>
            <p class="text-xs text-slate-500 dark:text-gray-400">Masuk untuk mengelola konten dan meninjau pesan kerja sama.</p>
        </div>

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Email -->
            <div class="space-y-2">
                <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-gray-300">
                    Alamat Email Admin
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', 'admin@portfolio.local') }}" 
                       required 
                       autofocus
                       class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:border-ps-primary text-sm">
                @error('email')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 dark:text-gray-300">
                    Kata Sandi
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       value="password"
                       required
                       class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:border-ps-primary text-sm">
                @error('password')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600 dark:text-gray-400">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-black/60 border border-white/20 text-ps-primary focus:ring-0">
                    <span>Ingat saya pada perangkat ini</span>
                </label>
                <span class="text-ps-primary font-mono">Role: Superadmin</span>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-ps-primary !w-full !py-3 !text-sm !font-bold">
                <span>Masuk ke Control Panel</span>
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </button>
        </form>

        <div class="text-center pt-2">
            <a href="{{ route('home') }}" class="text-xs text-slate-500 dark:text-gray-400 hover:text-ps-primary dark:hover:text-cyan-400 transition-colors">
                ← Kembali ke Halaman Portofolio Publik
            </a>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')

@section('title', 'Faiz Naufal Putra Permana - Manajemen Sertifikat')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-white/10 pb-6">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-gray-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-ps-primary dark:hover:text-blue-400">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-800 dark:text-gray-200 font-semibold">Sertifikat</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Katalog Sertifikasi &amp; Lisensi Digital</h1>
                <p class="text-xs text-slate-500 dark:text-gray-400">Kelola sertifikasi industri, organisasi penerbit, dan tautan verifikasi kredensial resmi.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.certificates.create') }}" class="btn-ps-primary !py-2.5 !px-5 !text-xs !font-bold flex items-center gap-1.5 shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>+ Tambah Sertifikat Baru</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Certificates Table Card -->
        <div class="ps-card-dark p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-mono uppercase font-bold text-slate-500 dark:text-gray-400">Daftar Sertifikasi Resmi</span>
                    <span class="text-xs font-mono text-ps-primary dark:text-blue-400 bg-ps-primary/10 dark:bg-blue-500/10 px-2.5 py-0.5 rounded-full border border-ps-primary/20 dark:border-blue-400/20 font-bold">
                        {{ $certificates->count() }} Data
                    </span>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                        <thead class="text-xs font-mono uppercase bg-slate-100/90 dark:bg-white/[0.04] text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                            <tr>
                                <th class="px-4 py-3.5">Urutan</th>
                                <th class="px-4 py-3.5">Nama Sertifikat</th>
                                <th class="px-4 py-3.5">Organisasi Penerbit</th>
                                <th class="px-4 py-3.5 font-mono">Tahun</th>
                                <th class="px-4 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-white/5">
                            @forelse($certificates as $cert)
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors">
                                    <td class="px-4 py-3.5 font-mono text-xs text-slate-400">#{{ $cert->order_index }}</td>
                                    <td class="px-4 py-3.5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-white dark:bg-black/40 border border-slate-200 dark:border-white/10 p-1 flex items-center justify-center shrink-0 shadow-xs">
                                                <img src="{{ $cert->media_file_path ?? asset('assets/certificates/cert-aws-saa.svg') }}"
                                                     alt="{{ $cert->certificate_name }}"
                                                     class="w-full h-full object-contain">
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-900 dark:text-white">{{ $cert->certificate_name }}</div>
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    @if($cert->category)
                                                        @foreach(array_filter(array_map('trim', explode(',', $cert->category))) as $cat)
                                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-slate-100 dark:bg-white/10 text-ps-primary dark:text-blue-300 border border-slate-200 dark:border-white/10">{{ $cat }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-[11px] font-mono text-slate-400 dark:text-gray-500">Sertifikasi</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3.5 text-ps-primary dark:text-blue-400 font-semibold">{{ $cert->issuer_organization }}</td>
                                    <td class="px-4 py-3.5 font-mono text-xs font-semibold text-slate-700 dark:text-gray-300">
                                        {{ $cert->issue_date ? $cert->issue_date->format('Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-3.5 text-right">
                                        <div class="flex items-center justify-end gap-2 text-xs">
                                            <a href="{{ route('admin.certificates.edit', $cert->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-ps-primary dark:text-blue-300 bg-ps-primary/10 hover:bg-ps-primary hover:text-white dark:bg-blue-500/10 dark:hover:bg-blue-600 dark:hover:text-white transition-all">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus sertifikat {{ $cert->certificate_name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-rose-600 dark:text-rose-400 bg-rose-50 hover:bg-rose-100 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 border border-rose-200/60 dark:border-rose-400/20 transition-all">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                                        Belum ada sertifikasi yang ditambahkan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if(method_exists($certificates, 'links'))
                <div class="pt-4 border-t border-slate-200 dark:border-white/10">
                    {{ $certificates->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

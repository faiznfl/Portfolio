@extends('layouts.admin')

@section('title', 'Faiz Naufal Putra Permana - Admin')

@section('content')
<div id="dashboard" class="px-4 sm:px-6 lg:px-8 font-sans scroll-mt-28">
    <div class="max-w-7xl mx-auto space-y-10">
        <!-- Top Command Header Banner -->
        <div class="ps-card-dark p-6 sm:p-8 relative overflow-hidden">
            <!-- Subtle Decorative Radial Glow Background -->
            <div class="absolute -right-16 -top-16 w-64 h-64 bg-ps-primary/10 dark:bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 relative z-10">
                <div class="space-y-2">
                    <div class="flex items-center gap-2.5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-mono font-bold tracking-wider uppercase bg-ps-primary/10 text-ps-primary dark:bg-cyan-500/15 dark:text-cyan-300 border border-ps-primary/25 dark:border-cyan-500/30">
                            <span class="w-2 h-2 rounded-full bg-ps-primary dark:bg-cyan-400 animate-pulse"></span>
                            CONTROL HUB • v2.4
                        </span>
                        <span class="text-xs font-mono text-slate-400 dark:text-gray-500">
                            Superadmin Active
                        </span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-light text-slate-900 dark:text-white tracking-tight">
                        Manajemen Portofolio <span class="font-bold text-ps-primary dark:text-cyan-400">&amp; Showcase</span>
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-gray-400 max-w-2xl leading-relaxed">
                        Kelola etalase proyek, katalog keahlian teknis, linimasa perjalanan karier, dan sertifikasi digital secara terintegrasi.
                    </p>
                </div>

                <!-- Quick Action Shortcuts -->
                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                    <a href="{{ route('admin.projects.create') }}" class="btn-ps-primary !py-2.5 !px-4 !text-xs !font-semibold flex items-center gap-1.5 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>+ Proyek</span>
                    </a>
                    <a href="{{ route('admin.skills.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full text-xs font-semibold text-slate-800 dark:text-slate-100 bg-slate-100 hover:bg-slate-200 dark:bg-white/10 dark:hover:bg-white/15 border border-slate-300/80 dark:border-white/10 transition-all">
                        <svg class="w-3.5 h-3.5 text-ps-primary dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>+ Skill</span>
                    </a>
                    <button type="button" onclick="openCvModal()" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full text-xs font-semibold text-ps-primary dark:text-cyan-300 bg-ps-primary/10 hover:bg-ps-primary/20 dark:bg-cyan-500/10 dark:hover:bg-cyan-500/20 border border-ps-primary/30 dark:border-cyan-500/30 transition-all shadow-sm cursor-pointer" title="Unggah Berkas CV / Resume Baru">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span>Upload CV</span>
                    </button>
                    <a href="{{ route('resume.preview') }}" target="_blank" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full text-xs font-semibold text-slate-700 dark:text-slate-300 bg-white/70 dark:bg-white/5 hover:bg-white dark:hover:bg-white/10 border border-slate-300 dark:border-white/10 transition-all" title="Lihat Berkas CV Aktif ({{ $cvInfo['filename'] ?? 'resume.pdf' }})">
                        <svg class="w-3.5 h-3.5 text-ps-primary dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>Lihat CV</span>
                    </a>
                    <a href="{{ route('resume.download') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full text-xs font-semibold text-slate-700 dark:text-slate-300 bg-white/70 dark:bg-white/5 hover:bg-white dark:hover:bg-white/10 border border-slate-300 dark:border-white/10 transition-all" title="Unduh Berkas CV Aktif ({{ $cvInfo['filename'] ?? 'resume.pdf' }})">
                        <svg class="w-3.5 h-3.5 text-ps-primary dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Unduh CV</span>
                    </a>
                    <a href="{{ route('admin.account.index') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-full text-xs font-semibold text-slate-700 dark:text-slate-300 bg-white/70 dark:bg-white/5 hover:bg-white dark:hover:bg-white/10 border border-slate-300 dark:border-white/10 transition-all" title="Pengaturan Email & Kata Sandi Admin">
                        <svg class="w-3.5 h-3.5 text-ps-primary dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>Akun Admin</span>
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Sleek KPI Metric Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <!-- 1. Proyek -->
            <div class="ps-card-dark p-5 flex flex-col justify-between group hover:-translate-y-1 hover:border-blue-500/40 transition-all duration-300">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] text-slate-500 dark:text-gray-400 font-mono uppercase font-bold tracking-wider">Proyek</span>
                        <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-light text-slate-900 dark:text-white tracking-tight">{{ $totalProjects }}</div>
                </div>
                <div class="pt-3 border-t border-slate-200/60 dark:border-white/5">
                    <a href="{{ route('admin.projects.index') }}" class="text-[11px] font-medium text-ps-primary dark:text-cyan-400 hover:underline inline-flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                        <span>Kelola Proyek</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            <!-- 2. Keahlian -->
            <div class="ps-card-dark p-5 flex flex-col justify-between group hover:-translate-y-1 hover:border-cyan-500/40 transition-all duration-300">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] text-slate-500 dark:text-gray-400 font-mono uppercase font-bold tracking-wider">Keahlian</span>
                        <div class="w-7 h-7 rounded-lg bg-cyan-500/10 text-cyan-600 dark:text-cyan-300 border border-cyan-500/20 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-light text-slate-900 dark:text-white tracking-tight">{{ $totalSkills }}</div>
                </div>
                <div class="pt-3 border-t border-slate-200/60 dark:border-white/5">
                    <a href="{{ route('admin.skills.index') }}" class="text-[11px] font-medium text-ps-primary dark:text-cyan-400 hover:underline inline-flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                        <span>Kelola Skills</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            <!-- 3. Pengalaman -->
            <div class="ps-card-dark p-5 flex flex-col justify-between group hover:-translate-y-1 hover:border-purple-500/40 transition-all duration-300">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] text-slate-500 dark:text-gray-400 font-mono uppercase font-bold tracking-wider">Pengalaman</span>
                        <div class="w-7 h-7 rounded-lg bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/20 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-light text-slate-900 dark:text-white tracking-tight">{{ $totalExperiences }}</div>
                </div>
                <div class="pt-3 border-t border-slate-200/60 dark:border-white/5">
                    <a href="{{ route('admin.experiences.index') }}" class="text-[11px] font-medium text-ps-primary dark:text-cyan-400 hover:underline inline-flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                        <span>Kelola Journey</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            <!-- 4. Sertifikat -->
            <div class="ps-card-dark p-5 flex flex-col justify-between group hover:-translate-y-1 hover:border-amber-500/40 transition-all duration-300">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] text-slate-500 dark:text-gray-400 font-mono uppercase font-bold tracking-wider">Sertifikat</span>
                        <div class="w-7 h-7 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-light text-slate-900 dark:text-white tracking-tight">{{ $totalCertificates }}</div>
                </div>
                <div class="pt-3 border-t border-slate-200/60 dark:border-white/5">
                    <a href="{{ route('admin.certificates.index') }}" class="text-[11px] font-medium text-ps-primary dark:text-cyan-400 hover:underline inline-flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                        <span>Kelola Sertifikat</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            <!-- 5. Total Pesan -->
            <div class="ps-card-dark p-5 flex flex-col justify-between group hover:-translate-y-1 hover:border-emerald-500/40 transition-all duration-300">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] text-slate-500 dark:text-gray-400 font-mono uppercase font-bold tracking-wider">Total Pesan</span>
                        <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-light text-slate-900 dark:text-white tracking-tight">{{ $totalMessages }}</div>
                </div>
                <div class="pt-3 border-t border-slate-200/60 dark:border-white/5">
                    <span class="text-[11px] text-slate-400 dark:text-gray-500 block">Masuk via formulir</span>
                </div>
            </div>

            <!-- 6. Belum Dibaca -->
            <div class="ps-card-dark p-5 flex flex-col justify-between group hover:-translate-y-1 hover:border-rose-500/40 transition-all duration-300">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] text-slate-500 dark:text-gray-400 font-mono uppercase font-bold tracking-wider">Belum Dibaca</span>
                        <div class="w-7 h-7 rounded-lg {{ $unreadMessagesCount > 0 ? 'bg-rose-500/10 text-rose-600 dark:text-rose-400 border border-rose-500/25' : 'bg-slate-500/10 text-slate-500 border border-slate-500/20' }} flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                    </div>
                    <div class="text-3xl font-light text-slate-900 dark:text-white tracking-tight">{{ $unreadMessagesCount }}</div>
                </div>
                <div class="pt-3 border-t border-slate-200/60 dark:border-white/5">
                    @if($unreadMessagesCount > 0)
                        <span class="inline-flex items-center gap-1.5 text-[11px] text-rose-600 dark:text-rose-400 font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                            Perlu ditinjau
                        </span>
                    @else
                        <span class="text-[11px] text-slate-400 dark:text-gray-500 block">Semua terbaca</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Inquiries & Messages List (Refined Inbox Card) -->
        <div class="ps-card-dark p-6 sm:p-8 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-white/10 pb-5">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-ps-primary/10 text-ps-primary dark:text-cyan-300 border border-ps-primary/20 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Pesan &amp; Tawaran Kerja Sama Masuk</h2>
                        <p class="text-xs text-slate-500 dark:text-gray-400 mt-0.5">Daftar pertanyaan dan penawaran dari formulir Contacts publik.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-mono text-slate-500 dark:text-gray-400 bg-slate-100 dark:bg-white/5 px-3 py-1.5 rounded-full border border-slate-200 dark:border-white/10">
                        Total: <span class="font-bold text-slate-800 dark:text-slate-200">{{ $totalMessages }}</span>
                    </span>
                    @if($unreadMessagesCount > 0)
                        <span class="text-xs font-mono text-rose-600 dark:text-rose-400 bg-rose-500/10 px-3 py-1.5 rounded-full border border-rose-500/20 font-bold">
                            {{ $unreadMessagesCount }} Baru
                        </span>
                    @endif
                </div>
            </div>

            @if($messages->isEmpty())
                <div class="text-center py-12 border border-dashed border-slate-200 dark:border-white/15 rounded-2xl text-slate-400 text-sm space-y-2">
                    <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 dark:bg-white/5 flex items-center justify-center text-slate-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    </div>
                    <p class="font-medium text-slate-600 dark:text-slate-300">Belum ada pesan masuk</p>
                    <p class="text-xs text-slate-400 dark:text-gray-500">Pesan dari pengunjung akan otomatis tersimpan dan tertampil di sini.</p>
                </div>
            @else
                <div class="space-y-3.5">
                    @foreach($messages as $msg)
                        <div class="p-4 sm:p-5 rounded-2xl border transition-all duration-200 {{ $msg->is_read ? 'bg-slate-50/60 dark:bg-black/30 border-slate-200/80 dark:border-white/10' : 'bg-ps-primary/[0.04] dark:bg-cyan-500/[0.04] border-ps-primary/30 dark:border-cyan-400/30 shadow-xs' }} space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full {{ $msg->is_read ? 'bg-slate-200 dark:bg-white/10 text-slate-700 dark:text-slate-300' : 'bg-ps-primary text-white' }} flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ strtoupper(substr($msg->sender_name, 0, 1)) }}
                                    </div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $msg->sender_name }}</span>
                                        <a href="mailto:{{ $msg->sender_email }}" class="text-xs text-ps-primary dark:text-cyan-400 hover:underline font-mono bg-slate-100 dark:bg-white/5 px-2 py-0.5 rounded-md border border-slate-200 dark:border-white/5">
                                            {{ $msg->sender_email }}
                                        </a>
                                        @if(!$msg->is_read)
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase bg-rose-500/15 text-rose-600 dark:text-rose-400 border border-rose-500/25">
                                                Baru
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-xs text-slate-400 dark:text-gray-500 font-mono">
                                    {{ $msg->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>

                            <div class="space-y-1.5 pl-0 sm:pl-11">
                                <div class="text-xs font-semibold text-slate-800 dark:text-gray-200 flex items-center gap-1.5">
                                    <span class="text-slate-400 dark:text-gray-500 font-normal">Subjek:</span>
                                    <span>{{ $msg->subject }}</span>
                                </div>
                                <p class="text-sm text-slate-600 dark:text-gray-300 leading-relaxed font-light bg-white/70 dark:bg-black/40 p-3.5 rounded-xl border border-slate-200/60 dark:border-white/5">
                                    {{ $msg->message_body }}
                                </p>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-3 pt-1 text-xs pl-0 sm:pl-11 border-t border-slate-200/50 dark:border-white/5">
                                <span class="text-slate-400 dark:text-gray-500 font-mono text-[11px]">IP: {{ $msg->ip_address ?? 'Local' }}</span>
                                
                                <div class="flex items-center gap-2">
                                    <a href="mailto:{{ $msg->sender_email }}?subject=Re: {{ urlencode($msg->subject) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-ps-primary dark:text-cyan-300 bg-ps-primary/10 hover:bg-ps-primary hover:text-white dark:bg-cyan-500/10 dark:hover:bg-cyan-400 dark:hover:text-black transition-all">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                        <span>Balas via Email ↗</span>
                                    </a>

                                    <form action="{{ route('admin.messages.toggle-read', $msg->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 dark:text-gray-300 bg-slate-100 hover:bg-slate-200 dark:bg-white/5 dark:hover:bg-white/10 border border-slate-200 dark:border-white/10 transition-all">
                                            {{ $msg->is_read ? 'Tandai Belum Terbaca' : 'Tandai Terbaca' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-rose-600 dark:text-rose-400 bg-rose-50 hover:bg-rose-100 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 border border-rose-200/60 dark:border-rose-400/20 transition-all">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if(method_exists($messages, 'links'))
                    <div class="pt-3">
                        {{ $messages->links() }}
                    </div>
                @endif
            @endif
        </div>

        <!-- 4-in-1 Showcase Management Hub -->
        <div class="space-y-8">
            <!-- SECTION 1: SKILLS -->
            <div id="skills" class="ps-card-dark p-6 sm:p-8 space-y-6 scroll-mt-28">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-white/10 pb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-300 border border-cyan-500/20 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Katalog Keahlian &amp; Teknologi</h2>
                            <p class="text-xs text-slate-500 dark:text-gray-400 mt-0.5">Daftar skill yang ditampilkan pada grid interaktif halaman publik.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.skills.index') }}" class="text-xs font-semibold text-ps-primary dark:text-cyan-400 hover:underline">
                            Lihat Semua Skills →
                        </a>
                        <a href="{{ route('admin.skills.create') }}" class="btn-ps-primary !py-2 !px-4 !text-xs !font-bold">
                            <span>+ Tambah Skill Baru</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-white/10">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                            <thead class="text-xs font-mono uppercase bg-slate-100/90 dark:bg-white/[0.04] text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                                <tr>
                                    <th class="px-4 py-3.5">Urutan</th>
                                    <th class="px-4 py-3.5">Icon</th>
                                    <th class="px-4 py-3.5">Nama Skill</th>
                                    <th class="px-4 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-white/5">
                                @forelse($skills->take(6) as $s)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors">
                                        <td class="px-4 py-3.5 font-mono text-xs text-slate-400">#{{ $s->order_index }}</td>
                                        <td class="px-4 py-3.5">
                                            <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-white/10 border border-slate-200 dark:border-white/10 flex items-center justify-center text-ps-primary dark:text-cyan-300 [&>svg]:w-5 [&>svg]:h-5 [&>svg]:max-w-full [&>svg]:max-h-full overflow-hidden">
                                                @if(!empty($s->icon_svg))
                                                    @if(str_starts_with(trim($s->icon_svg), '<svg') || str_starts_with(trim($s->icon_svg), '<i '))
                                                        {!! $s->icon_svg !!}
                                                    @elseif(str_starts_with(trim($s->icon_svg), 'http') || str_starts_with(trim($s->icon_svg), '/'))
                                                        <img src="{{ $s->icon_svg }}" alt="{{ $s->name }}" class="w-5 h-5 object-contain">
                                                    @else
                                                        <span class="text-base">{{ $s->icon_svg }}</span>
                                                    @endif
                                                @else
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-4 h-4 text-slate-400">
                                                        <polyline points="16 18 22 12 16 6"/>
                                                        <polyline points="8 6 2 12 8 18"/>
                                                    </svg>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3.5 font-semibold text-slate-900 dark:text-white">
                                            <span>{{ $s->name }}</span>
                                            @if($s->is_featured)
                                                <span class="ml-2 px-2 py-0.5 rounded-full text-[10px] font-mono font-bold uppercase bg-amber-500/15 text-amber-600 dark:text-yellow-400 border border-amber-500/25">Featured</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-2 text-xs">
                                                <a href="{{ route('admin.skills.edit', $s->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium text-ps-primary dark:text-cyan-300 bg-ps-primary/10 hover:bg-ps-primary hover:text-white dark:bg-cyan-500/10 dark:hover:bg-cyan-400 dark:hover:text-black transition-all">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.skills.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus skill {{ $s->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium text-rose-600 dark:text-rose-400 bg-rose-50 hover:bg-rose-100 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 transition-all">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-slate-400">
                                            Belum ada data skill. Klik tombol di atas untuk menambah skill.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- SECTION 2: PROJECTS -->
            <div id="projects" class="ps-card-dark p-6 sm:p-8 space-y-6 scroll-mt-28">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-white/10 pb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Katalog Proyek</h2>
                            <p class="text-xs text-slate-500 dark:text-gray-400 mt-0.5">Daftar proyek yang aktif ditampilkan pada halaman publik.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.projects.index') }}" class="text-xs font-semibold text-ps-primary dark:text-cyan-400 hover:underline">
                            Lihat Semua Proyek →
                        </a>
                        <a href="{{ route('admin.projects.create') }}" class="btn-ps-primary !py-2 !px-4 !text-xs !font-bold">
                            <span>+ Tambah Proyek Baru</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-white/10">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                            <thead class="text-xs font-mono uppercase bg-slate-100/90 dark:bg-white/[0.04] text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                                <tr>
                                    <th class="px-4 py-3.5">Urutan</th>
                                    <th class="px-4 py-3.5">Judul Proyek</th>
                                    <th class="px-4 py-3.5">Status</th>
                                    <th class="px-4 py-3.5">Featured</th>
                                    <th class="px-4 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-white/5">
                                @forelse($projects->take(6) as $p)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors">
                                        <td class="px-4 py-3.5 font-mono text-xs text-slate-400">#{{ $p->order_index }}</td>
                                        <td class="px-4 py-3.5 font-semibold text-slate-900 dark:text-white">
                                            {{ $p->title }}
                                            <span class="block text-xs font-mono text-slate-400 dark:text-gray-500 font-normal">{{ $p->slug }}</span>
                                        </td>
                                        <td class="px-4 py-3.5">
                                            @if($p->is_published)
                                                 <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                                     <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Publik
                                                 </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-200/70 dark:bg-white/10 text-slate-500 dark:text-gray-400">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5">
                                            @if($p->is_featured)
                                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-amber-500/15 text-amber-600 dark:text-yellow-400 border border-amber-500/25">★ Ya</span>
                                            @else
                                                <span class="text-xs text-slate-400 dark:text-gray-500 font-mono">-</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-2 text-xs">
                                                <a href="{{ route('admin.projects.edit', $p->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium text-ps-primary dark:text-cyan-300 bg-ps-primary/10 hover:bg-ps-primary hover:text-white dark:bg-cyan-500/10 dark:hover:bg-cyan-400 dark:hover:text-black transition-all">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.projects.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus proyek ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium text-rose-600 dark:text-rose-400 bg-rose-50 hover:bg-rose-100 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 transition-all">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                                            Belum ada proyek. Klik tombol di atas untuk menambah proyek.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: EXPERIENCES (JOURNEY) -->
            <div id="experiences" class="ps-card-dark p-6 sm:p-8 space-y-6 scroll-mt-28">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-white/10 pb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/20 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Linimasa Karier (Journey Timeline)</h2>
                            <p class="text-xs text-slate-500 dark:text-gray-400 mt-0.5">Daftar pengalaman kerja yang ditampilkan pada timeline halaman publik.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.experiences.index') }}" class="text-xs font-semibold text-ps-primary dark:text-cyan-400 hover:underline">
                            Lihat Semua Journey →
                        </a>
                        <a href="{{ route('admin.experiences.create') }}" class="btn-ps-primary !py-2 !px-4 !text-xs !font-bold">
                            <span>+ Tambah Pengalaman Baru</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-white/10">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                            <thead class="text-xs font-mono uppercase bg-slate-100/90 dark:bg-white/[0.04] text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                                <tr>
                                    <th class="px-4 py-3.5">Urutan</th>
                                    <th class="px-4 py-3.5">Periode</th>
                                    <th class="px-4 py-3.5">Posisi</th>
                                    <th class="px-4 py-3.5">Perusahaan</th>
                                    <th class="px-4 py-3.5">Status</th>
                                    <th class="px-4 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-white/5">
                                @forelse($experiences->take(5) as $exp)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors">
                                        <td class="px-4 py-3.5 font-mono text-xs text-slate-400">#{{ $exp->order_index }}</td>
                                        <td class="px-4 py-3.5 font-mono text-xs text-slate-500 dark:text-gray-400">
                                            {{ $exp->start_date->format('M Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? $exp->end_date->format('M Y') : '-') }}
                                        </td>
                                        <td class="px-4 py-3.5 font-semibold text-slate-900 dark:text-white">{{ $exp->role_title }}</td>
                                        <td class="px-4 py-3.5 text-ps-primary dark:text-cyan-400 font-medium">{{ $exp->company_name }}</td>
                                        <td class="px-4 py-3.5">
                                            @if($exp->is_current)
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs text-slate-500 dark:text-gray-400 bg-slate-100 dark:bg-white/5 font-mono">
                                                    Selesai
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-2 text-xs">
                                                <a href="{{ route('admin.experiences.edit', $exp->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium text-ps-primary dark:text-cyan-300 bg-ps-primary/10 hover:bg-ps-primary hover:text-white dark:bg-cyan-500/10 dark:hover:bg-cyan-400 dark:hover:text-black transition-all">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.experiences.destroy', $exp->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengalaman ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium text-rose-600 dark:text-rose-400 bg-rose-50 hover:bg-rose-100 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 transition-all">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                            Belum ada riwayat pengalaman. Klik tombol di atas untuk menambah data.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: CERTIFICATES -->
            <div id="certificates" class="ps-card-dark p-6 sm:p-8 space-y-6 scroll-mt-28">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-white/10 pb-5">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Katalog Sertifikasi Digital</h2>
                            <p class="text-xs text-slate-500 dark:text-gray-400 mt-0.5">Daftar sertifikasi resmi yang dapat diverifikasi publik.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.certificates.index') }}" class="text-xs font-semibold text-ps-primary dark:text-cyan-400 hover:underline">
                            Lihat Semua Sertifikat →
                        </a>
                        <a href="{{ route('admin.certificates.create') }}" class="btn-ps-primary !py-2 !px-4 !text-xs !font-bold">
                            <span>+ Tambah Sertifikat Baru</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-hidden rounded-xl border border-slate-200 dark:border-white/10">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                            <thead class="text-xs font-mono uppercase bg-slate-100/90 dark:bg-white/[0.04] text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                                <tr>
                                    <th class="px-4 py-3.5">Urutan</th>
                                    <th class="px-4 py-3.5">Nama Sertifikat</th>
                                    <th class="px-4 py-3.5">Penerbit</th>
                                    <th class="px-4 py-3.5 font-mono">Tahun</th>
                                    <th class="px-4 py-3.5 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200 dark:divide-white/5">
                                @forelse($certificates->take(5) as $cert)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.03] transition-colors">
                                        <td class="px-4 py-3.5 font-mono text-xs text-slate-400">#{{ $cert->order_index }}</td>
                                        <td class="px-4 py-3.5">
                                            <div class="font-semibold text-slate-900 dark:text-white">{{ $cert->certificate_name }}</div>
                                            @if($cert->category)
                                                <div class="flex flex-wrap gap-1 mt-1">
                                                    @foreach(array_filter(array_map('trim', explode(',', $cert->category))) as $cat)
                                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-slate-100 dark:bg-white/10 text-ps-primary dark:text-cyan-300 border border-slate-200 dark:border-white/10">{{ $cat }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 text-ps-primary dark:text-cyan-400 font-medium">{{ $cert->issuer_organization }}</td>
                                        <td class="px-4 py-3.5 font-mono text-xs font-semibold text-slate-700 dark:text-gray-300">
                                            {{ $cert->issue_date ? $cert->issue_date->format('Y') : '-' }}
                                        </td>
                                        <td class="px-4 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-2 text-xs">
                                                <a href="{{ route('admin.certificates.edit', $cert->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium text-ps-primary dark:text-cyan-300 bg-ps-primary/10 hover:bg-ps-primary hover:text-white dark:bg-cyan-500/10 dark:hover:bg-cyan-400 dark:hover:text-black transition-all">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus sertifikat ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md text-xs font-medium text-rose-600 dark:text-rose-400 bg-rose-50 hover:bg-rose-100 dark:bg-rose-500/10 dark:hover:bg-rose-500/20 transition-all">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                                            Belum ada sertifikat. Klik tombol di atas untuk menambah sertifikat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Berkas CV -->
<div id="cv-upload-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/70 backdrop-blur-sm transition-opacity duration-300">
    <div class="ps-card-dark max-w-lg w-full p-6 sm:p-7 space-y-6 shadow-2xl relative border border-slate-200 dark:border-white/15 animate-in fade-in zoom-in duration-200" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="flex items-start justify-between border-b border-slate-200 dark:border-white/10 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-ps-primary/10 text-ps-primary dark:text-cyan-400 border border-ps-primary/20 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Upload &amp; Perbarui Berkas CV</h3>
                    <p class="text-xs text-slate-500 dark:text-gray-400 mt-0.5">Unggah berkas CV terbaru yang langsung terhubung ke publik.</p>
                </div>
            </div>
            <button type="button" onclick="closeCvModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white p-1 rounded-lg hover:bg-slate-100 dark:hover:bg-white/10 transition-colors" title="Tutup Modal">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Current Active CV Status Widget -->
        <div class="p-4 rounded-xl bg-slate-100/80 dark:bg-white/[0.03] border border-slate-200 dark:border-white/10 space-y-2.5 text-xs">
            <div class="flex items-center justify-between">
                <span class="font-mono uppercase font-bold text-[10px] tracking-wider text-slate-500 dark:text-gray-400">Berkas CV Aktif Saat Ini:</span>
                @if($cvInfo['exists'])
                    <span class="inline-flex items-center gap-1 text-[10px] font-mono px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Tersedia
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-[10px] font-mono px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 font-semibold">
                        Belum Diunggah
                    </span>
                @endif
            </div>
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-2 truncate">
                    <svg class="w-4 h-4 text-ps-primary dark:text-cyan-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-semibold text-slate-800 dark:text-slate-200 truncate font-mono text-[11px]" title="{{ $cvInfo['filename'] }}">{{ $cvInfo['filename'] }}</span>
                </div>
                <span class="font-mono text-slate-500 dark:text-gray-400 text-[11px] shrink-0">{{ $cvInfo['size'] }}</span>
            </div>
            @if($cvInfo['updated_at'])
                <div class="text-[11px] text-slate-400 dark:text-gray-500">
                    Terakhir diperbarui: <span class="font-mono text-slate-600 dark:text-gray-300">{{ $cvInfo['updated_at'] }}</span>
                </div>
            @endif
            <div class="pt-1 flex items-center gap-4">
                <a href="{{ route('resume.preview') }}" target="_blank" class="text-ps-primary dark:text-cyan-400 hover:underline inline-flex items-center gap-1 font-semibold text-[11px]">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Lihat / Preview CV</span>
                </a>
                <a href="{{ route('resume.download') }}" class="text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white inline-flex items-center gap-1 text-[11px]">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Download CV Langsung</span>
                </a>
            </div>
        </div>

        @error('cv_file')
            <div class="p-3 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-600 dark:text-rose-400 text-xs flex items-center gap-2">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $message }}</span>
            </div>
        @enderror

        <!-- Form Upload -->
        <form action="{{ route('admin.cv.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="cv-modal-form">
            @csrf

            <!-- Dropzone Area -->
            <div id="cv-dropzone" 
                 class="relative border-2 border-dashed border-slate-300 dark:border-white/20 hover:border-ps-primary dark:hover:border-cyan-400 rounded-2xl p-6 text-center cursor-pointer transition-all bg-slate-50/50 hover:bg-ps-primary/[0.02] dark:bg-white/[0.02] dark:hover:bg-cyan-500/[0.03] group">
                <input type="file" 
                       id="modal_cv_file" 
                       name="cv_file" 
                       accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" 
                       required 
                       class="hidden" 
                       onchange="handleCvFileSelect(this)">

                <div id="dropzone-idle" class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-ps-primary/10 text-ps-primary dark:bg-cyan-500/10 dark:text-cyan-400 border border-ps-primary/20 dark:border-cyan-500/30 mx-auto flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">
                            Tarik &amp; letakkan berkas CV ke sini, atau <span class="text-ps-primary dark:text-cyan-400 underline">pilih berkas</span>
                        </p>
                        <p class="text-xs text-slate-500 dark:text-gray-400">
                            Format yang didukung: <span class="font-semibold text-slate-700 dark:text-slate-300">PDF, DOC, DOCX</span> (Maksimal 10 MB)
                        </p>
                    </div>
                </div>

                <div id="dropzone-selected" class="hidden space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30 mx-auto flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <p id="selected-cv-name" class="text-sm font-bold text-slate-900 dark:text-white font-mono truncate max-w-xs mx-auto"></p>
                        <p id="selected-cv-size" class="text-xs text-emerald-600 dark:text-emerald-400 font-mono font-medium"></p>
                    </div>
                    <button type="button" onclick="resetCvFileInput(event)" class="text-xs text-rose-500 hover:text-rose-600 underline font-medium">
                        Pilih Berkas Lain
                    </button>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="closeCvModal()" class="px-4 py-2.5 rounded-full text-xs font-semibold text-slate-600 dark:text-gray-300 hover:bg-slate-200/70 dark:hover:bg-white/10 transition-colors">
                    Batal
                </button>
                <button type="submit" id="btn-submit-cv" class="btn-ps-primary !py-2.5 !px-6 !text-xs !font-bold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    <span>Upload &amp; Terapkan CV</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const cvModal = document.getElementById('cv-upload-modal');
    const cvDropzone = document.getElementById('cv-dropzone');
    const cvFileInput = document.getElementById('modal_cv_file');
    const dropzoneIdle = document.getElementById('dropzone-idle');
    const dropzoneSelected = document.getElementById('dropzone-selected');
    const selectedCvName = document.getElementById('selected-cv-name');
    const selectedCvSize = document.getElementById('selected-cv-size');

    function openCvModal() {
        if (!cvModal) return;
        cvModal.classList.remove('hidden');
        cvModal.classList.add('flex');
    }

    function closeCvModal() {
        if (!cvModal) return;
        cvModal.classList.add('hidden');
        cvModal.classList.remove('flex');
    }

    // Close on backdrop click
    if (cvModal) {
        cvModal.addEventListener('click', function(e) {
            if (e.target === cvModal) {
                closeCvModal();
            }
        });
    }

    // Close on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && cvModal && !cvModal.classList.contains('hidden')) {
            closeCvModal();
        }
    });

    if (cvDropzone && cvFileInput) {
        cvDropzone.addEventListener('click', function(e) {
            if (e.target.tagName !== 'BUTTON' && !e.target.closest('button')) {
                cvFileInput.click();
            }
        });

        // Drag and drop events
        ['dragenter', 'dragover'].forEach(eventName => {
            cvDropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                cvDropzone.classList.add('border-ps-primary', 'dark:border-cyan-400', 'bg-ps-primary/5', 'dark:bg-cyan-500/10');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            cvDropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                cvDropzone.classList.remove('border-ps-primary', 'dark:border-cyan-400', 'bg-ps-primary/5', 'dark:bg-cyan-500/10');
            }, false);
        });

        cvDropzone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                cvFileInput.files = files;
                handleCvFileSelect(cvFileInput);
            }
        });
    }

    function handleCvFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            selectedCvName.textContent = file.name;
            const sizeInKb = (file.size / 1024);
            if (sizeInKb >= 1024) {
                selectedCvSize.textContent = (sizeInKb / 1024).toFixed(2) + ' MB';
            } else {
                selectedCvSize.textContent = sizeInKb.toFixed(1) + ' KB';
            }
            dropzoneIdle.classList.add('hidden');
            dropzoneSelected.classList.remove('hidden');
        }
    }

    function resetCvFileInput(event) {
        if (event) event.stopPropagation();
        if (cvFileInput) cvFileInput.value = '';
        dropzoneIdle.classList.remove('hidden');
        dropzoneSelected.classList.add('hidden');
    }

    @if($errors->has('cv_file'))
        document.addEventListener('DOMContentLoaded', function() {
            openCvModal();
        });
    @endif
</script>
@endsection

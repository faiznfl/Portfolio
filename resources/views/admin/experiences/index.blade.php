@extends('layouts.admin')

@section('title', 'Faiz Naufal Putra Permana - Manajemen Journey')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-white/10 pb-6">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-gray-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-ps-primary">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-800 dark:text-gray-200">Journey (Pengalaman)</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Linimasa Perjalanan Karier (Journey)</h1>
                <p class="text-xs text-slate-500 dark:text-gray-400">Kelola riwayat posisi, perusahaan, tanggung jawab rekayasa, dan pencapaian sistem.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.experiences.create') }}" class="btn-ps-primary !py-2.5 !px-5 !text-xs !font-bold">
                    <span>+ Tambah Pengalaman Baru</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Experiences Table -->
        <div class="ps-card-dark p-6 sm:p-8 space-y-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                    <thead class="text-xs font-mono uppercase bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                        <tr>
                            <th class="px-4 py-3">Periode</th>
                            <th class="px-4 py-3">Posisi / Role</th>
                            <th class="px-4 py-3">Perusahaan</th>
                            <th class="px-4 py-3">Lokasi</th>
                            <th class="px-4 py-3">Deskripsi / Ringkasan</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-white/5">
                        @forelse($experiences as $exp)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-4 py-3 font-mono text-xs text-slate-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $exp->start_date->format('M Y') }} — 
                                    @if($exp->is_current)
                                        <span class="text-emerald-600 dark:text-green-400 font-bold">Present</span>
                                    @else
                                        {{ $exp->end_date ? $exp->end_date->format('M Y') : '-' }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-bold text-slate-900 dark:text-white">{{ $exp->role_title }}</td>
                                <td class="px-4 py-3 text-ps-primary dark:text-cyan-400 font-medium">{{ $exp->company_name }}</td>
                                <td class="px-4 py-3 text-xs text-slate-500 dark:text-gray-400">{{ $exp->location }}</td>
                                <td class="px-4 py-3 text-xs text-slate-600 dark:text-gray-300">
                                    @php
                                        $pts = is_array($exp->description_points) ? $exp->description_points : (is_string($exp->description_points) ? json_decode($exp->description_points, true) : []);
                                    @endphp
                                    <span class="line-clamp-2">{{ $exp->summary ?: ($pts[0] ?? '-') }}</span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-3 text-xs">
                                        <a href="{{ route('admin.experiences.edit', $exp->id) }}" class="text-ps-primary hover:underline font-semibold">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.experiences.destroy', $exp->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengalaman {{ $exp->role_title }} di {{ $exp->company_name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-600 underline">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                                    Belum ada data perjalanan karier. Silakan tambahkan pengalaman baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($experiences, 'links'))
                <div class="pt-4 border-t border-slate-200 dark:border-white/10">
                    {{ $experiences->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

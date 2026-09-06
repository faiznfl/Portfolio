@extends('layouts.admin')

@section('title', 'Faiz Naufal Putra Permana - Manajemen Keahlian')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-white/10 pb-6">
            <div class="space-y-1">
                <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-gray-400">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-ps-primary">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-800 dark:text-gray-200">Keahlian (Skills)</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Katalog Keahlian &amp; Teknologi</h1>
                <p class="text-xs text-slate-500 dark:text-gray-400">Kelola daftar skill teknis, tingkat penguasaan, dan kategori yang tampil di publik.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.skills.create') }}" class="btn-ps-primary !py-2.5 !px-5 !text-xs !font-bold">
                    <span>+ Tambah Skill Baru</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Skills Table -->
        <div class="ps-card-dark p-6 sm:p-8 space-y-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                    <thead class="text-xs font-mono uppercase bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                        <tr>
                            <th class="px-4 py-3">Urutan</th>
                            <th class="px-4 py-3">Icon</th>
                            <th class="px-4 py-3">Nama Skill</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Featured</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-white/5">
                        @forelse($skills as $skill)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-4 py-3 font-mono text-xs text-slate-400">#{{ $skill->order_index }}</td>
                                <td class="px-4 py-3">
                                    <div class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-white/10 border border-slate-200 dark:border-white/10 flex items-center justify-center text-ps-primary dark:text-cyan-300 [&>svg]:w-5 [&>svg]:h-5 [&>svg]:fill-current overflow-hidden">
                                        @if(!empty($skill->icon_svg))
                                            @if(str_starts_with(trim($skill->icon_svg), '<svg') || str_starts_with(trim($skill->icon_svg), '<i '))
                                                {!! $skill->icon_svg !!}
                                            @elseif(str_starts_with(trim($skill->icon_svg), 'http') || str_starts_with(trim($skill->icon_svg), '/'))
                                                <img src="{{ $skill->icon_svg }}" alt="{{ $skill->name }}" class="w-5 h-5 object-contain">
                                            @else
                                                <span class="text-base">{{ $skill->icon_svg }}</span>
                                            @endif
                                        @else
                                            <span class="text-xs font-mono text-slate-400">⚡</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-bold text-slate-900 dark:text-white">{{ $skill->name }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2.5 py-0.5 rounded text-xs font-mono bg-slate-100 dark:bg-white/10 text-ps-primary dark:text-cyan-300 border border-slate-200 dark:border-white/10">
                                        {{ $skill->category }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($skill->is_featured)
                                        <span class="text-xs text-amber-500 dark:text-yellow-400 font-semibold">★ Ya</span>
                                    @else
                                        <span class="text-xs text-slate-400 dark:text-gray-500 font-mono">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-3 text-xs">
                                        <a href="{{ route('admin.skills.edit', $skill->id) }}" class="text-ps-primary hover:underline font-semibold">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus keahlian {{ $skill->name }}?')">
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
                                    Belum ada data skill teknis. Silakan tambahkan skill baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($skills, 'links'))
                <div class="pt-4 border-t border-slate-200 dark:border-white/10">
                    {{ $skills->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

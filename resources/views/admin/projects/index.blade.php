@extends('layouts.admin')

@section('title', 'Faiz Naufal Putra Permana - Manajemen Proyek')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Breadcrumb & Top Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-white/10 pb-6">
            <div>
                <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-gray-400 mb-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-ps-primary">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-800 dark:text-gray-200">Proyek</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Katalog Proyek</h1>
            </div>
            <div>
                <a href="{{ route('admin.projects.create') }}" class="btn-ps-primary !py-2.5 !px-5 !text-xs !font-bold">
                    <span>+ Tambah Proyek Baru</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Projects Table -->
        <div class="ps-card-dark p-6 sm:p-8 space-y-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                    <thead class="text-xs font-mono uppercase bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                        <tr>
                            <th class="px-4 py-3">Urutan</th>
                            <th class="px-4 py-3">Judul &amp; Slug</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Featured</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-white/5">
                        @forelse($projects as $project)
                            <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                <td class="px-4 py-3 font-mono text-xs text-slate-400">{{ $project->order_index }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-bold text-slate-900 dark:text-white">{{ $project->title }}</div>
                                    <div class="text-xs font-mono text-slate-400 dark:text-gray-500">{{ $project->slug }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2.5 py-0.5 rounded text-xs font-mono bg-slate-100 dark:bg-white/10 text-ps-primary dark:text-cyan-300 border border-slate-200 dark:border-white/10">{{ $project->category }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($project->is_published)
                                        <span class="inline-flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Publik
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 text-xs text-slate-400 dark:text-gray-500">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($project->is_featured)
                                        <span class="text-xs text-amber-500 dark:text-yellow-400 font-semibold">★ Ya</span>
                                    @else
                                        <span class="text-xs text-slate-400 dark:text-gray-500 font-mono">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right space-x-3 text-xs">
                                    <a href="{{ route('admin.projects.edit', $project->id) }}" class="text-ps-primary hover:underline font-semibold">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus proyek ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-600 underline">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                                    Belum ada proyek yang ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($projects, 'links'))
                <div class="p-4 border-t border-slate-200 dark:border-white/10">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

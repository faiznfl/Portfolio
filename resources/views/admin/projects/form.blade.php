@extends('layouts.admin')

@section('title', 'Faiz Naufal Putra Permana - ' . ($isEdit ? 'Edit Proyek' : 'Tambah Proyek'))

@section('content')
<div class="px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-gray-400">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-ps-primary">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.projects.index') }}" class="hover:text-ps-primary">Proyek</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-gray-200">{{ $isEdit ? 'Edit' : 'Baru' }}</span>
        </div>

        <div class="ps-card-dark p-8 sm:p-10 space-y-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                    {{ $isEdit ? 'Edit Proyek: ' . $project->title : 'Tambah Proyek Baru' }}
                </h1>
                <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">
                    Kelola informasi proyek portofolio: gambar, deskripsi, fitur utama (key features), dan tech stack.
                </p>
            </div>

            <form action="{{ $isEdit ? route('admin.projects.update', $project->id) : route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <!-- SECTION 1: Informasi Pokok -->
                <div class="space-y-5">
                    <div class="border-b border-slate-200 dark:border-white/10 pb-2">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-ps-primary dark:text-blue-400 font-mono">
                            01. Informasi Pokok &amp; Gambar
                        </h3>
                    </div>

                    <!-- Title -->
                    <div class="space-y-2">
                        <label for="title" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Judul Proyek <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required
                               placeholder="cth: OmniPulse: Commerce Engine"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                        @error('title') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Cover Image (Lewat Direktori Lokal) -->
                    <div class="space-y-4 p-5 rounded-2xl bg-slate-50/80 dark:bg-white/[0.03] border border-slate-200 dark:border-white/10">
                        <div>
                            <label class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                                Gambar Sampul Proyek (Direktori Lokal)
                            </label>
                            <p class="text-xs text-slate-500 dark:text-gray-400 mt-0.5">
                                Pilih file gambar langsung dari direktori lokal komputer Anda (mendukung .svg, .png, .jpg, .jpeg, .webp).
                            </p>
                        </div>

                        <!-- Local File Picker Box -->
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <label for="project_image" 
                                   class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-5 py-3 rounded-xl bg-ps-primary hover:bg-ps-primary/90 text-white font-medium text-xs shadow-md transition-all cursor-pointer hover:scale-[1.02] active:scale-[0.98]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <span>Pilih Berkas dari Komputer</span>
                                <input type="file" 
                                       id="project_image" 
                                       name="project_image" 
                                       accept="image/*,.svg"
                                       onchange="handleProjectFileSelect(this)" 
                                       class="hidden">
                            </label>

                            <div id="project-file-chosen-info" class="text-xs text-slate-600 dark:text-gray-400 font-mono truncate max-w-xs">
                                {{ $project->cover_image ? basename($project->cover_image) : 'Belum ada berkas baru dipilih' }}
                            </div>
                        </div>
                        @error('project_image') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                        <!-- Hidden input to retain existing or fallback path -->
                        <input type="hidden" id="cover_image" name="cover_image" value="{{ old('cover_image', $project->cover_image ?? '/assets/projects/project-omnipulse.svg') }}">

                        <!-- Quick Preset Selector from public/assets/projects -->
                        <div class="pt-2 border-t border-slate-200 dark:border-white/10 flex flex-wrap items-center gap-2">
                            <span class="text-[11px] text-slate-400 dark:text-gray-500">Atau pilih dari aset lokal yang tersedia:</span>
                            <button type="button" onclick="selectProjectLocalPreset('/assets/projects/project-omnipulse.svg', 'OmniPulse Commerce')" class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 dark:bg-white/5 hover:bg-ps-primary hover:text-white dark:hover:bg-blue-500/20 dark:hover:text-blue-300 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 hover:border-ps-primary dark:hover:border-blue-400/40 transition-all font-mono">OmniPulse</button>
                            <button type="button" onclick="selectProjectLocalPreset('/assets/projects/project-hyperion.svg', 'Hyperion K8s')" class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 dark:bg-white/5 hover:bg-ps-primary hover:text-white dark:hover:bg-blue-500/20 dark:hover:text-blue-300 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 hover:border-ps-primary dark:hover:border-blue-400/40 transition-all font-mono">Hyperion</button>
                            <button type="button" onclick="selectProjectLocalPreset('/assets/projects/project-aethermesh.svg', 'AetherMesh Service')" class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 dark:bg-white/5 hover:bg-ps-primary hover:text-white dark:hover:bg-blue-500/20 dark:hover:text-blue-300 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 hover:border-ps-primary dark:hover:border-blue-400/40 transition-all font-mono">AetherMesh</button>
                            <button type="button" onclick="selectProjectLocalPreset('/assets/projects/project-nexus.svg', 'Nexus API Gateway')" class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 dark:bg-white/5 hover:bg-ps-primary hover:text-white dark:hover:bg-blue-500/20 dark:hover:text-blue-300 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 hover:border-ps-primary dark:hover:border-blue-400/40 transition-all font-mono">Nexus</button>
                            <button type="button" onclick="selectProjectLocalPreset('/assets/projects/project-sentinel.svg', 'Sentinel Security')" class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 dark:bg-white/5 hover:bg-ps-primary hover:text-white dark:hover:bg-blue-500/20 dark:hover:text-blue-300 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 hover:border-ps-primary dark:hover:border-blue-400/40 transition-all font-mono">Sentinel</button>
                            <button type="button" onclick="selectProjectLocalPreset('/assets/projects/project-collab.svg', 'Collab Platform')" class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 dark:bg-white/5 hover:bg-ps-primary hover:text-white dark:hover:bg-blue-500/20 dark:hover:text-blue-300 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-white/10 hover:border-ps-primary dark:hover:border-blue-400/40 transition-all font-mono">Collab</button>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: Deskripsi, Fitur Utama & Tech Stack -->
                <div class="space-y-5">
                    <div class="border-b border-slate-200 dark:border-white/10 pb-2">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-ps-primary dark:text-blue-400 font-mono">
                            02. Deskripsi, Fitur Utama &amp; Tech Stack
                        </h3>
                    </div>

                    <!-- Description -->
                    <div class="space-y-2">
                        <label for="summary" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Deskripsi Proyek <span class="text-red-500">*</span>
                        </label>
                        <textarea id="summary" name="summary" rows="4" required
                                  placeholder="Jelaskan mengenai proyek ini, tujuan pembuatan, dan gambaran umum sistem..."
                                  class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">{{ old('summary', $project->summary) }}</textarea>
                        @error('summary') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Key Features -->
                    @php
                        $featuresText = '';
                        $featuresArray = !empty($project->key_features) 
                            ? (is_array($project->key_features) ? $project->key_features : json_decode($project->key_features, true)) 
                            : (!empty($project->key_metrics) ? (is_array($project->key_metrics) ? $project->key_metrics : json_decode($project->key_metrics, true)) : []);
                        if (!empty($featuresArray)) {
                            $featuresText = implode("\n", $featuresArray);
                        }
                    @endphp
                    <div class="space-y-2">
                        <label for="key_features_raw" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Fitur-Fitur Utama (Key Features - Satu per Baris)
                        </label>
                        <textarea id="key_features_raw" name="key_features_raw" rows="4"
                                  placeholder="Multi-tenant database architecture dengan isolasi data terdistribusi&#10;Asynchronous checkout pipeline bertenaga Apache Kafka&#10;Flash-sale high concurrency engine dengan Redis atomic locking&#10;Sinkronisasi inventaris multi-gudang dan analitik real-time"
                                  class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">{{ old('key_features_raw', $featuresText) }}</textarea>
                        <p class="text-[11px] text-slate-500 dark:text-gray-400">Tuliskan poin-poin fitur unggulan proyek, pisahkan dengan baris baru (tekan Enter).</p>
                        @error('key_features_raw') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tech Stacks -->
                    @php
                        $stacks = '';
                        if (!empty($project->tech_stacks)) {
                            $arr = is_array($project->tech_stacks) ? $project->tech_stacks : json_decode($project->tech_stacks, true);
                            $stacks = implode(', ', $arr ?? []);
                        }
                    @endphp
                    <div class="space-y-2">
                        <label for="tech_stacks_raw" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Tech Stack yang Digunakan (Pisahkan dengan Koma)
                        </label>
                        <input type="text" id="tech_stacks_raw" name="tech_stacks_raw" 
                               value="{{ old('tech_stacks_raw', $stacks) }}"
                               placeholder="Laravel 12, PostgreSQL, Redis Cluster, Kafka, Docker, Tailwind CSS"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                        <p class="text-[11px] text-slate-500 dark:text-gray-400">Daftar bahasa, framework, basis data, dan library yang digunakan (pisahkan dengan tanda koma).</p>
                        @error('tech_stacks_raw') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- SECTION 3: Tautan & Pengaturan -->
                <div class="space-y-5">
                    <div class="border-b border-slate-200 dark:border-white/10 pb-2">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-ps-primary dark:text-blue-400 font-mono">
                            03. Tautan Demo/Repo &amp; Status
                        </h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Demo URL -->
                        <div class="space-y-2">
                            <label for="demo_url" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                                Live Demo URL (Opsional)
                            </label>
                            <input type="url" id="demo_url" name="demo_url" value="{{ old('demo_url', $project->demo_url) }}"
                                   placeholder="https://example.com"
                                   class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                            @error('demo_url') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Repo URL -->
                        <div class="space-y-2">
                            <label for="repo_url" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                                Repository URL (Opsional)
                            </label>
                            <input type="url" id="repo_url" name="repo_url" value="{{ old('repo_url', $project->repo_url) }}"
                                   placeholder="https://github.com/username/repo"
                                   class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                            @error('repo_url') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-2">
                        <!-- Order Index -->
                        <div class="space-y-2">
                            <label for="order_index" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                                Urutan Tampilan
                            </label>
                            <input type="number" id="order_index" name="order_index" value="{{ old('order_index', $project->order_index ?? 0) }}"
                                   class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                            @error('order_index') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <!-- Is Featured -->
                        <div class="flex items-center gap-3 pt-6">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded bg-black/60 border border-white/20 text-ps-primary focus:ring-0">
                            <label for="is_featured" class="text-xs text-slate-700 dark:text-gray-300">Tampilkan di Pilihan Utama (Featured)</label>
                        </div>

                        <!-- Is Published -->
                        <div class="flex items-center gap-3 pt-6">
                            <input type="checkbox" id="is_published" name="is_published" value="1" 
                                   {{ old('is_published', $project->is_published ?? true) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded bg-black/60 border border-white/20 text-ps-primary focus:ring-0">
                            <label for="is_published" class="text-xs text-slate-700 dark:text-gray-300">Status Publikasi (Published)</label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-200 dark:border-white/10">
                    <a href="{{ route('admin.projects.index') }}" class="btn-ps-outline-dark !py-2.5 !px-5 !text-xs !bg-white/70 dark:!bg-transparent !border-slate-300 dark:!border-white/15 !text-slate-800 dark:!text-white">
                        Batal
                    </a>
                    <button type="submit" class="btn-ps-primary !py-2.5 !px-6 !text-xs">
                        <span>{{ $isEdit ? 'Simpan Perubahan' : 'Terbitkan Proyek Baru' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleProjectFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileInfo = document.getElementById('project-file-chosen-info');
            if (fileInfo) fileInfo.textContent = file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
        }
    }

    function selectProjectLocalPreset(presetPath, label) {
        const inputHidden = document.getElementById('cover_image');
        if (inputHidden) inputHidden.value = presetPath;

        const fileInfo = document.getElementById('project-file-chosen-info');
        if (fileInfo) fileInfo.textContent = 'Aset lokal: ' + label;

        // Clear any selected file input
        const fileInput = document.getElementById('project_image');
        if (fileInput) fileInput.value = '';
    }
</script>
@endsection

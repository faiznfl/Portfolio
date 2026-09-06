@extends('layouts.admin')

@section('title', 'Faiz Naufal Putra Permana - ' . ($isEdit ? 'Edit Sertifikat' : 'Tambah Sertifikat'))

@section('content')
<div class="px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-3xl mx-auto space-y-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-gray-400">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-ps-primary">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.certificates.index') }}" class="hover:text-ps-primary">Sertifikat</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-gray-200">{{ $isEdit ? 'Edit' : 'Baru' }}</span>
        </div>

        <div class="ps-card-dark p-8 sm:p-10 space-y-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                    {{ $isEdit ? 'Edit Sertifikat: ' . $certificate->certificate_name : 'Tambah Sertifikat Baru' }}
                </h1>
                <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">
                    Lengkapi informasi sertifikat (pilih berkas gambar lokal, judul, tahun terbit, lembaga penerbit, dan deskripsi).
                </p>
            </div>

            <form action="{{ $isEdit ? route('admin.certificates.update', $certificate->id) : route('admin.certificates.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data" 
                  class="space-y-6">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <!-- 1. Gambar atau Foto Sertifikat (Lewat Direktori Lokal) -->
                <div class="space-y-4 p-5 rounded-2xl bg-slate-50/80 dark:bg-white/[0.03] border border-slate-200 dark:border-white/10">
                    <div>
                        <label class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            1. Berkas Gambar / Foto Sertifikat <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-slate-500 dark:text-gray-400 mt-0.5">
                            Pilih file gambar langsung dari direktori lokal komputer Anda (mendukung .svg, .png, .jpg, .jpeg, .webp).
                        </p>
                    </div>

                    <!-- Local File Picker Box -->
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <label for="certificate_image" 
                               class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-5 py-3 rounded-xl bg-ps-primary hover:bg-ps-primary/90 text-white font-medium text-xs shadow-md transition-all cursor-pointer hover:scale-[1.02] active:scale-[0.98]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            <span>Pilih Berkas dari Komputer</span>
                            <input type="file" 
                                   id="certificate_image" 
                                   name="certificate_image" 
                                   accept="image/*,.svg"
                                   onchange="handleLocalFileSelect(this)" 
                                   class="hidden">
                        </label>

                        <div id="file-chosen-info" class="text-xs text-slate-600 dark:text-gray-400 font-mono truncate max-w-xs">
                            {{ $certificate->media_file_path ? basename($certificate->media_file_path) : 'Belum ada file baru dipilih' }}
                        </div>
                    </div>
                    @error('certificate_image') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                    <!-- Hidden input to retain existing or fallback path -->
                    <input type="hidden" id="media_file_path" name="media_file_path" value="{{ old('media_file_path', $certificate->media_file_path ?? '/assets/certificates/cert-aws-saa.svg') }}">

                    <!-- Quick Preset Selector from public/assets/certificates -->
                    <div class="pt-2 border-t border-slate-200 dark:border-white/10 flex flex-wrap items-center gap-2">
                        <span class="text-[11px] text-slate-400 dark:text-gray-500">Atau pilih dari aset lokal yang tersedia:</span>
                        <button type="button" onclick="selectLocalPreset('/assets/certificates/cert-aws-saa.svg', 'AWS Certified SAA')" class="px-2.5 py-1 rounded-lg text-xs bg-slate-200/70 dark:bg-white/10 hover:bg-ps-primary hover:text-white dark:hover:bg-cyan-400 dark:hover:text-black transition-colors font-mono">AWS</button>
                        <button type="button" onclick="selectLocalPreset('/assets/certificates/cert-terraform.svg', 'HashiCorp Terraform')" class="px-2.5 py-1 rounded-lg text-xs bg-slate-200/70 dark:bg-white/10 hover:bg-ps-primary hover:text-white dark:hover:bg-cyan-400 dark:hover:text-black transition-colors font-mono">Terraform</button>
                        <button type="button" onclick="selectLocalPreset('/assets/certificates/cert-gcp.svg', 'Google Cloud PCD')" class="px-2.5 py-1 rounded-lg text-xs bg-slate-200/70 dark:bg-white/10 hover:bg-ps-primary hover:text-white dark:hover:bg-cyan-400 dark:hover:text-black transition-colors font-mono">GCP</button>
                        <button type="button" onclick="selectLocalPreset('/assets/certificates/cert-bnsp.svg', 'BNSP Architect')" class="px-2.5 py-1 rounded-lg text-xs bg-slate-200/70 dark:bg-white/10 hover:bg-ps-primary hover:text-white dark:hover:bg-cyan-400 dark:hover:text-black transition-colors font-mono">BNSP</button>
                    </div>
                </div>

                <!-- 2. Judul Sertifikat & 3. Tahun Sertifikat -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Judul Sertifikat (Col 1 & 2) -->
                    <div class="sm:col-span-2 space-y-2">
                        <label for="certificate_name" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            2. Judul Sertifikat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="certificate_name" name="certificate_name" 
                               value="{{ old('certificate_name', $certificate->certificate_name) }}" required
                               placeholder="cth: AWS Certified Solutions Architect – Associate"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                        @error('certificate_name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tahun Sertifikat (Col 3) -->
                    <div class="sm:col-span-1 space-y-2">
                        <label for="issue_year" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            3. Tahun Sertifikat <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="issue_year" name="issue_year" 
                               min="2000" max="2099" step="1"
                               value="{{ old('issue_year', $certificate->issue_date ? $certificate->issue_date->format('Y') : date('Y')) }}" required
                               placeholder="2026"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary font-mono text-center">
                        @error('issue_date') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        @error('issue_year') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- 4. Lembaga / Organisasi Penerbit -->
                <div class="space-y-2">
                    <label for="issuer_organization" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                        4. Lembaga / Platform Penerbit <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="issuer_organization" name="issuer_organization" 
                           value="{{ old('issuer_organization', $certificate->issuer_organization ?? 'Amazon Web Services (AWS)') }}" required
                           placeholder="cth: Amazon Web Services (AWS), Dicoding, Coursera, Udemy"
                           class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                    @error('issuer_organization') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- 5. Kategori Sertifikat -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <label for="category" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            5. Kategori Sertifikat
                        </label>
                        <span class="text-[11px] text-slate-400 dark:text-gray-500">Ketik kustom atau klik pilihan preset di bawah</span>
                    </div>
                    <input type="text" id="category" name="category" 
                           value="{{ old('category', $certificate->category) }}"
                           placeholder="cth: Prompt Engineering, Artificial Intelligence Basic"
                           class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary font-medium">
                    
                    <!-- Preset Capsule Chips matching user image -->
                    <div class="flex flex-wrap items-center gap-2 pt-1">
                        <button type="button" 
                                onclick="toggleCategoryPreset('Prompt Engineering')" 
                                class="category-preset-btn px-4 py-1.5 rounded-full text-xs font-medium bg-slate-200/90 hover:bg-slate-300 dark:bg-[#151926] dark:hover:bg-[#1e2336] text-slate-800 dark:text-gray-200 border border-slate-300/90 dark:border-white/15 hover:border-ps-primary dark:hover:border-cyan-400 transition-all cursor-pointer shadow-xs select-none">
                            Prompt Engineering
                        </button>
                        <button type="button" 
                                onclick="toggleCategoryPreset('Artificial Intelligence Basic')" 
                                class="category-preset-btn px-4 py-1.5 rounded-full text-xs font-medium bg-slate-200/90 hover:bg-slate-300 dark:bg-[#151926] dark:hover:bg-[#1e2336] text-slate-800 dark:text-gray-200 border border-slate-300/90 dark:border-white/15 hover:border-ps-primary dark:hover:border-cyan-400 transition-all cursor-pointer shadow-xs select-none">
                            Artificial Intelligence Basic
                        </button>
                        <button type="button" 
                                onclick="toggleCategoryPreset('Cloud & Architecture')" 
                                class="category-preset-btn px-4 py-1.5 rounded-full text-xs font-medium bg-slate-200/90 hover:bg-slate-300 dark:bg-[#151926] dark:hover:bg-[#1e2336] text-slate-800 dark:text-gray-200 border border-slate-300/90 dark:border-white/15 hover:border-ps-primary dark:hover:border-cyan-400 transition-all cursor-pointer shadow-xs select-none">
                            Cloud &amp; Architecture
                        </button>
                        <button type="button" 
                                onclick="toggleCategoryPreset('DevOps & Infrastructure')" 
                                class="category-preset-btn px-4 py-1.5 rounded-full text-xs font-medium bg-slate-200/90 hover:bg-slate-300 dark:bg-[#151926] dark:hover:bg-[#1e2336] text-slate-800 dark:text-gray-200 border border-slate-300/90 dark:border-white/15 hover:border-ps-primary dark:hover:border-cyan-400 transition-all cursor-pointer shadow-xs select-none">
                            DevOps &amp; Infrastructure
                        </button>
                        <button type="button" 
                                onclick="toggleCategoryPreset('Software Engineering')" 
                                class="category-preset-btn px-4 py-1.5 rounded-full text-xs font-medium bg-slate-200/90 hover:bg-slate-300 dark:bg-[#151926] dark:hover:bg-[#1e2336] text-slate-800 dark:text-gray-200 border border-slate-300/90 dark:border-white/15 hover:border-ps-primary dark:hover:border-cyan-400 transition-all cursor-pointer shadow-xs select-none">
                            Software Engineering
                        </button>
                    </div>
                    @error('category') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- 6. Keterangan atau Deskripsinya -->
                <div class="space-y-2">
                    <label for="description" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                        6. Keterangan atau Deskripsi Sertifikat
                    </label>
                    <textarea id="description" name="description" rows="4"
                              placeholder="Keterangan materi keahlian, topik yang dikuasai, atau catatan penting sertifikat..."
                              class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">{{ old('description', $certificate->description) }}</textarea>
                    @error('description') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-200 dark:border-white/10">
                    <a href="{{ route('admin.certificates.index') }}" class="btn-ps-outline-dark !py-2.5 !px-5 !text-xs !bg-white/70 dark:!bg-transparent !border-slate-300 dark:!border-white/15 !text-slate-800 dark:!text-white">
                        Batal
                    </a>
                    <button type="submit" class="btn-ps-primary !py-2.5 !px-6 !text-xs">
                        <span>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Sertifikat Baru' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function handleLocalFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileInfo = document.getElementById('file-chosen-info');
            if (fileInfo) fileInfo.textContent = file.name + ' (' + Math.round(file.size / 1024) + ' KB)';
        }
    }

    function selectLocalPreset(presetPath, label) {
        const inputHidden = document.getElementById('media_file_path');
        if (inputHidden) inputHidden.value = presetPath;

        const fileInfo = document.getElementById('file-chosen-info');
        if (fileInfo) fileInfo.textContent = 'Aset lokal: ' + label;

        // Clear any selected file input
        const fileInput = document.getElementById('certificate_image');
        if (fileInput) fileInput.value = '';
    }

    function toggleCategoryPreset(cat) {
        const input = document.getElementById('category');
        if (!input) return;
        let existing = input.value ? input.value.split(',').map(s => s.trim()).filter(Boolean) : [];
        if (existing.includes(cat)) {
            existing = existing.filter(item => item !== cat);
        } else {
            existing.push(cat);
        }
        input.value = existing.join(', ');
        updatePresetButtonStyles();
    }

    function updatePresetButtonStyles() {
        const input = document.getElementById('category');
        if (!input) return;
        const activeTags = input.value ? input.value.split(',').map(s => s.trim()).filter(Boolean) : [];
        document.querySelectorAll('.category-preset-btn').forEach(btn => {
            const text = btn.textContent.trim();
            if (activeTags.includes(text)) {
                btn.classList.add('!bg-ps-primary', '!text-white', '!border-ps-primary', 'dark:!bg-cyan-400', 'dark:!text-black', 'dark:!border-cyan-400', 'font-semibold');
            } else {
                btn.classList.remove('!bg-ps-primary', '!text-white', '!border-ps-primary', 'dark:!bg-cyan-400', 'dark:!text-black', 'dark:!border-cyan-400', 'font-semibold');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        updatePresetButtonStyles();
        const catInput = document.getElementById('category');
        if (catInput) {
            catInput.addEventListener('input', updatePresetButtonStyles);
        }
    });
</script>
@endsection

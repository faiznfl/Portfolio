@extends('layouts.admin')

@section('title', 'Faiz Naufal Putra Permana - ' . ($isEdit ? 'Edit Keahlian' : 'Tambah Keahlian'))

@section('content')
<div class="px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-gray-400">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-ps-primary">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.skills.index') }}" class="hover:text-ps-primary">Keahlian</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-gray-200">{{ $isEdit ? 'Edit' : 'Baru' }}</span>
        </div>

        <div class="ps-card-dark p-8 sm:p-10 space-y-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                    {{ $isEdit ? 'Edit Keahlian: ' . $skill->name : 'Tambah Keahlian & Teknologi Baru' }}
                </h1>
                <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Lengkapi informasi teknologi dan pilih icon yang sesuai untuk ditampilkan pada showcase portofolio.</p>
            </div>

            <form action="{{ $isEdit ? route('admin.skills.update', $skill->id) : route('admin.skills.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="skill-form">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <!-- Hidden proficiency_level (retained for database compatibility, hidden from UI) -->
                <input type="hidden" id="proficiency_level" name="proficiency_level" value="{{ old('proficiency_level', $skill->proficiency_level ?? 100) }}">

                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                        Nama Teknologi / Skill <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $skill->name) }}" required
                           placeholder="cth: Docker, PostgreSQL, Laravel, Go, TypeScript"
                           class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                    @error('name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- ICON UPLOAD SECTION -->
                <div class="p-5 sm:p-6 rounded-2xl bg-slate-50/80 dark:bg-white/[0.03] border border-slate-200 dark:border-white/10 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">
                                Icon / Visual Keahlian (Upload File SVG)
                            </label>
                            <p class="text-xs text-slate-500 dark:text-gray-400 mt-0.5">
                                Unggah berkas vektor icon berformat <strong class="text-ps-primary dark:text-blue-400">.svg</strong> langsung dari komputer Anda.
                            </p>
                        </div>
                        <button type="button" id="btn-clear-icon" class="text-xs text-rose-500 hover:text-rose-600 font-medium underline self-start sm:self-auto">
                            Hapus Icon
                        </button>
                    </div>

                    <!-- Live Preview and File Dropzone -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 pt-1">
                        <!-- Live Preview Box -->
                        <div class="flex flex-col items-center gap-1.5 flex-shrink-0">
                            <div id="icon-preview-box" class="w-20 h-20 rounded-2xl bg-slate-200/80 dark:bg-white/10 border border-slate-300 dark:border-white/15 flex items-center justify-center text-3xl text-ps-primary dark:text-blue-400 shadow-inner overflow-hidden transition-all duration-200">
                                <span id="icon-preview-placeholder" class="text-xs font-mono text-slate-400 font-bold">&lt;/&gt;</span>
                            </div>
                            <span class="text-[10px] font-mono text-slate-400 uppercase tracking-wider">Preview Icon</span>
                        </div>

                        <!-- Dropzone & File Picker Box -->
                        <div class="flex-1 w-full space-y-2">
                            <label for="icon_svg_file"
                                   id="dropzone"
                                   class="group relative flex flex-col sm:flex-row items-center justify-between gap-4 p-4 rounded-xl border-2 border-dashed border-slate-300 dark:border-white/20 hover:border-ps-primary dark:hover:border-blue-400/60 bg-white dark:bg-black/40 hover:bg-slate-50 dark:hover:bg-white/[0.04] transition-all cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-ps-primary/10 dark:bg-blue-500/10 text-ps-primary dark:text-blue-400 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-xs font-semibold text-slate-900 dark:text-white group-hover:text-ps-primary dark:group-hover:text-blue-300 transition-colors">
                                            Pilih Berkas SVG dari Komputer
                                        </div>
                                        <div class="text-[11px] text-slate-500 dark:text-gray-400">
                                            Klik untuk telusuri berkas atau seret berkas SVG ke sini (maks. 2MB)
                                        </div>
                                    </div>
                                </div>
                                <span class="px-3.5 py-1.5 rounded-lg text-xs font-medium text-white bg-ps-primary hover:bg-ps-primary/90 shadow-sm flex-shrink-0 pointer-events-none">
                                    Telusuri...
                                </span>
                                <input type="file"
                                       id="icon_svg_file"
                                       name="icon_svg_file"
                                       accept=".svg,image/svg+xml"
                                       class="hidden">
                            </label>

                            <!-- Chosen File Information -->
                            <div class="flex items-center justify-between px-1 text-xs">
                                <span id="file-name-info" class="font-mono text-slate-500 dark:text-gray-400 truncate max-w-sm">
                                    {{ $skill->icon_svg ? 'Icon saat ini telah terpasang' : 'Belum ada berkas SVG dipilih' }}
                                </span>
                                <span id="icon-type-indicator" class="font-mono text-[11px] text-ps-primary dark:text-blue-300"></span>
                            </div>

                            @error('icon_svg_file') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                            @error('icon_svg') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                            <!-- Hidden field to retain existing icon string if no new file is picked -->
                            <input type="hidden" id="icon_svg" name="icon_svg" value="{{ old('icon_svg', $skill->icon_svg) }}">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Order Index -->
                    <div class="space-y-2">
                        <label for="order_index" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Urutan Tampilan
                        </label>
                        <input type="number" id="order_index" name="order_index"
                               value="{{ old('order_index', $skill->order_index ?? 0) }}"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                        @error('order_index') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Featured Toggle -->
                    <div class="flex items-center gap-3 pt-6 sm:pt-7">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1"
                               {{ old('is_featured', $skill->is_featured) ? 'checked' : '' }}
                               class="w-4 h-4 rounded bg-black/60 border border-white/20 text-ps-primary focus:ring-0">
                        <label for="is_featured" class="text-xs text-slate-700 dark:text-gray-300 font-medium">
                            Tampilkan sebagai Skill Unggulan (*Featured Core Competency*)
                        </label>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-200 dark:border-white/10">
                    <a href="{{ route('admin.skills.index') }}" class="btn-ps-outline-dark !py-2.5 !px-5 !text-xs !bg-white/70 dark:!bg-transparent !border-slate-300 dark:!border-white/15 !text-slate-800 dark:!text-white">
                        Batal
                    </a>
                    <button type="submit" class="btn-ps-primary !py-2.5 !px-6 !text-xs">
                        <span>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Skill Baru' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('icon_svg_file');
    const hiddenIconInput = document.getElementById('icon_svg');
    const previewBox = document.getElementById('icon-preview-box');
    const btnClearIcon = document.getElementById('btn-clear-icon');
    const fileNameInfo = document.getElementById('file-name-info');
    const iconTypeIndicator = document.getElementById('icon-type-indicator');
    const nameInput = document.getElementById('name');
    const dropzone = document.getElementById('dropzone');

    function updatePreview(value) {
        const val = (value || '').trim();
        if (!val) {
            previewBox.innerHTML = '<span id="icon-preview-placeholder" class="text-xs font-mono text-slate-400 font-bold">&lt;/&gt;</span>';
            iconTypeIndicator.textContent = '';
            return;
        }

        if (val.startsWith('<svg') || val.startsWith('<i ') || val.includes('<svg')) {
            const svgStart = val.indexOf('<svg');
            const svgContent = svgStart !== -1 ? val.substring(svgStart) : val;
            previewBox.innerHTML = `<div class="w-10 h-10 inline-flex items-center justify-center text-ps-primary dark:text-blue-400 [&>svg]:w-9 [&>svg]:h-9 [&>svg]:max-w-full [&>svg]:max-h-full">${svgContent}</div>`;
            iconTypeIndicator.textContent = 'Format: Vektor SVG';
        } else if (val.startsWith('http://') || val.startsWith('https://') || val.startsWith('/') || val.endsWith('.svg') || val.endsWith('.png')) {
            previewBox.innerHTML = `<img src="${val}" alt="Icon Preview" class="w-10 h-10 object-contain" />`;
            iconTypeIndicator.textContent = 'Format: Berkas SVG';
        } else {
            previewBox.innerHTML = `<span class="text-3xl">${val}</span>`;
            iconTypeIndicator.textContent = 'Format: Simbol / Icon';
        }
    }

    function handleFile(file) {
        if (!file) return;

        const isSvg = file.type === 'image/svg+xml' || file.name.toLowerCase().endsWith('.svg');
        if (!isSvg) {
            alert('Silakan pilih berkas vektor berformat SVG (.svg).');
            fileInput.value = '';
            return;
        }

        const sizeKb = (file.size / 1024).toFixed(1);
        fileNameInfo.textContent = `${file.name} (${sizeKb} KB)`;
        fileNameInfo.className = 'font-mono text-emerald-600 dark:text-emerald-400 truncate max-w-sm font-semibold';

        const reader = new FileReader();
        reader.onload = function(e) {
            const content = e.target.result;
            hiddenIconInput.value = content;
            updatePreview(content);

            // Auto-fill skill name from filename if name input is empty
            if (!nameInput.value.trim()) {
                const baseName = file.name.replace(/\.[^/.]+$/, '').replace(/[-_]/g, ' ');
                nameInput.value = baseName.replace(/\b\w/g, l => l.toUpperCase());
            }
        };
        reader.readAsText(file);
    }

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                handleFile(this.files[0]);
            }
        });
    }

    if (dropzone) {
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.add('border-ps-primary', 'bg-ps-primary/5');
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, function(e) {
                e.preventDefault();
                e.stopPropagation();
                dropzone.classList.remove('border-ps-primary', 'bg-ps-primary/5');
            }, false);
        });

        dropzone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt ? dt.files : null;
            if (files && files[0]) {
                fileInput.files = files;
                handleFile(files[0]);
            }
        });
    }

    if (btnClearIcon) {
        btnClearIcon.addEventListener('click', function() {
            if (fileInput) fileInput.value = '';
            hiddenIconInput.value = '';
            updatePreview('');
            fileNameInfo.textContent = 'Belum ada berkas SVG dipilih';
            fileNameInfo.className = 'font-mono text-slate-500 dark:text-gray-400 truncate max-w-sm';
        });
    }

    // Initial render for edit mode or old input
    updatePreview(hiddenIconInput.value);
});
</script>
@endsection

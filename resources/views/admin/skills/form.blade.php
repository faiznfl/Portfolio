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

            <form action="{{ $isEdit ? route('admin.skills.update', $skill->id) : route('admin.skills.store') }}" method="POST" class="space-y-6" id="skill-form">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <!-- Hidden proficiency_level (retained for database compatibility, hidden from UI) -->
                <input type="hidden" id="proficiency_level" name="proficiency_level" value="{{ old('proficiency_level', $skill->proficiency_level ?? 100) }}">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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

                    <!-- Category -->
                    <div class="space-y-2">
                        <label for="category" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="category" name="category" list="skill-category-options" required
                               value="{{ old('category', $skill->category) }}"
                               placeholder="Pilih atau ketik kategori baru (cth: Frontend, UI/UX, Backend)"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                        <datalist id="skill-category-options">
                            <option value="Languages">
                            <option value="Frontend">
                            <option value="Backend">
                            <option value="UI/UX Design">
                            <option value="Databases">
                            <option value="DevOps">
                            <option value="Tools">
                        </datalist>
                        @error('category') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- ICON SELECTION SECTION -->
                <div class="p-5 rounded-2xl bg-slate-50 dark:bg-white/[0.02] border border-slate-200 dark:border-white/10 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white">
                                Icon / Visual Keahlian
                            </label>
                            <p class="text-xs text-slate-500 dark:text-gray-400 mt-0.5">
                                Pilih dari rekomendasi icon per kategori di bawah, atau masukkan kode SVG / emoji kustom.
                            </p>
                        </div>
                        <button type="button" id="btn-clear-icon" class="text-xs text-rose-500 hover:text-rose-600 font-medium underline self-start sm:self-auto">
                            Hapus Icon
                        </button>
                    </div>

                    <!-- Live Preview and Custom Input -->
                    <div class="flex flex-col sm:flex-row items-center gap-4 pt-1">
                        <!-- Live Preview Box -->
                        <div class="flex flex-col items-center gap-1.5 flex-shrink-0">
                            <div id="icon-preview-box" class="w-16 h-16 rounded-2xl bg-slate-200/80 dark:bg-white/10 border border-slate-300 dark:border-white/15 flex items-center justify-center text-2xl text-ps-primary dark:text-cyan-400 shadow-inner overflow-hidden transition-all duration-200">
                                <span id="icon-preview-placeholder" class="text-xs font-mono text-slate-400 font-bold">&lt;/&gt;</span>
                            </div>
                            <span class="text-[10px] font-mono text-slate-400 uppercase tracking-wider">Preview</span>
                        </div>

                        <!-- Manual/Active Icon Input Field -->
                        <div class="flex-1 w-full space-y-1.5">
                            <input type="text" id="icon_svg" name="icon_svg" value="{{ old('icon_svg', $skill->icon_svg) }}"
                                   placeholder="Pilih icon preset di bawah atau ketik emoji / kode <svg ...>"
                                   class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-black/60 border border-slate-300 dark:border-white/20 text-slate-900 dark:text-white text-xs font-mono focus:outline-none focus:border-ps-primary">
                            <div class="flex items-center justify-between text-[11px] text-slate-400">
                                <span>Mendukung: Vektor SVG, Emoji (🐘, ⚛️, 🐳), atau URL gambar.</span>
                                <span id="icon-type-indicator" class="font-mono text-ps-primary"></span>
                            </div>
                            @error('icon_svg') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Category Filter Tabs for Presets -->
                    <div class="pt-3 border-t border-slate-200 dark:border-white/10 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold text-slate-700 dark:text-gray-300">
                                Rekomendasi Icon: <span id="active-category-label" class="text-ps-primary dark:text-cyan-300 font-bold">Languages</span>
                            </span>
                            <div class="flex items-center gap-1 text-xs">
                                <button type="button" id="tab-auto" class="px-2.5 py-1 rounded-lg text-[11px] font-medium bg-ps-primary/15 text-ps-primary dark:text-cyan-300 border border-ps-primary/30">
                                    Sesuai Kategori
                                </button>
                                <button type="button" id="tab-all" class="px-2.5 py-1 rounded-lg text-[11px] font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white">
                                    Semua Icon
                                </button>
                            </div>
                        </div>

                        <!-- Preset Icons Grid Container -->
                        <div id="presets-container" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2.5 max-h-56 overflow-y-auto p-1.5 rounded-xl bg-white/60 dark:bg-black/30 border border-slate-200/80 dark:border-white/5">
                            <!-- Preset items rendered by JS -->
                        </div>

                        <!-- Quick Emoji Presets -->
                        <div class="flex flex-wrap items-center gap-1.5 pt-2">
                            <span class="text-[11px] font-mono text-slate-400 mr-1">Emoji Cepat:</span>
                            @foreach(['🐘', '🔥', '⚛️', '🐬', '🐳', '⚡', '🐍', '📜', '🎨', '☁️', '🔄', '🔌', '📨', '🤖', '💻'] as $emoji)
                                <button type="button" class="btn-emoji-preset w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 dark:bg-white/5 dark:hover:bg-white/15 border border-slate-200 dark:border-white/10 flex items-center justify-center text-sm transition-transform active:scale-90" data-emoji="{{ $emoji }}">
                                    {{ $emoji }}
                                </button>
                            @endforeach
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
    const categorySelect = document.getElementById('category');
    const iconInput = document.getElementById('icon_svg');
    const previewBox = document.getElementById('icon-preview-box');
    const presetsContainer = document.getElementById('presets-container');
    const activeCategoryLabel = document.getElementById('active-category-label');
    const tabAuto = document.getElementById('tab-auto');
    const tabAll = document.getElementById('tab-all');
    const btnClearIcon = document.getElementById('btn-clear-icon');
    const iconTypeIndicator = document.getElementById('icon-type-indicator');
    const nameInput = document.getElementById('name');

    let showAll = false;

    // Curated SVG presets per category
    const presets = [
        // Languages
        { name: 'PHP', category: 'Languages', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 3C6.48 3 2 7.03 2 12s4.48 9 10 9 10-4.03 10-9-4.48-9-10-9zm-3.2 12.5H7.2l.6-3.6H6.1c-1.2 0-2.1-.9-2.1-2.1s.9-2.1 2.1-2.1h3.3l-1.6 7.8zm7.5 0h-1.6l.6-3.6h-1.7c-1.2 0-2.1-.9-2.1-2.1s.9-2.1 2.1-2.1h3.3l-1.6 7.8zm4.2-3.8c-.3 2.1-2.1 3.8-4.2 3.8h-1.6l1.6-7.8h1.6c2.1 0 3.9 1.7 3.6 4z"/></svg>' },
        { name: 'JavaScript', category: 'Languages', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><rect width="20" height="20" x="2" y="2" rx="4" fill="#F7DF1E"/><path d="M7 16.5c.7.4 1.5.7 2.3.7 1.3 0 2.1-.7 2.1-1.7v-5h-2.1v5c0 .4-.3.6-.7.6-.4 0-.8-.2-1.1-.4l-.5 1.4zm6.7.2c1 .5 2.1.8 3.1.8 2.3 0 3.7-1.2 3.7-3.1 0-1.7-1.1-2.5-2.7-3.2-.9-.4-1.3-.8-1.3-1.4 0-.6.5-1.1 1.4-1.1.8 0 1.6.3 2.2.7l.6-1.5c-.7-.4-1.7-.7-2.8-.7-2.2 0-3.5 1.3-3.5 3 0 1.6 1 2.4 2.5 3 1 .4 1.5.8 1.5 1.5 0 .8-.7 1.3-1.7 1.3-1 0-1.9-.4-2.5-.9l-.5 1.5z" fill="#000"/></svg>' },
        { name: 'TypeScript', category: 'Languages', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><rect width="20" height="20" x="2" y="2" rx="4" fill="#3178C6"/><path d="M6 10.5h6v1.8H9.9v6.2H7.8v-6.2H6v-1.8zm8.7 6.2c.9.5 2 .8 3 .8 2.2 0 3.5-1.2 3.5-2.9 0-1.6-1-2.4-2.5-3-.9-.4-1.4-.7-1.4-1.3 0-.6.5-1 1.3-1 .8 0 1.5.3 2.1.7l.6-1.5c-.7-.4-1.6-.7-2.7-.7-2.1 0-3.4 1.2-3.4 2.8 0 1.5 1 2.3 2.4 2.9.9.4 1.4.7 1.4 1.4 0 .7-.6 1.2-1.6 1.2-1 0-1.8-.4-2.4-.8l-.7 1.4z" fill="#FFF"/></svg>' },
        { name: 'Python', category: 'Languages', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M11.9 2C8.5 2 6.5 3.5 6.5 5.7v1.8h5.6v.7H4.3C2.1 8.2 1 10.3 1 12.6c0 2.4 1.4 4.3 3.3 4.3h1.8v-2.5c0-2.3 1.9-4.2 4.2-4.2h5.6c1.9 0 3.5-1.6 3.5-3.5V5.7C19.4 3.5 17.4 2 11.9 2zm-1.8 1.8c.6 0 1.1.5 1.1 1.1s-.5 1.1-1.1 1.1-1.1-.5-1.1-1.1.5-1.1 1.1-1.1zm3.8 18.2c3.4 0 5.4-1.5 5.4-3.7v-1.8h-5.6v-.7h7.8c2.2 0 3.3-2.1 3.3-4.4 0-2.4-1.4-4.3-3.3-4.3h-1.8v2.5c0 2.3-1.9 4.2-4.2 4.2H9.8c-1.9 0-3.5 1.6-3.5 3.5v1c0 2.2 2 3.7 7.5 3.7zm1.8-1.8c-.6 0-1.1-.5-1.1-1.1s.5-1.1 1.1-1.1 1.1.5 1.1 1.1-.5 1.1-1.1 1.1z"/></svg>' },
        { name: 'Go (Golang)', category: 'Languages', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M1.5 10.5c.3-1.8 1.6-3.2 3.8-3.2 2.7 0 4.2 1.8 4.2 4.5 0 2.8-1.6 4.7-4.4 4.7-2.6 0-4.1-1.8-4.1-4.4 0-.6.1-1.1.5-1.6zm4.8 1.4c0-1.8-.8-2.9-2.2-2.9-1.2 0-2 1-2 2.8 0 1.7.8 2.8 2 2.8 1.4 0 2.2-1 2.2-2.7zm10.2 1.3h-3.4v-1.6h5.3c0 3.3-2 5-4.9 5-3.3 0-5.2-2.2-5.2-5.2 0-3.1 2-5.2 5.3-5.2 2.8 0 4.6 1.7 4.7 3.8h-1.9c-.2-1.3-1.2-2.2-2.8-2.2-2 0-3.2 1.4-3.2 3.6 0 2.1 1.2 3.6 3.2 3.6 1.7 0 2.7-.9 2.9-2.3z"/></svg>' },
        { name: 'Rust', category: 'Languages', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M21.5 12a9.5 9.5 0 01-1.2 4.6l1.4 1.1-.9 1.5-1.7-.6c-.9.9-2 1.7-3.2 2.1l.3 1.8h-1.8l-.5-1.7a9.7 9.7 0 01-3.8 0l-.5 1.7H7.8l.3-1.8c-1.2-.4-2.3-1.2-3.2-2.1l-1.7.6-.9-1.5 1.4-1.1A9.5 9.5 0 012.5 12c0-1.6.4-3.2 1.2-4.6L2.3 6.3l.9-1.5 1.7.6c.9-.9 2-1.7 3.2-2.1L7.8 1.5h1.8l.5 1.7c1.2-.2 2.5-.2 3.8 0l.5-1.7h1.8l-.3 1.8c1.2.4 2.3 1.2 3.2 2.1l1.7-.6.9 1.5-1.4 1.1c.8 1.4 1.2 3 1.2 4.6zm-11-4h3a3 3 0 011.5 5.6L16.5 16h-2.3l-1.2-2H10.5v2H8.5V8h2zm0 4h1.5a1.2 1.2 0 100-2.4H10.5V12z"/></svg>' },
        { name: 'HTML5', category: 'Languages', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M3 2l1.6 18.2L12 22l7.4-1.8L21 2H3zm14.7 5.4H9.4l.2 2.2h7.8l-.6 6.5-4.8 1.3-4.8-1.3-.3-3.7H9l.2 1.8 2.8.8 2.8-.8.3-3.2H6.7L6 4.3h12l-.3 3.1z"/></svg>' },
        { name: 'CSS3', category: 'Languages', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M3 2l1.6 18.2L12 22l7.4-1.8L21 2H3zm14.6 4.5l-.2 2.2H9.2l.2 2.2h7.6l-.6 6.5-4.4 1.2-4.4-1.2-.3-3.5H9l.2 1.8 2.8.8 2.8-.8.3-3.2H6.6l-.6-6H17.6z"/></svg>' },

        // Backend
        { name: 'Laravel', category: 'Backend', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M19.8 6.5l-6.9-4a1.8 1.8 0 00-1.8 0l-6.9 4A1.8 1.8 0 003.3 8v8a1.8 1.8 0 00.9 1.5l6.9 4c.6.3 1.2.3 1.8 0l6.9-4a1.8 1.8 0 00.9-1.5V8a1.8 1.8 0 00-.9-1.5zM12 4.1l5.5 3.2-2.5 1.5L9.5 5.6 12 4.1zm-1 15.8l-5.5-3.2V10.3l5.5 3.2v6.4zm1-8.1L6.5 8.6 9 7.1l5.5 3.2-2.5 1.5zm6.5 4.9l-5.5 3.2v-6.4l2.5-1.5v2.8l3-1.8v3.7z"/></svg>' },
        { name: 'Node.js', category: 'Backend', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 2l9.5 5.5v11L12 24l-9.5-5.5v-11L12 2zm0 2.3L4.5 8.6v8.8L12 21.7l7.5-4.3V8.6L12 4.3zm0 3.2a4.5 4.5 0 014.5 4.5c0 2.5-2 4.5-4.5 4.5S7.5 14.5 7.5 12s2-4.5 4.5-4.5z"/></svg>' },
        { name: 'NestJS', category: 'Backend', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 2L2 7l10 5 10-5-10-5zm-8 7.5v6.5l8 4 8-4V9.5l-8 4-8-4z"/></svg>' },
        { name: 'FastAPI', category: 'Backend', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 2L3 14h7l-2 8 11-12h-7l3-8z"/></svg>' },
        { name: 'GraphQL', category: 'Backend', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 2l8.66 5v10L12 22l-8.66-5V7L12 2zm0 2.3L5.34 8v8L12 19.7 18.66 16V8L12 4.3zM12 7a2 2 0 110 4 2 2 0 010-4zm-4 6a2 2 0 110 4 2 2 0 010-4zm8 0a2 2 0 110 4 2 2 0 010-4z"/></svg>' },
        { name: 'REST & gRPC', category: 'Backend', svg: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>' },
        { name: 'Apache Kafka', category: 'Backend', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 3a4 4 0 100 8 4 4 0 000-8zm-7 9a3.5 3.5 0 100 7 3.5 3.5 0 000-7zm14 0a3.5 3.5 0 100 7 3.5 3.5 0 000-7zM12 11l-5 3m5-3l5 3"/></svg>' },

        // Frontend
        { name: 'React', category: 'Frontend', svg: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><ellipse cx="12" cy="12" rx="10" ry="4.5" transform="rotate(0 12 12)"/><ellipse cx="12" cy="12" rx="10" ry="4.5" transform="rotate(60 12 12)"/><ellipse cx="12" cy="12" rx="10" ry="4.5" transform="rotate(120 12 12)"/><circle cx="12" cy="12" r="2" fill="currentColor"/></svg>' },
        { name: 'Next.js', category: 'Frontend', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm3.8 14.5l-6.2-8.3v8.3H7.5V7.5h2.3l6.2 8.3V7.5h2.1v9h-2.3z"/></svg>' },
        { name: 'Vue.js', category: 'Frontend', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M2 3h3.5L12 14.2 18.5 3H22L12 21 2 3zm4.5 0h3.5L12 6.8 14 3h3.5L12 12.5 6.5 3z"/></svg>' },
        { name: 'Tailwind CSS', category: 'Frontend', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 6c-2.7 0-4.3 1.3-5 4 .9-1.3 2-1.9 3.3-1.6 1 .2 1.7.9 2.5 1.7C14.1 11.4 15.6 13 19 13c2.7 0 4.3-1.3 5-4-.9 1.3-2 1.9-3.3 1.6-1-.2-1.7-.9-2.5-1.7C16.9 7.6 15.4 6 12 6zM5 13c-2.7 0-4.3 1.3-5 4 .9-1.3 2-1.9 3.3-1.6 1 .2 1.7.9 2.5 1.7C7.1 18.4 8.6 20 12 20c2.7 0 4.3-1.3 5-4-.9 1.3-2 1.9-3.3 1.6-1-.2-1.7-.9-2.5-1.7C9.9 14.6 8.4 13 5 13z"/></svg>' },
        { name: 'Vite', category: 'Frontend', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M20.9 3.3L12.7 22a.8.8 0 01-1.4 0L3.1 3.3a.8.8 0 01.9-1.1l8 1.6 8-1.6a.8.8 0 01.9 1.1zm-8.9 2.5L7.2 4.8l4.4 10.2.4-9.2zm1 0l-.4 9.2 4.4-10.2-4 1z"/></svg>' },

        // Databases
        { name: 'PostgreSQL', category: 'Databases', svg: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><ellipse cx="12" cy="6" rx="8" ry="3"/><path d="M4 6v6c0 1.66 3.58 3 8 3s8-1.34 8-3V6"/><path d="M4 12v6c0 1.66 3.58 3 8 3s8-1.34 8-3v-6"/></svg>' },
        { name: 'MySQL', category: 'Databases', svg: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><rect x="3" y="4" width="18" height="16" rx="3"/><path d="M3 10h18M8 15h2m4 0h2"/></svg>' },
        { name: 'Redis', category: 'Databases', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 2L2 7l10 5 10-5-10-5zm0 8L2 15l10 5 10-5-10-5zm0 7l-8-4 8 4 8-4-8 4z"/></svg>' },
        { name: 'MongoDB', category: 'Databases', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 2C11.5 2 7 8.5 7 14c0 3.3 2.2 6.1 5 7.6 2.8-1.5 5-4.3 5-7.6 0-5.5-4.5-12-5-12zm0 18.5c-.3 0-.5-.1-.7-.2V4.8C13 8 15.5 12 15.5 14c0 2.5-1.6 4.6-3.5 4.5z"/></svg>' },
        { name: 'Elasticsearch', category: 'Databases', svg: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><circle cx="11" cy="11" r="7"/><path stroke-linecap="round" d="M16.5 16.5L21 21M8 11h6m-3-3v6"/></svg>' },

        // DevOps
        { name: 'Docker', category: 'DevOps', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M22.5 10.5c-.3-.2-1.5-.3-2.5.3-.2-.7-.7-1.3-1.4-1.8l-.8-.5-.5.8c-.5.8-.6 1.7-.3 2.6-1 .6-2.5.7-4.3.7H2v3c0 2.8 2.2 5 5 5 5.5 0 9.8-3.4 11.2-8.4 1.3.1 2.9-.3 4.3-1.7zm-14-3h2v2h-2zm3 0h2v2h-2zm3 0h2v2h-2zm-6-3h2v2h-2zm3 0h2v2h-2zm3 0h2v2h-2z"/></svg>' },
        { name: 'Kubernetes', category: 'DevOps', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 2L3.5 7v10L12 22l8.5-5V7L12 2zm0 2.4l6.5 3.8v7.6L12 19.6 5.5 15.8V8.2L12 4.4zm0 3.6a4 4 0 100 8 4 4 0 000-8zm0 2a2 2 0 110 4 2 2 0 010-4z"/></svg>' },
        { name: 'AWS Cloud', category: 'DevOps', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/></svg>' },
        { name: 'Linux / Bash', category: 'DevOps', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 14H4V8h16v10zm-14-7l4 3-4 3v-2l1.5-1L6 12v-1zm6 5h5v2h-5v-2z"/></svg>' },
        { name: 'Terraform (IaC)', category: 'DevOps', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M1.5 2v7.5l6.5 3.7V5.7L1.5 2zm8 4.6v7.5l6.5 3.7V10.3l-6.5-3.7zm8 4.6v7.5l5-2.9v-7.5l-5 2.9zm-8 4.6v7.5l6.5-3.7v-7.5l-6.5 3.7z"/></svg>' },
        { name: 'CI/CD & Git', category: 'DevOps', svg: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><circle cx="6" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="9" r="3"/><path d="M6 9v6M9 6h4a4 4 0 014 4"/></svg>' },

        // Tools & AI
        { name: 'Figma', category: 'Tools', svg: '<svg viewBox="0 0 24 24" fill="none" class="w-6 h-6"><path d="M8 24c2.2 0 4-1.8 4-4v-4H8c-2.2 0-4 1.8-4 4s1.8 4 4 4z" fill="#0ACF83"/><path d="M4 12c0-2.2 1.8-4 4-4h4v8H8c-2.2 0-4-1.8-4-4z" fill="#A259FF"/><path d="M4 4c0-2.2 1.8-4 4-4h4v8H8C5.8 8 4 6.2 4 4z" fill="#F24E1E"/><path d="M12 0h4c2.2 0 4 1.8 4 4s-1.8 4-4 4h-4V0z" fill="#FF7262"/><path d="M20 12c0 2.2-1.8 4-4 4s-4-1.8-4-4 1.8-4 4-4 4 1.8 4 4z" fill="#1ABCFE"/></svg>' },
        { name: 'UI / UX Design', category: 'Tools', svg: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><circle cx="12" cy="12" r="9"/><path d="M12 3a9 9 0 0 0 0 18v-9z"/><path d="M16 12a4 4 0 0 0-4-4"/></svg>' },
        { name: 'Artificial Intelligence', category: 'Tools', svg: '<svg viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path d="M12 2a1 1 0 011 1v1.07A8.001 8.001 0 0119.93 11H21a1 1 0 110 2h-1.07A8.001 8.001 0 0113 19.93V21a1 1 0 11-2 0v-1.07A8.001 8.001 0 014.07 13H3a1 1 0 110-2h1.07A8.001 8.001 0 0111 4.07V3a1 1 0 011-1zm0 4a6 6 0 100 12 6 6 0 000-12zm-2 4a1.5 1.5 0 110 3 1.5 1.5 0 010-3zm4 0a1.5 1.5 0 110 3 1.5 1.5 0 010-3z"/></svg>' },
        { name: 'Terminal / CLI', category: 'Tools', svg: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><polyline points="4 17 10 11 4 5"/><line x1="12" y1="19" x2="20" y2="19"/></svg>' },
        { name: 'Code / IDE', category: 'Tools', svg: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-6 h-6"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>' },
    ];

    function updatePreview(value) {
        const val = (value || '').trim();
        if (!val) {
            previewBox.innerHTML = '<span id="icon-preview-placeholder" class="text-xs font-mono text-slate-400 font-bold">&lt;/&gt;</span>';
            iconTypeIndicator.textContent = '';
            return;
        }

        if (val.startsWith('<svg') || val.startsWith('<i ')) {
            previewBox.innerHTML = `<div class="w-8 h-8 inline-flex items-center justify-center text-ps-primary dark:text-cyan-400 [&>svg]:w-7 [&>svg]:h-7 [&>svg]:max-w-full [&>svg]:max-h-full">${val}</div>`;
            iconTypeIndicator.textContent = 'Format: Vektor SVG';
        } else if (val.startsWith('http://') || val.startsWith('https://') || val.startsWith('/') || val.endsWith('.svg') || val.endsWith('.png')) {
            previewBox.innerHTML = `<img src="${val}" alt="Icon Preview" class="w-8 h-8 object-contain" />`;
            iconTypeIndicator.textContent = 'Format: Gambar / URL';
        } else {
            previewBox.innerHTML = `<span class="text-3xl">${val}</span>`;
            iconTypeIndicator.textContent = 'Format: Emoji / Simbol';
        }
    }

    function renderPresets() {
        const selectedCat = categorySelect.value;
        activeCategoryLabel.textContent = showAll ? 'Semua Kategori' : selectedCat;

        const filtered = showAll
            ? presets
            : presets.filter(p => p.category.toLowerCase() === selectedCat.toLowerCase());

        presetsContainer.innerHTML = '';

        if (filtered.length === 0) {
            presetsContainer.innerHTML = '<div class="col-span-full py-6 text-center text-xs text-slate-400">Belum ada preset khusus untuk kategori ini. Pilih tab "Semua Icon" atau masukkan kode SVG/emoji manual.</div>';
            return;
        }

        filtered.forEach(p => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'group flex flex-col items-center justify-center p-2.5 rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/5 hover:border-ps-primary hover:bg-slate-50 dark:hover:bg-white/10 transition-all text-center';
            btn.innerHTML = `
                <div class="w-8 h-8 mb-1 flex items-center justify-center text-slate-700 dark:text-gray-200 group-hover:text-ps-primary dark:group-hover:text-cyan-300 transition-colors [&>svg]:w-6 [&>svg]:h-6 [&>svg]:fill-current">
                    ${p.svg}
                </div>
                <span class="text-[10px] font-medium text-slate-600 dark:text-gray-300 truncate w-full">${p.name}</span>
            `;

            btn.addEventListener('click', () => {
                iconInput.value = p.svg;
                updatePreview(p.svg);
                
                // Highlight active button
                document.querySelectorAll('#presets-container button').forEach(b => b.classList.remove('ring-2', 'ring-ps-primary'));
                btn.classList.add('ring-2', 'ring-ps-primary');

                // If name input is empty, fill with preset name
                if (!nameInput.value.trim()) {
                    nameInput.value = p.name;
                }
            });

            presetsContainer.appendChild(btn);
        });
    }

    // Category change listener: auto update preset icons
    ['change', 'input'].forEach(evt => {
        categorySelect.addEventListener(evt, function() {
            if (!showAll) {
                renderPresets();
            }
        });
    });

    // Tab buttons
    tabAuto.addEventListener('click', function() {
        showAll = false;
        tabAuto.className = 'px-2.5 py-1 rounded-lg text-[11px] font-medium bg-ps-primary/15 text-ps-primary dark:text-cyan-300 border border-ps-primary/30';
        tabAll.className = 'px-2.5 py-1 rounded-lg text-[11px] font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white';
        renderPresets();
    });

    tabAll.addEventListener('click', function() {
        showAll = true;
        tabAll.className = 'px-2.5 py-1 rounded-lg text-[11px] font-medium bg-ps-primary/15 text-ps-primary dark:text-cyan-300 border border-ps-primary/30';
        tabAuto.className = 'px-2.5 py-1 rounded-lg text-[11px] font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white';
        renderPresets();
    });

    // Manual input typing
    iconInput.addEventListener('input', function() {
        updatePreview(this.value);
    });

    // Emoji preset click
    document.querySelectorAll('.btn-emoji-preset').forEach(btn => {
        btn.addEventListener('click', function() {
            const emoji = this.dataset.emoji;
            iconInput.value = emoji;
            updatePreview(emoji);
        });
    });

    // Clear icon
    btnClearIcon.addEventListener('click', function() {
        iconInput.value = '';
        updatePreview('');
        document.querySelectorAll('#presets-container button').forEach(b => b.classList.remove('ring-2', 'ring-ps-primary'));
    });

    // Initial render
    renderPresets();
    updatePreview(iconInput.value);
});
</script>
@endsection

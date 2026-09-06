@extends('layouts.admin')

@section('title', 'Faiz Naufal Putra Permana - ' . ($isEdit ? 'Edit Pengalaman' : 'Tambah Pengalaman'))

@section('content')
<div class="px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-3xl mx-auto space-y-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-xs font-mono text-slate-500 dark:text-gray-400">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-ps-primary">Dashboard</a>
            <span>/</span>
            <a href="{{ route('admin.experiences.index') }}" class="hover:text-ps-primary">Journey</a>
            <span>/</span>
            <span class="text-slate-800 dark:text-gray-200">{{ $isEdit ? 'Edit' : 'Baru' }}</span>
        </div>

        <div class="ps-card-dark p-8 sm:p-10 space-y-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                    {{ $isEdit ? 'Edit Pengalaman: ' . $experience->role_title : 'Tambah Linimasa Karier Baru' }}
                </h1>
                <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Lengkapi data posisi, nama instansi/perusahaan, dan pencapaian teknis utama.</p>
            </div>

            <form action="{{ $isEdit ? route('admin.experiences.update', $experience->id) : route('admin.experiences.store') }}" method="POST" class="space-y-6">
                @csrf
                @if($isEdit)
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Role Title -->
                    <div class="space-y-2">
                        <label for="role_title" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Posisi / Jabatan Teknis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="role_title" name="role_title" value="{{ old('role_title', $experience->role_title) }}" required
                               placeholder="cth: Lead Backend Architect"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                        @error('role_title') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Company Name -->
                    <div class="space-y-2">
                        <label for="company_name" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Nama Perusahaan / Organisasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $experience->company_name) }}" required
                               placeholder="cth: Nexus Digital Systems"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                        @error('company_name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <!-- Location -->
                    <div class="space-y-2">
                        <label for="location" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="location" name="location" value="{{ old('location', $experience->location ?? 'Jakarta, Indonesia (Hybrid)') }}" required
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                        @error('location') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Employment Type -->
                    <div class="space-y-2">
                        <label for="employment_type" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Tipe Pekerjaan <span class="text-red-500">*</span>
                        </label>
                        <select id="employment_type" name="employment_type" required
                                class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                            <option value="Full-time" {{ old('employment_type', $experience->employment_type) == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                            <option value="Contract" {{ old('employment_type', $experience->employment_type) == 'Contract' ? 'selected' : '' }}>Contract</option>
                            <option value="Consultant" {{ old('employment_type', $experience->employment_type) == 'Consultant' ? 'selected' : '' }}>Consultant</option>
                            <option value="Part-time" {{ old('employment_type', $experience->employment_type) == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                        </select>
                        @error('employment_type') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Company URL -->
                    <div class="space-y-2">
                        <label for="company_url" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Website Perusahaan (Opsional)
                        </label>
                        <input type="url" id="company_url" name="company_url" value="{{ old('company_url', $experience->company_url) }}"
                               placeholder="https://company.com"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                        @error('company_url') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Start Date -->
                    <div class="space-y-2">
                        <label for="start_date" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Tanggal Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="start_date" name="start_date"
                               value="{{ old('start_date', $experience->start_date ? $experience->start_date->format('Y-m-d') : '') }}" required
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                        @error('start_date') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- End Date -->
                    <div class="space-y-2">
                        <label for="end_date" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                            Tanggal Selesai (Kosongkan jika masih aktif)
                        </label>
                        <input type="date" id="end_date" name="end_date"
                               value="{{ old('end_date', $experience->end_date ? $experience->end_date->format('Y-m-d') : '') }}"
                               class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                        @error('end_date') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Current Active Role Checkbox -->
                <div class="flex items-center gap-3">
                    <input type="checkbox" id="is_current" name="is_current" value="1"
                           {{ old('is_current', $experience->is_current) ? 'checked' : '' }}
                           class="w-4 h-4 rounded bg-black/60 border border-white/20 text-ps-primary focus:ring-0">
                    <label for="is_current" class="text-xs text-slate-700 dark:text-gray-300">
                        Masih aktif bekerja pada posisi ini saat ini (*Current Active Position*)
                    </label>
                </div>

                <!-- Description Points (One per line) -->
                @php
                    $pts = '';
                    if (!empty($experience->description_points)) {
                        $arr = is_array($experience->description_points) ? $experience->description_points : json_decode($experience->description_points, true);
                        $pts = implode("\n", $arr ?? []);
                    }
                @endphp
                <div class="space-y-2">
                    <label for="description_points_raw" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                        Poin-Poin Tanggung Jawab &amp; Pencapaian (1 Poin Per Baris) <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description_points_raw" name="description_points_raw" rows="4" required
                              placeholder="Memimpin tim arsitektur 8 engineer dan merancang distributed cache&#10;Mengurangi latensi transaksi p99 sebesar 65%&#10;Menerapkan CI/CD pipeline berbasis GitLab & Kubernetes"
                              class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary font-mono">{{ old('description_points_raw', $pts) }}</textarea>
                    <p class="text-[11px] text-slate-500 dark:text-gray-400">Tuliskan tiap pencapaian pada baris baru (tekan Enter untuk poin berikutnya).</p>
                    @error('description_points_raw') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <!-- Tech Used -->
                @php
                    $techs = '';
                    if (!empty($experience->tech_used)) {
                        $tArr = is_array($experience->tech_used) ? $experience->tech_used : json_decode($experience->tech_used, true);
                        $techs = implode(', ', $tArr ?? []);
                    }
                @endphp
                <div class="space-y-2">
                    <label for="tech_used_raw" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">
                        Teknologi yang Digunakan (Pisahkan dengan Koma)
                    </label>
                    <input type="text" id="tech_used_raw" name="tech_used_raw"
                           value="{{ old('tech_used_raw', $techs) }}"
                           placeholder="cth: Go, Laravel, Docker, Kubernetes, PostgreSQL, Kafka"
                           class="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                    @error('tech_used_raw') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-200 dark:border-white/10">
                    <a href="{{ route('admin.experiences.index') }}" class="btn-ps-outline-dark !py-2.5 !px-5 !text-xs !bg-white/70 dark:!bg-transparent !border-slate-300 dark:!border-white/15 !text-slate-800 dark:!text-white">
                        Batal
                    </a>
                    <button type="submit" class="btn-ps-primary !py-2.5 !px-6 !text-xs">
                        <span>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Pengalaman Baru' }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

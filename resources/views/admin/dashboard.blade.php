@extends('layouts.admin')

@section('title', 'Faiz Naufal Putra Permana - Admin')

@section('content')
<div id="dashboard" class="px-4 sm:px-6 lg:px-8 font-sans scroll-mt-28">
    <div class="max-w-7xl mx-auto space-y-10">
        <!-- Top Banner Bar -->
        <div class="border-b border-slate-200 dark:border-white/10 pb-6">
            <span class="text-xs font-mono uppercase tracking-widest text-ps-primary dark:text-cyan-400 font-bold">CONTROL PANEL</span>
            <h1 class="text-3xl font-light text-slate-900 dark:text-white tracking-tight">Manajemen Portofolio &amp; Showcase</h1>
            <p class="text-xs text-slate-500 dark:text-gray-400 mt-0.5">Pusat kendali konten: Projects, Skills, Journey Timeline, dan Certificates.</p>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Metric Cards Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="ps-card-dark p-5 space-y-1">
                <div class="text-xs text-slate-500 dark:text-gray-400 font-mono uppercase">Proyek</div>
                <div class="text-3xl font-light text-slate-900 dark:text-white">{{ $totalProjects }}</div>
                <a href="{{ route('admin.projects.index') }}" class="text-[11px] text-ps-primary dark:text-cyan-400 hover:underline block pt-1">Kelola Proyek →</a>
            </div>
            <div class="ps-card-dark p-5 space-y-1">
                <div class="text-xs text-slate-500 dark:text-gray-400 font-mono uppercase">Keahlian</div>
                <div class="text-3xl font-light text-slate-900 dark:text-white">{{ $totalSkills }}</div>
                <a href="{{ route('admin.skills.index') }}" class="text-[11px] text-ps-primary dark:text-cyan-400 hover:underline block pt-1">Kelola Skills →</a>
            </div>
            <div class="ps-card-dark p-5 space-y-1">
                <div class="text-xs text-slate-500 dark:text-gray-400 font-mono uppercase">Pengalaman</div>
                <div class="text-3xl font-light text-slate-900 dark:text-white">{{ $totalExperiences }}</div>
                <a href="{{ route('admin.experiences.index') }}" class="text-[11px] text-indigo-600 dark:text-indigo-400 hover:underline block pt-1">Kelola Journey →</a>
            </div>
            <div class="ps-card-dark p-5 space-y-1">
                <div class="text-xs text-slate-500 dark:text-gray-400 font-mono uppercase">Sertifikat</div>
                <div class="text-3xl font-light text-slate-900 dark:text-white">{{ $totalCertificates }}</div>
                <a href="{{ route('admin.certificates.index') }}" class="text-[11px] text-emerald-600 dark:text-emerald-400 hover:underline block pt-1">Kelola Sertifikat →</a>
            </div>
            <div class="ps-card-dark p-5 space-y-1">
                <div class="text-xs text-slate-500 dark:text-gray-400 font-mono uppercase">Total Pesan</div>
                <div class="text-3xl font-light text-slate-900 dark:text-white">{{ $totalMessages }}</div>
                <span class="text-[11px] text-slate-400 dark:text-gray-500 block pt-1">Masuk via formulir</span>
            </div>
            <div class="ps-card-dark p-5 space-y-1 bg-ps-primary/10 border-ps-primary/30">
                <div class="text-xs text-ps-primary font-mono uppercase font-bold">Belum Dibaca</div>
                <div class="text-3xl font-bold text-slate-900 dark:text-white">{{ $unreadMessagesCount }}</div>
                <span class="text-[11px] text-amber-600 dark:text-yellow-400 block pt-1">Memerlukan respon</span>
            </div>
        </div>

        <!-- Availability Setting & Inquiries -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Col 1: Update Availability Status (PRD ADM-2) -->
            <div class="lg:col-span-1 ps-card-dark p-6 sm:p-8 space-y-6">
                <div>
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Status Ketersediaan Kerja</h2>
                    <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Perbarui indikator status kerja yang tampil di hero section publik.</p>
                </div>

                <form action="{{ route('admin.availability.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2">
                        <label for="availability_status" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">Status Ketersediaan</label>
                        <select id="availability_status" name="availability_status" class="w-full px-3 py-2 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                            <option value="available" {{ ($profile->availability_status ?? '') == 'available' ? 'selected' : '' }}>Tersedia (Available)</option>
                            <option value="contract_only" {{ ($profile->availability_status ?? '') == 'contract_only' ? 'selected' : '' }}>Hanya Kontrak Strategis</option>
                            <option value="busy" {{ ($profile->availability_status ?? '') == 'busy' ? 'selected' : '' }}>Sedang Penuh (Busy)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="availability_text" class="block text-xs font-semibold uppercase text-slate-700 dark:text-gray-300">Teks Indikator Hero</label>
                        <input type="text" id="availability_text" name="availability_text" 
                               value="{{ old('availability_text', $profile->availability_text ?? 'Tersedia untuk Proyek Strategis & Posisi Senior') }}" 
                               required
                               class="w-full px-3 py-2 rounded-xl bg-slate-100/90 dark:bg-black/60 border border-slate-300/80 dark:border-white/20 text-slate-900 dark:text-white text-sm focus:outline-none focus:border-ps-primary">
                    </div>

                    <button type="submit" class="btn-ps-primary !w-full !py-2.5 !text-xs">
                        <span>Perbarui Status Kerja</span>
                    </button>
                </form>

                <!-- CV Quick Check -->
                <div class="pt-4 border-t border-slate-200 dark:border-white/10 space-y-2">
                    <span class="text-xs text-slate-500 dark:text-gray-400 block">Berkas CV Aktif:</span>
                    <div class="flex items-center justify-between text-xs bg-slate-100/90 dark:bg-black/50 p-2.5 rounded-xl border border-slate-200 dark:border-white/10">
                        <span class="font-mono text-slate-600 dark:text-gray-300 truncate">assets/resume-faiz-naufal.pdf</span>
                        <a href="{{ route('resume.download') }}" class="text-ps-primary font-semibold hover:underline">Unduh</a>
                    </div>
                </div>
            </div>

            <!-- Col 2: Inquiries & Messages List (PRD ADM-3) -->
            <div class="lg:col-span-2 ps-card-dark p-6 sm:p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Pesan &amp; Tawaran Kerja Sama Masuk</h2>
                        <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Daftar pertanyaan dan penawaran dari formulir Contacts publik.</p>
                    </div>
                    <span class="text-xs font-mono text-slate-500 dark:text-gray-400">Total: {{ $totalMessages }}</span>
                </div>

                @if($messages->isEmpty())
                    <div class="text-center py-12 border border-dashed border-slate-200 dark:border-white/15 rounded-xl text-slate-400 text-sm">
                        Belum ada pesan masuk dari pengunjung.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($messages as $msg)
                            <div class="p-4 rounded-xl border {{ $msg->is_read ? 'bg-slate-50/70 dark:bg-black/40 border-slate-200 dark:border-white/10' : 'bg-ps-primary/10 border-ps-primary/40' }} space-y-3">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        @if(!$msg->is_read)
                                            <span class="w-2 h-2 rounded-full bg-ps-primary"></span>
                                        @endif
                                        <span class="font-bold text-slate-900 dark:text-white text-sm">{{ $msg->sender_name }}</span>
                                        <a href="mailto:{{ $msg->sender_email }}" class="text-xs text-ps-primary hover:underline font-mono">
                                            &lt;{{ $msg->sender_email }}&gt;
                                        </a>
                                    </div>
                                    <span class="text-xs text-slate-400 font-mono">
                                        {{ $msg->created_at->format('d M Y H:i') }}
                                    </span>
                                </div>

                                <div>
                                    <div class="text-xs font-semibold text-slate-700 dark:text-gray-300 mb-1">Subjek: {{ $msg->subject }}</div>
                                    <p class="text-sm text-slate-600 dark:text-gray-300 leading-relaxed font-light bg-slate-100/80 dark:bg-black/40 p-3 rounded-lg border border-slate-200/60 dark:border-white/5">
                                        {{ $msg->message_body }}
                                    </p>
                                </div>

                                <div class="flex items-center justify-between pt-1 text-xs">
                                    <span class="text-slate-400 dark:text-gray-500 font-mono">IP: {{ $msg->ip_address ?? 'Local' }}</span>
                                    
                                    <div class="flex items-center gap-3">
                                        <a href="mailto:{{ $msg->sender_email }}?subject=Re: {{ urlencode($msg->subject) }}" class="text-ps-primary hover:underline font-medium">
                                            Balas via Email ↗
                                        </a>

                                        <form action="{{ route('admin.messages.toggle-read', $msg->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white underline">
                                                {{ $msg->is_read ? 'Tandai Belum Terbaca' : 'Tandai Terbaca' }}
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.messages.destroy', $msg->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-500 hover:text-rose-600 underline">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4">
                        {{ $messages->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- 4-in-1 Showcase Management Hub -->
        <div class="space-y-8">
            <!-- SECTION 1: SKILLS -->
            <div id="skills" class="ps-card-dark p-6 sm:p-8 space-y-6 scroll-mt-28">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Katalog Keahlian &amp; Teknologi</h2>
                        <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Daftar skill yang ditampilkan pada grid interaktif halaman publik.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.skills.index') }}" class="text-xs text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white underline">
                            Lihat Semua Skills →
                        </a>
                        <a href="{{ route('admin.skills.create') }}" class="btn-ps-primary !py-2 !px-4 !text-xs !bg-gradient-to-r !from-cyan-600 !to-ps-primary">
                            <span>+ Tambah Skill Baru</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                        <thead class="text-xs font-mono uppercase bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                            <tr>
                                <th class="px-4 py-3">Urutan</th>
                                <th class="px-4 py-3">Icon</th>
                                <th class="px-4 py-3">Nama Skill</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-white/5">
                            @forelse($skills->take(6) as $s)
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-4 py-3 font-mono text-xs text-slate-400">#{{ $s->order_index }}</td>
                                    <td class="px-4 py-3">
                                        <div class="w-7 h-7 rounded-lg bg-slate-100 dark:bg-white/10 border border-slate-200 dark:border-white/10 flex items-center justify-center text-ps-primary dark:text-cyan-300 [&>svg]:w-4 [&>svg]:h-4 [&>svg]:fill-current overflow-hidden">
                                            @if(!empty($s->icon_svg))
                                                @if(str_starts_with(trim($s->icon_svg), '<svg') || str_starts_with(trim($s->icon_svg), '<i '))
                                                    {!! $s->icon_svg !!}
                                                @elseif(str_starts_with(trim($s->icon_svg), 'http') || str_starts_with(trim($s->icon_svg), '/'))
                                                    <img src="{{ $s->icon_svg }}" alt="{{ $s->name }}" class="w-4 h-4 object-contain">
                                                @else
                                                    <span class="text-sm">{{ $s->icon_svg }}</span>
                                                @endif
                                            @else
                                                <span class="text-xs font-mono text-slate-400">⚡</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-slate-900 dark:text-white">{{ $s->name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 rounded text-xs font-mono bg-slate-100 dark:bg-white/10 text-ps-primary dark:text-cyan-300">
                                            {{ $s->category }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-2">
                                        <a href="{{ route('admin.skills.edit', $s->id) }}" class="text-xs text-ps-primary hover:underline font-semibold">Edit</a>
                                        <form action="{{ route('admin.skills.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus skill {{ $s->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-rose-500 hover:text-rose-600 underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                                        Belum ada data skill. Klik tombol di atas untuk menambah skill.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION 2: PROJECTS -->
            <div id="projects" class="ps-card-dark p-6 sm:p-8 space-y-6 scroll-mt-28">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Katalog Proyek</h2>
                        <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Daftar proyek yang aktif ditampilkan pada halaman publik.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.projects.index') }}" class="text-xs text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white underline">
                            Lihat Semua Proyek →
                        </a>
                        <a href="{{ route('admin.projects.create') }}" class="btn-ps-primary !py-2 !px-4 !text-xs">
                            <span>+ Tambah Proyek Baru</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                        <thead class="text-xs font-mono uppercase bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                            <tr>
                                <th class="px-4 py-3">Urutan</th>
                                <th class="px-4 py-3">Judul Proyek</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Featured</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-white/10">
                            @forelse($projects->take(6) as $p)
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-4 py-3 font-mono text-xs">{{ $p->order_index }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-900 dark:text-white">
                                        {{ $p->title }}
                                        <span class="block text-xs font-mono text-slate-400 dark:text-gray-500">{{ $p->slug }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-0.5 rounded text-xs bg-slate-100 dark:bg-white/10 text-slate-700 dark:text-gray-300 font-mono">{{ $p->category }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($p->is_published)
                                             <span class="text-xs text-emerald-600 dark:text-green-400 font-semibold">● Publik</span>
                                        @else
                                            <span class="text-xs text-slate-400 dark:text-gray-500">○ Draft</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($p->is_featured)
                                            <span class="text-xs text-amber-500 dark:text-yellow-400">★ Yes</span>
                                        @else
                                            <span class="text-xs text-slate-400 dark:text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-2">
                                        <a href="{{ route('admin.projects.edit', $p->id) }}" class="text-xs text-ps-primary hover:underline font-semibold">Edit</a>
                                        <form action="{{ route('admin.projects.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus proyek ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-rose-500 hover:text-rose-600 underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-slate-400">
                                        Belum ada proyek. Klik tombol di atas untuk menambah proyek.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION 3: EXPERIENCES (JOURNEY) -->
            <div id="experiences" class="ps-card-dark p-6 sm:p-8 space-y-6 scroll-mt-28">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Linimasa Karier (Journey Timeline)</h2>
                        <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Daftar pengalaman kerja yang ditampilkan pada timeline halaman publik.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.experiences.index') }}" class="text-xs text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white underline">
                            Lihat Semua Journey →
                        </a>
                        <a href="{{ route('admin.experiences.create') }}" class="btn-ps-primary !py-2 !px-4 !text-xs !bg-gradient-to-r !from-indigo-600 !to-ps-primary">
                            <span>+ Tambah Pengalaman Baru</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                        <thead class="text-xs font-mono uppercase bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                            <tr>
                                <th class="px-4 py-3">Periode</th>
                                <th class="px-4 py-3">Posisi</th>
                                <th class="px-4 py-3">Perusahaan</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-white/10">
                            @forelse($experiences->take(5) as $exp)
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-4 py-3 font-mono text-xs text-slate-500 dark:text-gray-400">
                                        {{ $exp->start_date->format('M Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? $exp->end_date->format('M Y') : '-') }}
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-slate-900 dark:text-white">{{ $exp->role_title }}</td>
                                    <td class="px-4 py-3 text-indigo-600 dark:text-indigo-300">{{ $exp->company_name }}</td>
                                    <td class="px-4 py-3">
                                        @if($exp->is_current)
                                            <span class="px-2 py-0.5 rounded text-[11px] font-mono bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border border-emerald-500/30">Active</span>
                                        @else
                                            <span class="text-xs text-slate-400 dark:text-gray-500 font-mono">Past</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-2">
                                        <a href="{{ route('admin.experiences.edit', $exp->id) }}" class="text-xs text-ps-primary hover:underline font-semibold">Edit</a>
                                        <form action="{{ route('admin.experiences.destroy', $exp->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengalaman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-rose-500 hover:text-rose-600 underline">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                                        Belum ada riwayat pengalaman. Klik tombol di atas untuk menambah data.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- SECTION 4: CERTIFICATES -->
            <div id="certificates" class="ps-card-dark p-6 sm:p-8 space-y-6 scroll-mt-28">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Katalog Sertifikasi Digital</h2>
                        <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Daftar sertifikasi resmi yang dapat diverifikasi publik.</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.certificates.index') }}" class="text-xs text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white underline">
                            Lihat Semua Sertifikat →
                        </a>
                        <a href="{{ route('admin.certificates.create') }}" class="btn-ps-primary !py-2 !px-4 !text-xs !bg-gradient-to-r !from-emerald-600 !to-teal-600">
                            <span>+ Tambah Sertifikat Baru</span>
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-700 dark:text-gray-300">
                        <thead class="text-xs font-mono uppercase bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-gray-400 border-b border-slate-200 dark:border-white/10">
                            <tr>
                                <th class="px-4 py-3">Nama Sertifikat</th>
                                <th class="px-4 py-3">Penerbit</th>
                                <th class="px-4 py-3">Tanggal Terbit</th>
                                <th class="px-4 py-3 font-mono">Tahun</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 dark:divide-white/10">
                            @forelse($certificates->take(5) as $cert)
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-slate-900 dark:text-white">{{ $cert->certificate_name }}</div>
                                        @if($cert->category)
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                @foreach(array_filter(array_map('trim', explode(',', $cert->category))) as $cat)
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono bg-slate-100 dark:bg-white/10 text-emerald-600 dark:text-emerald-400 border border-slate-200 dark:border-white/10">{{ $cat }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-emerald-600 dark:text-emerald-400">{{ $cert->issuer_organization }}</td>
                                    <td class="px-4 py-3 font-mono text-xs text-slate-500 dark:text-gray-400">{{ $cert->issue_date->format('d M Y') }}</td>
                                    <td class="px-4 py-3 font-mono text-xs font-semibold text-slate-700 dark:text-gray-300">{{ $cert->issue_date->format('Y') }}</td>
                                    <td class="px-4 py-3 text-right space-x-2">
                                        <a href="{{ route('admin.certificates.edit', $cert->id) }}" class="text-xs text-ps-primary hover:underline font-semibold">Edit</a>
                                        <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus sertifikat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-rose-500 hover:text-rose-600 underline">Hapus</button>
                                        </form>
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
@endsection

@extends('layouts.app')

@section('title', 'Faiz Naufal Putra Permana - Portfolio')

@section('custom_layout')
    <!-- Initial Payload for React JSX Application -->
    <script id="portfolio-initial-data" type="application/json">
        {!! json_encode([
            'profile' => $profile,
            'skills' => $skills,
            'skillsByCategory' => $skillsByCategory,
            'projects' => $projects,
            'experiences' => $experiences,
            'certificates' => $certificates,
            'csrfToken' => csrf_token(),
            'contactSubmitUrl' => route('contact.submit'),
            'resumeDownloadUrl' => route('resume.download'),
            'resumePreviewUrl' => route('resume.preview'),
            'resumeFileName' => $profile->resume_original_name ?? 'CV-Faiz-Naufal-Software-Engineer.pdf',
        ]) !!}
    </script>

    <!-- React JSX Root Mount Point with SSR Fallback Content -->
    <div id="portfolio-app">
    <!-- ==========================================
         CHAPTER 1: HOME (Hero with Interactive Ambient Canvas)
         ========================================== -->
    <section id="home" class="relative min-h-[92vh] flex items-center pt-24 pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <!-- Interactive Ambient Particle & PlayStation Symbols Canvas -->
        <canvas id="ambient-canvas"></canvas>

        <!-- Ambient Glow Spheres (Soft & Atmospheric) -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-ps-primary/15 rounded-full blur-[130px] pointer-events-none z-0"></div>
        <div class="absolute top-1/3 right-10 w-[400px] h-[400px] bg-cyan-500/10 rounded-full blur-[110px] pointer-events-none z-0"></div>
        <div class="absolute bottom-10 left-10 w-[450px] h-[450px] bg-indigo-600/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

        <div class="max-w-7xl mx-auto w-full relative z-10 pointer-events-auto">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                <!-- Left Column: Story & CTAs -->
                <div class="lg:col-span-7 space-y-8 text-left">
                    <!-- Main Headline (Fluid Gradient, Non-Rigid) -->
                    <div class="space-y-4">
                        <h1 class="ps-display-xl font-light tracking-tight text-white">
                            Crafting Resilient <br class="hidden sm:inline">
                            <span class="text-gradient-ps font-normal">Distributed Systems</span> <br class="hidden sm:inline">
                            &amp; Digital Products.
                        </h1>
                        <p class="text-lg sm:text-xl text-gray-300 font-light leading-relaxed max-w-2xl">
                            Halo, saya <span class="text-white font-medium">{{ $profile->full_name ?? 'Faiz Naufal Putra Permana' }}</span> — Web Developer. Mengubah arsitektur kompleks menjadi solusi web berkecepatan tinggi, tangguh di bawah beban jutaan transaksi, dan menyenangkan untuk digunakan.
                        </p>
                    </div>

                    <!-- Action Buttons (Clean & Focused) -->
                    <div class="flex flex-wrap items-center gap-3.5 pt-3">
                        <a href="{{ route('resume.preview') }}" target="_blank" rel="noopener noreferrer" class="btn-ps-primary !bg-gradient-to-r !from-indigo-600 !via-ps-primary !to-cyan-500 !shadow-lg !shadow-indigo-600/30 flex items-center gap-2" title="Download CV">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Download CV</span>
                        </a>
                        <a href="#contacts" class="btn-ps-outline-dark">
                            <span>Contact Me</span>
                        </a>
                        <a href="#projects" class="btn-ps-outline-dark">
                            <span>Projects</span>
                        </a>
                    </div>

                    <!-- Social Links (GitHub, LinkedIn, Email) -->
                    <div class="flex items-center gap-3 pt-2">
                        <!-- GitHub -->
                        <a
                            href="{{ $profile->social_links['github'] ?? 'https://github.com/faiznfl' }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-white/[0.05] border border-white/10 hover:border-cyan-400/50 hover:bg-cyan-500/10 text-slate-300 hover:text-cyan-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95"
                            title="GitHub Profile"
                            aria-label="GitHub Profile"
                        >
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                            </svg>
                        </a>

                        <!-- LinkedIn -->
                        <a
                            href="{{ $profile->social_links['linkedin'] ?? 'https://www.linkedin.com/in/faiz-naufal-putra-permana' }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="w-10 h-10 rounded-full bg-white/[0.05] border border-white/10 hover:border-cyan-400/50 hover:bg-cyan-500/10 text-slate-300 hover:text-cyan-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95"
                            title="LinkedIn Profile"
                            aria-label="LinkedIn Profile"
                        >
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                            </svg>
                        </a>

                        <!-- Email / Gmail -->
                        <a
                            href="mailto:{{ $profile->social_links['email'] ?? ($profile->email ?? 'faiznfl20@gmail.com') }}"
                            class="w-10 h-10 rounded-full bg-white/[0.05] border border-white/10 hover:border-cyan-400/50 hover:bg-cyan-500/10 text-slate-300 hover:text-cyan-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95"
                            title="Email: {{ $profile->social_links['email'] ?? ($profile->email ?? 'faiznfl20@gmail.com') }}"
                            aria-label="Send Email"
                        >
                            <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Metrics / Stats Capsule Bar (Calm & Elegant) -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 border-t border-white/10">
                        <div class="p-3.5 rounded-xl bg-white/[0.03] border border-white/5">
                            <div class="text-2xl sm:text-3xl font-light text-white tracking-tight text-gradient-ps">{{ $profile->stats['years_exp'] ?? '5+' }}</div>
                            <div class="text-[11px] uppercase tracking-wider text-gray-400 mt-0.5 font-mono">Tahun Pengalaman</div>
                        </div>
                        <div class="p-3.5 rounded-xl bg-white/[0.03] border border-white/5">
                            <div class="text-2xl sm:text-3xl font-light text-white tracking-tight text-gradient-ps">{{ $profile->stats['projects_shipped'] ?? '24+' }}</div>
                            <div class="text-[11px] uppercase tracking-wider text-gray-400 mt-0.5 font-mono">Proyek Shipped</div>
                        </div>
                        <div class="p-3.5 rounded-xl bg-white/[0.03] border border-white/5">
                            <div class="text-2xl sm:text-3xl font-light text-white tracking-tight text-green-400">{{ $profile->stats['uptime_sla'] ?? '99.98%' }}</div>
                            <div class="text-[11px] uppercase tracking-wider text-gray-400 mt-0.5 font-mono">Uptime SLA</div>
                        </div>
                        <div class="p-3.5 rounded-xl bg-white/[0.03] border border-white/5">
                            <div class="text-2xl sm:text-3xl font-light text-white tracking-tight text-yellow-400">{{ $profile->stats['certifications'] ?? '8+' }}</div>
                            <div class="text-[11px] uppercase tracking-wider text-gray-400 mt-0.5 font-mono">Sertifikasi Cloud</div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Editorial Portrait Photograph (Clean & Prestigious) -->
                <div class="lg:col-span-5 relative flex justify-center items-center">
                    <!-- Soft Cinematic Ambient Glow Backlight -->
                    <div class="absolute inset-0 bg-gradient-to-tr from-ps-primary/20 via-cyan-500/10 to-indigo-600/10 rounded-3xl blur-3xl transform scale-90 pointer-events-none"></div>

                    <!-- Clean Framed Portrait Photo -->
                    <div class="relative z-10 w-full max-w-sm sm:max-w-md rounded-3xl overflow-hidden glass-panel border border-white/15 shadow-2xl group transition-all duration-500 hover:border-cyan-400/40">
                        <div class="aspect-[3/4] w-full overflow-hidden relative">
                            <img src="{{ asset('assets/images/faiz-naufal.jpg') }}" 
                                 alt="{{ $profile->full_name ?? 'Faiz Naufal' }}" 
                                 class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105"
                                 loading="eager">

                            <!-- Subtle Vignette Bottom Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-[#070a12]/90 via-transparent to-transparent"></div>

                            <!-- Minimalist Floating Glass Badge -->
                            <div class="absolute bottom-5 left-5 right-5 p-4 rounded-2xl bg-black/60 backdrop-blur-md border border-white/15 flex items-center justify-between shadow-xl">
                                <div>
                                    <div class="text-sm font-semibold text-white tracking-wide">{{ $profile->full_name ?? 'Faiz Naufal Putra Permana' }}</div>
                                    <div class="text-xs text-cyan-300 font-light">{{ $profile->headline ?? 'Web Developer' }}</div>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-500/10 text-green-400 text-[11px] font-mono border border-green-500/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse"></span>
                                    Jakarta, ID
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         CHAPTER 2: ABOUT (Fluid Deep Dark with Ambient Lighting)
         ========================================== -->
    <section id="about" class="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-slate-200 dark:border-white/10 overflow-hidden transition-colors">
        <!-- Ambient Background Glow -->
        <div class="absolute top-1/4 left-1/3 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[350px] bg-ps-primary/10 dark:bg-ps-primary/15 rounded-full blur-[140px] pointer-events-none z-0"></div>
        <div class="absolute top-1/2 right-1/4 w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

        <div class="max-w-7xl mx-auto space-y-12 relative z-10">
            <!-- Header conforming strictly to the site-wide design system -->
            <div class="text-center space-y-2 max-w-2xl mx-auto">
                <div class="section-tagline">GET TO KNOW ME</div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-light text-slate-900 dark:text-white tracking-tight">
                    About <span class="text-gradient-ps font-semibold">Me</span>
                </h2>
                <p class="text-slate-600 dark:text-gray-400 text-sm sm:text-base font-light">
                    Sedikit cerita tentang latar belakang dan minat saya di dunia teknologi.
                </p>
            </div>

            <!-- 2-Column Split Layout with Symmetrical Alignment -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
                <!-- Left Column: Narrative Story & Education Cards -->
                <div class="lg:col-span-6 space-y-4">
                    <!-- Section Tag Indicator (Aligned with Right Column) -->
                    <div class="flex items-center gap-2 px-1">
                        <span class="w-2 h-2 rounded-full bg-ps-primary dark:bg-cyan-400 animate-pulse"></span>
                        <span class="text-xs font-mono font-bold tracking-widest uppercase text-ps-primary dark:text-cyan-400">
                            BIOGRAPHY &amp; EDUCATION
                        </span>
                    </div>

                    <!-- Bio Narrative Card -->
                    <div class="glass-panel p-6 sm:p-7 shadow-sm dark:shadow-none">
                        <p class="text-slate-700 dark:text-slate-200 text-base sm:text-lg leading-relaxed font-light">
                            Fresh graduate Sistem Informasi Universitas Pamulang dengan IPK 3.85, berfokus pada Web Development dan perancangan UI/UX. Terbiasa merancang antarmuka pengguna yang intuitif di Figma serta mengimplementasikannya menjadi aplikasi web menggunakan Laravel, PHP, MySQL, dan Tailwind CSS, termasuk integrasi payment gateway dan dashboard sistem. Terbuka untuk peluang kerja di bidang Web Development dan Software Engineering.
                        </p>
                    </div>

                    <!-- Education Cards Stack -->
                    <div class="space-y-4">
                        <div class="glass-panel p-5 flex items-center gap-4 hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all duration-300 hover:scale-[1.01] shadow-sm dark:shadow-none group">
                            <div class="w-12 h-12 rounded-xl bg-ps-primary/10 dark:bg-ps-primary/20 text-ps-primary dark:text-cyan-400 border border-ps-primary/25 dark:border-cyan-400/30 flex items-center justify-center shrink-0 transition-transform duration-300 group-hover:scale-105 group-hover:bg-ps-primary/15 dark:group-hover:bg-cyan-400/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14v7" />
                                </svg>
                            </div>
                            <div class="min-w-0 flex-1 space-y-1">
                                <div class="flex flex-wrap items-center justify-between gap-x-2">
                                    <h4 class="text-base font-semibold text-slate-900 dark:text-white tracking-tight leading-snug group-hover:text-ps-primary dark:group-hover:text-cyan-300 transition-colors">
                                        Universitas Pamulang
                                    </h4>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-mono font-semibold border border-emerald-500/20 shrink-0">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        IPK 3.85
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center justify-between gap-x-2">
                                    <p class="text-xs sm:text-sm text-ps-primary dark:text-cyan-300 font-medium">
                                        Sistem Informasi
                                    </p>
                                    <span class="text-xs font-mono text-slate-500 dark:text-gray-400">
                                        2022 - 2026
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interests & Focus Areas -->
                <div class="lg:col-span-6 space-y-4">
                    <!-- Section Tag Indicator -->
                    <div class="flex items-center gap-2 px-1">
                        <span class="w-2 h-2 rounded-full bg-ps-primary dark:bg-cyan-400 animate-pulse"></span>
                        <span class="text-xs font-mono font-bold tracking-widest uppercase text-ps-primary dark:text-cyan-400">
                            INTERESTS &amp; FOCUS AREAS
                        </span>
                    </div>

                    <!-- 2-Column Grid of Interest Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="glass-panel p-4 flex items-center gap-3.5 min-h-[70px] hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all duration-300 hover:scale-[1.02] shadow-sm dark:shadow-none group cursor-default">
                            <div class="w-10 h-10 rounded-xl bg-slate-200/60 dark:bg-white/[0.05] border border-slate-300/60 dark:border-white/10 flex items-center justify-center shrink-0 text-ps-primary dark:text-cyan-300 group-hover:scale-110 group-hover:bg-ps-primary/10 dark:group-hover:bg-cyan-400/10 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-800 dark:text-slate-200 tracking-tight leading-snug group-hover:text-ps-primary dark:group-hover:text-cyan-300 transition-colors">
                                Software Development
                            </span>
                        </div>

                        <div class="glass-panel p-4 flex items-center gap-3.5 min-h-[70px] hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all duration-300 hover:scale-[1.02] shadow-sm dark:shadow-none group cursor-default">
                            <div class="w-10 h-10 rounded-xl bg-slate-200/60 dark:bg-white/[0.05] border border-slate-300/60 dark:border-white/10 flex items-center justify-center shrink-0 text-ps-primary dark:text-cyan-300 group-hover:scale-110 group-hover:bg-ps-primary/10 dark:group-hover:bg-cyan-400/10 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-800 dark:text-slate-200 tracking-tight leading-snug group-hover:text-ps-primary dark:group-hover:text-cyan-300 transition-colors">
                                Web Development
                            </span>
                        </div>

                        <div class="glass-panel p-4 flex items-center gap-3.5 min-h-[70px] hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all duration-300 hover:scale-[1.02] shadow-sm dark:shadow-none group cursor-default">
                            <div class="w-10 h-10 rounded-xl bg-slate-200/60 dark:bg-white/[0.05] border border-slate-300/60 dark:border-white/10 flex items-center justify-center shrink-0 text-ps-primary dark:text-cyan-300 group-hover:scale-110 group-hover:bg-ps-primary/10 dark:group-hover:bg-cyan-400/10 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.5 2A2.5 2.5 0 007 4.5c0 .28.05.54.13.79A3 3 0 005 8a3 3 0 00.35 1.4A3.5 3.5 0 004 12.5a3.5 3.5 0 001.5 2.87V16a3 3 0 003 3h1v2a1 1 0 001 1h.5a1 1 0 001-1V2H9.5zM14.5 2A2.5 2.5 0 0117 4.5c0 .28-.05.54-.13.79A3 3 0 0119 8a3 3 0 01-.35 1.4 3.5 3.5 0 011.35 3.1A3.5 3.5 0 0118.5 15.37V16a3 3 0 01-3 3h-1v2a1 1 0 01-1 1h-.5a1 1 0 01-1-1V2h2.5z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-800 dark:text-slate-200 tracking-tight leading-snug group-hover:text-ps-primary dark:group-hover:text-cyan-300 transition-colors">
                                Artificial Intelligence
                            </span>
                        </div>

                        <div class="glass-panel p-4 flex items-center gap-3.5 min-h-[70px] hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all duration-300 hover:scale-[1.02] shadow-sm dark:shadow-none group cursor-default">
                            <div class="w-10 h-10 rounded-xl bg-slate-200/60 dark:bg-white/[0.05] border border-slate-300/60 dark:border-white/10 flex items-center justify-center shrink-0 text-ps-primary dark:text-cyan-300 group-hover:scale-110 group-hover:bg-ps-primary/10 dark:group-hover:bg-cyan-400/10 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4 7 7 0 0114-1.5 7.02 7.02 0 013 5.5 4 4 0 01-4 4 4 4 0 01-4-4c0-.75.6-1.5 1.5-1.5s1.5.75 1.5 1.5a1 1 0 001 1 1 1 0 001-1 4.5 4.5 0 00-4.5-4.5A4.5 4.5 0 008 17a4 4 0 01-1 4z" />
                                    <circle cx="8.5" cy="8.5" r="1" fill="currentColor" />
                                    <circle cx="12" cy="6.5" r="1" fill="currentColor" />
                                    <circle cx="15.5" cy="8.5" r="1" fill="currentColor" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-800 dark:text-slate-200 tracking-tight leading-snug group-hover:text-ps-primary dark:group-hover:text-cyan-300 transition-colors">
                                UI/UX Design
                            </span>
                        </div>

                        <div class="glass-panel p-4 flex items-center gap-3.5 min-h-[70px] hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all duration-300 hover:scale-[1.02] shadow-sm dark:shadow-none group cursor-default">
                            <div class="w-10 h-10 rounded-xl bg-slate-200/60 dark:bg-white/[0.05] border border-slate-300/60 dark:border-white/10 flex items-center justify-center shrink-0 text-ps-primary dark:text-cyan-300 group-hover:scale-110 group-hover:bg-ps-primary/10 dark:group-hover:bg-cyan-400/10 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <ellipse cx="12" cy="5" rx="9" ry="3" />
                                    <path stroke-linecap="round" d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
                                    <path stroke-linecap="round" d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-800 dark:text-slate-200 tracking-tight leading-snug group-hover:text-ps-primary dark:group-hover:text-cyan-300 transition-colors">
                                Database Management
                            </span>
                        </div>

                        <div class="glass-panel p-4 flex items-center gap-3.5 min-h-[70px] hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all duration-300 hover:scale-[1.02] shadow-sm dark:shadow-none group cursor-default">
                            <div class="w-10 h-10 rounded-xl bg-slate-200/60 dark:bg-white/[0.05] border border-slate-300/60 dark:border-white/10 flex items-center justify-center shrink-0 text-ps-primary dark:text-cyan-300 group-hover:scale-110 group-hover:bg-ps-primary/10 dark:group-hover:bg-cyan-400/10 transition-all duration-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                    <rect x="4" y="4" width="16" height="16" rx="2" />
                                    <rect x="9" y="9" width="6" height="6" />
                                    <path stroke-linecap="round" d="M9 1v3M15 1v3M9 20v3M15 20v3M20 9h3M20 14h3M1 9h3M1 14h3" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-slate-800 dark:text-slate-200 tracking-tight leading-snug group-hover:text-ps-primary dark:group-hover:text-cyan-300 transition-colors">
                                Information Technology
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================
         CHAPTER 3: SKILLS (Interactive Matrix)
         ========================================== -->
    <section id="skills" class="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-white/10 overflow-hidden">
        <div class="absolute -right-20 top-1/3 w-[450px] h-[450px] bg-cyan-600/10 rounded-full blur-[140px] pointer-events-none"></div>

        <div class="max-w-3xl mx-auto space-y-10 relative z-10">
            <!-- Header -->
            <div class="text-center space-y-2 max-w-xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-ps-primary/10 border border-ps-primary/30 text-xs font-bold uppercase tracking-widest text-cyan-400">
                    02 / TECHNICAL CAPABILITIES
                </div>
                <h2 class="ps-display-lg text-white font-light">
                    Peta Keahlian &amp; <span class="text-gradient-ps font-normal">Ekosistem Teknologi</span>
                </h2>
                <p class="text-gray-400 text-sm sm:text-base font-light">
                    Penguasaan mendalam terhadap bahasa pemrograman, framework enterprise, basis data terdistribusi, dan otomasi infrastruktur cloud.
                </p>
            </div>

            <!-- 5-Column 3D Tiles Grid with Skill Names -->
            <div class="grid grid-cols-5 gap-3 sm:gap-4 md:gap-4.5 max-w-[720px] mx-auto justify-items-center" id="skills-container">
                @forelse($skills as $skill)
                    <div class="group skill-card-item" title="{{ $skill->name }}" aria-label="{{ $skill->name }}">
                        <!-- Centered Brand Icon -->
                        <div class="mb-2 flex items-center justify-center">
                            @if(!empty($skill->icon_svg))
                                @php
                                    $rawSvg = trim($skill->icon_svg);
                                @endphp
                                @if(str_contains($rawSvg, '<svg') || str_starts_with($rawSvg, '<i '))
                                    @php
                                        $svgStart = strpos($rawSvg, '<svg');
                                        $cleanSvg = $svgStart !== false ? substr($rawSvg, $svgStart) : $rawSvg;
                                    @endphp
                                    <div class="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 text-ps-primary dark:text-cyan-400 [&>svg]:w-full [&>svg]:h-full [&>svg]:max-w-full [&>svg]:max-h-full [&>svg]:object-contain transition-transform duration-200 group-hover:scale-110">
                                        {!! $cleanSvg !!}
                                    </div>
                                @elseif(str_starts_with($rawSvg, 'http') || str_starts_with($rawSvg, '/'))
                                    <img src="{{ $rawSvg }}" alt="{{ $skill->name }}" class="w-9 h-9 sm:w-10 sm:h-10 object-contain transition-transform duration-200 group-hover:scale-110">
                                @else
                                    <span class="text-2xl sm:text-3xl select-none leading-none transition-transform duration-200 group-hover:scale-110">{{ $rawSvg }}</span>
                                @endif
                            @else
                                <svg class="w-9 h-9 sm:w-10 sm:h-10 text-ps-primary dark:text-cyan-400 transition-transform duration-200 group-hover:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <polyline points="16 18 22 12 16 6"/>
                                    <polyline points="8 6 2 12 8 18"/>
                                </svg>
                            @endif
                        </div>

                        <!-- Tech Name Only -->
                        <div class="w-full h-8 flex items-center justify-center px-1">
                            <span class="text-[11px] sm:text-xs font-semibold text-slate-800 dark:text-slate-200 tracking-tight leading-tight line-clamp-2 text-center group-hover:text-ps-primary dark:group-hover:text-cyan-300 transition-colors">
                                {{ $skill->name }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center text-slate-400 dark:text-gray-500 font-light border border-dashed border-slate-200 dark:border-white/10 rounded-2xl p-8">
                        <span class="text-3xl block mb-2">💻</span>
                        <span class="text-sm">Belum ada keahlian yang ditambahkan.</span>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ==========================================
         CHAPTER 4: PROJECTS (Interactive 3D Cards Showcase)
         ========================================== -->
    <section id="projects" class="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-white/10 overflow-hidden">
        <div class="absolute left-1/4 top-10 w-[500px] h-[500px] bg-indigo-600/10 rounded-full blur-[150px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto space-y-12 relative z-10">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3 max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-ps-primary/10 border border-ps-primary/30 text-xs font-bold uppercase tracking-widest text-cyan-400">
                        03 / FEATURED SHOWCASE
                    </div>
                    <h2 class="ps-display-lg text-white font-light">
                        Katalog Proyek Unggulan &amp; <span class="text-gradient-ps font-normal">Portofolio</span>
                    </h2>
                    <p class="text-gray-400 text-sm sm:text-base font-light">
                        Koleksi proyek pilihan dalam rekayasa sistem produksi, arsitektur terdistribusi, dan aplikasi web performa tinggi.
                    </p>
                </div>
            </div>

            <!-- Projects Grid with 3D Interactive Tilt -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 tilt-card-container" id="projects-grid">
                @forelse($projects as $project)
                    <article class="project-card-item tilt-card glass-panel flex flex-col overflow-hidden group border border-white/10">
                        <!-- Project Cover Mockup -->
                        <div class="relative w-full aspect-video bg-[#0a0f1d] overflow-hidden border-b border-white/10">
                            <img src="{{ $project->cover_image ?? asset('assets/projects/project-omnipulse.svg') }}" 
                                 alt="{{ $project->title }}" 
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                 loading="lazy">
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <h3 class="text-xl font-bold text-white tracking-tight group-hover:text-cyan-300 transition-colors">
                                    {{ $project->title }}
                                </h3>
                                <p class="text-sm text-gray-300 line-clamp-3 leading-relaxed font-light">
                                    {{ $project->summary }}
                                </p>
                            </div>

                            <!-- Tech Stack Pills -->
                            <div class="flex flex-wrap gap-1.5 pt-2">
                                @if(!empty($project->tech_stacks))
                                    @foreach(array_slice($project->tech_stacks, 0, 4) as $stack)
                                        <span class="px-2.5 py-0.5 rounded text-[11px] font-mono font-medium bg-white/10 text-gray-300 border border-white/10">
                                            {{ $stack }}
                                        </span>
                                    @endforeach
                                    @if(count($project->tech_stacks) > 4)
                                        <span class="px-2 py-0.5 rounded text-[11px] font-mono text-gray-500 bg-white/5">
                                            +{{ count($project->tech_stacks) - 4 }}
                                        </span>
                                    @endif
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            @if(!empty($project->demo_url) || !empty($project->repo_url))
                                <div class="pt-4 border-t border-white/10 flex items-center justify-end gap-2">
                                    @if(!empty($project->demo_url))
                                        <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium text-white bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-500 hover:to-cyan-400 shadow-sm shadow-blue-500/20 hover:shadow-cyan-500/30 transition-all" title="Buka Live Demo">
                                            <span>Demo</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    @endif

                                    @if(!empty($project->repo_url))
                                        <a href="{{ $project->repo_url }}" target="_blank" rel="noopener noreferrer" class="w-7 h-7 rounded-full inline-flex items-center justify-center text-gray-300 hover:text-white bg-white/[0.08] hover:bg-white/[0.15] border border-white/10 transition-all" title="Lihat Repositori GitHub">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"></path>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-16 text-center text-gray-500 font-light border border-dashed border-white/10 rounded-xl">
                        Belum ada proyek yang ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ==========================================
         CHAPTER 5: EXPERIENCE (Chronological Timeline)
         ========================================== -->
    <section id="experience" class="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-white/10 overflow-hidden">
        <div class="max-w-4xl mx-auto space-y-16 relative z-10">
            <!-- Header -->
            <div class="text-center space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-ps-primary/10 border border-ps-primary/30 text-xs font-bold uppercase tracking-widest text-cyan-400">
                    04 / CAREER MILESTONES
                </div>
                <h2 class="ps-display-lg text-white font-light">
                    Linimasa Pengalaman <span class="text-gradient-ps font-normal">Profesional</span>
                </h2>
                <p class="text-gray-400 text-sm sm:text-base font-light max-w-xl mx-auto">
                    Jejak karier kepemimpinan teknis dan pencapaian terukur di berbagai organisasi teknologi terdepan.
                </p>
            </div>

            <!-- Timeline Flow -->
            <div class="relative border-l-2 border-white/15 pl-6 sm:pl-10 space-y-12 ml-4 sm:ml-8">
                @forelse($experiences as $exp)
                    <div class="relative group">
                        <!-- Node Pin with Glowing Aura -->
                        <div class="absolute -left-[31px] sm:-left-[47px] top-2 w-4 h-4 rounded-full bg-ps-primary border-4 border-[#070a12] shadow-lg shadow-ps-primary/60 group-hover:scale-125 transition-transform"></div>

                        <div class="glass-panel p-6 sm:p-8 space-y-4">
                            <!-- Role & Company Bar -->
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-white/10 pb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-white">{{ $exp->role_title }}</h3>
                                    <div class="text-cyan-400 font-medium text-sm flex items-center gap-2 mt-1">
                                        <span>{{ $exp->company_name }}</span>
                                        <span class="text-gray-500">•</span>
                                        <span class="text-gray-400 text-xs">{{ $exp->location }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-mono bg-white/10 text-gray-300">
                                        {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} — 
                                        {{ $exp->is_current ? 'Sekarang' : \Carbon\Carbon::parse($exp->end_date)->format('M Y') }}
                                    </span>
                                    @if($exp->is_current)
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-950/80 text-green-400 border border-green-700/50">
                                            Aktif
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if(!empty($exp->summary))
                                <p class="text-sm text-gray-300 font-light leading-relaxed">
                                    {{ $exp->summary }}
                                </p>
                            @endif

                            <!-- Bullet Points -->
                            <ul class="space-y-2.5 text-sm text-gray-300 font-light leading-relaxed">
                                @if(!empty($exp->description_points))
                                    @foreach($exp->description_points as $point)
                                        <li class="flex items-start gap-3">
                                            <span class="text-cyan-400 mt-0.5 font-bold">›</span>
                                            <span>{{ $point }}</span>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>

                            <!-- Tech Used Tags -->
                            @if(!empty($exp->tech_used))
                                <div class="pt-3 flex flex-wrap gap-1.5">
                                    @foreach($exp->tech_used as $tech)
                                        <span class="px-2.5 py-0.5 rounded-full text-xs font-mono bg-white/5 text-gray-300 border border-white/10">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-gray-500 font-light border border-dashed border-white/10 rounded-xl">
                        Belum ada pengalaman / journey yang ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ==========================================
         CHAPTER 6: CERTIFICATES (Verified Credentials)
         ========================================== -->
    <section id="certificates" class="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-white/10 overflow-hidden">
        <div class="max-w-7xl mx-auto space-y-12 relative z-10">
            <!-- Header -->
            <div class="max-w-3xl space-y-3">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-ps-primary/10 border border-ps-primary/30 text-xs font-bold uppercase tracking-widest text-cyan-400">
                    05 / CREDENTIALS &amp; LICENSES
                </div>
                <h2 class="ps-display-lg text-white font-light">
                    Sertifikasi &amp; <span class="text-gradient-ps font-normal">Validasi Kompetensi</span>
                </h2>
                <p class="text-gray-400 text-sm sm:text-base font-light">
                    Bukti kompetensi berstandar industri internasional yang dapat diverifikasi langsung melalui portal penerbit resmi.
                </p>
            </div>

            <!-- Certificates Grid with 3D Tilt -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 tilt-card-container">
                @forelse($certificates as $cert)
                    <div class="tilt-card glass-panel p-6 flex flex-col justify-between space-y-5 border border-white/10">
                        <div class="space-y-4">
                            <!-- Issuer Badge Icon -->
                            <div class="w-16 h-16 rounded-2xl overflow-hidden bg-black/60 p-2.5 flex items-center justify-center border border-white/10 shadow-lg">
                                <img src="{{ $cert->media_file_path ?? asset('assets/certificates/cert-aws-saa.svg') }}" 
                                     alt="{{ $cert->certificate_name }}" 
                                     class="w-full h-full object-contain" 
                                     loading="lazy">
                            </div>

                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between gap-2">
                                    <span class="text-xs font-mono text-cyan-400 uppercase tracking-wider">{{ $cert->issuer_organization }}</span>
                                    @if($cert->issue_date)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-white/10 text-gray-300">
                                            {{ \Carbon\Carbon::parse($cert->issue_date)->format('Y') }}
                                        </span>
                                    @elseif($cert->category)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-white/10 text-cyan-300">
                                            {{ explode(',', $cert->category)[0] }}
                                        </span>
                                    @endif
                                </div>
                                <h3 class="text-base font-bold text-white leading-snug">{{ $cert->certificate_name }}</h3>
                                @if($cert->course_name)
                                    <p class="text-xs text-gray-400 font-medium">Course: <span class="text-gray-200">{{ $cert->course_name }}</span></p>
                                @endif
                                @if($cert->description)
                                    <p class="text-xs text-gray-400 line-clamp-2 font-light leading-relaxed">{{ $cert->description }}</p>
                                @endif
                            </div>

                            <div class="space-y-1 text-xs text-gray-400 font-mono pt-2 border-t border-white/10">
                                <div>ID: <span class="text-gray-200 font-semibold">{{ $cert->credential_id ?? 'Terverifikasi' }}</span></div>
                                @if($cert->expiration_date)
                                    <div>Berlaku: {{ \Carbon\Carbon::parse($cert->expiration_date)->format('d M Y') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-500 font-light border border-dashed border-white/10 rounded-xl">
                        Belum ada sertifikat yang ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ==========================================
         CHAPTER 7: CONTACTS (Collaborative & Engaging)
         ========================================== -->
    <section id="contacts" class="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-white/10 overflow-hidden">
        <div class="absolute right-1/4 bottom-10 w-[550px] h-[550px] bg-ps-primary/15 rounded-full blur-[160px] pointer-events-none"></div>

        <div class="max-w-5xl mx-auto space-y-12 relative z-10">
            <!-- Header -->
            <div class="text-center space-y-3 max-w-2xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-ps-primary/10 border border-ps-primary/30 text-xs font-bold uppercase tracking-widest text-cyan-400">
                    06 / GET IN TOUCH
                </div>
                <h2 class="ps-display-lg text-white font-light">
                    Mari Bangun Solusi Hebat <span class="text-gradient-ps font-normal">Bersama.</span>
                </h2>
                <p class="text-gray-300 text-sm sm:text-base font-light">
                    Tertarik membahas proyek baru, konsultasi arsitektur cloud, atau tawaran posisi strategis? Kirimkan pesan santai melalui formulir di bawah ini.
                </p>
            </div>

            <!-- Contact Grid: Info & Form -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Info Cards -->
                <div class="lg:col-span-5 space-y-4">
                    <!-- Master Card (Contact Information) -->
                    <div class="glass-panel p-6 sm:p-7 space-y-6 shadow-sm dark:shadow-none">
                        <h3 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                            Contact Information
                        </h3>

                        <div class="space-y-4">
                            <!-- Email Row with Copy Button -->
                            <div class="flex items-center justify-between gap-3 p-3 rounded-2xl bg-white/[0.02] border border-white/[0.06] hover:border-cyan-400/40 transition-all">
                                <div class="flex items-center gap-3.5 min-w-0">
                                    <div class="w-11 h-11 rounded-2xl bg-[#12162a] border border-indigo-500/30 flex items-center justify-center shrink-0 text-indigo-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-[11px] font-mono font-semibold uppercase tracking-wider text-gray-400">
                                            EMAIL
                                        </div>
                                        <a href="mailto:{{ $profile->email ?? 'faiznfl20@gmail.com' }}" class="text-sm sm:text-base font-semibold text-white hover:text-cyan-300 transition-colors truncate block">
                                            {{ $profile->email ?? 'faiznfl20@gmail.com' }}
                                        </a>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    onclick="navigator.clipboard.writeText('{{ $profile->email ?? 'faiznfl20@gmail.com' }}'); this.innerText = 'Copied!'; setTimeout(() => this.innerHTML = '<svg class=\'w-4 h-4\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\' stroke-width=\'1.8\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z\' /></svg>', 2000);"
                                    class="relative p-2.5 rounded-xl text-gray-400 hover:text-white hover:bg-white/10 transition-all shrink-0 active:scale-90"
                                    title="Salin email"
                                    aria-label="Salin alamat email"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Location Row -->
                            <div class="flex items-center gap-3.5 p-3 rounded-2xl bg-white/[0.02] border border-white/[0.06] hover:border-cyan-400/40 transition-all">
                                <div class="w-11 h-11 rounded-2xl bg-[#12162a] border border-indigo-500/30 flex items-center justify-center shrink-0 text-indigo-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-[11px] font-mono font-semibold uppercase tracking-wider text-gray-400">
                                        LOCATION
                                    </div>
                                    <div class="text-sm sm:text-base font-semibold text-white">
                                        Indonesia (Remote / On-site)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Divider & Connect via Social -->
                        <div class="pt-4 border-t border-white/10 space-y-3">
                            <div class="text-[11px] font-mono font-semibold uppercase tracking-wider text-gray-400">
                                CONNECT VIA SOCIAL
                            </div>
                            <div class="flex items-center gap-3">
                                <!-- GitHub -->
                                <a href="https://github.com/faiznfl" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/[0.05] border border-white/10 hover:border-cyan-400/50 hover:bg-cyan-500/10 text-slate-300 hover:text-cyan-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95" title="GitHub Profile" aria-label="GitHub Profile">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                                    </svg>
                                </a>

                                <!-- LinkedIn -->
                                <a href="https://www.linkedin.com/in/faiz-naufal-putra-permana" target="_blank" rel="noopener noreferrer" class="w-10 h-10 rounded-full bg-white/[0.05] border border-white/10 hover:border-cyan-400/50 hover:bg-cyan-500/10 text-slate-300 hover:text-cyan-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95" title="LinkedIn Profile" aria-label="LinkedIn Profile">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </a>

                                <!-- Email -->
                                <a href="mailto:{{ $profile->email ?? 'faiznfl20@gmail.com' }}" class="w-10 h-10 rounded-full bg-white/[0.05] border border-white/10 hover:border-cyan-400/50 hover:bg-cyan-500/10 text-slate-300 hover:text-cyan-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95" title="Kirim Email" aria-label="Kirim Email">
                                    <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="lg:col-span-7 glass-panel p-8 sm:p-10 border border-white/15">
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Honeypot anti-spam field -->
                        <div class="hidden" aria-hidden="true">
                            <label for="website_hp">Leave this empty</label>
                            <input type="text" name="website_hp" id="website_hp" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="space-y-2">
                                <label for="sender_name" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                    Nama Lengkap <span class="text-cyan-400">*</span>
                                </label>
                                <input type="text" 
                                       id="sender_name" 
                                       name="sender_name" 
                                       value="{{ old('sender_name') }}" 
                                       required
                                       placeholder="cth: Budi Santoso"
                                       class="w-full px-4 py-3 rounded-xl bg-black/50 border border-white/15 text-white placeholder-gray-500 focus:outline-none focus:border-ps-primary text-sm transition-colors">
                                @error('sender_name')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="sender_email" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                    Alamat Email Bisnis <span class="text-cyan-400">*</span>
                                </label>
                                <input type="email" 
                                       id="sender_email" 
                                       name="sender_email" 
                                       value="{{ old('sender_email') }}" 
                                       required
                                       placeholder="cth: budi@perusahaan.co"
                                       class="w-full px-4 py-3 rounded-xl bg-black/50 border border-white/15 text-white placeholder-gray-500 focus:outline-none focus:border-ps-primary text-sm transition-colors">
                                @error('sender_email')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="space-y-2">
                            <label for="subject" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                Subjek Diskusi / Tawaran <span class="text-cyan-400">*</span>
                            </label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   value="{{ old('subject') }}" 
                                   required
                                   placeholder="cth: Diskusi Proyek E-Commerce Multi-Tenant"
                                   class="w-full px-4 py-3 rounded-xl bg-black/50 border border-white/15 text-white placeholder-gray-500 focus:outline-none focus:border-ps-primary text-sm transition-colors">
                            @error('subject')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message Body with Live Character Counter -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label for="message_body" class="block text-xs font-semibold uppercase tracking-wider text-gray-300">
                                    Isi Pesan &amp; Rincian Kebutuhan <span class="text-cyan-400">*</span>
                                </label>
                                <span id="char-counter" class="text-xs text-gray-400 font-mono">0 karakter</span>
                            </div>
                            <textarea id="message_body" 
                                      name="message_body" 
                                      rows="5" 
                                      required
                                      placeholder="Ceritakan latar belakang kebutuhan proyek, ekspektasi timeline, atau teknologi yang relevan..."
                                      class="w-full px-4 py-3 rounded-xl bg-black/50 border border-white/15 text-white placeholder-gray-500 focus:outline-none focus:border-ps-primary text-sm transition-colors">{{ old('message_body') }}</textarea>
                            @error('message_body')
                                <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-between pt-2">
                            <span class="text-xs text-gray-400 font-mono">Token CSRF &amp; anti-bot aktif.</span>
                            <button type="submit" class="btn-ps-primary">
                                <span>Kirim Pesan Sekarang</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Minimalist Clean Footer (Matching Screenshot) -->
    <footer class="border-t border-slate-200/80 dark:border-white/[0.08] bg-slate-50 dark:bg-[#070a14] py-8 sm:py-9 px-4 sm:px-6 lg:px-8 transition-colors select-none font-sans">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-5 sm:gap-4">
            <!-- Left: Copyright -->
            <div class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 text-center sm:text-left">
                <span>&copy; {{ date('Y') }} Faiz Naufal Putra Permana. All rights reserved.</span>
            </div>

            <!-- Center: 3 Circular Social Buttons -->
            <div class="flex items-center gap-3">
                <!-- GitHub -->
                <a
                    href="https://github.com/faiznfl"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-10 h-10 rounded-full bg-slate-200/50 dark:bg-white/[0.04] border border-slate-300/70 dark:border-white/10 hover:bg-slate-300/60 dark:hover:bg-white/[0.08] hover:border-slate-400 dark:hover:border-white/20 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all duration-200 shadow-sm"
                    title="GitHub"
                    aria-label="GitHub"
                >
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                    </svg>
                </a>

                <!-- LinkedIn -->
                <a
                    href="https://www.linkedin.com/in/faiz-naufal-putra-permana"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="w-10 h-10 rounded-full bg-slate-200/50 dark:bg-white/[0.04] border border-slate-300/70 dark:border-white/10 hover:bg-slate-300/60 dark:hover:bg-white/[0.08] hover:border-slate-400 dark:hover:border-white/20 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all duration-200 shadow-sm"
                    title="LinkedIn"
                    aria-label="LinkedIn"
                >
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                    </svg>
                </a>

                <!-- Email -->
                <a
                    href="mailto:faiznfl20@gmail.com"
                    class="w-10 h-10 rounded-full bg-slate-200/50 dark:bg-white/[0.04] border border-slate-300/70 dark:border-white/10 hover:bg-slate-300/60 dark:hover:bg-white/[0.08] hover:border-slate-400 dark:hover:border-white/20 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all duration-200 shadow-sm"
                    title="Email"
                    aria-label="Email"
                >
                    <svg class="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </a>
            </div>

            <!-- Right: Circular Back to Top Button -->
            <a
                href="#home"
                class="w-10 h-10 rounded-full bg-slate-200/50 dark:bg-white/[0.04] border border-slate-300/70 dark:border-white/10 hover:bg-slate-300/60 dark:hover:bg-white/[0.08] hover:border-slate-400 dark:hover:border-white/20 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all duration-200 cursor-pointer shadow-sm"
                title="Kembali ke Atas"
                aria-label="Kembali ke Atas"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
            </a>
        </div>
    </footer>

    </div>
@endsection

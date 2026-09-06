<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Faiz Naufal Putra Permana - Portfolio')</title>
    <meta name="description" content="@yield('meta_description', 'Portofolio Resmi Faiz Naufal - Senior Full-Stack Software Engineer & Distributed Cloud Systems Architect. Menampilkan portofolio proyek enterprise, rekam jejak karier, dan sertifikasi terverifikasi.')">
    
    <!-- Open Graph / SEO -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Faiz Naufal Putra Permana - Portfolio')">
    <meta property="og:description" content="@yield('meta_description', 'Katalog proyek interaktif, pemetaan keahlian teknis, dan validasi sertifikasi digital resmi.')">
    <meta property="og:image" content="{{ asset('assets/projects/project-omnipulse.svg') }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:300,400,500,600,700" rel="stylesheet" />

    <!-- Theme Initializer (Zero Flickering Anti-FOIT) -->
    <script>
        (function() {
            try {
                const stored = localStorage.getItem('theme');
                if (stored === 'light') {
                    document.documentElement.classList.remove('dark');
                } else {
                    document.documentElement.classList.add('dark');
                }
            } catch (e) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo.svg') }}">

    <!-- Scripts & Styles with React Fast Refresh -->
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="bg-[#070a13] text-slate-100 antialiased selection:bg-ps-primary selection:text-white min-h-screen flex flex-col font-sans">
    @if(View::hasSection('custom_layout'))
        @yield('custom_layout')
    @else
        @if(!View::hasSection('hide_navbar'))
        <!-- Top Navigation Bar (PlayStation Dark Chrome) -->
        <header class="sticky top-0 z-50 bg-[#070a12]/85 backdrop-blur-xl border-b border-white/10 transition-all duration-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <!-- Brand Text (Pure Typography) -->
            <a href="{{ url('/#home') }}" class="text-lg font-bold tracking-tight text-white hover:text-cyan-400 transition-colors">
                <span>Faiz</span> <span class="text-cyan-400 font-light">Naufal.</span>
            </a>

            <!-- Desktop Navigation (7 Core Menu Items per PRD) -->
            <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-sm">
                <a href="{{ url('/#home') }}" class="nav-link text-gray-300 hover:text-white transition-colors">Home</a>
                <a href="{{ url('/#about') }}" class="nav-link text-gray-300 hover:text-white transition-colors">About</a>
                <a href="{{ url('/#skills') }}" class="nav-link text-gray-300 hover:text-white transition-colors">Skills</a>
                <a href="{{ url('/#projects') }}" class="nav-link text-gray-300 hover:text-white transition-colors">Projects</a>
                <a href="{{ url('/#experience') }}" class="nav-link text-gray-300 hover:text-white transition-colors">Experience</a>
                <a href="{{ url('/#certificates') }}" class="nav-link text-gray-300 hover:text-white transition-colors">Certificates</a>
                <a href="{{ url('/#contacts') }}" class="nav-link text-gray-300 hover:text-white transition-colors">Contacts</a>
            </nav>

            <!-- Action Pill CTAs -->
            <div class="hidden sm:flex items-center gap-3">
                <a href="{{ url('/#contacts') }}" class="btn-ps-primary !py-1.5 !px-4 !text-xs">
                    <span>Hubungi</span>
                </a>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="flex items-center sm:hidden">
                <button id="mobile-menu-btn" type="button" aria-label="Buka Menu" class="p-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-drawer" class="fixed inset-0 z-50 bg-black/95 flex flex-col p-6 hidden opacity-0 transition-opacity duration-200">
        <div class="flex justify-between items-center border-b border-white/10 pb-4">
            <span class="font-bold text-lg text-white">MENU NAVIGASI</span>
            <button id="mobile-menu-close" type="button" aria-label="Tutup Menu" class="p-2 rounded-full text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <nav class="flex flex-col gap-5 mt-8 text-xl font-light">
            <a href="{{ url('/#home') }}" class="mobile-nav-link text-gray-300 hover:text-ps-primary py-1">1. Home</a>
            <a href="{{ url('/#about') }}" class="mobile-nav-link text-gray-300 hover:text-ps-primary py-1">2. About</a>
            <a href="{{ url('/#skills') }}" class="mobile-nav-link text-gray-300 hover:text-ps-primary py-1">3. Skills</a>
            <a href="{{ url('/#projects') }}" class="mobile-nav-link text-gray-300 hover:text-ps-primary py-1">4. Projects</a>
            <a href="{{ url('/#experience') }}" class="mobile-nav-link text-gray-300 hover:text-ps-primary py-1">5. Experience</a>
            <a href="{{ url('/#certificates') }}" class="mobile-nav-link text-gray-300 hover:text-ps-primary py-1">6. Certificates</a>
            <a href="{{ url('/#contacts') }}" class="mobile-nav-link text-gray-300 hover:text-ps-primary py-1">7. Contacts</a>
        </nav>
        <div class="mt-auto pt-6 border-t border-white/10 flex flex-col gap-3">
            <a href="{{ route('admin.login') }}" class="text-xs text-gray-500 text-center py-2 hover:text-gray-300">Admin Login</a>
        </div>
    </div>
    @endif

    <!-- Main Content Flow -->
    <main class="flex-grow">
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="p-4 rounded-lg bg-green-950/80 border border-green-500/50 text-green-200 flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
                <div class="p-4 rounded-lg bg-red-950/80 border border-red-500/50 text-red-200 flex items-center gap-3">
                    <svg class="w-5 h-5 text-red-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @if(!View::hasSection('hide_footer'))
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
                    href="https://linkedin.com/in/faiznfl"
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
                    href="mailto:faiznaufal.dev@gmail.com"
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
            <button
                type="button"
                onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
                class="w-10 h-10 rounded-full bg-slate-200/50 dark:bg-white/[0.04] border border-slate-300/70 dark:border-white/10 hover:bg-slate-300/60 dark:hover:bg-white/[0.08] hover:border-slate-400 dark:hover:border-white/20 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all duration-200 cursor-pointer shadow-sm"
                title="Kembali ke Atas"
                aria-label="Kembali ke Atas"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                </svg>
            </button>
        </div>
    </footer>
    @else
    <!-- Minimalist Clean Footer for Auth / Clean pages -->
    <footer class="py-8 text-center text-xs text-slate-500 dark:text-gray-400 border-t border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-[#070a14] transition-colors font-mono">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div>
                &copy; {{ date('Y') }} Faiz Naufal Putra Permana • Admin Control Hub
            </div>
            <div class="text-[11px] text-slate-400">
                build v8
            </div>
        </div>
    </footer>
    @endif

    @if(!View::hasSection('hide_navbar'))
    <!-- Interactive Command Palette Modal (Ctrl+K) -->
    <div id="cmd-palette-modal" class="fixed inset-0 z-50 flex items-start justify-center pt-20 sm:pt-28 p-4 hidden">
        <!-- Backdrop -->
        <div id="cmd-backdrop" class="fixed inset-0 cmd-palette-backdrop"></div>

        <!-- Palette Dialog -->
        <div class="relative z-10 w-full max-w-2xl bg-[#121314] text-white rounded-xl border border-white/20 shadow-2xl overflow-hidden flex flex-col">
            <!-- Search Header -->
            <div class="flex items-center gap-3 px-5 py-4 border-b border-white/10 bg-black/40">
                <svg class="w-5 h-5 text-ps-primary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" 
                       id="cmd-search-input" 
                       placeholder="Ketik untuk mencari proyek, keahlian, atau sertifikat..." 
                       class="w-full bg-transparent border-none text-white placeholder-gray-500 focus:outline-none text-sm sm:text-base font-light">
                <kbd class="px-2 py-0.5 rounded bg-white/10 text-xs font-mono text-gray-400 border border-white/10">ESC</kbd>
                <button id="cmd-close-btn" type="button" class="text-gray-400 hover:text-white text-xs">Tutup</button>
            </div>

            <!-- Search Results Container -->
            <div id="cmd-results-container" class="p-3 max-h-96 overflow-y-auto space-y-1">
                <!-- Populated via JavaScript -->
            </div>

            <!-- Keyboard Footer Hints -->
            <div class="px-5 py-2.5 bg-black/60 border-t border-white/10 flex items-center justify-between text-[11px] text-gray-500 font-mono">
                <span>Pencarian Cepat Antar-Modul</span>
                <span>Tekan <kbd class="text-gray-300">ESC</kbd> untuk menutup</span>
            </div>
        </div>
    </div>
    @endif
    @endif
</body>
</html>

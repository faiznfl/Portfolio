<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Faiz Naufal Putra Permana - Admin')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/images/logo.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:300,400,500,600,700" rel="stylesheet" />

    <!-- Anti-FOIT Script (Zero Flickering Theme Detection) -->
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

    <!-- Scripts & Styles with React Fast Refresh -->
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="bg-[#f8fafc] text-slate-900 dark:bg-[#070a13] dark:text-slate-100 antialiased selection:bg-ps-primary selection:text-white min-h-screen flex flex-col font-sans transition-colors duration-300">
    <!-- Floating Liquid Glass Admin Navbar Container -->
    <header class="fixed top-4 sm:top-5 inset-x-3 sm:inset-x-0 mx-auto max-w-6xl z-50 rounded-full liquid-glass-nav px-4 sm:px-6 h-14 sm:h-16 flex items-center justify-between transition-all duration-300">
        <!-- Left: Admin Brand & Console Badge -->
        <div class="flex items-center gap-2.5 sm:gap-3 shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="text-base sm:text-lg font-bold tracking-tight text-slate-900 dark:text-white hover:text-ps-primary dark:hover:text-cyan-400 transition-colors">
                <span>Faiz</span> <span class="text-ps-primary dark:text-cyan-400 font-light">Naufal.</span>
            </a>
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold tracking-wider uppercase bg-ps-primary/10 text-ps-primary dark:bg-cyan-500/15 dark:text-cyan-300 border border-ps-primary/25 dark:border-cyan-500/30">
                <span class="w-1.5 h-1.5 rounded-full bg-ps-primary dark:bg-cyan-400 animate-pulse"></span>
                ADMIN CONSOLE
            </span>
        </div>

        <!-- Middle: Dedicated Admin Navigation Menu with Physical Sliding Pill Track -->
        <nav id="admin-nav-track" class="hidden md:flex items-center relative p-1 rounded-full bg-slate-200/50 dark:bg-white/[0.04] border border-slate-300/50 dark:border-white/[0.08]">
            <!-- Animated Sliding Liquid Glass Pill -->
            <div id="admin-nav-pill"
                 class="absolute top-0 left-0 rounded-full bg-white dark:bg-white/[0.12] border border-slate-300/80 dark:border-cyan-400/40 shadow-sm dark:shadow-[0_0_16px_rgba(0,212,255,0.25)] pointer-events-none z-0 transition-all duration-300 ease-out opacity-0"
                 style="transform: translate3d(0, 0, 0);">
            </div>

            <a href="{{ route('admin.dashboard') }}#dashboard" 
               data-section="dashboard"
               class="admin-nav-item relative z-10 font-medium py-1.5 px-3 rounded-full text-xs lg:text-sm transition-colors duration-200 select-none {{ request()->routeIs('admin.dashboard') && !request()->routeIs('admin.skills.*', 'admin.projects.*', 'admin.experiences.*', 'admin.certificates.*') ? 'text-ps-primary dark:text-cyan-300 font-semibold active-nav' : 'text-slate-600 hover:text-slate-900 dark:text-gray-300 dark:hover:text-white' }}">
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.dashboard') }}#skills" 
               data-section="skills"
               class="admin-nav-item relative z-10 font-medium py-1.5 px-3 rounded-full text-xs lg:text-sm transition-colors duration-200 select-none {{ request()->routeIs('admin.skills.*') ? 'text-ps-primary dark:text-cyan-300 font-semibold active-nav' : 'text-slate-600 hover:text-slate-900 dark:text-gray-300 dark:hover:text-white' }}">
                <span>Skills</span>
            </a>
            <a href="{{ route('admin.dashboard') }}#projects" 
               data-section="projects"
               class="admin-nav-item relative z-10 font-medium py-1.5 px-3 rounded-full text-xs lg:text-sm transition-colors duration-200 select-none {{ request()->routeIs('admin.projects.*') ? 'text-ps-primary dark:text-cyan-300 font-semibold active-nav' : 'text-slate-600 hover:text-slate-900 dark:text-gray-300 dark:hover:text-white' }}">
                <span>Projects</span>
            </a>
            <a href="{{ route('admin.dashboard') }}#experiences" 
               data-section="experiences"
               class="admin-nav-item relative z-10 font-medium py-1.5 px-3 rounded-full text-xs lg:text-sm transition-colors duration-200 select-none {{ request()->routeIs('admin.experiences.*') ? 'text-ps-primary dark:text-cyan-300 font-semibold active-nav' : 'text-slate-600 hover:text-slate-900 dark:text-gray-300 dark:hover:text-white' }}">
                <span>Experience</span>
            </a>
            <a href="{{ route('admin.dashboard') }}#certificates" 
               data-section="certificates"
               class="admin-nav-item relative z-10 font-medium py-1.5 px-3 rounded-full text-xs lg:text-sm transition-colors duration-200 select-none {{ request()->routeIs('admin.certificates.*') ? 'text-ps-primary dark:text-cyan-300 font-semibold active-nav' : 'text-slate-600 hover:text-slate-900 dark:text-gray-300 dark:hover:text-white' }}">
                <span>Certificates</span>
            </a>
        </nav>

        <!-- Right Action Items: Theme Toggle, Web Publik & Logout -->
        <div class="flex items-center gap-2 sm:gap-3">
            <!-- Theme Toggle Button (Sun / Moon) -->
            <button id="admin-theme-toggle" type="button" aria-label="Toggle Theme"
                    class="p-2 sm:p-2.5 rounded-full bg-slate-200/70 hover:bg-slate-300/80 dark:bg-white/10 dark:hover:bg-white/20 text-slate-800 dark:text-amber-300 border border-slate-300/50 dark:border-white/10 transition-all duration-300 transform active:scale-90"
                    title="Ganti Mode Terang / Gelap">
                <!-- Sun Icon (Active in Dark Mode) -->
                <svg id="theme-icon-sun" class="w-4 h-4 hidden dark:block text-amber-300 transition-transform duration-500 hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="5" stroke-width="2" stroke="currentColor" fill="currentColor" fill-opacity="0.2"></circle>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
                </svg>
                <!-- Moon Icon (Active in Light Mode) -->
                <svg id="theme-icon-moon" class="w-4 h-4 block dark:hidden text-slate-700 transition-transform duration-500 hover:-rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>

            <!-- Public Website Link Button -->
            <a href="{{ route('home') }}" target="_blank" 
               class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-medium text-slate-700 dark:text-slate-300 bg-slate-200/60 dark:bg-white/5 hover:bg-slate-300/70 dark:hover:bg-white/10 border border-slate-300/60 dark:border-white/10 hover:border-ps-primary dark:hover:border-cyan-400/40 transition-colors"
               title="Buka Website Publik di Tab Baru">
                <span>Web Publik</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>

            <!-- Logout Button -->
            <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-3.5 py-1.5 rounded-full text-xs font-semibold text-rose-600 dark:text-rose-400 hover:text-white hover:bg-rose-600 dark:hover:bg-rose-500/30 border border-rose-400/30 transition-all">
                    Logout
                </button>
            </form>

            <!-- Mobile Menu Toggle Button -->
            <div class="flex items-center md:hidden">
                <button id="admin-mobile-toggle" type="button" aria-label="Toggle Menu" class="p-2 rounded-full text-slate-700 dark:text-slate-300 hover:bg-black/5 dark:hover:bg-white/10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Mobile Drawer Navigation for Admin -->
    <div id="admin-mobile-menu" class="hidden md:hidden fixed inset-x-4 top-24 z-50 rounded-2xl liquid-glass-nav p-5 space-y-3 text-sm shadow-2xl border border-slate-300/60 dark:border-white/10">
        <div class="flex justify-between items-center pb-2 border-b border-slate-200 dark:border-white/10">
            <span class="font-bold text-xs uppercase tracking-wider text-ps-primary dark:text-cyan-400">Navigasi Admin</span>
            <span class="text-xs text-slate-500 dark:text-gray-400">Control Hub</span>
        </div>
        <a href="{{ route('admin.dashboard') }}#dashboard" data-section="dashboard" class="admin-mobile-nav-item block px-3 py-2 rounded-xl text-slate-800 dark:text-slate-200 hover:bg-black/5 dark:hover:bg-white/5 font-medium transition-colors {{ request()->routeIs('admin.dashboard') && !request()->routeIs('admin.skills.*', 'admin.projects.*', 'admin.experiences.*', 'admin.certificates.*') ? 'text-ps-primary dark:text-cyan-400 font-bold bg-black/5 dark:bg-white/5 active-nav' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('admin.dashboard') }}#skills" data-section="skills" class="admin-mobile-nav-item block px-3 py-2 rounded-xl text-slate-800 dark:text-slate-200 hover:bg-black/5 dark:hover:bg-white/5 font-medium transition-colors {{ request()->routeIs('admin.skills.*') ? 'text-ps-primary dark:text-cyan-400 font-bold bg-black/5 dark:bg-white/5 active-nav' : '' }}">
            Skills
        </a>
        <a href="{{ route('admin.dashboard') }}#projects" data-section="projects" class="admin-mobile-nav-item block px-3 py-2 rounded-xl text-slate-800 dark:text-slate-200 hover:bg-black/5 dark:hover:bg-white/5 font-medium transition-colors {{ request()->routeIs('admin.projects.*') ? 'text-ps-primary dark:text-cyan-400 font-bold bg-black/5 dark:bg-white/5 active-nav' : '' }}">
            Projects
        </a>
        <a href="{{ route('admin.dashboard') }}#experiences" data-section="experiences" class="admin-mobile-nav-item block px-3 py-2 rounded-xl text-slate-800 dark:text-slate-200 hover:bg-black/5 dark:hover:bg-white/5 font-medium transition-colors {{ request()->routeIs('admin.experiences.*') ? 'text-ps-primary dark:text-cyan-400 font-bold bg-black/5 dark:bg-white/5 active-nav' : '' }}">
            Experience
        </a>
        <a href="{{ route('admin.dashboard') }}#certificates" data-section="certificates" class="admin-mobile-nav-item block px-3 py-2 rounded-xl text-slate-800 dark:text-slate-200 hover:bg-black/5 dark:hover:bg-white/5 font-medium transition-colors {{ request()->routeIs('admin.certificates.*') ? 'text-ps-primary dark:text-cyan-400 font-bold bg-black/5 dark:bg-white/5 active-nav' : '' }}">
            Certificates
        </a>
        <div class="pt-2 border-t border-slate-200 dark:border-white/10">
            <a href="{{ route('home') }}" target="_blank" class="block px-3 py-2 rounded-xl text-ps-primary dark:text-cyan-400 font-semibold hover:underline">
                Buka Web Publik ↗
            </a>
        </div>
    </div>

    <!-- Main Content Container (with generous top and bottom padding for smooth scrolling) -->
    <main class="pt-24 sm:pt-28 pb-36 flex-grow">
        @yield('content')
    </main>

    <!-- Admin Footer -->
    <footer class="border-t border-slate-200 dark:border-white/10 bg-slate-100 dark:bg-[#05070e] py-6 px-4 sm:px-6 lg:px-8 text-xs text-slate-500 dark:text-gray-400 transition-colors">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 font-mono">
            <div class="flex items-center gap-2 text-center sm:text-left">
                <span class="font-bold text-slate-800 dark:text-slate-200">Faiz Naufal Putra Permana</span>
                <span class="text-slate-400 dark:text-slate-600">•</span>
                <span>Admin Management Suite &copy; {{ date('Y') }}</span>
            </div>
            <div class="flex items-center gap-4 text-[11px] text-slate-400 dark:text-gray-500">
                <span>PlayStation 5 Liquid Glass Design System</span>
                <span class="hidden md:inline text-slate-300 dark:text-slate-700">•</span>
                <span class="hidden md:inline">Laravel {{ app()->version() }} (PHP {{ PHP_VERSION }})</span>
            </div>
            <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200/70 hover:bg-slate-300/70 dark:bg-white/[0.06] dark:hover:bg-white/[0.12] border border-slate-300 dark:border-white/10 text-slate-700 dark:text-slate-300 transition-all text-xs group" title="Kembali ke Bagian Paling Atas">
                <span>Ke Atas</span>
                <svg class="w-3.5 h-3.5 group-hover:-translate-y-0.5 transition-transform text-ps-primary dark:text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
            </button>
        </div>
    </footer>

    <!-- Interactive Navigation Scripts (Sliding Pill Track + Smooth Anchor Scroll) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Theme toggle script (Sync with public site localStorage)
            const themeBtn = document.getElementById('admin-theme-toggle');
            if (themeBtn) {
                themeBtn.addEventListener('click', () => {
                    const isDark = document.documentElement.classList.contains('dark');
                    if (isDark) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    }
                });
            }

            // Mobile Menu Toggle
            const mobileBtn = document.getElementById('admin-mobile-toggle');
            const mobileMenu = document.getElementById('admin-mobile-menu');
            if (mobileBtn && mobileMenu) {
                mobileBtn.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Smooth Scroll and Click Handler matching User Navbar with Physical Sliding Pill
            const pillEl = document.getElementById('admin-nav-pill');
            const navTrack = document.getElementById('admin-nav-track');
            const navLinks = Array.from(document.querySelectorAll('.admin-nav-item'));
            const mobileNavLinks = Array.from(document.querySelectorAll('.admin-mobile-nav-item'));
            const isDashboard = window.location.pathname.replace(/\/$/, '') === '{{ parse_url(route('admin.dashboard'), PHP_URL_PATH) }}' || window.location.pathname === '/admin';
            const sectionOrder = ['dashboard', 'skills', 'projects', 'experiences', 'certificates'];

            let isProgrammaticScroll = false;
            let currentAnimationId = null;
            let activeInterruptCleanup = null;
            let stepTimeouts = [];

            const clearStepTimeouts = () => {
                stepTimeouts.forEach(t => clearTimeout(t));
                stepTimeouts = [];
            };

            // Track the active section (server-rendered active route or initial hash)
            let currentActiveSection = 'dashboard';
            const serverActiveEl = navLinks.find(link => link.classList.contains('active-nav'));
            if (serverActiveEl && serverActiveEl.dataset.section) {
                currentActiveSection = serverActiveEl.dataset.section;
            }
            if (isDashboard && window.location.hash) {
                const hashSection = window.location.hash.substring(1);
                if (sectionOrder.includes(hashSection)) {
                    currentActiveSection = hashSection;
                }
            }

            function setPillPosition(targetEl) {
                if (!pillEl || !targetEl) return;
                pillEl.style.transform = `translate3d(${targetEl.offsetLeft}px, ${targetEl.offsetTop}px, 0)`;
                pillEl.style.width = `${targetEl.offsetWidth}px`;
                pillEl.style.height = `${targetEl.offsetHeight}px`;
                pillEl.style.opacity = '1';
            }

            function setActiveSection(sectionId, shouldUpdatePill = true) {
                currentActiveSection = sectionId;
                const activeEl = navLinks.find(link => link.dataset.section === sectionId);

                navLinks.forEach(link => {
                    if (link === activeEl) {
                        link.classList.add('text-ps-primary', 'dark:text-cyan-300', 'font-semibold', 'active-nav');
                        link.classList.remove('text-slate-600', 'dark:text-gray-300');
                    } else {
                        link.classList.remove('text-ps-primary', 'dark:text-cyan-300', 'font-semibold', 'active-nav');
                        link.classList.add('text-slate-600', 'dark:text-gray-300');
                    }
                });

                if (shouldUpdatePill && activeEl) {
                    setPillPosition(activeEl);
                }

                // Sync mobile drawer items
                mobileNavLinks.forEach(item => {
                    if (item.dataset.section === sectionId) {
                        item.classList.add('text-ps-primary', 'dark:text-cyan-400', 'font-bold', 'bg-black/5', 'dark:bg-white/5', 'active-nav');
                        item.classList.remove('text-slate-800', 'dark:text-slate-200');
                    } else {
                        item.classList.remove('text-ps-primary', 'dark:text-cyan-400', 'font-bold', 'bg-black/5', 'dark:bg-white/5', 'active-nav');
                        item.classList.add('text-slate-800', 'dark:text-slate-200');
                    }
                });
            }

            const updatePill = setActiveSection;



            // Immediately set active section and pill on load
            setActiveSection(currentActiveSection);

            if (document.fonts && document.fonts.ready) {
                document.fonts.ready.then(() => {
                    const activeEl = navLinks.find(link => link.dataset.section === currentActiveSection) || navLinks[0];
                    if (activeEl) setPillPosition(activeEl);
                });
            }

            window.addEventListener('resize', () => {
                const activeEl = navLinks.find(link => link.dataset.section === currentActiveSection) || navLinks[0];
                if (activeEl) setPillPosition(activeEl);
            });

            function rafSmoothScrollTo(targetY, duration, onComplete) {
                if (currentAnimationId) {
                    cancelAnimationFrame(currentAnimationId);
                    currentAnimationId = null;
                }
                if (activeInterruptCleanup) {
                    activeInterruptCleanup();
                    activeInterruptCleanup = null;
                }

                const startY = window.scrollY;
                const distance = targetY - startY;

                if (Math.abs(distance) < 2) {
                    if (onComplete) onComplete();
                    return;
                }

                const animDuration = duration || Math.min(850, Math.max(450, Math.abs(distance) * 0.22));
                const startTime = performance.now();

                const easeInOutCubic = (t) => {
                    return t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;
                };

                const prevScrollBehavior = document.documentElement.style.scrollBehavior;
                document.documentElement.style.scrollBehavior = 'auto';

                const onInterrupt = () => {
                    if (currentAnimationId) {
                        cancelAnimationFrame(currentAnimationId);
                        currentAnimationId = null;
                    }
                    document.documentElement.style.scrollBehavior = prevScrollBehavior;
                    clearStepTimeouts();
                    isProgrammaticScroll = false;
                    if (activeInterruptCleanup) {
                        activeInterruptCleanup();
                        activeInterruptCleanup = null;
                    }
                };

                window.addEventListener('wheel', onInterrupt, { passive: true });
                window.addEventListener('touchmove', onInterrupt, { passive: true });

                activeInterruptCleanup = () => {
                    window.removeEventListener('wheel', onInterrupt);
                    window.removeEventListener('touchmove', onInterrupt);
                };

                const step = (currentTime) => {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / animDuration, 1);
                    const ease = easeInOutCubic(progress);

                    window.scrollTo(0, startY + distance * ease);

                    if (progress < 1) {
                        currentAnimationId = requestAnimationFrame(step);
                    } else {
                        currentAnimationId = null;
                        document.documentElement.style.scrollBehavior = prevScrollBehavior;
                        if (activeInterruptCleanup) {
                            activeInterruptCleanup();
                            activeInterruptCleanup = null;
                        }
                        if (onComplete) onComplete();
                    }
                };

                currentAnimationId = requestAnimationFrame(step);
            }

            function scrollToSection(targetId) {
                const targetEl = document.getElementById(targetId);
                if (!targetEl) return;

                clearStepTimeouts();

                const currentSectionId = (navLinks.find(l => l.classList.contains('active-nav')) || {}).dataset?.section || 'dashboard';
                const startIndex = sectionOrder.indexOf(currentSectionId);
                const targetIndex = sectionOrder.indexOf(targetId);

                const offset = 85;
                const bodyRect = document.body.getBoundingClientRect().top;
                const elementRect = targetEl.getBoundingClientRect().top;
                const targetY = Math.max(0, elementRect - bodyRect - offset);

                if (startIndex === -1 || targetIndex === -1 || startIndex === targetIndex) {
                    updatePill(targetId);
                    rafSmoothScrollTo(targetY, 500);
                    return;
                }

                const distanceCount = Math.abs(targetIndex - startIndex);
                const direction = targetIndex > startIndex ? 1 : -1;
                const totalDuration = Math.min(850, Math.max(500, distanceCount * 130));
                const stepInterval = totalDuration / distanceCount;

                isProgrammaticScroll = true;

                // Animate intermediate items across the navbar so the pill visibly glides through each menu
                for (let i = 1; i <= distanceCount; i++) {
                    const nextIdx = startIndex + direction * i;
                    const nextId = sectionOrder[nextIdx];
                    const delay = Math.round(i * stepInterval);

                    const timeoutId = setTimeout(() => {
                        updatePill(nextId);
                    }, delay);
                    stepTimeouts.push(timeoutId);
                }

                rafSmoothScrollTo(targetY, totalDuration, () => {
                    updatePill(targetId);
                    clearStepTimeouts();
                    setTimeout(() => {
                        isProgrammaticScroll = false;
                    }, 100);
                });
            }

            if (isDashboard) {
                // Attach smooth scroll on click
                const allNavItems = [...navLinks, ...mobileNavLinks];
                allNavItems.forEach(item => {
                    item.addEventListener('click', (e) => {
                        const targetId = item.dataset.section;
                        const targetEl = document.getElementById(targetId);
                        if (targetEl) {
                            e.preventDefault();
                            scrollToSection(targetId);
                            if (history.pushState) {
                                history.pushState(null, null, '#' + targetId);
                            }
                            if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                                mobileMenu.classList.add('hidden');
                            }
                        }
                    });
                });

                // Check initial hash on page load
                if (window.location.hash) {
                    const hashId = window.location.hash.substring(1);
                    setTimeout(() => scrollToSection(hashId), 150);
                }

                // Scrollspy: update active indicator dynamically while scrolling
                const handleScroll = () => {
                    if (isProgrammaticScroll) return;

                    // Check if scrolled to bottom of page
                    const isAtBottom = (window.innerHeight + window.scrollY) >= (document.documentElement.scrollHeight - 120);
                    if (isAtBottom) {
                        updatePill(sectionOrder[sectionOrder.length - 1]);
                        return;
                    }

                    const sections = sectionOrder.map(id => document.getElementById(id)).filter(Boolean);
                    const scrollPos = window.scrollY + 180;

                    for (let i = sections.length - 1; i >= 0; i--) {
                        if (sections[i].offsetTop <= scrollPos) {
                            updatePill(sectionOrder[i]);
                            break;
                        }
                    }
                };

                window.addEventListener('scroll', handleScroll, { passive: true });
            }
        });
    </script>
</body>
</html>

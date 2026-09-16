import React, { useState, useEffect, useRef } from 'react';
import { smoothScrollTo } from '../utils/smoothScroll';

export default function Navbar({ resumeUrl, theme = 'dark', onToggleTheme }) {
    const [mobileOpen, setMobileOpen] = useState(false);
    const [activeSection, setActiveSection] = useState('home');
    const [pillStyle, setPillStyle] = useState({ left: 0, top: 0, width: 0, height: 0, opacity: 0 });

    const navRef = useRef(null);
    const itemRefs = useRef({});
    const isProgrammaticScrollRef = useRef(false);
    const stepTimeoutsRef = useRef([]);

    const navItems = [
        { id: 'home', label: 'Home' },
        { id: 'about', label: 'About' },
        { id: 'skills', label: 'Skills' },
        { id: 'projects', label: 'Projects' },
        { id: 'experience', label: 'Experience' },
        { id: 'certificates', label: 'Certificates' },
        { id: 'contacts', label: 'Contacts' }
    ];

    // Measure active button and glide the pill into exact pixel-perfect place
    const updatePill = () => {
        const activeEl = itemRefs.current[activeSection];
        if (activeEl) {
            setPillStyle({
                left: activeEl.offsetLeft,
                top: activeEl.offsetTop,
                width: activeEl.offsetWidth,
                height: activeEl.offsetHeight,
                opacity: 1,
            });
        }
    };

    useEffect(() => {
        updatePill();

        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(updatePill);
        }

        window.addEventListener('resize', updatePill);
        return () => window.removeEventListener('resize', updatePill);
    }, [activeSection]);

    // Lock body scroll when mobile navigation drawer is active
    useEffect(() => {
        if (mobileOpen) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
        return () => {
            document.body.style.overflow = '';
        };
    }, [mobileOpen]);

    const clearStepTimeouts = () => {
        stepTimeoutsRef.current.forEach((t) => clearTimeout(t));
        stepTimeoutsRef.current = [];
    };

    useEffect(() => {
        const handleScroll = () => {
            if (isProgrammaticScrollRef.current) return;

            // Check if user scrolled to bottom of page
            const isAtBottom = window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 120;
            if (isAtBottom && navItems.length > 0) {
                setActiveSection(navItems[navItems.length - 1].id);
                return;
            }

            const sections = navItems.map((item) => document.getElementById(item.id)).filter(Boolean);
            const scrollPos = window.scrollY + 180;

            for (let i = sections.length - 1; i >= 0; i--) {
                if (sections[i].offsetTop <= scrollPos) {
                    setActiveSection(navItems[i].id);
                    break;
                }
            }
        };

        const onUserInterrupt = () => {
            if (isProgrammaticScrollRef.current) {
                clearStepTimeouts();
                isProgrammaticScrollRef.current = false;
            }
        };

        window.addEventListener('scroll', handleScroll, { passive: true });
        window.addEventListener('wheel', onUserInterrupt, { passive: true });
        window.addEventListener('touchmove', onUserInterrupt, { passive: true });

        return () => {
            window.removeEventListener('scroll', handleScroll);
            window.removeEventListener('wheel', onUserInterrupt);
            window.removeEventListener('touchmove', onUserInterrupt);
            clearStepTimeouts();
        };
    }, []);

    const scrollTo = (targetId) => {
        clearStepTimeouts();
        setMobileOpen(false);

        const startIndex = navItems.findIndex((item) => item.id === activeSection);
        const targetIndex = navItems.findIndex((item) => item.id === targetId);

        if (startIndex === -1 || targetIndex === -1 || startIndex === targetIndex) {
            setActiveSection(targetId);
            smoothScrollTo(targetId, { offset: 80 });
            return;
        }

        const distanceCount = Math.abs(targetIndex - startIndex);
        const direction = targetIndex > startIndex ? 1 : -1;

        // Dynamic scroll duration based on distance: ~500ms to 850ms
        const totalDuration = Math.min(850, Math.max(500, distanceCount * 130));
        const stepInterval = totalDuration / distanceCount;

        isProgrammaticScrollRef.current = true;

        // Animate intermediate items across the navbar so the pill visibly glides through each menu
        for (let i = 1; i <= distanceCount; i++) {
            const nextIdx = startIndex + direction * i;
            const nextId = navItems[nextIdx].id;
            const delay = Math.round(i * stepInterval);

            const timeoutId = setTimeout(() => {
                setActiveSection(nextId);
            }, delay);
            stepTimeoutsRef.current.push(timeoutId);
        }

        smoothScrollTo(targetId, {
            offset: 80,
            duration: totalDuration,
            onComplete: () => {
                setActiveSection(targetId);
                clearStepTimeouts();
                setTimeout(() => {
                    isProgrammaticScrollRef.current = false;
                }, 100);
            },
        });
    };

    return (
        <>
            {/* Floating Liquid Glass Navbar Container */}
            <header className="fixed top-4 sm:top-5 inset-x-3 sm:inset-x-0 mx-auto max-w-5xl z-50 rounded-full liquid-glass-nav px-3 sm:px-6 h-14 sm:h-16 flex items-center justify-between shadow-2xl transition-all duration-300">
                {/* Brand Text (No logo, pure typography) */}
                <a
                    href="#home"
                    onClick={(e) => { e.preventDefault(); scrollTo('home'); }}
                    className="text-base sm:text-lg font-bold tracking-tight text-slate-900 dark:text-white hover:text-ps-primary dark:hover:text-blue-400 transition-colors shrink-0"
                    title="Faiz Naufal - Portfolio Home"
                >
                    <span>Faiz</span> <span className="text-ps-primary dark:text-blue-400 font-light">Naufal.</span>
                </a>

                {/* Desktop Navigation Links with Physical Sliding Pill Track */}
                <nav
                    ref={navRef}
                    className="hidden md:flex items-center relative p-1 rounded-full bg-slate-200/50 dark:bg-white/[0.04] border border-slate-300/50 dark:border-white/[0.08]"
                >
                    {/* Animated Sliding Liquid Glass Pill */}
                    <div
                        className="absolute top-0 left-0 rounded-full bg-white dark:bg-white/[0.12] border border-slate-300/80 dark:border-blue-400/40 shadow-sm dark:shadow-[0_0_16px_rgba(37,99,235,0.25)] pointer-events-none z-0 transition-all duration-300 ease-out"
                        style={{
                            transform: `translate3d(${pillStyle.left}px, ${pillStyle.top}px, 0)`,
                            width: `${pillStyle.width}px`,
                            height: `${pillStyle.height}px`,
                            opacity: pillStyle.opacity,
                        }}
                    />

                    {navItems.map((item) => {
                        const isActive = activeSection === item.id;
                        return (
                            <button
                                key={item.id}
                                ref={(el) => { itemRefs.current[item.id] = el; }}
                                onClick={() => scrollTo(item.id)}
                                className={`relative z-10 font-medium py-1.5 px-3 rounded-full text-xs lg:text-sm transition-colors duration-200 cursor-pointer select-none ${isActive
                                        ? 'text-ps-primary dark:text-blue-300 font-semibold'
                                        : 'text-slate-600 hover:text-slate-900 dark:text-gray-300 dark:hover:text-white'
                                    }`}
                            >
                                {item.label}
                            </button>
                        );
                    })}
                </nav>

                {/* Right Action Items: Theme Toggle & Resume Button */}
                <div className="flex items-center gap-2 sm:gap-3">
                    {/* Dark/Light Mode Switcher Button */}
                    <button
                        type="button"
                        onClick={onToggleTheme}
                        aria-label={`Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`}
                        title={`Ganti ke ${theme === 'dark' ? 'Mode Terang (Light)' : 'Mode Gelap (Dark)'}`}
                        className="p-2 sm:p-2.5 rounded-full bg-slate-200/70 hover:bg-slate-300/80 dark:bg-white/10 dark:hover:bg-white/20 text-slate-800 dark:text-amber-300 border border-slate-300/50 dark:border-white/10 transition-all duration-300 transform active:scale-90"
                    >
                        {theme === 'dark' ? (
                            // Sun Icon for Dark Mode
                            <svg className="w-4 h-4 text-amber-300 transition-transform duration-500 hover:rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="5" strokeWidth="2" stroke="currentColor" fill="currentColor" fillOpacity="0.2"></circle>
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
                            </svg>
                        ) : (
                            // Moon Icon for Light Mode
                            <svg className="w-4 h-4 text-slate-700 transition-transform duration-500 hover:-rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        )}
                    </button>

                    {/* Mobile Hamburger Button (Morphing into X) */}
                    <div className="flex items-center md:hidden">
                        <button
                            type="button"
                            onClick={() => setMobileOpen(!mobileOpen)}
                            aria-label={mobileOpen ? "Tutup menu" : "Buka menu"}
                            aria-expanded={mobileOpen}
                            className="p-2.5 rounded-full text-slate-700 dark:text-gray-300 hover:bg-slate-200/60 dark:hover:bg-white/10 active:scale-90 transition-all cursor-pointer flex items-center justify-center"
                        >
                            <div className="w-5 h-4 relative flex flex-col justify-between items-center">
                                <span className={`h-0.5 w-5 bg-current rounded-full transform transition-all duration-300 ease-in-out origin-center ${
                                    mobileOpen ? 'rotate-45 translate-y-[7px]' : 'translate-y-0'
                                }`} />
                                <span className={`h-0.5 w-5 bg-current rounded-full transition-all duration-200 ease-in-out ${
                                    mobileOpen ? 'opacity-0 scale-x-0' : 'opacity-100'
                                }`} />
                                <span className={`h-0.5 w-5 bg-current rounded-full transform transition-all duration-300 ease-in-out origin-center ${
                                    mobileOpen ? '-rotate-45 -translate-y-[7px]' : 'translate-y-0'
                                }`} />
                            </div>
                        </button>
                    </div>
                </div>
            </header>

            {/* Smooth Mobile Menu Backdrop */}
            <div
                onClick={() => setMobileOpen(false)}
                className={`fixed inset-0 z-40 bg-slate-950/40 dark:bg-black/70 backdrop-blur-sm md:hidden transition-all duration-300 ease-out ${
                    mobileOpen
                        ? 'opacity-100 pointer-events-auto visible'
                        : 'opacity-0 pointer-events-none invisible'
                }`}
                aria-hidden="true"
            />

            {/* Smooth Floating Mobile Menu Card */}
            <div
                className={`fixed top-20 sm:top-24 inset-x-3 sm:inset-x-6 mx-auto max-w-sm z-40 md:hidden transition-all duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] transform ${
                    mobileOpen
                        ? 'opacity-100 translate-y-0 scale-100 pointer-events-auto visible'
                        : 'opacity-0 -translate-y-3 scale-95 pointer-events-none invisible'
                }`}
                aria-hidden={!mobileOpen}
            >
                <div className="liquid-glass-nav bg-white/95 dark:bg-[#0b1120]/95 backdrop-blur-2xl rounded-2xl border border-slate-200/90 dark:border-white/10 shadow-2xl p-2.5 overflow-hidden">
                    {/* Direct Menu Items List (Clean, Smooth, Direct) */}
                    <nav className="flex flex-col gap-1">
                        {navItems.map((item) => {
                            const isActive = activeSection === item.id;
                            return (
                                <button
                                    key={item.id}
                                    onClick={() => scrollTo(item.id)}
                                    className={`w-full text-left py-2.5 px-4 rounded-xl transition-all duration-200 text-sm font-medium cursor-pointer active:scale-[0.98] ${
                                        isActive
                                            ? 'text-slate-900 dark:text-white font-semibold bg-slate-100/90 dark:bg-white/[0.08]'
                                            : 'text-slate-600 dark:text-gray-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100/60 dark:hover:bg-white/5 active:bg-slate-200/60 dark:active:bg-white/10'
                                    }`}
                                >
                                    {item.label}
                                </button>
                            );
                        })}
                    </nav>
                </div>
            </div>
        </>
    );
}

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
        { id: 'contacts', label: 'Contact' }
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

                    {/* Mobile Hamburger Button */}
                    <div className="flex items-center md:hidden">
                        <button
                            type="button"
                            onClick={() => setMobileOpen(!mobileOpen)}
                            aria-label="Toggle navigation menu"
                            className="p-2 rounded-full text-slate-700 dark:text-gray-300 hover:bg-black/5 dark:hover:bg-white/10"
                        >
                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            {/* Mobile Navigation Drawer */}
            {mobileOpen && (
                <div className="fixed inset-0 z-50 bg-slate-900/60 dark:bg-black/80 backdrop-blur-xl flex flex-col p-6 animate-fadeIn">
                    <div className="flex justify-between items-center border-b border-slate-200 dark:border-white/10 pb-4">
                        <span className="font-bold text-lg text-slate-900 dark:text-white">MENU NAVIGASI</span>
                        <button
                            type="button"
                            onClick={() => setMobileOpen(false)}
                            className="p-2 rounded-full text-slate-500 dark:text-gray-400 hover:text-white"
                        >
                            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <nav className="flex flex-col gap-5 mt-8 text-lg font-light">
                        {navItems.map((item, idx) => (
                            <button
                                key={item.id}
                                onClick={() => scrollTo(item.id)}
                                className="text-left text-slate-800 dark:text-gray-200 hover:text-ps-primary dark:hover:text-blue-400 py-1"
                            >
                                {idx + 1}. {item.label}
                            </button>
                        ))}
                    </nav>
                </div>
            )}
        </>
    );
}

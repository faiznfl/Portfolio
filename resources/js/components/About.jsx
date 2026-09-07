import React from 'react';

export default function About({ profile }) {
    const educationList = [
        {
            institution: 'Universitas Pamulang',
            major: 'Sistem Informasi',
            period: '2022 - 2026',
            gpa: '3.85',
            color: 'primary',
            icon: (
                <svg className="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="1.8">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 14v7" />
                </svg>
            ),
        },
    ];

    const interests = [
        {
            name: 'Software Development',
            icon: (
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
            ),
        },
        {
            name: 'Web Development',
            icon: (
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                </svg>
            ),
        },
        {
            name: 'Artificial Intelligence',
            icon: (
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="1.8">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M9.5 2A2.5 2.5 0 007 4.5c0 .28.05.54.13.79A3 3 0 005 8a3 3 0 00.35 1.4A3.5 3.5 0 004 12.5a3.5 3.5 0 001.5 2.87V16a3 3 0 003 3h1v2a1 1 0 001 1h.5a1 1 0 001-1V2H9.5zM14.5 2A2.5 2.5 0 0117 4.5c0 .28-.05.54-.13.79A3 3 0 0119 8a3 3 0 01-.35 1.4 3.5 3.5 0 011.35 3.1A3.5 3.5 0 0118.5 15.37V16a3 3 0 01-3 3h-1v2a1 1 0 01-1 1h-.5a1 1 0 01-1-1V2h2.5z" />
                </svg>
            ),
        },
        {
            name: 'UI/UX Design',
            icon: (
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="1.8">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M7 21a4 4 0 01-4-4 7 7 0 0114-1.5 7.02 7.02 0 013 5.5 4 4 0 01-4 4 4 4 0 01-4-4c0-.75.6-1.5 1.5-1.5s1.5.75 1.5 1.5a1 1 0 001 1 1 1 0 001-1 4.5 4.5 0 00-4.5-4.5A4.5 4.5 0 008 17a4 4 0 01-1 4z" />
                    <circle cx="8.5" cy="8.5" r="1" fill="currentColor" />
                    <circle cx="12" cy="6.5" r="1" fill="currentColor" />
                    <circle cx="15.5" cy="8.5" r="1" fill="currentColor" />
                </svg>
            ),
        },
        {
            name: 'Database Management',
            icon: (
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="1.8">
                    <ellipse cx="12" cy="5" rx="9" ry="3" />
                    <path strokeLinecap="round" d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3" />
                    <path strokeLinecap="round" d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5" />
                </svg>
            ),
        },
        {
            name: 'Information Technology',
            icon: (
                <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="1.8">
                    <rect x="4" y="4" width="16" height="16" rx="2" />
                    <rect x="9" y="9" width="6" height="6" />
                    <path strokeLinecap="round" d="M9 1v3M15 1v3M9 20v3M15 20v3M20 9h3M20 14h3M1 9h3M1 14h3" />
                </svg>
            ),
        },
    ];

    const bioNarrative =
        'Fresh graduate Sistem Informasi Universitas Pamulang dengan IPK 3.85, berfokus pada Web Development dan perancangan UI/UX. Terbiasa merancang antarmuka pengguna yang intuitif di Figma serta mengimplementasikannya menjadi aplikasi web menggunakan Laravel, PHP, MySQL, dan Tailwind CSS, termasuk integrasi payment gateway dan dashboard sistem. Terbuka untuk peluang kerja di bidang Web Development dan Software Engineering.';

    return (
        <section id="about" className="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-slate-200 dark:border-white/10 overflow-hidden transition-colors">
            {/* Ambient Background Glow matching other sections */}
            <div className="absolute top-1/4 left-1/3 -translate-x-1/2 -translate-y-1/2 w-[550px] h-[350px] bg-ps-primary/10 dark:bg-ps-primary/15 rounded-full blur-[140px] pointer-events-none z-0"></div>
            <div className="absolute top-1/2 right-1/4 w-[400px] h-[400px] bg-indigo-600/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

            <div className="max-w-7xl mx-auto space-y-12 relative z-10">
                {/* Header conforming strictly to the site-wide design system */}
                <div className="text-center space-y-2 max-w-2xl mx-auto">
                    <div className="section-tagline">GET TO KNOW ME</div>
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-light text-slate-900 dark:text-white tracking-tight">
                        About <span className="text-gradient-ps font-semibold">Me</span>
                    </h2>
                    <p className="text-slate-600 dark:text-gray-400 text-sm sm:text-base font-light">
                        Sedikit cerita tentang latar belakang dan minat saya di dunia teknologi.
                    </p>
                </div>

                {/* 2-Column Split Layout with Symmetrical Alignment */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-start">
                    {/* Left Column: Narrative Story & Education Cards */}
                    <div className="lg:col-span-6 space-y-4">
                        {/* Section Tag Indicator (Aligned with Right Column) */}
                        <div className="flex items-center gap-2 px-1">
                            <span className="w-2 h-2 rounded-full bg-ps-primary dark:bg-cyan-400 animate-pulse"></span>
                            <span className="text-xs font-mono font-bold tracking-widest uppercase text-ps-primary dark:text-cyan-400">
                                BIOGRAPHY &amp; EDUCATION
                            </span>
                        </div>

                        {/* Bio Narrative Card */}
                        <div className="glass-panel p-6 sm:p-7 shadow-sm dark:shadow-none">
                            <p className="text-slate-700 dark:text-slate-200 text-base sm:text-lg leading-relaxed font-light">
                                {bioNarrative}
                            </p>
                        </div>

                        {/* Education Cards Stack */}
                        <div className="space-y-4">
                            {educationList.map((edu, idx) => (
                                <div
                                    key={idx}
                                    className="glass-panel p-5 flex items-center gap-4 hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all duration-300 hover:scale-[1.01] shadow-sm dark:shadow-none group"
                                >
                                    <div
                                        className={`w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border transition-transform duration-300 group-hover:scale-105 ${
                                            edu.color === 'primary'
                                                ? 'bg-ps-primary/10 dark:bg-ps-primary/20 text-ps-primary dark:text-cyan-400 border-ps-primary/25 dark:border-cyan-400/30 group-hover:bg-ps-primary/15 dark:group-hover:bg-cyan-400/20'
                                                : 'bg-cyan-500/10 dark:bg-cyan-500/20 text-cyan-600 dark:text-cyan-300 border-cyan-500/25 dark:border-cyan-400/30 group-hover:bg-cyan-500/15'
                                        }`}
                                    >
                                        {edu.icon}
                                    </div>
                                    <div className="min-w-0 flex-1 space-y-1">
                                        <div className="flex flex-wrap items-center justify-between gap-x-2">
                                            <h4 className="text-base font-semibold text-slate-900 dark:text-white tracking-tight leading-snug group-hover:text-ps-primary dark:group-hover:text-cyan-300 transition-colors">
                                                {edu.institution}
                                            </h4>
                                            {edu.gpa && (
                                                <span className="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 text-xs font-mono font-semibold border border-emerald-500/20 shrink-0">
                                                    <span className="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                    IPK {edu.gpa}
                                                </span>
                                            )}
                                        </div>
                                        <div className="flex flex-wrap items-center justify-between gap-x-2">
                                            <p className="text-xs sm:text-sm text-ps-primary dark:text-cyan-300 font-medium">
                                                {edu.major}
                                            </p>
                                            {edu.period && (
                                                <span className="text-xs font-mono text-slate-500 dark:text-gray-400">
                                                    {edu.period}
                                                </span>
                                            )}
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* Right Column: Interests & Focus Areas */}
                    <div className="lg:col-span-6 space-y-4">
                        {/* Section Tag Indicator */}
                        <div className="flex items-center gap-2 px-1">
                            <span className="w-2 h-2 rounded-full bg-ps-primary dark:bg-cyan-400 animate-pulse"></span>
                            <span className="text-xs font-mono font-bold tracking-widest uppercase text-ps-primary dark:text-cyan-400">
                                INTERESTS &amp; FOCUS AREAS
                            </span>
                        </div>

                        {/* 2-Column Grid of Interest Cards */}
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            {interests.map((item, idx) => (
                                <div
                                    key={idx}
                                    className="glass-panel p-4 flex items-center gap-3.5 min-h-[70px] hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all duration-300 hover:scale-[1.02] shadow-sm dark:shadow-none group cursor-default"
                                >
                                    <div className="w-10 h-10 rounded-xl bg-slate-200/60 dark:bg-white/[0.05] border border-slate-300/60 dark:border-white/10 flex items-center justify-center shrink-0 text-ps-primary dark:text-cyan-300 group-hover:scale-110 group-hover:bg-ps-primary/10 dark:group-hover:bg-cyan-400/10 transition-all duration-200">
                                        {item.icon}
                                    </div>
                                    <span className="text-sm font-medium text-slate-800 dark:text-slate-200 tracking-tight leading-snug group-hover:text-ps-primary dark:group-hover:text-cyan-300 transition-colors">
                                        {item.name}
                                    </span>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

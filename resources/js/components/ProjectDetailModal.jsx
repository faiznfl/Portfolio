import React, { useEffect } from 'react';

export default function ProjectDetailModal({ project, onClose }) {
    useEffect(() => {
        if (!project) return;

        const handleKeyDown = (e) => {
            if (e.key === 'Escape') onClose();
        };
        window.addEventListener('keydown', handleKeyDown);

        // Lock background scrolling on body and html
        const originalBodyOverflow = document.body.style.overflow;
        const originalHtmlOverflow = document.documentElement.style.overflow;
        const originalBodyPaddingRight = document.body.style.paddingRight;

        // Prevent layout shift from scrollbar disappearing
        const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
        if (scrollbarWidth > 0) {
            document.body.style.paddingRight = `${scrollbarWidth}px`;
        }

        document.body.style.overflow = 'hidden';
        document.documentElement.style.overflow = 'hidden';

        return () => {
            window.removeEventListener('keydown', handleKeyDown);
            document.body.style.overflow = originalBodyOverflow;
            document.documentElement.style.overflow = originalHtmlOverflow;
            document.body.style.paddingRight = originalBodyPaddingRight;
        };
    }, [project, onClose]);

    if (!project) return null;

    const stacks = Array.isArray(project.tech_stacks)
        ? project.tech_stacks
        : (typeof project.tech_stacks === 'string' ? JSON.parse(project.tech_stacks) : []);

    const rawFeatures = (Array.isArray(project.key_features) && project.key_features.length > 0)
        ? project.key_features
        : (typeof project.key_features === 'string'
            ? (function () { try { return JSON.parse(project.key_features); } catch (e) { return []; } })()
            : (Array.isArray(project.key_metrics)
                ? project.key_metrics
                : (typeof project.key_metrics === 'string' ? (function () { try { return JSON.parse(project.key_metrics); } catch (e) { return []; } })() : [])));
    const features = (Array.isArray(rawFeatures) ? rawFeatures : []).map(f => typeof f === 'string' ? f.trim() : f).filter(Boolean);

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto overscroll-contain">
            {/* Soft Ambient Backdrop with Rich Blur */}
            <div
                className="fixed inset-0 bg-slate-900/60 dark:bg-black/80 backdrop-blur-md transition-opacity duration-300 overscroll-contain"
                onClick={onClose}
                onWheel={(e) => e.stopPropagation()}
                onTouchMove={(e) => e.stopPropagation()}
            />

            {/* Modal Dialog Card */}
            <div className="relative z-10 w-full max-w-4xl max-h-[90vh] bg-white dark:bg-[#0d1527] text-slate-900 dark:text-white border border-slate-200 dark:border-white/15 shadow-2xl dark:shadow-blue-950/30 rounded-3xl overflow-hidden flex flex-col my-auto transition-all transform duration-300 animate-fadeIn overscroll-contain">
                {/* Header Bar */}
                <div className="sticky top-0 z-20 bg-white/95 dark:bg-[#0d1527]/95 backdrop-blur-md px-6 sm:px-8 py-4 border-b border-slate-100 dark:border-white/10 flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <span className="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-mono font-bold tracking-wider uppercase bg-ps-primary/10 text-ps-primary dark:text-blue-400 border border-ps-primary/20 dark:border-blue-500/30">
                            PROJECT SHOWCASE
                        </span>
                        {project.is_featured && (
                            <span className="hidden sm:inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-mono uppercase bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 font-semibold">
                                ★ Featured
                            </span>
                        )}
                    </div>

                    <button
                        type="button"
                        onClick={onClose}
                        aria-label="Tutup Dialog"
                        className="w-8 h-8 sm:w-9 sm:h-9 rounded-full flex items-center justify-center text-slate-400 hover:text-slate-900 dark:text-gray-400 dark:hover:text-white bg-slate-100 hover:bg-slate-200 dark:bg-white/[0.08] dark:hover:bg-white/[0.16] border border-slate-200/80 dark:border-white/10 transition-all hover:rotate-90 duration-200 cursor-pointer shadow-xs"
                    >
                        <svg className="w-4 h-4 sm:w-4.5 sm:h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {/* Scrollable Content Body */}
                <div className="overflow-y-auto p-6 sm:p-8 overscroll-contain">
                    {/* Responsive 2-Column Grid */}
                    <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        {/* Left Column: Cover Mockup & Actions */}
                        <div className="lg:col-span-5 space-y-4">
                            <div className="relative w-full aspect-video rounded-2xl overflow-hidden bg-slate-100 dark:bg-[#070a12] border border-slate-200/80 dark:border-white/10 shadow-md">
                                <img
                                    src={project.cover_image || '/assets/projects/project-omnipulse.svg'}
                                    alt={project.title}
                                    className="w-full h-full object-cover"
                                />
                            </div>

                            {/* CTAs Attached Beneath Image */}
                            {(project.demo_url || project.repo_url) && (
                                <div className="flex flex-wrap sm:flex-nowrap items-center gap-3 pt-1">
                                    {project.demo_url && (
                                        <a
                                            href={project.demo_url}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-white bg-blue-600 hover:bg-blue-500 shadow-md shadow-blue-600/30 hover:-translate-y-0.5 active:translate-y-0 transition-all text-center cursor-pointer group"
                                        >
                                            <span>Live Demo</span>
                                            <svg className="w-3.5 h-3.5 shrink-0 transform group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    )}

                                    {project.repo_url && (
                                        <a
                                            href={project.repo_url}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-white/[0.08] dark:hover:bg-white/[0.14] border border-slate-300/80 dark:border-white/12 hover:-translate-y-0.5 active:translate-y-0 transition-all text-center cursor-pointer group"
                                        >
                                            <svg className="w-4 h-4 text-slate-800 dark:text-white shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                <path fillRule="evenodd" clipRule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                                            </svg>
                                            <span>GitHub</span>
                                        </a>
                                    )}
                                </div>
                            )}
                        </div>

                        {/* Right Column: Title, Deskripsi, Key Features & Tech Stack */}
                        <div className="lg:col-span-7 space-y-6">
                            {/* Title & Deskripsi */}
                            <div className="space-y-3">
                                <h3 className="text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white tracking-tight leading-snug">
                                    {project.title}
                                </h3>
                                <p className="text-sm sm:text-base text-slate-600 dark:text-gray-300 leading-relaxed font-light">
                                    {project.summary}
                                </p>
                            </div>

                            {/* Fitur Utama (Key Features) */}
                            {features.length > 0 && (
                                <div className="p-4 sm:p-5 rounded-2xl bg-blue-500/5 dark:bg-blue-950/20 border border-blue-500/20 space-y-3">
                                    <div className="flex items-center gap-2 text-ps-primary dark:text-blue-400">
                                        <svg className="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <h4 className="text-xs font-mono font-bold uppercase tracking-wider">
                                            Fitur-Fitur Utama (Key Features)
                                        </h4>
                                    </div>
                                    <ul className="space-y-2">
                                        {features.map((feature, idx) => (
                                            <li key={idx} className="flex items-start gap-2.5 text-xs sm:text-sm text-slate-700 dark:text-gray-200 leading-relaxed">
                                                <span className="w-4 h-4 rounded-full bg-blue-500/20 text-ps-primary dark:text-blue-300 flex items-center justify-center shrink-0 mt-0.5"><svg className="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M5 13l4 4L19 7" /></svg></span>
                                                <span>{feature}</span>
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            )}

                            {/* Teknologi yang Digunakan (Tech Stack) */}
                            {stacks.length > 0 && (
                                <div className="space-y-2.5 pt-1">
                                    <h4 className="text-[11px] font-mono uppercase tracking-widest text-slate-400 dark:text-gray-500 font-bold">
                                        Teknologi yang Digunakan (Tech Stack)
                                    </h4>
                                    <div className="flex flex-wrap gap-2">
                                        {stacks.map((tech, idx) => (
                                            <span
                                                key={idx}
                                                className="px-3 py-1.5 rounded-lg text-xs font-mono font-medium bg-slate-100 dark:bg-white/[0.06] text-slate-700 dark:text-gray-200 border border-slate-200/80 dark:border-white/10 hover:border-ps-primary/50 transition-colors"
                                            >
                                                {tech}
                                            </span>
                                        ))}
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

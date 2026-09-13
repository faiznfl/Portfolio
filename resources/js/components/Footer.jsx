import React from 'react';
import { smoothScrollTo } from '../utils/smoothScroll';

export default function Footer() {
    return (
        <footer className="border-t border-slate-200/80 dark:border-white/[0.08] bg-slate-50 dark:bg-[#070a14] py-8 sm:py-9 px-4 sm:px-6 lg:px-8 transition-colors select-none font-sans">
            <div className="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-5 sm:gap-4">
                {/* Left: Copyright */}
                <div className="text-xs sm:text-sm text-slate-500 dark:text-slate-400 text-center sm:text-left">
                    <span>&copy; {new Date().getFullYear()} Faiz Naufal Putra Permana. All rights reserved.</span>
                </div>

                {/* Center: 3 Circular Social Buttons */}
                <div className="flex items-center gap-3">
                    {/* GitHub */}
                    <a
                        href="https://github.com/faiznfl"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="w-10 h-10 rounded-full bg-slate-200/50 dark:bg-white/[0.04] border border-slate-300/70 dark:border-white/10 hover:bg-slate-300/60 dark:hover:bg-white/[0.08] hover:border-slate-400 dark:hover:border-white/20 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all duration-200 shadow-sm"
                        title="GitHub"
                        aria-label="GitHub"
                    >
                        <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z" />
                        </svg>
                    </a>

                    {/* LinkedIn */}
                    <a
                        href="https://www.linkedin.com/in/faiz-naufal-putra-permana"
                        target="_blank"
                        rel="noopener noreferrer"
                        className="w-10 h-10 rounded-full bg-slate-200/50 dark:bg-white/[0.04] border border-slate-300/70 dark:border-white/10 hover:bg-slate-300/60 dark:hover:bg-white/[0.08] hover:border-slate-400 dark:hover:border-white/20 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all duration-200 shadow-sm"
                        title="LinkedIn"
                        aria-label="LinkedIn"
                    >
                        <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </a>

                    {/* Email */}
                    <a
                        href="mailto:faiznfl20@gmail.com"
                        className="w-10 h-10 rounded-full bg-slate-200/50 dark:bg-white/[0.04] border border-slate-300/70 dark:border-white/10 hover:bg-slate-300/60 dark:hover:bg-white/[0.08] hover:border-slate-400 dark:hover:border-white/20 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all duration-200 shadow-sm"
                        title="Email"
                        aria-label="Email"
                    >
                        <svg className="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" strokeWidth="1.8">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </a>
                </div>

                {/* Right: Circular Back to Top Button */}
                <button
                    type="button"
                    onClick={() => smoothScrollTo(0, { duration: 600 })}
                    className="w-10 h-10 rounded-full bg-slate-200/50 dark:bg-white/[0.04] border border-slate-300/70 dark:border-white/10 hover:bg-slate-300/60 dark:hover:bg-white/[0.08] hover:border-slate-400 dark:hover:border-white/20 flex items-center justify-center text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all duration-200 cursor-pointer shadow-sm"
                    title="Kembali ke Atas"
                    aria-label="Kembali ke Atas"
                >
                    <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                </button>
            </div>
        </footer>
    );
}

import React, { Suspense } from 'react';
import LanyardBadge3D from './LanyardBadge3D';
import Interactive3DCard from './Interactive3DCard';
import AmbientCanvas from './AmbientCanvas';
import { smoothScrollTo } from '../utils/smoothScroll';

export default function Hero({ profile, resumeUrl, resumePreviewUrl }) {
    const scrollTo = (id) => {
        smoothScrollTo(id, { offset: 80 });
    };

    const githubUrl = profile?.social_links?.github || 'https://github.com/faiznfl';
    const linkedinUrl = profile?.social_links?.linkedin || 'https://www.linkedin.com/in/faiz-naufal-putra-permana';
    const emailAddress = profile?.social_links?.email || profile?.email || 'faiznfl20@gmail.com';

    return (
        <section id="home" className="relative min-h-[90vh] flex items-center pt-24 sm:pt-32 lg:pt-36 pb-14 sm:pb-20 px-4 sm:px-6 lg:px-8 overflow-hidden">
            {/* Interactive Ambient Particle Canvas */}
            <AmbientCanvas />

            {/* Ambient Background Glows */}
            <div className="absolute top-1/4 left-1/3 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-ps-primary/10 dark:bg-ps-primary/15 rounded-full blur-[140px] pointer-events-none z-0"></div>
            <div className="absolute top-1/3 right-1/4 w-[450px] h-[450px] bg-blue-600/10 rounded-full blur-[120px] pointer-events-none z-0"></div>

            <div className="max-w-7xl mx-auto w-full relative z-10 pointer-events-auto">
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8 lg:gap-8 items-center">
                    {/* Text Column: Greeting, Role & CTAs (order-2 on mobile/tablet, order-1 on desktop) */}
                    <div className="order-2 lg:order-1 lg:col-span-7 space-y-5 sm:space-y-6 text-center lg:text-left relative z-20 pointer-events-auto">

                        {/* Main Title matching reference */}
                        <div className="space-y-2">
                            <h1 className="text-3xl sm:text-5xl lg:text-7xl font-light tracking-tight text-slate-900 dark:text-white leading-[1.12]">
                                Hi, I'm <span className="text-gradient-ps font-semibold">{profile?.full_name || 'Faiz Naufal Putra Permana'}</span>
                            </h1>
                            <div className="text-lg sm:text-2xl font-normal text-ps-primary dark:text-blue-300 font-sans tracking-wide pt-1">
                                {profile?.headline || 'Web Developer'}
                            </div>
                        </div>

                        {/* Short Bio Description */}
                        <p className="text-sm sm:text-lg text-slate-600 dark:text-gray-300 font-light leading-relaxed max-w-xl mx-auto lg:mx-0">
                            {profile?.bio_about || 'Selamat datang di portofolio saya. Silakan tambahkan informasi profil dan portofolio Anda melalui panel admin.'}
                        </p>

                        {/* 3 Action Buttons (ATM Reference Pill Buttons) */}
                        <div className="flex flex-wrap items-center justify-center lg:justify-start gap-2.5 sm:gap-3.5 pt-2 sm:pt-3 relative z-30 pointer-events-auto">
                            <a
                                href={resumePreviewUrl || '/resume/preview'}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="btn-ps-primary !bg-blue-600 hover:!bg-blue-500 !shadow-lg !shadow-blue-600/30 cursor-pointer flex items-center gap-2"
                                title="Download CV"
                            >
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Download CV</span>
                            </a>
                            <button
                                onClick={() => scrollTo('contacts')}
                                className="btn-ps-outline-dark !border-slate-300 dark:!border-white/15 !text-slate-800 dark:!text-white !bg-white/70 dark:!bg-transparent"
                            >
                                <span>Contact Me</span>
                            </button>
                            <button
                                onClick={() => scrollTo('projects')}
                                className="btn-ps-outline-dark !border-slate-300 dark:!border-white/15 !text-slate-800 dark:!text-white !bg-white/70 dark:!bg-transparent"
                            >
                                <span>Projects</span>
                            </button>
                        </div>

                        {/* Social Links (GitHub, LinkedIn, Email / Gmail) */}
                        <div className="flex items-center justify-center lg:justify-start gap-3 pt-1 sm:pt-2 relative z-30 pointer-events-auto">
                            {/* GitHub Button */}
                            <a
                                href={githubUrl}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="w-10 h-10 rounded-full bg-slate-200/70 dark:bg-white/[0.05] border border-slate-300/80 dark:border-white/10 hover:border-ps-primary dark:hover:border-blue-400/50 hover:bg-ps-primary/10 dark:hover:bg-blue-500/10 text-slate-700 dark:text-slate-300 hover:text-ps-primary dark:hover:text-blue-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95"
                                title="GitHub Profile"
                                aria-label="GitHub Profile"
                            >
                                <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z" />
                                </svg>
                            </a>

                            {/* LinkedIn Button */}
                            <a
                                href={linkedinUrl}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="w-10 h-10 rounded-full bg-slate-200/70 dark:bg-white/[0.05] border border-slate-300/80 dark:border-white/10 hover:border-ps-primary dark:hover:border-blue-400/50 hover:bg-ps-primary/10 dark:hover:bg-blue-500/10 text-slate-700 dark:text-slate-300 hover:text-ps-primary dark:hover:text-blue-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95"
                                title="LinkedIn Profile"
                                aria-label="LinkedIn Profile"
                            >
                                <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                </svg>
                            </a>

                            {/* Email / Gmail Button */}
                            <a
                                href={`mailto:${emailAddress}`}
                                className="w-10 h-10 rounded-full bg-slate-200/70 dark:bg-white/[0.05] border border-slate-300/80 dark:border-white/10 hover:border-ps-primary dark:hover:border-blue-400/50 hover:bg-ps-primary/10 dark:hover:bg-blue-500/10 text-slate-700 dark:text-slate-300 hover:text-ps-primary dark:hover:text-blue-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95"
                                title={`Email: ${emailAddress}`}
                                aria-label="Send Email"
                            >
                                <svg className="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" strokeWidth="1.8">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    {/* Lanyard Column: Interactive 3D Physics Lanyard Badge (order-1 on mobile/tablet, order-2 on desktop) */}
                    <div className="order-1 lg:order-2 lg:col-span-5 relative flex flex-col items-center justify-center min-h-[420px] sm:min-h-[500px] lg:min-h-[640px] z-10 overflow-visible -mt-5 sm:-mt-8 lg:-mt-12">
                        <div className="w-full h-full flex items-center justify-center overflow-visible">
                            <Suspense fallback={<Interactive3DCard profile={profile} />}>
                                <LanyardBadge3D
                                    profile={profile}
                                    fallbackComponent={<Interactive3DCard profile={profile} />}
                                />
                            </Suspense>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

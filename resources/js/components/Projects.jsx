import React from 'react';

export default function Projects({ projects = [], onSelectProject }) {
    return (
        <section id="projects" className="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-slate-200 dark:border-white/10 overflow-hidden transition-colors">
            <div className="max-w-7xl mx-auto space-y-12 relative z-10">
                {/* Header */}
                <div className="text-center space-y-2 max-w-2xl mx-auto">
                    <div className="section-tagline">TAKE A LOOK AT MY</div>
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-light text-slate-900 dark:text-white tracking-tight">
                        Featured <span className="text-gradient-ps font-semibold">Projects</span>
                    </h2>
                    <p className="text-slate-600 dark:text-gray-400 text-sm sm:text-base font-light">
                        Kumpulan proyek yang saya kerjakan, meliputi pengembangan sistem terdistribusi, aplikasi web, dan proyek-proyek lainnya.
                    </p>
                </div>

                {/* 3-Column Projects Grid */}
                <div
                    className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                    id="projects-grid"
                >
                    {projects.length === 0 ? (
                        <div className="col-span-full py-16 text-center text-slate-400 dark:text-gray-500 font-light border border-dashed border-slate-200 dark:border-white/10 rounded-2xl p-8">
                            <div className="w-10 h-10 mx-auto mb-3 text-slate-400 dark:text-gray-500 flex items-center justify-center">
                                <svg className="w-8 h-8 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                            </div>
                            <span className="text-sm">Belum ada proyek yang ditambahkan.</span>
                        </div>
                    ) : (
                        projects.map((project, index) => {
                            const stacks = Array.isArray(project.tech_stacks)
                                ? project.tech_stacks
                                : (typeof project.tech_stacks === 'string' ? JSON.parse(project.tech_stacks) : []);

                            return (
                                <article
                                    key={project.id || project.slug}
                                    style={{ animationDelay: `${Math.min(index * 45, 250)}ms` }}
                                    onClick={() => onSelectProject && onSelectProject(project)}
                                    onKeyDown={(e) => {
                                        if (e.key === 'Enter' || e.key === ' ') {
                                            e.preventDefault();
                                            onSelectProject && onSelectProject(project);
                                        }
                                    }}
                                    tabIndex={0}
                                    role="button"
                                    className="glass-panel filter-item-animate flex flex-col overflow-hidden group cursor-pointer hover:border-ps-primary dark:hover:border-blue-400/40 transition-all duration-300 hover:-translate-y-1.5 shadow-md dark:shadow-xl focus:outline-none focus:ring-2 focus:ring-ps-primary/50"
                                >
                                    {/* Project Cover Mockup */}
                                    <div className="relative w-full aspect-video bg-slate-100 dark:bg-[#0a0d1a] overflow-hidden border-b border-slate-200 dark:border-white/10">
                                        <img
                                            src={project.cover_image || '/assets/projects/project-omnipulse.svg'}
                                            alt={project.title}
                                            className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                            loading="lazy"
                                        />
                                    </div>

                                    {/* Card Body */}
                                    <div className="p-6 flex-grow flex flex-col justify-between space-y-4">
                                        <div className="space-y-2">
                                            <h3 className="text-xl font-bold text-slate-900 dark:text-white tracking-tight group-hover:text-ps-primary dark:group-hover:text-blue-300 transition-colors">
                                                {project.title}
                                            </h3>
                                            <p className="text-sm text-slate-600 dark:text-gray-300 line-clamp-3 leading-relaxed font-light">
                                                {project.summary}
                                            </p>
                                        </div>

                                        {/* Tech Stack Pills */}
                                        <div className="flex flex-wrap gap-1.5 pt-1">
                                            {stacks.slice(0, 4).map((stack, idx) => (
                                                <span
                                                    key={idx}
                                                    className="px-2.5 py-0.5 rounded text-[11px] font-mono font-medium bg-slate-200/80 dark:bg-white/10 text-slate-700 dark:text-gray-300 border border-slate-300/60 dark:border-white/10"
                                                >
                                                    {stack}
                                                </span>
                                            ))}
                                            {stacks.length > 4 && (
                                                <span className="px-2 py-0.5 rounded text-[11px] font-mono text-slate-500 dark:text-gray-400 bg-slate-100 dark:bg-white/5">
                                                    +{stacks.length - 4}
                                                </span>
                                            )}
                                        </div>

                                        {/* Action Footer with Live Demo & Repository */}
                                        {(project.demo_url || project.repo_url) && (
                                            <div className="pt-4 border-t border-slate-200 dark:border-white/10 flex items-center justify-end gap-2">
                                                {project.demo_url && (
                                                    <a
                                                        href={project.demo_url}
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        onClick={(e) => e.stopPropagation()}
                                                        className="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium text-white bg-blue-600 hover:bg-blue-500 shadow-sm shadow-blue-600/30 transition-all cursor-pointer"
                                                        title="Buka Live Demo"
                                                    >
                                                        <span>Demo</span>
                                                        <svg className="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                        </svg>
                                                    </a>
                                                )}

                                                {project.repo_url && (
                                                    <a
                                                        href={project.repo_url}
                                                        target="_blank"
                                                        rel="noopener noreferrer"
                                                        onClick={(e) => e.stopPropagation()}
                                                        className="w-7 h-7 rounded-full inline-flex items-center justify-center text-slate-600 dark:text-gray-300 hover:text-slate-900 dark:hover:text-white bg-slate-100 hover:bg-slate-200 dark:bg-white/[0.08] dark:hover:bg-white/[0.15] border border-slate-200 dark:border-white/10 transition-all cursor-pointer"
                                                        title="Lihat Repositori GitHub"
                                                    >
                                                        <svg className="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                            <path fillRule="evenodd" clipRule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.53 1.032 1.53 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" />
                                                        </svg>
                                                    </a>
                                                )}
                                            </div>
                                        )}
                                    </div>
                                </article>
                            );
                        })
                    )}
                </div>
            </div>
        </section>
    );
}

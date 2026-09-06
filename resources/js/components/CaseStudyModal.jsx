import React, { useState, useEffect } from 'react';

export default function CaseStudyModal({ project, onClose }) {
    const [activeTab, setActiveTab] = useState('overview');

    useEffect(() => {
        const handleKeyDown = (e) => {
            if (e.key === 'Escape') onClose();
        };
        window.addEventListener('keydown', handleKeyDown);
        return () => window.removeEventListener('keydown', handleKeyDown);
    }, [onClose]);

    if (!project) return null;

    const stacks = Array.isArray(project.tech_stacks)
        ? project.tech_stacks
        : (typeof project.tech_stacks === 'string' ? JSON.parse(project.tech_stacks) : []);

    const metrics = Array.isArray(project.key_metrics)
        ? project.key_metrics
        : (typeof project.key_metrics === 'string' ? JSON.parse(project.key_metrics) : []);

    const handleTabClick = (tabKey) => {
        setActiveTab(tabKey);
    };

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 animate-fadeIn">
            {/* Backdrop */}
            <div
                className="fixed inset-0 modal-backdrop"
                onClick={onClose}
            />

            {/* Dialog Box */}
            <div className="relative z-10 w-full max-w-4xl max-h-[90vh] glass-panel bg-white/95 dark:bg-[#0d1322]/95 text-slate-900 dark:text-white border border-slate-200 dark:border-white/20 shadow-2xl overflow-y-auto flex flex-col">
                {/* Modal Header */}
                <div className="sticky top-0 z-20 bg-white/95 dark:bg-[#0d1322]/95 backdrop-blur-md px-6 py-4 border-b border-slate-200 dark:border-white/10 flex items-center justify-between">
                    <div>
                        <span className="text-xs font-mono uppercase tracking-widest text-ps-primary dark:text-cyan-400 font-bold">
                            {project.category}
                        </span>
                        <h3 className="text-xl font-bold text-slate-900 dark:text-white tracking-tight">{project.title}</h3>
                    </div>
                    <button
                        type="button"
                        onClick={onClose}
                        className="p-2 rounded-full text-slate-400 hover:text-slate-900 dark:text-gray-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/10 transition-colors"
                    >
                        <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {/* Interactive Modal Navigation Tabs */}
                <div className="flex border-b border-slate-200 dark:border-white/10 px-6 bg-slate-50 dark:bg-black/40 overflow-x-auto gap-2">
                    <button
                        type="button"
                        onClick={() => handleTabClick('overview')}
                        className={`modal-tab-btn ${activeTab === 'overview' ? 'active' : ''}`}
                    >
                        Ringkasan
                    </button>
                    <button
                        type="button"
                        onClick={() => handleTabClick('solution')}
                        className={`modal-tab-btn ${activeTab === 'solution' ? 'active' : ''}`}
                    >
                        Tantangan &amp; Solusi
                    </button>
                    <button
                        type="button"
                        onClick={() => handleTabClick('architecture')}
                        className={`modal-tab-btn ${activeTab === 'architecture' ? 'active' : ''}`}
                    >
                        Arsitektur &amp; Stack
                    </button>
                    <button
                        type="button"
                        onClick={() => handleTabClick('metrics')}
                        className={`modal-tab-btn ${activeTab === 'metrics' ? 'active' : ''}`}
                    >
                        Metrik &amp; Dampak
                    </button>
                </div>

                {/* Modal Content Panels */}
                <div className="p-6 sm:p-8 space-y-6">
                    {activeTab === 'overview' && (
                        <div className="space-y-6">
                            <div className="w-full aspect-video rounded-xl overflow-hidden bg-slate-100 dark:bg-black border border-slate-200 dark:border-white/10 shadow-lg">
                                <img
                                    src={project.cover_image || '/assets/projects/project-omnipulse.svg'}
                                    alt={project.title}
                                    className="w-full h-full object-cover"
                                />
                            </div>
                            <div className="space-y-2">
                                <h4 className="text-xs font-mono font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400">Ringkasan Eksekutif</h4>
                                <p className="text-base text-slate-700 dark:text-gray-200 leading-relaxed font-light">{project.summary}</p>
                            </div>
                        </div>
                    )}

                    {activeTab === 'solution' && (
                        <div className="space-y-6">
                            <div className="p-5 rounded-xl bg-red-500/10 dark:bg-red-950/30 border border-red-500/20 dark:border-red-500/30 space-y-2">
                                <h4 className="text-xs font-mono font-bold uppercase tracking-wider text-red-600 dark:text-red-400">
                                    01. Problem Statement (Tantangan &amp; Bottleneck Awal)
                                </h4>
                                <p className="text-sm text-slate-700 dark:text-gray-300 leading-relaxed font-light">
                                    {project.problem_statement || 'Studi kasus performa tinggi dengan kebutuhan arsitektur terukur.'}
                                </p>
                            </div>
                            <div className="p-5 rounded-xl bg-emerald-500/10 dark:bg-emerald-950/30 border border-emerald-500/20 dark:border-emerald-500/30 space-y-2">
                                <h4 className="text-xs font-mono font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                                    02. Engineering Solution (Solusi Rekayasa Sistem)
                                </h4>
                                <p className="text-sm text-slate-700 dark:text-gray-300 leading-relaxed font-light">
                                    {project.solution_details || 'Implementasi modular service berbasis clean architecture dan testing terstandarisasi.'}
                                </p>
                            </div>
                        </div>
                    )}

                    {activeTab === 'architecture' && (
                        <div className="space-y-6">
                            <div className="p-5 rounded-xl bg-blue-500/10 dark:bg-blue-950/30 border border-blue-500/20 dark:border-blue-500/30 space-y-2">
                                <h4 className="text-xs font-mono font-bold uppercase tracking-wider text-ps-primary dark:text-cyan-400">
                                    03. System Architecture &amp; Technical Decisions
                                </h4>
                                <p className="text-sm text-slate-700 dark:text-gray-300 leading-relaxed font-light">
                                    {project.architecture_details || 'Arsitektur terdistribusi dengan high-availability SLA dan automated CI/CD.'}
                                </p>
                            </div>
                            <div className="space-y-2">
                                <h4 className="text-xs font-mono font-bold uppercase tracking-wider text-slate-500 dark:text-gray-400">Teknologi &amp; Dependencies</h4>
                                <div className="flex flex-wrap gap-2">
                                    {stacks.map((tech, idx) => (
                                        <span
                                            key={idx}
                                            className="px-3 py-1 rounded-full text-xs font-mono font-medium bg-ps-primary/10 dark:bg-blue-900/40 text-ps-primary dark:text-cyan-300 border border-ps-primary/20 dark:border-blue-700/50"
                                        >
                                            {tech}
                                        </span>
                                    ))}
                                </div>
                            </div>
                        </div>
                    )}

                    {activeTab === 'metrics' && (
                        <div className="space-y-6">
                            <div className="space-y-3 bg-slate-50 dark:bg-black/40 p-6 rounded-xl border border-slate-200 dark:border-white/10">
                                <h4 className="text-xs font-mono font-bold uppercase tracking-wider text-amber-600 dark:text-yellow-400">
                                    04. Hasil Terukur, Uptime &amp; SLA
                                </h4>
                                <ul className="space-y-3">
                                    {metrics.map((metric, idx) => (
                                        <li key={idx} className="flex items-center gap-2.5 text-sm text-slate-700 dark:text-gray-200">
                                            <span className="w-5 h-5 rounded-full bg-green-500/20 text-green-600 dark:text-green-400 flex items-center justify-center text-xs font-bold shrink-0">
                                                ✓
                                            </span>
                                            <span>{metric}</span>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                    )}

                    {/* Action Links Footer */}
                    <div className="flex items-center gap-4 pt-4 border-t border-slate-200 dark:border-white/10">
                        {project.demo_url && (
                            <a
                                href={project.demo_url}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="btn-ps-primary"
                            >
                                <span>Buka Live Demo</span>
                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        )}
                        {project.repo_url && (
                            <a
                                href={project.repo_url}
                                target="_blank"
                                rel="noopener noreferrer"
                                className="btn-ps-outline-dark !border-slate-300 dark:!border-white/15 !text-slate-800 dark:!text-white !bg-white/70 dark:!bg-transparent"
                            >
                                <span>Lihat Repositori Kode</span>
                            </a>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}

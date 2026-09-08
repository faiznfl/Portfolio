import React, { useState } from 'react';

export default function Experience({ experiences = [] }) {
    const [expandedIds, setExpandedIds] = useState({});

    const formatDate = (dateStr) => {
        if (!dateStr) return '';
        const d = new Date(dateStr);
        return d.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' });
    };

    const toggleCard = (cardKey) => {
        setExpandedIds((prev) => ({
            ...prev,
            [cardKey]: !prev[cardKey],
        }));
    };

    const sortedExperiences = [...experiences].sort((a, b) => {
        const orderA = Number(a.order_index ?? 0);
        const orderB = Number(b.order_index ?? 0);
        if (orderA !== orderB) return orderA - orderB;

        const timeA = new Date(a.start_date || 0).getTime();
        const timeB = new Date(b.start_date || 0).getTime();
        if (timeB !== timeA) return timeB - timeA;
        const endA = a.is_current ? Infinity : new Date(a.end_date || 0).getTime();
        const endB = b.is_current ? Infinity : new Date(b.end_date || 0).getTime();
        return endB - endA;
    });

    return (
        <section id="experience" className="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-slate-200 dark:border-white/10 overflow-hidden transition-colors">
            <div className="max-w-6xl mx-auto space-y-12 relative z-10">
                {/* Header */}
                <div className="text-center space-y-2 max-w-2xl mx-auto">
                    <div className="section-tagline">MY PROFESSIONAL PATH</div>
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-light text-slate-900 dark:text-white tracking-tight">
                        Journey <span className="text-gradient-ps font-semibold">Timeline</span>
                    </h2>
                    <p className="text-slate-600 dark:text-gray-400 text-sm sm:text-base font-light">
                        Linimasa karier profesional, kepemimpinan rekayasa perangkat lunak, dan kontribusi sistem.
                    </p>
                </div>

                {/* Alternating Journey Timeline */}
                <div className="relative">
                    {sortedExperiences.length === 0 ? (
                        <div className="py-16 text-center text-slate-400 dark:text-gray-500 font-light border border-dashed border-slate-200 dark:border-white/10 rounded-2xl p-8 max-w-xl mx-auto">
                            <span className="text-3xl block mb-2">🧭</span>
                            <span className="text-sm">Belum ada linimasa pengalaman yang ditambahkan.</span>
                        </div>
                    ) : (
                        <>
                            {/* Central Glowing Line */}
                            <div className="absolute left-4 md:left-1/2 top-4 bottom-4 w-0.5 bg-gradient-to-b from-ps-primary via-cyan-400 to-indigo-600 -translate-x-1/2 shadow-[0_0_12px_rgba(0,112,209,0.5)]"></div>

                            <div className="space-y-10">
                                {sortedExperiences.map((exp, idx) => {
                                    const cardKey = exp.id ?? idx;
                                    const isExpanded = !!expandedIds[cardKey];
                                    const isEven = idx % 2 === 0;

                                    const rawPoints = Array.isArray(exp.description_points)
                                        ? exp.description_points
                                        : (typeof exp.description_points === 'string'
                                            ? (function () { try { return JSON.parse(exp.description_points); } catch (e) { return []; } })()
                                            : []);
                                    const points = (Array.isArray(rawPoints) ? rawPoints : []).map(p => typeof p === 'string' ? p.trim() : p).filter(Boolean);

                                    const techUsed = Array.isArray(exp.tech_used)
                                        ? exp.tech_used
                                        : (typeof exp.tech_used === 'string' ? JSON.parse(exp.tech_used) : []);

                                    const hasMore = points.length > 1 || techUsed.length > 0;

                                    return (
                                        <div
                                            key={cardKey}
                                            className={`relative flex flex-col md:flex-row items-center transition-all duration-300 ${isEven ? 'md:flex-row-reverse' : ''
                                                }`}
                                        >
                                            {/* Center Node Dot */}
                                            <div className="absolute left-4 md:left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-white dark:bg-black border-4 border-ps-primary dark:border-cyan-400 shadow-[0_0_15px_rgba(0,112,209,0.6)] z-20"></div>

                                            {/* Card Container (Takes 5/12 width on desktop) */}
                                            <div className="w-full md:w-5/12 pl-12 md:pl-0">
                                                <div className="glass-panel p-5 sm:p-6 space-y-3.5 hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all duration-300 hover:scale-[1.01] shadow-md dark:shadow-xl">
                                                    {/* Role & Date Bar */}
                                                    <div className="flex flex-wrap items-center justify-between gap-2 border-b border-slate-200 dark:border-white/10 pb-2.5">
                                                        <span className="px-3 py-1 rounded-full text-xs font-mono bg-slate-200/80 dark:bg-white/[0.06] text-slate-800 dark:text-cyan-300 border border-slate-300 dark:border-white/10">
                                                            {formatDate(exp.start_date)} — {exp.is_current ? 'Present' : formatDate(exp.end_date)}
                                                        </span>
                                                        {exp.is_current && (
                                                            <span className="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-500/15 text-emerald-600 dark:text-green-400 border border-emerald-500/30">
                                                                Active
                                                            </span>
                                                        )}
                                                    </div>

                                                    {/* Title & Company */}
                                                    <div>
                                                        <h3 className="text-lg sm:text-xl font-bold text-slate-900 dark:text-white tracking-tight">{exp.role_title}</h3>
                                                        <div className="text-sm font-medium text-ps-primary dark:text-cyan-400 flex items-center gap-2 mt-0.5">
                                                            <span>{exp.company_name}</span>
                                                            <span className="text-slate-400 dark:text-gray-500">•</span>
                                                            <span className="text-xs text-slate-500 dark:text-gray-400 font-light">{exp.location}</span>
                                                        </div>
                                                    </div>

                                                    {/* Deskripsi Singkat */}
                                                    {exp.summary && (
                                                        <p className="text-sm text-slate-600 dark:text-gray-300 font-light leading-relaxed">
                                                            {exp.summary}
                                                        </p>
                                                    )}

                                                    {/* Points & Accordion (Zero Gap, Uniform 8px Spacing) */}
                                                    {points.length > 0 ? (
                                                        <div>
                                                            {/* Always Visible First Point */}
                                                            <div className="flex items-start gap-2.5 text-sm text-slate-600 dark:text-gray-300 font-light leading-relaxed">
                                                                <span className="text-ps-primary dark:text-cyan-400 mt-1 shrink-0 text-xs">◆</span>
                                                                <span>{points[0]}</span>
                                                            </div>

                                                            {/* Expandable Remaining Points (Exact 8px gap between all points) */}
                                                            {hasMore && (
                                                                <div className={`accordion-wrapper ${isExpanded ? 'is-open' : ''}`}>
                                                                    <div className="accordion-inner">
                                                                        <div className="space-y-3">
                                                                            {points.length > 1 && (
                                                                                <div className="space-y-2 pt-2">
                                                                                    {points.slice(1).map((point, pIdx) => (
                                                                                        <div key={pIdx} className="flex items-start gap-2.5 text-sm text-slate-600 dark:text-gray-300 font-light leading-relaxed">
                                                                                            <span className="text-ps-primary dark:text-cyan-400 mt-1 shrink-0 text-xs">◆</span>
                                                                                            <span>{point}</span>
                                                                                        </div>
                                                                                    ))}
                                                                                </div>
                                                                            )}

                                                                            {techUsed.length > 0 && (
                                                                                <div className="pt-2">
                                                                                    <div className="flex flex-wrap gap-1.5">
                                                                                        {techUsed.map((tech, tIdx) => (
                                                                                            <span
                                                                                                key={tIdx}
                                                                                                className="px-2 py-0.5 rounded text-[11px] font-mono bg-slate-100 dark:bg-white/5 text-slate-700 dark:text-gray-300 border border-slate-200 dark:border-white/10"
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
                                                            )}
                                                        </div>
                                                    ) : (
                                                        techUsed.length > 0 && (
                                                            <div className="flex flex-wrap gap-1.5 pt-1">
                                                                {techUsed.map((tech, tIdx) => (
                                                                    <span
                                                                        key={tIdx}
                                                                        className="px-2 py-0.5 rounded text-[11px] font-mono bg-slate-100 dark:bg-white/5 text-slate-700 dark:text-gray-300 border border-slate-200 dark:border-white/10"
                                                                    >
                                                                        {tech}
                                                                    </span>
                                                                ))}
                                                            </div>
                                                        )
                                                    )}

                                                    {/* Per-section Toggle Button: Show More / Show Less */}
                                                    {hasMore && (
                                                        <div className="pt-1">
                                                            <button
                                                                type="button"
                                                                onClick={() => toggleCard(cardKey)}
                                                                className="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-ps-primary dark:text-cyan-300 bg-ps-primary/5 dark:bg-cyan-400/10 hover:bg-ps-primary/15 dark:hover:bg-cyan-400/20 border border-ps-primary/20 dark:border-cyan-400/25 transition-all cursor-pointer group"
                                                            >
                                                                <span>{isExpanded ? 'Show Less' : 'Show More'}</span>
                                                                <svg
                                                                    className={`w-3.5 h-3.5 transform transition-transform duration-300 ${isExpanded ? 'rotate-180' : 'group-hover:translate-y-0.5'
                                                                        }`}
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    viewBox="0 0 24 24"
                                                                >
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M19 9l-7 7-7-7" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    )}
                                                </div>
                                            </div>

                                            {/* Empty Spacer on opposite side for desktop centering */}
                                            <div className="hidden md:block md:w-5/12"></div>
                                        </div>
                                    );
                                })}
                            </div>
                        </>
                    )}
                </div>
            </div>
        </section>
    );
}

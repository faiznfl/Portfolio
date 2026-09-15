import React from 'react';

export default function Skills({ skills = [] }) {
    // Tech icon mapping fallback helper
    const getSkillIcon = (name) => {
        const n = (name || '').toLowerCase();
        if (n.includes('php')) return '\u{1F418}';
        if (n.includes('laravel')) return '\u{1F525}';
        if (n.includes('go') || n.includes('golang')) return '\u{1F439}';
        if (n.includes('type') || n.includes('script') || n.includes('java')) return '\u{1F4DC}';
        if (n.includes('python')) return '\u{1F40D}';
        if (n.includes('react') || n.includes('vue')) return '\u{269B}\u{FE0F}';
        if (n.includes('tailwind') || n.includes('css')) return '\u{1F3A8}';
        if (n.includes('postgre') || n.includes('sql') || n.includes('mysql')) return '\u{1F42C}';
        if (n.includes('redis')) return '\u{26A1}';
        if (n.includes('docker') || n.includes('kube') || n.includes('k8s')) return '\u{1F433}';
        if (n.includes('aws') || n.includes('cloud') || n.includes('gcp')) return '\u{2601}\u{FE0F}';
        if (n.includes('git') || n.includes('ci')) return '\u{1F504}';
        if (n.includes('rest') || n.includes('api') || n.includes('grpc')) return '\u{1F50C}';
        if (n.includes('kafka') || n.includes('rabbit')) return '\u{1F4EC}';
        return '\u{1F4BB}';
    };

    const renderSkillIcon = (skill) => {
        if (skill.icon_svg) {
            const icon = skill.icon_svg.trim();
            if (icon.startsWith('<svg') || icon.startsWith('<i ') || icon.includes('<svg')) {
                const svgStart = icon.indexOf('<svg');
                const svgContent = svgStart !== -1 ? icon.substring(svgStart) : icon;
                return (
                    <span
                        className="inline-flex items-center justify-center w-9 h-9 sm:w-10 sm:h-10 text-ps-primary dark:text-blue-400 [&>svg]:w-full [&>svg]:h-full [&>svg]:max-w-full [&>svg]:max-h-full [&>svg]:object-contain transition-transform duration-200 group-hover:scale-110"
                        dangerouslySetInnerHTML={{ __html: svgContent }}
                    />
                );
            }
            if (icon.startsWith('http://') || icon.startsWith('https://') || icon.startsWith('/') || icon.endsWith('.svg') || icon.endsWith('.png')) {
                return (
                    <img
                        src={icon}
                        alt={skill.name}
                        className="w-9 h-9 sm:w-10 sm:h-10 object-contain transition-transform duration-200 group-hover:scale-110"
                    />
                );
            }
            return <span className="text-2xl sm:text-3xl select-none leading-none transition-transform duration-200 group-hover:scale-110">{icon}</span>;
        }
        return <span className="text-2xl sm:text-3xl select-none leading-none transition-transform duration-200 group-hover:scale-110">{getSkillIcon(skill.name)}</span>;
    };

    return (
        <section id="skills" className="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-slate-200 dark:border-white/10 overflow-hidden transition-colors">
            {/* Ambient Background Glows */}
            <div className="absolute top-1/4 -left-20 w-[400px] h-[400px] bg-ps-primary/10 dark:bg-ps-primary/15 rounded-full blur-[130px] pointer-events-none" />
            <div className="absolute bottom-10 -right-20 w-[420px] h-[420px] bg-blue-500/10 dark:bg-blue-500/15 rounded-full blur-[140px] pointer-events-none" />

            <div className="max-w-4xl mx-auto space-y-10 relative z-10">
                {/* Header */}
                <div className="text-center space-y-2 max-w-xl mx-auto">
                    <div className="section-tagline">CHECK OUT MY SKILLS</div>
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-light text-slate-900 dark:text-white tracking-tight">
                        Skills &amp; <span className="text-gradient-ps font-semibold">Technologies</span>
                    </h2>
                    <p className="text-slate-600 dark:text-gray-400 text-sm sm:text-base font-light">
                        Kumpulan bahasa, framework, dan tools yang saya pelajari dan aktif saya gunakan.
                    </p>
                </div>

                {/* 5-Column 3D Tiles Grid with Skill Names */}
                <div
                    className="grid grid-cols-5 gap-3 sm:gap-4 md:gap-4.5 max-w-[720px] mx-auto justify-items-center"
                    id="skills-container"
                >
                    {skills.length === 0 ? (
                        <div className="col-span-full py-16 text-center text-slate-400 dark:text-gray-500 font-light border border-dashed border-slate-200 dark:border-white/10 rounded-2xl p-8 space-y-2">
                            <div className="w-10 h-10 mx-auto mb-3 text-slate-400 dark:text-gray-500 flex items-center justify-center">
                                <svg className="w-8 h-8 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span className="text-sm">Belum ada keahlian yang ditambahkan.</span>
                        </div>
                    ) : (
                        skills.map((skill, index) => (
                            <div
                                key={skill.id || skill.name}
                                style={{ animationDelay: `${Math.min(index * 15, 150)}ms` }}
                                className="group skill-card-item filter-item-animate"
                                title={skill.name}
                                aria-label={skill.name}
                            >
                                {/* Centered Brand Icon */}
                                <div className="mb-2 flex items-center justify-center">
                                    {renderSkillIcon(skill)}
                                </div>

                                {/* Tech Name Only */}
                                <div className="w-full h-8 flex items-center justify-center px-1">
                                    <span className="text-[11px] sm:text-xs font-semibold text-slate-800 dark:text-slate-200 tracking-tight leading-tight line-clamp-2 text-center group-hover:text-ps-primary dark:group-hover:text-blue-300 transition-colors">
                                        {skill.name}
                                    </span>
                                </div>
                            </div>
                        ))
                    )}
                </div>
            </div>
        </section>
    );
}

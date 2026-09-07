import React, { useState } from 'react';

export default function Skills({ skills = [] }) {
    const [selectedCategory, setSelectedCategory] = useState('all');

    // Extract unique categories dynamically from actual inputted skills
    const availableCategories = Array.from(
        new Set((skills || []).map(s => s.category?.trim()).filter(Boolean))
    );

    const activeCategory = (selectedCategory === 'all' || availableCategories.includes(selectedCategory))
        ? selectedCategory
        : 'all';

    const filteredSkills = activeCategory === 'all'
        ? skills
        : skills.filter(s => s.category?.trim().toLowerCase() === activeCategory.toLowerCase());

    const handleFilter = (cat) => {
        setSelectedCategory(cat);
    };

    // Tech icon mapping helper
    const getSkillIcon = (name) => {
        const n = (name || '').toLowerCase();
        if (n.includes('php')) return '🐘';
        if (n.includes('laravel')) return '🔥';
        if (n.includes('go') || n.includes('golang')) return '🐹';
        if (n.includes('type') || n.includes('script') || n.includes('java')) return '📜';
        if (n.includes('python')) return '🐍';
        if (n.includes('react') || n.includes('vue')) return '⚛️';
        if (n.includes('tailwind') || n.includes('css')) return '🎨';
        if (n.includes('postgre') || n.includes('sql') || n.includes('mysql')) return '🐬';
        if (n.includes('redis')) return '⚡';
        if (n.includes('docker') || n.includes('kube') || n.includes('k8s')) return '🐳';
        if (n.includes('aws') || n.includes('cloud') || n.includes('gcp')) return '☁️';
        if (n.includes('git') || n.includes('ci')) return '🔄';
        if (n.includes('rest') || n.includes('api') || n.includes('grpc')) return '🔌';
        if (n.includes('kafka') || n.includes('rabbit')) return '📨';
        return '💻';
    };

    const renderSkillIcon = (skill) => {
        if (skill.icon_svg) {
            const icon = skill.icon_svg.trim();
            if (icon.startsWith('<svg') || icon.startsWith('<i ')) {
                return (
                    <span
                        className="inline-flex items-center justify-center w-8 h-8 text-ps-primary dark:text-cyan-400 [&>svg]:w-7 [&>svg]:h-7 [&>svg]:max-w-full [&>svg]:max-h-full"
                        dangerouslySetInnerHTML={{ __html: icon }}
                    />
                );
            }
            if (icon.startsWith('http://') || icon.startsWith('https://') || icon.startsWith('/') || icon.endsWith('.svg') || icon.endsWith('.png')) {
                return <img src={icon} alt={skill.name} className="w-7 h-7 object-contain" />;
            }
            return <span className="text-2xl">{icon}</span>;
        }
        return <span className="text-2xl">{getSkillIcon(skill.name)}</span>;
    };

    return (
        <section id="skills" className="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-slate-200 dark:border-white/10 overflow-hidden transition-colors">
            <div className="max-w-7xl mx-auto space-y-12 relative z-10">
                {/* Header (Matching Reference Image) */}
                <div className="text-center space-y-2 max-w-2xl mx-auto">
                    <div className="section-tagline">CHECK OUT MY SKILLS</div>
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-light text-slate-900 dark:text-white tracking-tight">
                        Skills &amp; <span className="text-gradient-ps font-semibold">Technologies</span>
                    </h2>
                    <p className="text-slate-600 dark:text-gray-400 text-sm sm:text-base font-light">
                        Peta keahlian teknis, framework, dan ekosistem infrastruktur yang saya gunakan dalam membangun sistem produksi.
                    </p>
                </div>

                {/* Category Filter Pills (Only shown when categories exist) */}
                {availableCategories.length > 0 && (
                    <div className="w-full flex items-center justify-start sm:justify-center gap-2.5 overflow-x-auto py-2 px-1 max-w-5xl mx-auto scrollbar-none [scrollbar-width:none] [-ms-overflow-style:none] [&::-webkit-scrollbar]:hidden">
                        <button
                            type="button"
                            onClick={() => handleFilter('all')}
                            className={`filter-chip-dark whitespace-nowrap shrink-0 ${activeCategory === 'all' ? 'active' : ''}`}
                        >
                            All Skills
                        </button>
                        {availableCategories.map((cat) => (
                            <button
                                key={cat}
                                type="button"
                                onClick={() => handleFilter(cat)}
                                className={`filter-chip-dark whitespace-nowrap shrink-0 ${activeCategory === cat ? 'active' : ''}`}
                            >
                                {cat === 'DevOps' ? 'DevOps & Cloud' : cat}
                            </button>
                        ))}
                    </div>
                )}

                {/* Skills Grid matching Reference Squircle Cards */}
                <div 
                    key={selectedCategory}
                    className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4" 
                    id="skills-container"
                >
                    {filteredSkills.length === 0 ? (
                        <div className="col-span-full py-16 text-center text-slate-400 dark:text-gray-500 font-light border border-dashed border-slate-200 dark:border-white/10 rounded-2xl p-8">
                            <span className="text-3xl block mb-2">💻</span>
                            <span className="text-sm">Belum ada keahlian yang ditambahkan.</span>
                        </div>
                    ) : (
                        filteredSkills.map((skill, index) => (
                            <div
                                key={skill.id || skill.name}
                                style={{ animationDelay: `${Math.min(index * 25, 200)}ms` }}
                                className="skill-card-item glass-panel filter-item-animate p-5 text-center flex flex-col items-center justify-center space-y-3 transition-all duration-300 hover:scale-[1.04] shadow-sm dark:shadow-none"
                                data-category={skill.category}
                            >
                                {/* Illuminated Squircle Icon Container */}
                                <div className="skill-icon-box text-2xl flex items-center justify-center">
                                    {renderSkillIcon(skill)}
                                </div>

                                {/* Tech Title */}
                                <div className="space-y-0.5">
                                    <h4 className="text-sm font-semibold text-slate-900 dark:text-white tracking-tight">{skill.name}</h4>
                                </div>
                            </div>
                        ))
                    )}
                </div>
            </div>
        </section>
    );
}

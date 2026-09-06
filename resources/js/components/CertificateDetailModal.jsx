import React, { useEffect } from 'react';

export default function CertificateDetailModal({ certificate, onClose }) {
    useEffect(() => {
        const handleKeyDown = (e) => {
            if (e.key === 'Escape') onClose();
        };
        window.addEventListener('keydown', handleKeyDown);
        return () => window.removeEventListener('keydown', handleKeyDown);
    }, [onClose]);

    useEffect(() => {
        if (certificate) {
            document.body.style.overflow = 'hidden';
        }
        return () => {
            document.body.style.overflow = '';
        };
    }, [certificate]);

    if (!certificate) return null;

    const getYear = (dateStr) => {
        if (!dateStr) return '2026';
        const d = new Date(dateStr);
        return isNaN(d.getFullYear()) ? '2026' : d.getFullYear();
    };

    // Extract tags from category or certificate tags
    const getTags = () => {
        const list = [];
        if (certificate.category) {
            const parts = certificate.category.split(',').map(s => s.trim()).filter(Boolean);
            list.push(...parts);
        }
        return list;
    };

    const tags = getTags();

    return (
        <div className="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
            {/* Ambient Backdrop */}
            <div
                className="fixed inset-0 bg-slate-950/50 backdrop-blur-md transition-opacity duration-300"
                onClick={onClose}
            />

            {/* Modal Dialog Card (White Liquid Glass Aesthetic) */}
            <div className="relative z-10 w-full max-w-lg bg-white/85 dark:bg-white/90 backdrop-blur-2xl text-slate-900 border border-white/80 shadow-[0_20px_50px_rgba(0,0,0,0.18)] rounded-3xl overflow-hidden p-4 sm:p-5 flex flex-col my-auto transition-all transform duration-200 animate-fadeIn ring-1 ring-black/5">
                {/* Subtle Liquid Glass Specular Shine Accent */}
                <div className="absolute -top-24 -right-24 w-48 h-48 bg-gradient-to-br from-white/70 via-cyan-100/30 to-transparent rounded-full blur-2xl pointer-events-none" />

                {/* 1. Gambar Sertifikat dengan Tombol Close Bulat di Pojok Kanan Atas */}
                <div className="relative w-full aspect-[16/11] sm:aspect-[16/10] rounded-2xl overflow-hidden bg-white/95 p-2.5 sm:p-3 flex items-center justify-center border border-slate-200/70 shadow-xs">
                    <img
                        src={certificate.media_file_path || '/assets/certificates/cert-aws-saa.svg'}
                        alt={certificate.certificate_name}
                        className="w-full h-full object-contain filter drop-shadow-xs"
                    />

                    {/* Circular Frosted Close Button */}
                    <button
                        type="button"
                        onClick={onClose}
                        aria-label="Tutup Pratinjau"
                        className="absolute top-2.5 right-2.5 z-20 w-8 h-8 rounded-full bg-slate-900/80 hover:bg-slate-950 text-white flex items-center justify-center border border-white/30 backdrop-blur-md transition-all hover:scale-105 cursor-pointer shadow-md"
                    >
                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2.5" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {/* 2. Informasi Sertifikat (White Liquid Glass Theme) */}
                <div className="pt-4 px-2 pb-2 space-y-3 relative z-10">
                    {/* Ribbon Icon + Tahun (Pink/Magenta Accent) */}
                    <div className="flex items-center gap-1.5 text-pink-600 font-semibold text-sm">
                        <svg className="w-4 h-4 text-pink-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                            <circle cx="12" cy="8" r="5" />
                            <path d="m9 12-4 9 7-3.5 7 3.5-4-9" />
                        </svg>
                        <span>{getYear(certificate.issue_date)}</span>
                    </div>

                    {/* Judul Sertifikat */}
                    <h3 className="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight leading-snug">
                        {certificate.certificate_name}
                    </h3>

                    {/* Organisasi Penerbit / Course Provider (PlayStation Blue / Cyan Accent) */}
                    <div className="text-ps-primary font-semibold text-sm sm:text-base">
                        {certificate.issuer_organization}
                    </div>

                    {/* Keterangan / Deskripsi */}
                    {certificate.description && (
                        <p className="text-slate-600 text-sm font-normal leading-relaxed pt-0.5">
                            {certificate.description}
                        </p>
                    )}

                    {/* Tags / Pills (Capsules matching screenshot) */}
                    {tags.length > 0 && (
                        <div className="flex flex-wrap items-center gap-2 pt-2">
                            {tags.map((tag, idx) => (
                                <span
                                    key={idx}
                                    className="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-medium text-slate-800 dark:text-gray-200 bg-slate-100 dark:bg-[#151926] border border-slate-300/80 dark:border-white/20 shadow-2xs select-none"
                                >
                                    {tag}
                                </span>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}

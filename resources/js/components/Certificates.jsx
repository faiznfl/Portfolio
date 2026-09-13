import React from 'react';

export default function Certificates({ certificates = [], onSelectCertificate }) {
    return (
        <section id="certificates" className="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-slate-200 dark:border-white/10 overflow-hidden transition-colors">
            <div className="max-w-7xl mx-auto space-y-12 relative z-10">
                {/* Header */}
                <div className="text-center space-y-2 max-w-2xl mx-auto">
                    <div className="section-tagline">VERIFIED CREDENTIALS</div>
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-light text-slate-900 dark:text-white tracking-tight">
                        Certificates &amp; <span className="text-gradient-ps font-semibold">Licenses</span>
                    </h2>
                    <p className="text-slate-600 dark:text-gray-400 text-sm sm:text-base font-light">
                        Validasi sertifikasi standar internasional beserta detail nomor kredensial resmi.
                    </p>
                </div>

                {/* Certificates Grid (3 Column Layout matching Reference) */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {certificates.length === 0 ? (
                        <div className="col-span-full py-16 text-center text-slate-400 dark:text-gray-500 font-light border border-dashed border-slate-200 dark:border-white/10 rounded-2xl p-8">
                            <div className="w-10 h-10 mx-auto mb-3 text-slate-400 dark:text-gray-500 flex items-center justify-center">
                                <svg className="w-8 h-8 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z" />
                                </svg>
                            </div>
                            <span className="text-sm">Belum ada sertifikat yang ditambahkan.</span>
                        </div>
                    ) : (
                        certificates.map((cert) => (
                            <div
                                key={cert.id || cert.credential_id}
                                onClick={() => onSelectCertificate && onSelectCertificate(cert)}
                                onKeyDown={(e) => {
                                    if (e.key === 'Enter' || e.key === ' ') {
                                        e.preventDefault();
                                        onSelectCertificate && onSelectCertificate(cert);
                                    }
                                }}
                                role="button"
                                tabIndex={0}
                                aria-label={`Detail sertifikat ${cert.certificate_name}`}
                                className="glass-panel p-5 flex flex-col justify-between space-y-4 hover:border-ps-primary dark:hover:border-blue-400/40 transition-all duration-300 hover:-translate-y-1 shadow-md dark:shadow-lg group cursor-pointer focus:outline-none focus:ring-2 focus:ring-ps-primary/50 select-none"
                            >
                                {/* Certificate Image Banner */}
                                <div className="relative w-full aspect-[16/10] rounded-xl overflow-hidden bg-white p-3 flex items-center justify-center border border-slate-200 dark:border-white/20 shadow-inner">
                                    <img
                                        src={cert.media_file_path || '/assets/certificates/cert-aws-saa.svg'}
                                        alt={cert.certificate_name}
                                        className="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105"
                                        loading="lazy"
                                    />
                                </div>

                                {/* Details */}
                                <div className="space-y-3 flex-grow">
                                    <div className="flex items-center justify-between gap-2">
                                        <span className="text-xs font-mono text-ps-primary dark:text-blue-400 uppercase tracking-wider font-semibold">
                                            {cert.issuer_organization}
                                        </span>
                                        {cert.issue_date ? (
                                            <span className="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-slate-100 dark:bg-white/10 text-slate-700 dark:text-gray-300 border border-slate-200 dark:border-white/10 shrink-0">
                                                {new Date(cert.issue_date).getFullYear()}
                                            </span>
                                        ) : cert.category ? (
                                            <span className="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-slate-100 dark:bg-white/10 text-ps-primary dark:text-blue-300 border border-slate-200 dark:border-white/10 shrink-0">
                                                {cert.category.split(',')[0].trim()}
                                            </span>
                                        ) : null}
                                    </div>

                                    <div>
                                        <h3 className="text-base font-bold text-slate-900 dark:text-white leading-snug group-hover:text-ps-primary dark:group-hover:text-blue-300 transition-colors">
                                            {cert.certificate_name}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        ))
                    )}
                </div>
            </div>
        </section>
    );
}

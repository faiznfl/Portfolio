import React, { useState } from 'react';

export default function Contacts({ profile = {}, csrfToken = '', submitUrl = '/contact/submit' }) {
    const [formData, setFormData] = useState({
        sender_name: '',
        sender_email: '',
        subject: '',
        message_body: '',
        website_hp: ''
    });

    const [charCount, setCharCount] = useState(0);
    const [copied, setCopied] = useState(false);

    const email = profile?.social_links?.email || profile?.email || 'faiznfl20@gmail.com';
    const github = profile?.social_links?.github || 'https://github.com/faiznfl';
    const linkedin = profile?.social_links?.linkedin || 'https://www.linkedin.com/in/faiz-naufal-putra-permana';
    const locationText = 'Indonesia (Remote / On-site)';

    const handleCopyEmail = async () => {
        try {
            await navigator.clipboard.writeText(email);
            setCopied(true);
            setTimeout(() => setCopied(false), 2000);
        } catch (err) {
            console.error('Gagal menyalin email:', err);
        }
    };

    const handleChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
        if (name === 'message_body') {
            setCharCount(value.length);
        }
    };

    return (
        <section id="contacts" className="relative py-28 px-4 sm:px-6 lg:px-8 border-t border-slate-200 dark:border-white/10 overflow-hidden transition-colors">
            <div className="max-w-6xl mx-auto space-y-12 relative z-10">
                {/* Header */}
                <div className="text-center space-y-2 max-w-2xl mx-auto">
                    <div className="section-tagline">LET'S CONNECT</div>
                    <h2 className="text-3xl sm:text-4xl lg:text-5xl font-light text-slate-900 dark:text-white tracking-tight">
                        Contact <span className="text-gradient-ps font-semibold">Me</span>
                    </h2>
                    <p className="text-slate-600 dark:text-gray-400 text-sm sm:text-base font-light">
                        Punya gagasan proyek, tawaran posisi strategis, atau ingin berdiskusi teknis? Kirim pesan langsung melalui formulir di bawah.
                    </p>
                </div>

                {/* Split Contact Grid: Info Cards & Form */}
                <div className="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    {/* Left Column: Contact Information Master Card & Channel Cards */}
                    <div className="lg:col-span-5 space-y-4">
                        {/* Master Card (Contact Information) */}
                        <div className="glass-panel p-6 sm:p-7 space-y-6 shadow-sm dark:shadow-none">
                            <h3 className="text-xl sm:text-2xl font-bold text-slate-900 dark:text-white tracking-tight">
                                Contact Information
                            </h3>

                            <div className="space-y-4">
                                {/* Email Row with Copy Button */}
                                <div className="flex items-center justify-between gap-3 p-3 rounded-2xl bg-slate-100/70 dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.06] hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all">
                                    <div className="flex items-center gap-3.5 min-w-0">
                                        <div className="w-11 h-11 rounded-2xl bg-slate-200/70 dark:bg-[#12162a] border border-slate-300/80 dark:border-indigo-500/30 flex items-center justify-center shrink-0 text-slate-700 dark:text-indigo-400">
                                            <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="1.8">
                                                <path strokeLinecap="round" strokeLinejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div className="min-w-0">
                                            <div className="text-[11px] font-mono font-semibold uppercase tracking-wider text-slate-400 dark:text-gray-400">
                                                EMAIL
                                            </div>
                                            <a 
                                                href={`mailto:${email}`} 
                                                className="text-sm sm:text-base font-semibold text-slate-900 dark:text-white hover:text-ps-primary dark:hover:text-cyan-300 transition-colors truncate block"
                                                title={`Kirim email ke ${email}`}
                                            >
                                                {email}
                                            </a>
                                        </div>
                                    </div>

                                    {/* Interactive Copy Button */}
                                    <button
                                        type="button"
                                        onClick={handleCopyEmail}
                                        className="relative p-2.5 rounded-xl text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200/70 dark:hover:bg-white/10 transition-all shrink-0 active:scale-90"
                                        title={copied ? "Tersalin ke clipboard!" : "Salin email"}
                                        aria-label="Salin alamat email"
                                    >
                                        {copied ? (
                                            <span className="flex items-center gap-1 text-xs font-mono font-semibold text-emerald-600 dark:text-emerald-400">
                                                <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="2.5">
                                                    <path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span className="hidden sm:inline">Copied</span>
                                            </span>
                                        ) : (
                                            <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="1.8">
                                                <path strokeLinecap="round" strokeLinejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                        )}
                                    </button>
                                </div>

                                {/* Location Row */}
                                <div className="flex items-center gap-3.5 p-3 rounded-2xl bg-slate-100/70 dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.06] hover:border-ps-primary dark:hover:border-cyan-400/40 transition-all">
                                    <div className="w-11 h-11 rounded-2xl bg-slate-200/70 dark:bg-[#12162a] border border-slate-300/80 dark:border-indigo-500/30 flex items-center justify-center shrink-0 text-slate-700 dark:text-indigo-400">
                                        <svg className="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" strokeWidth="1.8">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div className="min-w-0">
                                        <div className="text-[11px] font-mono font-semibold uppercase tracking-wider text-slate-400 dark:text-gray-400">
                                            LOCATION
                                        </div>
                                        <div className="text-sm sm:text-base font-semibold text-slate-900 dark:text-white">
                                            {locationText}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Divider & Connect via Social */}
                            <div className="pt-4 border-t border-slate-200/80 dark:border-white/10 space-y-3">
                                <div className="text-[11px] font-mono font-semibold uppercase tracking-wider text-slate-400 dark:text-gray-400">
                                    CONNECT VIA SOCIAL
                                </div>
                                <div className="flex items-center gap-3">
                                    {/* GitHub */}
                                    <a
                                        href={github}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/[0.05] border border-slate-300/80 dark:border-white/10 hover:border-ps-primary dark:hover:border-cyan-400/50 hover:bg-slate-200/70 dark:hover:bg-cyan-500/10 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-cyan-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95"
                                        title="GitHub Profile"
                                        aria-label="GitHub Profile"
                                    >
                                        <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                            <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                                        </svg>
                                    </a>

                                    {/* LinkedIn */}
                                    <a
                                        href={linkedin}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/[0.05] border border-slate-300/80 dark:border-white/10 hover:border-ps-primary dark:hover:border-cyan-400/50 hover:bg-slate-200/70 dark:hover:bg-cyan-500/10 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-cyan-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95"
                                        title="LinkedIn Profile"
                                        aria-label="LinkedIn Profile"
                                    >
                                        <svg className="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                        </svg>
                                    </a>

                                    {/* Email */}
                                    <a
                                        href={`mailto:${email}`}
                                        className="w-10 h-10 rounded-full bg-slate-100 dark:bg-white/[0.05] border border-slate-300/80 dark:border-white/10 hover:border-ps-primary dark:hover:border-cyan-400/50 hover:bg-slate-200/70 dark:hover:bg-cyan-500/10 text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-cyan-300 flex items-center justify-center transition-all duration-200 shadow-sm hover:scale-110 active:scale-95"
                                        title={`Kirim email ke ${email}`}
                                        aria-label="Kirim Email Langsung"
                                    >
                                        <svg className="w-4 h-4 fill-none stroke-current" viewBox="0 0 24 24" strokeWidth="1.8">
                                            <path strokeLinecap="round" strokeLinejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {/* Right Column: Clean Contact Form */}
                    <div className="lg:col-span-7 glass-panel p-8 sm:p-9 shadow-lg dark:shadow-2xl">
                        <form action={submitUrl || '/contact/submit'} method="POST" className="space-y-5">
                            <input type="hidden" name="_token" value={csrfToken || ''} />

                            {/* Honeypot field */}
                            <div className="hidden" aria-hidden="true">
                                <label htmlFor="website_hp">Leave this empty</label>
                                <input
                                    type="text"
                                    name="website_hp"
                                    id="website_hp"
                                    tabIndex="-1"
                                    autoComplete="off"
                                    value={formData.website_hp}
                                    onChange={handleChange}
                                />
                            </div>

                            <div className="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div className="space-y-1.5">
                                    <label htmlFor="sender_name" className="block text-xs font-mono uppercase tracking-wider text-slate-700 dark:text-gray-300 font-medium">
                                        Nama Lengkap <span className="text-ps-primary dark:text-cyan-400">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        id="sender_name"
                                        name="sender_name"
                                        required
                                        placeholder="cth: Budi Santoso"
                                        value={formData.sender_name}
                                        onChange={handleChange}
                                        className="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/50 border border-slate-300/80 dark:border-white/15 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:border-ps-primary text-sm transition-colors"
                                    />
                                </div>

                                <div className="space-y-1.5">
                                    <label htmlFor="sender_email" className="block text-xs font-mono uppercase tracking-wider text-slate-700 dark:text-gray-300 font-medium">
                                        Alamat Email <span className="text-ps-primary dark:text-cyan-400">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        id="sender_email"
                                        name="sender_email"
                                        required
                                        placeholder="cth: budi@company.com"
                                        value={formData.sender_email}
                                        onChange={handleChange}
                                        className="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/50 border border-slate-300/80 dark:border-white/15 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:border-ps-primary text-sm transition-colors"
                                    />
                                </div>
                            </div>

                            <div className="space-y-1.5">
                                <label htmlFor="subject" className="block text-xs font-mono uppercase tracking-wider text-slate-700 dark:text-gray-300 font-medium">
                                    Subjek Pesan <span className="text-ps-primary dark:text-cyan-400">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    required
                                    placeholder="cth: Penawaran Kolaborasi / Diskusi Proyek"
                                    value={formData.subject}
                                    onChange={handleChange}
                                    className="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/50 border border-slate-300/80 dark:border-white/15 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:border-ps-primary text-sm transition-colors"
                                />
                            </div>

                            <div className="space-y-1.5">
                                <div className="flex items-center justify-between">
                                    <label htmlFor="message_body" className="block text-xs font-mono uppercase tracking-wider text-slate-700 dark:text-gray-300 font-medium">
                                        Isi Pesan <span className="text-ps-primary dark:text-cyan-400">*</span>
                                    </label>
                                    <span className={`text-xs font-mono ${charCount >= 10 ? 'text-emerald-600 dark:text-green-400' : 'text-slate-400 dark:text-gray-400'}`}>
                                        {charCount} karakter
                                    </span>
                                </div>
                                <textarea
                                    id="message_body"
                                    name="message_body"
                                    rows="4"
                                    required
                                    placeholder="Tuliskan rincian kebutuhan proyek, timeline, atau topik diskusi..."
                                    value={formData.message_body}
                                    onChange={handleChange}
                                    className="w-full px-4 py-3 rounded-xl bg-slate-100/90 dark:bg-black/50 border border-slate-300/80 dark:border-white/15 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:border-ps-primary text-sm transition-colors"
                                ></textarea>
                            </div>

                            <div className="pt-2">
                                <button 
                                    type="submit" 
                                    className="btn-ps-primary !w-full !py-3 !text-sm !font-bold !bg-gradient-to-r !from-indigo-600 !via-ps-primary !to-cyan-500"
                                >
                                    <span>Send Message</span>
                                    <svg className="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    );
}

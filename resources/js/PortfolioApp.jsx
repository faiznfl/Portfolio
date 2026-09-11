import React, { useState, useEffect } from 'react';
import Navbar from './components/Navbar';
import Hero from './components/Hero';
import About from './components/About';
import Skills from './components/Skills';
import Projects from './components/Projects';
import Experience from './components/Experience';
import Certificates from './components/Certificates';
import Contacts from './components/Contacts';
import Footer from './components/Footer';
import ProjectDetailModal from './components/ProjectDetailModal';
import CertificateDetailModal from './components/CertificateDetailModal';
import { smoothScrollTo } from './utils/smoothScroll';

export default function PortfolioApp({ initialData = {} }) {
    const {
        profile = {},
        skills = [],
        projects = [],
        experiences = [],
        certificates = [],
        csrfToken = '',
        contactSubmitUrl = '/contact/submit',
        resumeDownloadUrl = '/resume/download',
        resumePreviewUrl = '/resume/preview',
        resumeFileName = 'CV-Faiz-Naufal.pdf'
    } = initialData;

    const [selectedProject, setSelectedProject] = useState(null);
    const [selectedCertificate, setSelectedCertificate] = useState(null);

    // Dark / Light Theme State Management
    const [theme, setTheme] = useState(() => {
        if (typeof window !== 'undefined') {
            const saved = localStorage.getItem('theme');
            if (saved) return saved;
            return document.documentElement.classList.contains('dark') ? 'dark' : 'light';
        }
        return 'dark';
    });

    useEffect(() => {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }, [theme]);

    const toggleTheme = () => {
        const nextTheme = theme === 'dark' ? 'light' : 'dark';
        setTheme(nextTheme);
        if (typeof window !== 'undefined') {
            localStorage.setItem('theme', nextTheme);
        }
        if (nextTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    };

    return (
        <div className="bg-[#f8fafc] text-slate-900 dark:bg-[#070a13] dark:text-slate-100 min-h-screen flex flex-col font-sans selection:bg-ps-primary selection:text-white transition-colors duration-300">
            {/* Floating Liquid Glass Navigation */}
            <Navbar
                resumeUrl={resumeDownloadUrl}
                theme={theme}
                onToggleTheme={toggleTheme}
            />

            {/* Main Content Sections */}
            <main className="flex-grow">
                {/* 1. Hero with Hanging Lanyard ID Card */}
                <Hero
                    profile={profile}
                    resumeUrl={resumeDownloadUrl}
                    resumePreviewUrl={resumePreviewUrl}
                    theme={theme}
                />

                {/* 2. About Me with Split Info Capsules */}
                <About profile={profile} />

                {/* 3. Skills & Technologies with Squircle Icons */}
                <Skills skills={skills} />

                {/* 4. Projects Showcase */}
                <Projects
                    projects={projects}
                    onSelectProject={(proj) => setSelectedProject(proj)}
                />

                {/* 5. Journey Timeline (Alternating Timeline) */}
                <Experience experiences={experiences} />

                {/* 6. Certificates & Credentials */}
                <Certificates
                    certificates={certificates}
                    onSelectCertificate={(cert) => setSelectedCertificate(cert)}
                />

                {/* 7. Contact Me */}
                <Contacts profile={profile} csrfToken={csrfToken} submitUrl={contactSubmitUrl} />
            </main>

            {/* High-Impact Cyber Glassmorphism Footer */}
            <Footer resumeUrl={resumeDownloadUrl} />

            {/* Project Detail Modal */}
            <ProjectDetailModal
                project={selectedProject}
                onClose={() => setSelectedProject(null)}
            />

            {/* Certificate Detail Modal */}
            <CertificateDetailModal
                certificate={selectedCertificate}
                onClose={() => setSelectedCertificate(null)}
            />
        </div>
    );
}

// PlayStation Portfolio Showcase - Ultra-Interactive Engine

class PlayStationAudio {
    constructor() {
        this.ctx = null;
        this.enabled = localStorage.getItem('ps_audio_enabled') === 'true';
        this.init();
    }

    init() {
        const toggleBtn = document.getElementById('audio-toggle-btn');
        if (toggleBtn) {
            this.updateButtonUI(toggleBtn);
            toggleBtn.addEventListener('click', () => {
                this.enabled = !this.enabled;
                localStorage.setItem('ps_audio_enabled', this.enabled);
                this.updateButtonUI(toggleBtn);
                if (this.enabled) {
                    this.initAudioContext();
                    this.playClick();
                }
            });
        }
    }

    initAudioContext() {
        if (!this.ctx && (window.AudioContext || window.webkitAudioContext)) {
            const AudioCtx = window.AudioContext || window.webkitAudioContext;
            this.ctx = new AudioCtx();
        }
        if (this.ctx && this.ctx.state === 'suspended') {
            this.ctx.resume();
        }
    }

    updateButtonUI(btn) {
        const label = btn.querySelector('.audio-label');
        if (this.enabled) {
            btn.classList.add('audio-active', 'border-ps-primary', 'text-ps-primary');
            btn.classList.remove('text-gray-400', 'border-white/20');
            if (label) label.textContent = 'Audio: ON';
        } else {
            btn.classList.remove('audio-active', 'border-ps-primary', 'text-ps-primary');
            btn.classList.add('text-gray-400', 'border-white/20');
            if (label) label.textContent = 'Audio: MUTE';
        }
    }

    playTone(freq, type = 'sine', duration = 0.08, gainVal = 0.06) {
        if (!this.enabled) return;
        this.initAudioContext();
        if (!this.ctx) return;

        try {
            const osc = this.ctx.createOscillator();
            const gain = this.ctx.createGain();
            osc.type = type;
            osc.frequency.setValueAtTime(freq, this.ctx.currentTime);

            gain.gain.setValueAtTime(gainVal, this.ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, this.ctx.currentTime + duration);

            osc.connect(gain);
            gain.connect(this.ctx.destination);

            osc.start();
            osc.stop(this.ctx.currentTime + duration);
        } catch (e) {
            // Silently ignore audio errors if blocked by browser policy
        }
    }

    playHover() {
        this.playTone(520, 'sine', 0.05, 0.03);
    }

    playClick() {
        this.playTone(840, 'triangle', 0.08, 0.07);
    }

    playWhoosh() {
        if (!this.enabled) return;
        this.initAudioContext();
        if (!this.ctx) return;

        try {
            const osc = this.ctx.createOscillator();
            const gain = this.ctx.createGain();
            osc.type = 'sine';
            osc.frequency.setValueAtTime(320, this.ctx.currentTime);
            osc.frequency.exponentialRampToValueAtTime(780, this.ctx.currentTime + 0.15);

            gain.gain.setValueAtTime(0.06, this.ctx.currentTime);
            gain.gain.exponentialRampToValueAtTime(0.001, this.ctx.currentTime + 0.18);

            osc.connect(gain);
            gain.connect(this.ctx.destination);
            osc.start();
            osc.stop(this.ctx.currentTime + 0.18);
        } catch (e) {}
    }

    playSuccess() {
        setTimeout(() => this.playTone(523.25, 'triangle', 0.12, 0.08), 0);
        setTimeout(() => this.playTone(659.25, 'triangle', 0.14, 0.08), 80);
        setTimeout(() => this.playTone(783.99, 'triangle', 0.22, 0.1), 160);
    }
}

// Ambient Particle & PlayStation Geometric Symbols Canvas
class AmbientCanvas {
    constructor() {
        this.canvas = document.getElementById('ambient-canvas');
        if (!this.canvas) return;

        this.ctx = this.canvas.getContext('2d');
        this.particles = [];
        this.symbols = ['△', '◯', '✕', '▢'];
        this.mouse = { x: -1000, y: -1000, radius: 140 };
        this.width = 0;
        this.height = 0;

        this.init();
    }

    init() {
        this.resize();
        window.addEventListener('resize', () => this.resize());

        const hero = document.getElementById('home');
        if (hero) {
            hero.addEventListener('mousemove', (e) => {
                const rect = this.canvas.getBoundingClientRect();
                this.mouse.x = e.clientX - rect.left;
                this.mouse.y = e.clientY - rect.top;
            });

            hero.addEventListener('mouseleave', () => {
                this.mouse.x = -1000;
                this.mouse.y = -1000;
            });
        }

        const count = Math.min(Math.floor((this.width * this.height) / 32000), 24);
        for (let i = 0; i < count; i++) {
            this.particles.push({
                x: Math.random() * this.width,
                y: Math.random() * this.height,
                vx: (Math.random() - 0.5) * 0.4,
                vy: (Math.random() - 0.5) * 0.4,
                size: Math.random() * 1.5 + 1,
                symbol: Math.random() > 0.7 ? this.symbols[Math.floor(Math.random() * this.symbols.length)] : null,
                symbolSize: Math.floor(Math.random() * 5 + 9),
                alpha: Math.random() * 0.25 + 0.1,
                angle: Math.random() * Math.PI * 2,
                vAngle: (Math.random() - 0.5) * 0.015
            });
        }

        this.animate();
    }

    resize() {
        if (!this.canvas) return;
        this.width = this.canvas.width = this.canvas.offsetWidth;
        this.height = this.canvas.height = this.canvas.offsetHeight;
    }

    animate() {
        requestAnimationFrame(() => this.animate());
        if (!this.ctx) return;

        this.ctx.clearRect(0, 0, this.width, this.height);

        // Draw connections
        for (let i = 0; i < this.particles.length; i++) {
            for (let j = i + 1; j < this.particles.length; j++) {
                const dx = this.particles[i].x - this.particles[j].x;
                const dy = this.particles[i].y - this.particles[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < 110) {
                    const alpha = (1 - dist / 110) * 0.15;
                    this.ctx.strokeStyle = `rgba(0, 112, 209, ${alpha})`;
                    this.ctx.lineWidth = 0.75;
                    this.ctx.beginPath();
                    this.ctx.moveTo(this.particles[i].x, this.particles[i].y);
                    this.ctx.lineTo(this.particles[j].x, this.particles[j].y);
                    this.ctx.stroke();
                }
            }
        }

        // Draw & Update Particles
        this.particles.forEach(p => {
            // Mouse gravity/repulsion
            const mdx = this.mouse.x - p.x;
            const mdy = this.mouse.y - p.y;
            const mDist = Math.sqrt(mdx * mdx + mdy * mdy);

            if (mDist < this.mouse.radius) {
                const force = (1 - mDist / this.mouse.radius) * 1.5;
                p.x -= (mdx / mDist) * force;
                p.y -= (mdy / mDist) * force;
            }

            p.x += p.vx;
            p.y += p.vy;
            p.angle += p.vAngle;

            if (p.x < 0) p.x = this.width;
            if (p.x > this.width) p.x = 0;
            if (p.y < 0) p.y = this.height;
            if (p.y > this.height) p.y = 0;

            if (p.symbol) {
                this.ctx.save();
                this.ctx.translate(p.x, p.y);
                this.ctx.rotate(p.angle);
                this.ctx.font = `${p.symbolSize}px sans-serif`;
                this.ctx.fillStyle = `rgba(0, 112, 209, ${p.alpha * 0.8})`;
                this.ctx.textAlign = 'center';
                this.ctx.textBaseline = 'middle';
                this.ctx.fillText(p.symbol, 0, 0);
                this.ctx.restore();
            } else {
                this.ctx.fillStyle = `rgba(56, 189, 248, ${p.alpha})`;
                this.ctx.beginPath();
                this.ctx.arc(p.x, p.y, p.size, 0, Math.PI * 2);
                this.ctx.fill();
            }
        });
    }
}

// 3D Tilt and Specular Glare Card Effect
class CardTiltEffect {
    constructor(audio) {
        this.audio = audio;
        this.cards = document.querySelectorAll('.tilt-card');
        this.init();
    }

    init() {
        this.cards.forEach(card => {
            // Create glare element inside card if absent
            let glare = card.querySelector('.tilt-glare');
            if (!glare) {
                glare = document.createElement('div');
                glare.className = 'tilt-glare';
                card.appendChild(glare);
            }

            card.addEventListener('mouseenter', () => {
                if (this.audio) this.audio.playHover();
            });

            card.addEventListener('mousemove', (e) => {
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = ((y - centerY) / centerY) * -7;
                const rotateY = ((x - centerX) / centerX) * 7;

                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-4px) scale(1.015)`;

                if (glare) {
                    glare.style.opacity = '1';
                    glare.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255,255,255,0.18), transparent 60%)`;
                }
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) translateY(0) scale(1)';
                if (glare) {
                    glare.style.opacity = '0';
                }
            });
        });
    }
}

// Command Palette (Quick Search via Ctrl+K)
class CommandPalette {
    constructor(audio) {
        this.audio = audio;
        this.modal = document.getElementById('cmd-palette-modal');
        this.input = document.getElementById('cmd-search-input');
        this.resultsContainer = document.getElementById('cmd-results-container');
        this.openBtns = document.querySelectorAll('[data-open-cmd]');
        this.closeBtn = document.getElementById('cmd-close-btn');

        this.searchIndex = [];
        this.init();
    }

    init() {
        this.buildSearchIndex();

        // Keyboard Shortcut: Ctrl+K / Cmd+K
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                this.toggle();
            }
            if (e.key === 'Escape' && this.isOpen()) {
                this.close();
            }
        });

        this.openBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                this.open();
            });
        });

        if (this.closeBtn) this.closeBtn.addEventListener('click', () => this.close());

        const backdrop = document.getElementById('cmd-backdrop');
        if (backdrop) backdrop.addEventListener('click', () => this.close());

        if (this.input) {
            this.input.addEventListener('input', () => this.performSearch(this.input.value));
        }
    }

    buildSearchIndex() {
        // Collect Projects
        document.querySelectorAll('.project-card-item').forEach(card => {
            const btn = card.querySelector('.open-case-study-btn');
            const title = card.querySelector('h3')?.textContent.trim() || '';
            const category = card.getAttribute('data-category') || '';
            const rawData = btn?.getAttribute('data-project');
            this.searchIndex.push({
                type: 'PROJECT',
                title: title,
                subtitle: category + ' Showcase',
                badge: 'Project',
                url: '#projects',
                action: () => {
                    this.close();
                    if (btn) btn.click();
                }
            });
        });

        // Collect Skills
        document.querySelectorAll('.skill-item').forEach(item => {
            const title = item.querySelector('h4')?.textContent.trim() || '';
            const category = item.getAttribute('data-category') || '';
            this.searchIndex.push({
                type: 'SKILL',
                title: title,
                subtitle: 'Kategori: ' + category,
                badge: 'Skill',
                url: '#skills',
                action: () => {
                    this.close();
                    const el = document.getElementById('skills');
                    if (el) el.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });

        // Collect Certificates
        document.querySelectorAll('#certificates .ps-card-light').forEach(card => {
            const title = card.querySelector('h3')?.textContent.trim() || '';
            const org = card.querySelector('.font-mono')?.textContent.trim() || '';
            this.searchIndex.push({
                type: 'CERTIFICATE',
                title: title,
                subtitle: org,
                badge: 'License',
                url: '#certificates',
                action: () => {
                    this.close();
                    const el = document.getElementById('certificates');
                    if (el) el.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    }

    isOpen() {
        return this.modal && !this.modal.classList.contains('hidden');
    }

    toggle() {
        this.isOpen() ? this.close() : this.open();
    }

    open() {
        if (!this.modal) return;
        this.modal.classList.remove('hidden');
        if (this.audio) this.audio.playWhoosh();
        if (this.input) {
            this.input.value = '';
            setTimeout(() => this.input.focus(), 50);
        }
        this.performSearch('');
        document.body.style.overflow = 'hidden';
    }

    close() {
        if (!this.modal) return;
        this.modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    performSearch(query) {
        if (!this.resultsContainer) return;
        const q = query.toLowerCase().trim();
        const filtered = q === '' 
            ? this.searchIndex.slice(0, 8) 
            : this.searchIndex.filter(item => 
                item.title.toLowerCase().includes(q) || 
                item.subtitle.toLowerCase().includes(q) ||
                item.badge.toLowerCase().includes(q)
            ).slice(0, 10);

        this.resultsContainer.innerHTML = '';

        if (filtered.length === 0) {
            this.resultsContainer.innerHTML = `
                <div class="p-8 text-center text-gray-500 text-sm">
                    Tidak ditemukan hasil untuk "<span class="text-white">${query}</span>"
                </div>
            `;
            return;
        }

        filtered.forEach(item => {
            const row = document.createElement('div');
            row.className = 'flex items-center justify-between p-3.5 rounded-lg hover:bg-white/10 cursor-pointer transition-colors group';
            row.innerHTML = `
                <div class="flex items-center gap-3">
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono uppercase bg-ps-primary/20 text-ps-primary border border-ps-primary/30">
                        ${item.badge}
                    </span>
                    <div>
                        <div class="text-white text-sm font-semibold group-hover:text-ps-primary transition-colors">${item.title}</div>
                        <div class="text-xs text-gray-400 font-light">${item.subtitle}</div>
                    </div>
                </div>
                <span class="text-xs text-gray-500 group-hover:text-white transition-colors">Buka ↗</span>
            `;
            row.addEventListener('click', () => {
                if (this.audio) this.audio.playClick();
                item.action();
            });
            this.resultsContainer.appendChild(row);
        });
    }
}

// Master DOM Initialization
document.addEventListener('DOMContentLoaded', () => {
    // 1. Audio Engine
    const audio = new PlayStationAudio();

    // 2. Ambient Particles & PS Shapes Canvas
    new AmbientCanvas();

    // 3. 3D Card Tilt with Specular Glare
    new CardTiltEffect(audio);

    // 4. Command Palette (Ctrl+K)
    new CommandPalette(audio);

    // 5. Sound trigger bindings on interactive elements
    document.querySelectorAll('.btn-ps-primary, .btn-ps-commerce, .filter-chip, .filter-chip-dark').forEach(el => {
        el.addEventListener('mouseenter', () => audio.playHover());
        el.addEventListener('click', () => audio.playClick());
    });

    // 6. Mobile Menu Drawer
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const mobileLinks = document.querySelectorAll('.mobile-nav-link');

    if (mobileMenuBtn && mobileDrawer) {
        mobileMenuBtn.addEventListener('click', () => {
            audio.playWhoosh();
            mobileDrawer.classList.remove('hidden');
            setTimeout(() => mobileDrawer.classList.remove('opacity-0'), 10);
            document.body.style.overflow = 'hidden';
        });

        const closeDrawer = () => {
            mobileDrawer.classList.add('opacity-0');
            setTimeout(() => {
                mobileDrawer.classList.add('hidden');
                document.body.style.overflow = '';
            }, 250);
        };

        if (mobileMenuClose) mobileMenuClose.addEventListener('click', closeDrawer);
        mobileLinks.forEach(link => link.addEventListener('click', closeDrawer));
    }

    // 7. Active Navigation Highlight via IntersectionObserver
    const navLinks = document.querySelectorAll('.nav-link');
    const sections = document.querySelectorAll('section[id]');

    if ('IntersectionObserver' in window && sections.length > 0) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const activeId = entry.target.getAttribute('id');
                    navLinks.forEach(link => {
                        if (link.getAttribute('href') === `#${activeId}`) {
                            link.classList.add('text-ps-primary', 'font-semibold');
                            link.classList.remove('text-gray-300');
                        } else {
                            link.classList.remove('text-ps-primary', 'font-semibold');
                            link.classList.add('text-gray-300');
                        }
                    });
                }
            });
        }, { rootMargin: '-30% 0px -60% 0px' });

        sections.forEach(section => observer.observe(section));
    }

    // 8. Project Filtering with Smooth Stagger
    const projectFilterBtns = document.querySelectorAll('[data-project-filter]');
    const projectCards = document.querySelectorAll('.project-card-item');

    projectFilterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-project-filter');
            projectFilterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            projectCards.forEach(card => {
                const category = card.getAttribute('data-category');
                if (filter === 'all' || category === filter) {
                    card.style.display = 'flex';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.96)';
                    setTimeout(() => card.style.display = 'none', 200);
                }
            });
        });
    });

    // 9. Skills Category Filtering
    const skillFilterBtns = document.querySelectorAll('[data-skill-filter]');
    const skillItems = document.querySelectorAll('.skill-item');

    skillFilterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-skill-filter');
            skillFilterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            skillItems.forEach(item => {
                const category = item.getAttribute('data-category');
                item.style.display = (filter === 'all' || category === filter) ? 'block' : 'none';
            });
        });
    });

    // 10. Interactive Project Case Study Modal with Tabs
    const caseStudyModal = document.getElementById('case-study-modal');
    const modalBackdrop = document.getElementById('modal-backdrop');
    const modalCloseBtn = document.getElementById('modal-close-btn');
    const openModalBtns = document.querySelectorAll('.open-case-study-btn');

    // Modal Content Elements
    const modalTitle = document.getElementById('modal-title');
    const modalCategory = document.getElementById('modal-category');
    const modalSummary = document.getElementById('modal-summary');
    const modalProblem = document.getElementById('modal-problem');
    const modalSolution = document.getElementById('modal-solution');
    const modalArchitecture = document.getElementById('modal-architecture');
    const modalTechStacks = document.getElementById('modal-tech-stacks');
    const modalMetrics = document.getElementById('modal-metrics');
    const modalDemoLink = document.getElementById('modal-demo-link');
    const modalRepoLink = document.getElementById('modal-repo-link');
    const modalImage = document.getElementById('modal-image');

    // Tab buttons & Tab Panels inside Modal
    const tabBtns = document.querySelectorAll('.modal-tab-btn');
    const tabPanels = document.querySelectorAll('.modal-tab-panel');

    const switchModalTab = (targetTabId) => {
        tabBtns.forEach(btn => {
            if (btn.getAttribute('data-tab') === targetTabId) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        tabPanels.forEach(panel => {
            if (panel.id === targetTabId) {
                panel.classList.remove('hidden');
            } else {
                panel.classList.add('hidden');
            }
        });
    };

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            audio.playClick();
            switchModalTab(btn.getAttribute('data-tab'));
        });
    });

    const openCaseStudy = (data) => {
        if (!caseStudyModal) return;

        audio.playWhoosh();

        if (modalTitle) modalTitle.textContent = data.title;
        if (modalCategory) modalCategory.textContent = data.category;
        if (modalSummary) modalSummary.textContent = data.summary;
        if (modalProblem) modalProblem.textContent = data.problem_statement || 'Studi kasus performa tinggi dengan kebutuhan arsitektur terukur.';
        if (modalSolution) modalSolution.textContent = data.solution_details || 'Implementasi modular service berbasis clean architecture dan testing terstandarisasi.';
        if (modalArchitecture) modalArchitecture.textContent = data.architecture_details || 'Arsitektur terdistribusi dengan high-availability SLA dan automated CI/CD.';
        if (modalImage && data.cover_image) modalImage.src = data.cover_image;

        // Reset to first tab
        switchModalTab('tab-overview');

        // Tech stacks tags
        if (modalTechStacks) {
            modalTechStacks.innerHTML = '';
            const stacks = Array.isArray(data.tech_stacks) 
                ? data.tech_stacks 
                : (typeof data.tech_stacks === 'string' ? JSON.parse(data.tech_stacks) : []);
            stacks.forEach(tech => {
                const badge = document.createElement('span');
                badge.className = 'px-3 py-1 rounded-full text-xs font-semibold bg-blue-900/40 text-blue-300 border border-blue-700/50';
                badge.textContent = tech;
                modalTechStacks.appendChild(badge);
            });
        }

        // Metrics tags
        if (modalMetrics) {
            modalMetrics.innerHTML = '';
            const metrics = Array.isArray(data.key_metrics) 
                ? data.key_metrics 
                : (typeof data.key_metrics === 'string' ? JSON.parse(data.key_metrics) : []);
            metrics.forEach(metric => {
                const li = document.createElement('li');
                li.className = 'flex items-center gap-2 text-sm text-gray-200';
                li.innerHTML = `<span class="w-5 h-5 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center text-xs font-bold shrink-0">✓</span> ${metric}`;
                modalMetrics.appendChild(li);
            });
        }

        // Links
        if (modalDemoLink) {
            if (data.demo_url) {
                modalDemoLink.href = data.demo_url;
                modalDemoLink.classList.remove('hidden');
            } else {
                modalDemoLink.classList.add('hidden');
            }
        }

        if (modalRepoLink) {
            if (data.repo_url) {
                modalRepoLink.href = data.repo_url;
                modalRepoLink.classList.remove('hidden');
            } else {
                modalRepoLink.classList.add('hidden');
            }
        }

        caseStudyModal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    const closeCaseStudy = () => {
        if (!caseStudyModal) return;
        caseStudyModal.classList.add('hidden');
        document.body.style.overflow = '';
    };

    openModalBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const rawData = btn.getAttribute('data-project');
            if (rawData) {
                try {
                    openCaseStudy(JSON.parse(rawData));
                } catch (err) {
                    console.error('Failed to parse project JSON', err);
                }
            }
        });
    });

    if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeCaseStudy);
    if (modalBackdrop) modalBackdrop.addEventListener('click', closeCaseStudy);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeCaseStudy();
    });

    // 11. Contact Message Live Character Counter
    const messageInput = document.getElementById('message_body');
    const charCounter = document.getElementById('char-counter');
    if (messageInput && charCounter) {
        messageInput.addEventListener('input', () => {
            const count = messageInput.value.length;
            charCounter.textContent = `${count} karakter`;
            charCounter.className = count >= 10 ? 'text-xs text-green-400 font-mono' : 'text-xs text-gray-500 font-mono';
        });
    }

    // Contact form submit sound
    const contactForm = document.querySelector('form[action*="contact/submit"]');
    if (contactForm) {
        contactForm.addEventListener('submit', () => {
            audio.playSuccess();
        });
    }
});

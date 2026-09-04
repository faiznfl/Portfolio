<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Collection;

class PortfolioData
{
    /**
     * Get the default profile instance.
     */
    public static function getProfile(): Profile
    {
        return new Profile([
            'id' => 1,
            'full_name' => 'Faiz Naufal',
            'headline' => 'Senior Full-Stack Engineer & Cloud Systems Architect',
            'subheadline' => 'Merancang sistem terdistribusi berkecepatan tinggi, database berdaya tahan tinggi, dan antarmuka web modern dengan standar keandalan 99.98%.',
            'bio_about' => 'Saya adalah Software Engineer dengan pengalaman lebih dari 5 tahun dalam merancang dan membangun ekosistem perangkat lunak berskala besar. Berfokus pada sistem backend berkinerja tinggi, arsitektur terdistribusi yang tangguh, serta antarmuka web modern yang presisi dan responsif. Berdedikasi pada prinsip Clean Code, automatisasi DevOps, dan efisiensi arsitektur yang memberikan dampak bisnis nyata.',
            'engineering_principles' => [
                [
                    'title' => 'Architecture Before Code',
                    'desc' => 'Merancang domain boundary, skema relasi data, dan strategi konkurensi sebelum menulis baris kode pertama guna mencegah technical debt.',
                    'icon' => 'cube',
                ],
                [
                    'title' => 'Resilience & High Availability',
                    'desc' => 'Menerapkan graceful degradation, circuit breaker, idempotency key, dan failover otomatis untuk menjaga SLA uptime 99.99%.',
                    'icon' => 'shield',
                ],
                [
                    'title' => 'Cinematic & Accessible UI',
                    'desc' => 'Antarmuka pengguna bukan sekadar visual, melainkan instrumen komunikasi interaktif berkecepatan tinggi dengan aksesibilitas standar WCAG 2.1.',
                    'icon' => 'sparkles',
                ],
                [
                    'title' => 'Continuous Automation',
                    'desc' => 'Setiap perubahan kode harus melewati pipeline validasi otomatis: static analysis, unit/feature tests, dan zero-downtime containerized deployments.',
                    'icon' => 'cpu',
                ],
            ],
            'avatar_image' => '/assets/images/faiz-naufal.jpg',
            'resume_file_path' => '/assets/resume-faiz-naufal.pdf',
            'availability_status' => 'available',
            'availability_text' => 'Tersedia untuk Proyek Strategis & Posisi Senior',
            'social_links' => [
                'github' => 'https://github.com/faiznfl',
                'linkedin' => 'https://linkedin.com/in/faiznfl',
                'email' => 'faiznaufal.dev@gmail.com',
                'twitter' => 'https://x.com/faiznfl',
            ],
            'stats' => [
                'years_exp' => '5+',
                'projects_shipped' => '24+',
                'uptime_sla' => '99.98%',
                'certifications' => '8+',
            ],
        ]);
    }

    /**
     * Get default skills collection.
     *
     * @return Collection<int, Skill>
     */
    public static function getSkills(): Collection
    {
        $items = [
            // Languages
            ['id' => 1, 'name' => 'PHP 8.4+', 'category' => 'Languages', 'proficiency_level' => 96, 'order_index' => 1, 'is_featured' => true],
            ['id' => 2, 'name' => 'TypeScript', 'category' => 'Languages', 'proficiency_level' => 92, 'order_index' => 2, 'is_featured' => true],
            ['id' => 3, 'name' => 'Go (Golang)', 'category' => 'Languages', 'proficiency_level' => 88, 'order_index' => 3, 'is_featured' => true],
            ['id' => 4, 'name' => 'Python', 'category' => 'Languages', 'proficiency_level' => 82, 'order_index' => 4, 'is_featured' => false],
            ['id' => 5, 'name' => 'SQL (PostgreSQL)', 'category' => 'Languages', 'proficiency_level' => 94, 'order_index' => 5, 'is_featured' => true],

            // Backend
            ['id' => 6, 'name' => 'Laravel 12/13', 'category' => 'Backend', 'proficiency_level' => 98, 'order_index' => 6, 'is_featured' => true],
            ['id' => 7, 'name' => 'Node.js / NestJS', 'category' => 'Backend', 'proficiency_level' => 89, 'order_index' => 7, 'is_featured' => true],
            ['id' => 8, 'name' => 'GraphQL / gRPC', 'category' => 'Backend', 'proficiency_level' => 86, 'order_index' => 8, 'is_featured' => false],
            ['id' => 9, 'name' => 'FastAPI', 'category' => 'Backend', 'proficiency_level' => 83, 'order_index' => 9, 'is_featured' => false],

            // Frontend
            ['id' => 10, 'name' => 'Tailwind CSS v4', 'category' => 'Frontend', 'proficiency_level' => 95, 'order_index' => 10, 'is_featured' => true],
            ['id' => 11, 'name' => 'Vue.js 3 / Inertia', 'category' => 'Frontend', 'proficiency_level' => 91, 'order_index' => 11, 'is_featured' => true],
            ['id' => 12, 'name' => 'React & Next.js', 'category' => 'Frontend', 'proficiency_level' => 87, 'order_index' => 12, 'is_featured' => false],
            ['id' => 13, 'name' => 'Modern Vanilla JS', 'category' => 'Frontend', 'proficiency_level' => 94, 'order_index' => 13, 'is_featured' => false],

            // Databases
            ['id' => 14, 'name' => 'PostgreSQL & pgvector', 'category' => 'Databases', 'proficiency_level' => 93, 'order_index' => 14, 'is_featured' => true],
            ['id' => 15, 'name' => 'Redis (Cache/PubSub)', 'category' => 'Databases', 'proficiency_level' => 95, 'order_index' => 15, 'is_featured' => true],
            ['id' => 16, 'name' => 'MySQL / MariaDB', 'category' => 'Databases', 'proficiency_level' => 90, 'order_index' => 16, 'is_featured' => false],
            ['id' => 17, 'name' => 'Elasticsearch', 'category' => 'Databases', 'proficiency_level' => 84, 'order_index' => 17, 'is_featured' => false],

            // DevOps & Cloud
            ['id' => 18, 'name' => 'Docker & Podman', 'category' => 'DevOps', 'proficiency_level' => 94, 'order_index' => 18, 'is_featured' => true],
            ['id' => 19, 'name' => 'Kubernetes (K8s)', 'category' => 'DevOps', 'proficiency_level' => 86, 'order_index' => 19, 'is_featured' => true],
            ['id' => 20, 'name' => 'AWS (ECS, S3, RDS)', 'category' => 'DevOps', 'proficiency_level' => 90, 'order_index' => 20, 'is_featured' => true],
            ['id' => 21, 'name' => 'CI/CD (GitHub Actions)', 'category' => 'DevOps', 'proficiency_level' => 93, 'order_index' => 21, 'is_featured' => true],
            ['id' => 22, 'name' => 'Terraform (IaC)', 'category' => 'DevOps', 'proficiency_level' => 85, 'order_index' => 22, 'is_featured' => false],
        ];

        return collect($items)->map(fn ($item) => new Skill($item));
    }

    /**
     * Get default projects collection.
     *
     * @return Collection<int, Project>
     */
    public static function getProjects(): Collection
    {
        $items = [
            [
                'id' => 1,
                'title' => 'OmniPulse: Enterprise Multi-Tenant Commerce Engine',
                'slug' => 'omnipulse-commerce-engine',
                'category' => 'Full-Stack',
                'summary' => 'Sistem e-commerce berskala enterprise dengan arsitektur multi-tenant database terisolasi, checkout asinkron berbasis Kafka, dan analitik real-time.',
                'cover_image' => '/assets/projects/project-omnipulse.svg',
                'problem_statement' => 'Klien menghadapi bottleneck transaksi parah saat flash sale dengan trafik melonjak 18x lipat. Sistem lama sering mengalami database deadlocks dan kegagalan sinkronisasi inventaris multi-gudang secara instan.',
                'solution_details' => 'Membangun ulang arsitektur monolitik menjadi modular service dengan isolasi tenant, implementasi Redis atomic locks untuk reservasi stok flash sale, pipeline event-driven Kafka untuk settlement pesanan, dan cache warming terdistribusi.',
                'architecture_details' => 'Laravel 12 REST/GraphQL Core, Redis Cluster untuk atomic decrement stok, PostgreSQL dengan partitioning tabel transaksi bulanan, MinIO untuk asset storage, dan Docker Swarm orchestration dengan auto-scaling.',
                'tech_stacks' => ['Laravel 12', 'PostgreSQL', 'Redis Cluster', 'Kafka', 'Docker', 'Tailwind CSS'],
                'key_features' => [
                    'Multi-tenant database architecture dengan isolasi data tingkat enterprise',
                    'Asynchronous checkout pipeline bertenaga Apache Kafka',
                    'Flash-sale high concurrency engine dengan Redis atomic locking',
                    'Sinkronisasi inventaris multi-gudang dan analitik real-time',
                ],
                'demo_url' => 'https://omnipulse-demo.internal',
                'repo_url' => 'https://github.com/faiznfl/omnipulse-engine',
                'gallery_images' => ['/assets/projects/project-omnipulse.svg'],
                'key_metrics' => [
                    'Mampu menangani 14,000 req/sec peak',
                    'Zero duplicate transaction record',
                    'Pengurangan latency checkout dari 2.4s ke 180ms',
                ],
                'is_featured' => true,
                'is_published' => true,
                'order_index' => 1,
            ],
            [
                'id' => 2,
                'title' => 'SentinelGate: Distributed Edge API Security Shield',
                'slug' => 'sentinelgate-edge-security',
                'category' => 'Backend & Systems',
                'summary' => 'Edge gateway berkecepatan tinggi dengan token-bucket rate limiting adaptif, proteksi DDoS, dan mitigasi bot otomatis.',
                'cover_image' => '/assets/projects/project-sentinel.svg',
                'problem_statement' => 'Serangan scraping agresif dan credential stuffing mengakibatkan lonjakan biaya server hingga 400% serta ancaman kebocoran data pengguna pada public endpoint.',
                'solution_details' => 'Merancang gateway proksi berbasis Golang & Redis sliding-window counter. Dilengkapi analisis reputasi IP secara real-time, behavioral bot scoring, dan token enkripsi HMAC.',
                'architecture_details' => 'Golang reverse proxy core, Redis cluster untuk global rate-limit state sync, Cloudflare edge workers integration, Prometheus & Grafana dashboard untuk visualisasi anomali seketika.',
                'tech_stacks' => ['Go (Golang)', 'Redis', 'Docker', 'Prometheus', 'Grafana', 'eBPF'],
                'key_features' => [
                    'Adaptive token-bucket rate limiting dengan sliding window counter',
                    'Mitigasi DDoS otomatis dan analisis reputasi IP real-time',
                    'Verifikasi token terenkripsi HMAC dengan latency sub-5ms',
                    'Dashboard telemetri anomali real-time via Prometheus & Grafana',
                ],
                'demo_url' => 'https://sentinel.internal',
                'repo_url' => 'https://github.com/faiznfl/sentinelgate',
                'gallery_images' => ['/assets/projects/project-sentinel.svg'],
                'key_metrics' => [
                    'Latency overhead < 4.2ms pada P99',
                    'Memblokir 1.8M malicious bot requests per hari',
                    'Penghematan compute cost sebesar 45%',
                ],
                'is_featured' => true,
                'is_published' => true,
                'order_index' => 2,
            ],
            [
                'id' => 3,
                'title' => 'AetherMesh: Telemetry & Microservices Observability APM',
                'slug' => 'aethermesh-observability',
                'category' => 'Cloud & DevOps',
                'summary' => 'Platform observabilitas terpusat untuk pelacakan jejak terdistribusi (distributed tracing), metrik kesehatan klaster, dan peringatan insiden cerdas.',
                'cover_image' => '/assets/projects/project-aethermesh.svg',
                'problem_statement' => 'Tim developer membutuhkan waktu rata-rata 3 jam (MTTD) untuk melacak sumber error pada sistem yang terdiri dari 32 microservices.',
                'solution_details' => 'Mengimplementasikan standar OpenTelemetry terpadu ke seluruh layanan, agregasi trace terdistribusi, korelasi log otomatis dengan SpanID, serta modul notifikasi insiden berbasis threshold dinamis.',
                'architecture_details' => 'OpenTelemetry collector, Vector daemon, ClickHouse untuk penyimpanan deret waktu bervolume tinggi, Next.js interactive timeline viewer.',
                'tech_stacks' => ['OpenTelemetry', 'ClickHouse', 'Vector', 'TypeScript', 'Tailwind CSS', 'Docker'],
                'key_features' => [
                    'Distributed tracing standar OpenTelemetry terpadu untuk 32+ microservices',
                    'Agregasi trace dan korelasi log otomatis dengan SpanID',
                    'Penyimpanan deret waktu ClickHouse dengan kompresi hingga 85%',
                    'Sistem peringatan insiden dinamis berbasis threshold otomatis',
                ],
                'demo_url' => 'https://aethermesh.internal',
                'repo_url' => 'https://github.com/faiznfl/aethermesh',
                'gallery_images' => ['/assets/projects/project-aethermesh.svg'],
                'key_metrics' => [
                    'Mengurangi MTTD dari 3 jam ke 7 menit',
                    'Throughput penyerapan data 50GB logs/hari',
                    'Penyimpanan terkompresi hingga 85%',
                ],
                'is_featured' => true,
                'is_published' => true,
                'order_index' => 3,
            ],
            [
                'id' => 4,
                'title' => 'NexusLedger: Double-Entry Core Banking & Payment Ledger',
                'slug' => 'nexus-ledger-banking',
                'category' => 'Backend & Systems',
                'summary' => 'Mesin pembukuan akuntansi ganda berintegritas tinggi dengan jaminan ACID mutlak, idempotency tokens, dan audit trails tamper-proof.',
                'cover_image' => '/assets/projects/project-nexus.svg',
                'problem_statement' => 'Kebutuhan kepatuhan regulasi finansial terhadap pelacakan mutasi saldo tanpa selisih 1 rupiah pun, dengan audit trail yang tidak dapat diubah.',
                'solution_details' => 'Menerapkan paradigma Immutable Accounting Ledger di mana tidak ada operasi UPDATE saldo langsung; semua mutasi dicatat sebagai jurnal DEBIT dan KREDIT berpasangan dengan verifikasi hash chaining.',
                'architecture_details' => 'Laravel 12 / PHP 8.4 engine, PostgreSQL strict constraints & row-level locking, cryptographically signed ledger blocks, RESTful compliance API.',
                'tech_stacks' => ['PHP 8.4', 'Laravel', 'PostgreSQL', 'Docker', 'OpenAPI'],
                'key_features' => [
                    'Immutable Double-Entry Accounting Ledger dengan jaminan ACID penuh',
                    'Audit trail tamper-proof dengan verifikasi hash chaining kriptografis',
                    'Idempotency tokens untuk mencegah duplikasi transaksi finansial',
                    'Kapasitas pemrosesan hingga 3,500 journal entries per detik',
                ],
                'demo_url' => 'https://ledger.internal',
                'repo_url' => 'https://github.com/faiznfl/nexusledger',
                'gallery_images' => ['/assets/projects/project-nexus.svg'],
                'key_metrics' => [
                    'Zero balance reconciliation discrepancies',
                    '100% compliant dengan audit standar perbankan',
                    'Kapasitas pemrosesan 3,500 journal entries/sec',
                ],
                'is_featured' => false,
                'is_published' => true,
                'order_index' => 4,
            ],
            [
                'id' => 5,
                'title' => 'Hyperion: Enterprise Semantic Search & Contextual Copilot',
                'slug' => 'hyperion-semantic-search',
                'category' => 'AI & Realtime',
                'summary' => 'Mesin pencarian semantik perusahaan berbasis RAG (Retrieval-Augmented Generation) dan vector embeddings untuk jutaan dokumen internal.',
                'cover_image' => '/assets/projects/project-hyperion.svg',
                'problem_statement' => 'Karyawan kesulitan menemukan SOP dan dokumentasi teknis yang tersebar di Notion, Confluence, dan PDF dengan pencarian keyword tradisional.',
                'solution_details' => 'Membangun ingestion pipeline otomatis yang mengekstrak teks, men-chunk secara cerdas, membuat embeddings 1536-dimensi, dan melayani hybrid search (BM25 + cosine similarity) dengan LLM re-ranking.',
                'architecture_details' => 'FastAPI / Python worker, PostgreSQL dengan ekstensi pgvector, Redis vector cache, Vue 3 interface dengan streaming response via Server-Sent Events (SSE).',
                'tech_stacks' => ['Python', 'PostgreSQL pgvector', 'Redis', 'Vue 3', 'Tailwind CSS', 'FastAPI'],
                'key_features' => [
                    'Hybrid semantic search menggabungkan BM25 dan pgvector cosine similarity',
                    'RAG pipeline otomatis untuk dokumen Notion, Confluence, dan PDF',
                    'Streaming token response via Server-Sent Events (SSE)',
                    'Vector cache terdistribusi bertenaga Redis untuk query instan',
                ],
                'demo_url' => 'https://hyperion.internal',
                'repo_url' => 'https://github.com/faiznfl/hyperion-rag',
                'gallery_images' => ['/assets/projects/project-hyperion.svg'],
                'key_metrics' => [
                    'Tingkat akurasi relevansi pencarian 94.2%',
                    'Latency response pencarian < 250ms',
                    'Efisiensi waktu riset internal meningkat 60%',
                ],
                'is_featured' => false,
                'is_published' => true,
                'order_index' => 5,
            ],
            [
                'id' => 6,
                'title' => 'CollabCanvas: Real-time Multi-User Whiteboard Engine',
                'slug' => 'collab-canvas-engine',
                'category' => 'Full-Stack',
                'summary' => 'Aplikasi kolaborasi papan tulis real-time dengan sinkronisasi konflik-bebas berbasis Conflict-free Replicated Data Types (CRDTs).',
                'cover_image' => '/assets/projects/project-collab.svg',
                'problem_statement' => 'Kolaborasi visual tim sering mengalami stuttering dan lag parah ketika lebih dari 10 pengguna menggambar secara bersamaan.',
                'solution_details' => 'Memanfaatkan WebSockets biner, algoritma Yjs CRDT untuk resolusi konflik instan di sisi klien, dan rendering berbasis Canvas 2D yang dioptimalkan dengan spatial partitioning quadtree.',
                'architecture_details' => 'Node.js WebSocket gateway, Redis adapter untuk horizontal scaling multi-instance, HTML5 Canvas 60fps rendering engine, Vite + Tailwind frontend.',
                'tech_stacks' => ['TypeScript', 'Node.js', 'WebSockets', 'Yjs CRDT', 'Canvas API', 'Tailwind CSS'],
                'key_features' => [
                    'Sinkronisasi multi-user bebas konflik berbasis algoritma Yjs CRDTs',
                    'WebSocket duplex streaming bertenaga Go backend',
                    'Infinite vector canvas rendering 60 FPS menggunakan WebGL / HTML5 Canvas',
                    'Riwayat mutasi tak terbatas (undo/redo) dan export format SVG/PNG',
                ],
                'demo_url' => 'https://collab.internal',
                'repo_url' => 'https://github.com/faiznfl/collabcanvas',
                'gallery_images' => ['/assets/projects/project-collab.svg'],
                'key_metrics' => [
                    'Smooth 60 FPS pada 50 pengguna bersamaan per canvas',
                    'WebSocket ping roundtrip < 35ms',
                    'Zero packet drop state recovery',
                ],
                'is_featured' => false,
                'is_published' => true,
                'order_index' => 6,
            ],
        ];

        return collect($items)->map(fn ($item) => new Project($item));
    }

    /**
     * Find project by slug from default data.
     */
    public static function findProject(string $slug): ?Project
    {
        return self::getProjects()->firstWhere('slug', $slug);
    }

    /**
     * Get default experiences collection.
     *
     * @return Collection<int, Experience>
     */
    public static function getExperiences(): Collection
    {
        $items = [
            [
                'id' => 1,
                'role_title' => 'Lead Full-Stack & Systems Architect',
                'company_name' => 'ScaleFlow Technologies',
                'company_url' => 'https://scaleflow.internal',
                'location' => 'Jakarta, Indonesia (Hybrid)',
                'employment_type' => 'Full-time',
                'start_date' => '2024-02-01',
                'end_date' => null,
                'is_current' => true,
                'description_points' => [
                    'Memimpin tim rekayasa backend (8 engineer) dalam perancangan arsitektur microservices terdistribusi yang melayani 2.5 juta pengguna aktif bulanan.',
                    'Mengoptimalkan database query dan caching layer Redis yang menghasilkan penurunan latency rata-rata API sebesar 58%.',
                    'Menginisiasi standarisasi CI/CD pipeline dengan automated quality gates (Pint, PHPStan Level 8, PHPUnit) yang memangkas waktu rilis dari 4 hari menjadi 45 menit.',
                    'Merancang arsitektur disaster recovery multi-region dengan RPO < 5 menit dan RTO < 15 menit.',
                ],
                'tech_used' => ['Laravel 12', 'Go', 'PostgreSQL', 'Redis', 'Docker', 'AWS ECS', 'Kubernetes'],
                'order_index' => 1,
            ],
            [
                'id' => 2,
                'role_title' => 'Senior Backend Engineer',
                'company_name' => 'Nusantara FinTech Global',
                'company_url' => 'https://fintech.internal',
                'location' => 'Jakarta, Indonesia',
                'employment_type' => 'Full-time',
                'start_date' => '2022-04-01',
                'end_date' => '2024-01-31',
                'is_current' => false,
                'description_points' => [
                    'Mengembangkan modul pembayaran instan (QRIS, Virtual Account, Disbursment) dengan throughput 600 transaksi/detik.',
                    'Mengimplementasikan idempotent event messaging berbasis Kafka untuk mencegah transaksi ganda selama kegagalan jaringan.',
                    'Membangun audit trail compliance log terenkripsi yang memenuhi regulasi standar keamanan Bank Indonesia.',
                ],
                'tech_used' => ['PHP / Laravel', 'PostgreSQL', 'Apache Kafka', 'Redis', 'Docker', 'Prometheus'],
                'order_index' => 2,
            ],
            [
                'id' => 3,
                'role_title' => 'Full-Stack Web Developer',
                'company_name' => 'CloudMatrix Digital Studio',
                'company_url' => 'https://cloudmatrix.internal',
                'location' => 'Bandung, Indonesia (Remote)',
                'employment_type' => 'Full-time',
                'start_date' => '2020-07-01',
                'end_date' => '2022-03-31',
                'is_current' => false,
                'description_points' => [
                    'Membangun lebih dari 15 portal web kustom dan sistem back-office enterprise menggunakan Laravel, Vue.js, dan Tailwind CSS.',
                    'Merancang sistem manajemen konten (CMS) berbasis peran (RBAC) dengan granular authorization.',
                    'Meningkatkan skor Google Lighthouse dari 64 menjadi 98+ melalui teknik code splitting, asset minification, dan responsive image generation.',
                ],
                'tech_used' => ['Laravel', 'Vue.js', 'MySQL', 'Tailwind CSS', 'Alpine.js', 'REST API'],
                'order_index' => 3,
            ],
            [
                'id' => 4,
                'role_title' => 'Software Engineer Intern',
                'company_name' => 'Telkom Digital Innovation Center',
                'company_url' => 'https://telkom.internal',
                'location' => 'Bandung, Indonesia',
                'employment_type' => 'Internship',
                'start_date' => '2019-08-01',
                'end_date' => '2020-01-31',
                'is_current' => false,
                'description_points' => [
                    'Mengembangkan dashboard internal analitik jaringan IoT dan visualisasi data perangkat secara real-time.',
                    'Membuat unit test otomatis dengan PHPUnit dengan test coverage mencapai 85%.',
                ],
                'tech_used' => ['PHP', 'CodeIgniter', 'MySQL', 'JavaScript', 'Chart.js'],
                'order_index' => 4,
            ],
        ];

        return collect($items)->map(fn ($item) => new Experience($item));
    }

    /**
     * Get default certificates collection.
     *
     * @return Collection<int, Certificate>
     */
    public static function getCertificates(): Collection
    {
        $items = [
            [
                'id' => 1,
                'certificate_name' => 'AWS Certified Solutions Architect – Associate',
                'issuer_organization' => 'Amazon Web Services (AWS)',
                'issue_date' => '2024-05-15',
                'expiration_date' => '2027-05-15',
                'credential_id' => 'AWS-SAA-884920418',
                'credential_url' => 'https://aws.amazon.com/verification',
                'media_file_path' => '/assets/certificates/cert-aws-saa.svg',
                'category' => 'Cloud & Architecture',
                'order_index' => 1,
            ],
            [
                'id' => 2,
                'certificate_name' => 'HashiCorp Certified: Terraform Associate',
                'issuer_organization' => 'HashiCorp',
                'issue_date' => '2023-11-20',
                'expiration_date' => '2025-11-20',
                'credential_id' => 'HC-TA-559102941',
                'credential_url' => 'https://www.credly.com/org/hashicorp',
                'media_file_path' => '/assets/certificates/cert-terraform.svg',
                'category' => 'DevOps & Infrastructure',
                'order_index' => 2,
            ],
            [
                'id' => 3,
                'certificate_name' => 'Google Cloud Certified: Professional Cloud Developer',
                'issuer_organization' => 'Google Cloud',
                'issue_date' => '2023-08-10',
                'expiration_date' => '2025-08-10',
                'credential_id' => 'GCP-PCD-390184820',
                'credential_url' => 'https://cloud.google.com/certification',
                'media_file_path' => '/assets/certificates/cert-gcp.svg',
                'category' => 'Cloud & Backend',
                'order_index' => 3,
            ],
            [
                'id' => 4,
                'certificate_name' => 'Sertifikasi Kompetensi Rekayasa Perangkat Lunak (Software Architect)',
                'issuer_organization' => 'Badan Nasional Sertifikasi Profesi (BNSP)',
                'issue_date' => '2022-12-05',
                'expiration_date' => '2025-12-05',
                'credential_id' => 'BNSP-RPL-77182901',
                'credential_url' => 'https://bnsp.go.id/verifikasi',
                'media_file_path' => '/assets/certificates/cert-bnsp.svg',
                'category' => 'Software Engineering',
                'order_index' => 4,
            ],
        ];

        return collect($items)->map(fn ($item) => new Certificate($item));
    }
}

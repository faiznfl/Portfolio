<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Database\Seeders\PortfolioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PortfolioSeeder::class);
        $this->admin = User::where('email', 'admin@portfolio.local')->first();
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    public function test_admin_login_page_renders_successfully(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
        $response->assertSee('<title>Faiz Naufal Putra Permana - Admin Login</title>', false);
        $response->assertSee('Portal Manajemen Admin');
        $response->assertDontSee('id="mobile-drawer"', false);
        $response->assertDontSee('Desktop Navigation', false);
    }

    public function test_admin_can_authenticate_with_valid_credentials(): void
    {
        $response = $this->post('/admin/login', [
            'email' => 'admin@portfolio.local',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_authenticated_admin_can_view_dashboard_and_messages(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('<title>Faiz Naufal Putra Permana - Admin</title>', false);
        $response->assertSee('Manajemen Portofolio');
        $response->assertSee('Pesan &amp; Tawaran Kerja Sama Masuk', false);
    }

    public function test_admin_can_update_availability_status(): void
    {
        $profile = Profile::create([
            'full_name' => 'Faiz Naufal',
            'headline' => 'Senior Full-Stack Engineer',
            'bio_about' => 'Senior software engineer bio.',
            'availability_status' => 'available',
            'availability_text' => 'Tersedia',
        ]);

        $response = $this->actingAs($this->admin)->put('/admin/availability', [
            'availability_status' => 'busy',
            'availability_text' => 'Fokus pada Kontrak Arsitektur Aktif',
        ]);

        $response->assertSessionHas('success');

        $profile = Profile::first();
        $this->assertEquals('busy', $profile->availability_status);
        $this->assertEquals('Fokus pada Kontrak Arsitektur Aktif', $profile->availability_text);
    }

    public function test_admin_can_toggle_message_read_status(): void
    {
        $message = Message::create([
            'sender_name' => 'Test Sender',
            'sender_email' => 'sender@example.com',
            'subject' => 'Inquiry',
            'message_body' => 'Message content for testing.',
            'is_read' => false,
        ]);
        $initialStatus = $message->is_read;

        $response = $this->actingAs($this->admin)->patch('/admin/messages/'.$message->id.'/toggle-read');

        $response->assertSessionHas('success');
        $this->assertEquals(! $initialStatus, $message->fresh()->is_read);
    }

    public function test_admin_can_delete_message(): void
    {
        $message = Message::create([
            'sender_name' => 'Delete Sender',
            'sender_email' => 'delete@example.com',
            'subject' => 'Inquiry to delete',
            'message_body' => 'Message content to be deleted.',
            'is_read' => false,
        ]);

        $response = $this->actingAs($this->admin)->delete('/admin/messages/'.$message->id);

        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('messages', ['id' => $message->id]);
    }

    public function test_admin_can_create_new_project(): void
    {
        $payload = [
            'title' => 'Valkyrie Telemetry Engine',
            'category' => 'Cloud & DevOps',
            'summary' => 'Real-time telemetry and streaming ingestion engine.',
            'cover_image' => '/assets/projects/project-valkyrie.svg',
            'key_features_raw' => "Sub-5ms telemetry latency\nZero data loss pipeline\nKafka partitioning",
            'tech_stacks_raw' => 'Go, Kafka, Docker',
            'order_index' => 10,
            'is_published' => 1,
            'is_featured' => 1,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/projects', $payload);

        $response->assertRedirect('/admin/projects');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('projects', [
            'title' => 'Valkyrie Telemetry Engine',
            'slug' => 'valkyrie-telemetry-engine',
            'cover_image' => '/assets/projects/project-valkyrie.svg',
        ]);

        $project = Project::where('slug', 'valkyrie-telemetry-engine')->first();
        $this->assertCount(3, $project->key_features);
        $this->assertEquals('Sub-5ms telemetry latency', $project->key_features[0]);
    }

    public function test_admin_can_upload_project_image_from_local_directory(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('custom_project.png');

        $payload = [
            'title' => 'Nexus Gateway Engine',
            'category' => 'Cloud & DevOps',
            'summary' => 'High performance gateway.',
            'project_image' => $file,
            'key_features_raw' => 'Sub-millisecond routing',
            'order_index' => 1,
            'is_published' => 1,
            'is_featured' => 0,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/projects', $payload);

        $response->assertRedirect('/admin/projects');
        $response->assertSessionHas('success');

        $project = Project::where('slug', 'nexus-gateway-engine')->first();
        $this->assertNotNull($project);
        $this->assertStringStartsWith('/assets/projects/', $project->cover_image);
        $this->assertStringEndsWith('.png', $project->cover_image);

        // Clean up created file if it was moved to public_path
        $actualPath = public_path(ltrim($project->cover_image, '/'));
        if (file_exists($actualPath)) {
            @unlink($actualPath);
        }
    }

    public function test_admin_can_update_existing_project(): void
    {
        $project = Project::create([
            'title' => 'Initial Project',
            'slug' => 'initial-project',
            'category' => 'Full-Stack',
            'summary' => 'Initial summary text.',
            'order_index' => 1,
            'is_published' => true,
            'is_featured' => true,
        ]);

        $payload = [
            'title' => 'OmniPulse Engine V2',
            'category' => 'Full-Stack',
            'summary' => 'Updated summary text.',
            'cover_image' => '/assets/projects/project-omnipulse.svg',
            'key_features_raw' => "14,000 req/sec peak\nZero duplicates\nReal-time analytics",
            'order_index' => 1,
            'is_published' => 1,
            'is_featured' => 1,
        ];

        $response = $this->actingAs($this->admin)->put('/admin/projects/'.$project->id, $payload);

        $response->assertRedirect('/admin/projects');
        $this->assertEquals('OmniPulse Engine V2', $project->fresh()->title);
        $this->assertCount(3, $project->fresh()->key_features);
    }

    public function test_admin_can_delete_project(): void
    {
        $project = Project::create([
            'title' => 'Project to Delete',
            'slug' => 'project-to-delete',
            'category' => 'Full-Stack',
            'summary' => 'Summary to delete.',
            'order_index' => 1,
            'is_published' => true,
            'is_featured' => true,
        ]);

        $response = $this->actingAs($this->admin)->delete('/admin/projects/'.$project->id);

        $response->assertRedirect('/admin/projects');
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    public function test_admin_can_create_update_and_delete_skill(): void
    {
        // 1. Create Skill with icon_svg and without proficiency_level
        $payload = [
            'name' => 'GraphQL & Apollo',
            'category' => 'Backend',
            'icon_svg' => '<svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg>',
            'order_index' => 15,
            'is_featured' => 1,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/skills', $payload);
        $response->assertRedirect('/admin/skills');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('skills', [
            'name' => 'GraphQL & Apollo',
            'proficiency_level' => 100,
        ]);

        $skill = Skill::where('name', 'GraphQL & Apollo')->first();
        $this->assertStringContainsString('<svg', $skill->icon_svg);

        // 2. Update Skill
        $updatePayload = [
            'name' => 'GraphQL & Federation',
            'category' => 'Backend',
            'icon_svg' => '🔥',
            'order_index' => 12,
            'is_featured' => 1,
        ];

        $updateResponse = $this->actingAs($this->admin)->put('/admin/skills/'.$skill->id, $updatePayload);
        $updateResponse->assertRedirect('/admin/skills');
        $this->assertEquals('GraphQL & Federation', $skill->fresh()->name);
        $this->assertEquals('🔥', $skill->fresh()->icon_svg);

        // 3. Delete Skill
        $deleteResponse = $this->actingAs($this->admin)->delete('/admin/skills/'.$skill->id);
        $deleteResponse->assertRedirect('/admin/skills');
        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }

    public function test_skill_form_has_icon_input_and_no_percentage_field(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/skills/create');
        $response->assertOk();
        $response->assertSee('Icon / Visual Keahlian');
        $response->assertSee('icon_svg');
        $response->assertDontSee('Tingkat Penguasaan (1 - 100%)');
    }

    public function test_public_portfolio_does_not_display_skill_percentages(): void
    {
        $response = $this->get('/');
        $response->assertOk();
        $response->assertDontSee('Tingkat Profisiensi');
        $response->assertDontSee('% Mastery');
    }

    public function test_admin_can_create_update_and_delete_experience(): void
    {
        // 1. Create Experience
        $payload = [
            'role_title' => 'Principal Systems Architect',
            'company_name' => 'ScaleOps Global',
            'company_url' => 'https://scaleops.global',
            'location' => 'Singapore (Remote)',
            'employment_type' => 'Full-time',
            'start_date' => '2025-01-01',
            'is_current' => 1,
            'description_points_raw' => "Architected multi-region failover.\nReduced infrastructure cost by 40%.",
            'tech_used_raw' => 'Kubernetes, Go, AWS, Terraform',
            'order_index' => 1,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/experiences', $payload);
        $response->assertRedirect('/admin/experiences');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('experiences', ['role_title' => 'Principal Systems Architect']);

        $experience = Experience::where('role_title', 'Principal Systems Architect')->first();

        // 2. Update Experience
        $updatePayload = [
            'role_title' => 'Chief Technology Architect',
            'company_name' => 'ScaleOps Global',
            'location' => 'Singapore (Remote)',
            'employment_type' => 'Full-time',
            'start_date' => '2025-01-01',
            'is_current' => 1,
            'description_points_raw' => "Overseeing global distributed infrastructure.\nDirecting 20+ senior engineers.",
            'tech_used_raw' => 'Kubernetes, Go, AWS',
            'order_index' => 1,
        ];

        $updateResponse = $this->actingAs($this->admin)->put('/admin/experiences/'.$experience->id, $updatePayload);
        $updateResponse->assertRedirect('/admin/experiences');
        $this->assertEquals('Chief Technology Architect', $experience->fresh()->role_title);

        // 3. Delete Experience
        $deleteResponse = $this->actingAs($this->admin)->delete('/admin/experiences/'.$experience->id);
        $deleteResponse->assertRedirect('/admin/experiences');
        $this->assertDatabaseMissing('experiences', ['id' => $experience->id]);
    }

    public function test_admin_can_create_update_and_delete_certificate(): void
    {
        // 1. Create Certificate
        $payload = [
            'certificate_name' => 'Certified Kubernetes Administrator (CKA)',
            'course_name' => 'Kubernetes Mastery & Production Deployment',
            'issuer_organization' => 'Cloud Native Computing Foundation (CNCF)',
            'issue_date' => '2025-06-15',
            'credential_id' => 'CKA-99281',
            'credential_url' => 'https://www.cncf.io/certification/cka/',
            'category' => 'Cloud & DevOps',
            'description' => 'Mendemonstrasikan kompetensi mendalam dalam manajemen cluster Kubernetes skala enterprise.',
            'order_index' => 1,
        ];

        $response = $this->actingAs($this->admin)->post('/admin/certificates', $payload);
        $response->assertRedirect('/admin/certificates');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('certificates', [
            'certificate_name' => 'Certified Kubernetes Administrator (CKA)',
            'course_name' => 'Kubernetes Mastery & Production Deployment',
        ]);

        $certificate = Certificate::where('certificate_name', 'Certified Kubernetes Administrator (CKA)')->first();

        // 2. Update Certificate
        $updatePayload = [
            'certificate_name' => 'CKA - Certified Kubernetes Administrator V2',
            'course_name' => 'Advanced Kubernetes Multi-Cluster Operations',
            'issuer_organization' => 'CNCF / Linux Foundation',
            'issue_date' => '2025-06-15',
            'credential_id' => 'CKA-99281-V2',
            'description' => 'Sertifikasi lanjutan konfigurasi multi-cluster.',
            'order_index' => 1,
        ];

        $updateResponse = $this->actingAs($this->admin)->put('/admin/certificates/'.$certificate->id, $updatePayload);
        $updateResponse->assertRedirect('/admin/certificates');
        $this->assertEquals('CKA - Certified Kubernetes Administrator V2', $certificate->fresh()->certificate_name);
        $this->assertEquals('Advanced Kubernetes Multi-Cluster Operations', $certificate->fresh()->course_name);

        // 3. Delete Certificate
        $deleteResponse = $this->actingAs($this->admin)->delete('/admin/certificates/'.$certificate->id);
        $deleteResponse->assertRedirect('/admin/certificates');
        $this->assertDatabaseMissing('certificates', ['id' => $certificate->id]);
    }

    public function test_admin_certificates_and_projects_do_not_render_preview_actions(): void
    {
        // 1. Certificates index
        $certIndexRes = $this->actingAs($this->admin)->get('/admin/certificates');
        $certIndexRes->assertStatus(200);
        $certIndexRes->assertDontSee('admin-cert-modal');
        $certIndexRes->assertDontSee('Preview ↗');

        // 2. Certificate create form
        $certCreateRes = $this->actingAs($this->admin)->get('/admin/certificates/create');
        $certCreateRes->assertStatus(200);
        $certCreateRes->assertDontSee('Pratinjau Berkas Gambar');
        $certCreateRes->assertDontSee('cert-preview-img');

        // 3. Projects index
        $projIndexRes = $this->actingAs($this->admin)->get('/admin/projects');
        $projIndexRes->assertStatus(200);
        $projIndexRes->assertDontSee('Preview ↗');

        // 4. Admin dashboard
        $dashRes = $this->actingAs($this->admin)->get('/admin');
        $dashRes->assertStatus(200);
        $dashRes->assertDontSee('Preview ↗');
    }

    public function test_admin_navbar_active_state_stays_on_module_when_accessing_create_or_subpages(): void
    {
        // 1. Dashboard active
        $dashRes = $this->actingAs($this->admin)->get('/admin');
        $dashRes->assertStatus(200);
        $dashRes->assertSee('data-section="dashboard"'."\n".'               class="admin-nav-item relative z-10 font-medium py-1.5 px-3 rounded-full text-xs lg:text-sm transition-colors duration-200 select-none text-ps-primary dark:text-cyan-300 font-semibold active-nav', false);

        // 2. Certificate create active on certificates
        $certRes = $this->actingAs($this->admin)->get('/admin/certificates/create');
        $certRes->assertStatus(200);
        $certRes->assertSee('data-section="certificates"'."\n".'               class="admin-nav-item relative z-10 font-medium py-1.5 px-3 rounded-full text-xs lg:text-sm transition-colors duration-200 select-none text-ps-primary dark:text-cyan-300 font-semibold active-nav', false);

        // 3. Project create active on projects
        $projRes = $this->actingAs($this->admin)->get('/admin/projects/create');
        $projRes->assertStatus(200);
        $projRes->assertSee('data-section="projects"'."\n".'               class="admin-nav-item relative z-10 font-medium py-1.5 px-3 rounded-full text-xs lg:text-sm transition-colors duration-200 select-none text-ps-primary dark:text-cyan-300 font-semibold active-nav', false);

        // 4. Skills create active on skills
        $skillRes = $this->actingAs($this->admin)->get('/admin/skills/create');
        $skillRes->assertStatus(200);
        $skillRes->assertSee('data-section="skills"'."\n".'               class="admin-nav-item relative z-10 font-medium py-1.5 px-3 rounded-full text-xs lg:text-sm transition-colors duration-200 select-none text-ps-primary dark:text-cyan-300 font-semibold active-nav', false);

        // 5. Experience create active on experiences
        $expRes = $this->actingAs($this->admin)->get('/admin/experiences/create');
        $expRes->assertStatus(200);
        $expRes->assertSee('data-section="experiences"'."\n".'               class="admin-nav-item relative z-10 font-medium py-1.5 px-3 rounded-full text-xs lg:text-sm transition-colors duration-200 select-none text-ps-primary dark:text-cyan-300 font-semibold active-nav', false);
    }

    public function test_admin_certificate_form_renders_category_input_and_presets(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/certificates/create');

        $response->assertStatus(200);
        $response->assertSee('name="category"', false);
        $response->assertSee('Prompt Engineering');
        $response->assertSee('Artificial Intelligence Basic');
    }

    public function test_skills_index_displays_custom_icons_and_no_lightning_bolt_placeholders(): void
    {
        Skill::create([
            'name' => 'Laravel',
            'category' => 'Backend',
            'icon_svg' => '<svg viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg>',
            'order_index' => 1,
            'is_featured' => 1,
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/skills');

        $response->assertStatus(200);
        $response->assertDontSee('⚡');
        $response->assertSee('<svg', false);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Database\Seeders\PortfolioSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PortfolioSeeder::class);
    }

    public function test_portfolio_homepage_renders_successfully_with_seven_sections(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<title>Faiz Naufal Putra Permana - Portfolio</title>', false);

        // Assert 7 key sections are present per PRD
        $response->assertSee('id="home"', false);
        $response->assertSee('id="about"', false);
        $response->assertSee('id="skills"', false);
        $response->assertSee('id="projects"', false);
        $response->assertSee('id="experience"', false);
        $response->assertSee('id="certificates"', false);
        $response->assertSee('id="contacts"', false);

        // Assert seeded benchmark content
        $response->assertSee('Faiz Naufal');
        $response->assertSee('OmniPulse');
    }

    public function test_portfolio_works_completely_without_database_seeder(): void
    {
        // Wipe tables to simulate completely fresh install with NO seeder run
        Profile::truncate();
        Skill::truncate();
        Project::truncate();
        Experience::truncate();
        Certificate::truncate();

        $response = $this->get('/');
        $response->assertStatus(200);

        // Verify that all 7 sections render cleanly without 500 errors
        $response->assertSee('id="home"', false);
        $response->assertSee('id="about"', false);
        $response->assertSee('id="skills"', false);
        $response->assertSee('id="projects"', false);
        $response->assertSee('id="experience"', false);
        $response->assertSee('id="certificates"', false);
        $response->assertSee('id="contacts"', false);

        // Test non-existent project returns 404
        $projectResponse = $this->get('/projects/non-existent-project');
        $projectResponse->assertStatus(404);
    }

    public function test_project_route_redirects_to_homepage_showcase(): void
    {
        $project = Project::create([
            'title' => 'OmniPulse Engine',
            'slug' => 'omnipulse-engine',
            'category' => 'Full-Stack',
            'summary' => 'High throughput commerce engine',
            'order_index' => 1,
            'is_published' => true,
        ]);

        $response = $this->get('/projects/'.$project->slug);

        $response->assertRedirect('/#projects');
    }

    public function test_project_ajax_endpoint_returns_json(): void
    {
        $project = Project::create([
            'title' => 'OmniPulse Engine',
            'slug' => 'omnipulse-engine',
            'category' => 'Full-Stack',
            'summary' => 'High throughput commerce engine',
            'problem_statement' => 'Problem Statement',
            'solution_details' => 'Engineering Solution',
            'order_index' => 1,
            'is_published' => true,
        ]);

        $response = $this->getJson('/projects/'.$project->slug);

        $response->assertStatus(200);
        $response->assertJson([
            'id' => $project->id,
            'slug' => $project->slug,
            'title' => $project->title,
        ]);
    }

    public function test_resume_download_endpoint_returns_file(): void
    {
        $response = $this->get('/resume/download');

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_contact_form_submits_successfully_and_persists_in_database(): void
    {
        $payload = [
            'sender_name' => 'John Client',
            'sender_email' => 'john@clientcompany.com',
            'subject' => 'Project Architecture Inquiry',
            'message_body' => 'We are interested in discussing a high-concurrency microservices project with you.',
            'website_hp' => '', // Honeypot remains empty
        ];

        $response = $this->post('/contact/submit', $payload);

        $response->assertRedirect('/#contacts');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('messages', [
            'sender_name' => 'John Client',
            'sender_email' => 'john@clientcompany.com',
            'subject' => 'Project Architecture Inquiry',
        ]);
    }

    public function test_contact_form_validates_required_fields(): void
    {
        $response = $this->post('/contact/submit', [
            'sender_name' => '',
            'sender_email' => 'not-an-email',
            'subject' => '',
            'message_body' => 'short',
        ]);

        $response->assertSessionHasErrors([
            'sender_name',
            'sender_email',
            'subject',
            'message_body',
        ]);
    }

    public function test_contact_form_blocks_honeypot_spam(): void
    {
        $payload = [
            'sender_name' => 'Spam Bot',
            'sender_email' => 'bot@spammer.com',
            'subject' => 'Buy Crypto Cheap',
            'message_body' => 'Spam message sent automatically by bot network.',
            'website_hp' => 'http://spam.com', // Filled honeypot
        ];

        $response = $this->post('/contact/submit', $payload);

        $this->assertDatabaseMissing('messages', [
            'sender_name' => 'Spam Bot',
        ]);
    }
}

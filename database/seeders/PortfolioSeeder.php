<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use App\Services\PortfolioData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin untuk akses Control Panel
        User::updateOrCreate(
            ['email' => 'admin@portfolio.local'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Data Profil (Benchmark Reference)
        $profile = PortfolioData::getProfile();
        Profile::updateOrCreate(
            ['full_name' => $profile->full_name],
            [
                'full_name' => $profile->full_name,
                'headline' => $profile->headline,
                'subheadline' => $profile->subheadline,
                'bio_about' => $profile->bio_about,
                'engineering_principles' => $profile->engineering_principles,
                'resume_file_path' => $profile->resume_file_path,
                'availability_status' => $profile->availability_status,
                'availability_text' => $profile->availability_text,
                'social_links' => $profile->social_links,
                'stats' => $profile->stats,
            ]
        );

        // 3. Data Skills (Benchmark Reference)
        foreach (PortfolioData::getSkills() as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill->name],
                [
                    'name' => $skill->name,
                    'category' => $skill->category,
                    'proficiency_level' => $skill->proficiency_level,
                    'order_index' => $skill->order_index,
                    'is_featured' => $skill->is_featured,
                ]
            );
        }

        // 4. Data Projects (Benchmark Reference)
        foreach (PortfolioData::getProjects() as $project) {
            Project::updateOrCreate(
                ['slug' => $project->slug],
                [
                    'title' => $project->title,
                    'slug' => $project->slug,
                    'category' => $project->category,
                    'summary' => $project->summary,
                    'cover_image' => $project->cover_image,
                    'key_features' => $project->key_features,
                    'problem_statement' => $project->problem_statement,
                    'solution_details' => $project->solution_details,
                    'architecture_details' => $project->architecture_details,
                    'tech_stacks' => $project->tech_stacks,
                    'demo_url' => $project->demo_url,
                    'repo_url' => $project->repo_url,
                    'gallery_images' => $project->gallery_images,
                    'key_metrics' => $project->key_metrics,
                    'is_featured' => $project->is_featured,
                    'is_published' => $project->is_published,
                    'order_index' => $project->order_index,
                ]
            );
        }

        // 5. Data Experiences (Benchmark Reference)
        foreach (PortfolioData::getExperiences() as $experience) {
            Experience::updateOrCreate(
                [
                    'role_title' => $experience->role_title,
                    'company_name' => $experience->company_name,
                ],
                [
                    'role_title' => $experience->role_title,
                    'company_name' => $experience->company_name,
                    'company_url' => $experience->company_url,
                    'location' => $experience->location,
                    'employment_type' => $experience->employment_type,
                    'start_date' => $experience->start_date,
                    'end_date' => $experience->end_date,
                    'is_current' => $experience->is_current,
                    'description_points' => $experience->description_points,
                    'tech_used' => $experience->tech_used,
                    'order_index' => $experience->order_index,
                ]
            );
        }

        // 6. Data Certificates (Benchmark Reference)
        foreach (PortfolioData::getCertificates() as $certificate) {
            Certificate::updateOrCreate(
                ['certificate_name' => $certificate->certificate_name],
                [
                    'certificate_name' => $certificate->certificate_name,
                    'issuer_organization' => $certificate->issuer_organization,
                    'issue_date' => $certificate->issue_date,
                    'expiration_date' => $certificate->expiration_date,
                    'credential_id' => $certificate->credential_id,
                    'credential_url' => $certificate->credential_url,
                    'media_file_path' => $certificate->media_file_path,
                    'category' => $certificate->category,
                    'order_index' => $certificate->order_index,
                ]
            );
        }
    }
}

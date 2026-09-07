<?php

namespace Database\Seeders;

use App\Models\Profile;
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

        // 2. Data Profil (Informasi Utama Faiz Naufal)
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
    }
}

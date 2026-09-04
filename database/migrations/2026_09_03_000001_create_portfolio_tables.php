<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('headline');
            $table->string('subheadline')->nullable();
            $table->text('bio_about');
            $table->json('engineering_principles')->nullable();
            $table->string('resume_file_path')->nullable();
            $table->string('availability_status')->default('available');
            $table->string('availability_text')->nullable();
            $table->json('social_links')->nullable();
            $table->json('stats')->nullable();
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category');
            $table->unsignedTinyInteger('proficiency_level')->default(85);
            $table->text('icon_svg')->nullable();
            $table->integer('order_index')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category');
            $table->text('summary');
            $table->string('cover_image')->nullable();
            $table->text('problem_statement')->nullable();
            $table->text('solution_details')->nullable();
            $table->text('architecture_details')->nullable();
            $table->json('tech_stacks')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('repo_url')->nullable();
            $table->json('gallery_images')->nullable();
            $table->json('key_metrics')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('role_title');
            $table->string('company_name');
            $table->string('company_url')->nullable();
            $table->string('location');
            $table->string('employment_type')->default('Full-time');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->json('description_points');
            $table->json('tech_used')->nullable();
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('certificate_name');
            $table->string('issuer_organization');
            $table->date('issue_date');
            $table->date('expiration_date')->nullable();
            $table->string('credential_id')->nullable();
            $table->string('credential_url')->nullable();
            $table->string('media_file_path')->nullable();
            $table->string('category')->nullable();
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name');
            $table->string('sender_email');
            $table->string('subject');
            $table->text('message_body');
            $table->string('ip_address', 45)->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('experiences');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('profiles');
    }
};

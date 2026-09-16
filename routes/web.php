<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortfolioController;
use App\Models\Profile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Portfolio & Showcase Platform
|--------------------------------------------------------------------------
*/

// Public Portfolio Showcase Routes
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::get('/projects/{slug}', [PortfolioController::class, 'project'])->name('projects.show');
Route::get('/resume', [PortfolioController::class, 'previewCv'])->name('resume.view');
Route::get('/resume/preview', [PortfolioController::class, 'previewCv'])->name('resume.preview');
Route::get('/resume/download', [PortfolioController::class, 'downloadCv'])->name('resume.download');
Route::post('/contact/submit', [PortfolioController::class, 'submitContact'])->name('contact.submit');

// Admin Authentication Routes
Route::get('/admin/login', [AdminController::class, 'login'])->name('login');
Route::get('/admin/login-redirect', fn () => redirect()->route('login'))->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Protected Admin Panel Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::put('/availability', [AdminController::class, 'updateAvailability'])->name('availability.update');

    // Account & Credentials Management
    Route::get('/account', [AdminController::class, 'accountIndex'])->name('account.index');
    Route::put('/account', [AdminController::class, 'accountUpdate'])->name('account.update');
    Route::put('/account/password', [AdminController::class, 'passwordUpdate'])->name('account.password.update');
    Route::post('/cv/upload', [AdminController::class, 'uploadCv'])->name('cv.upload');

    // Messages Management
    Route::patch('/messages/{message}/toggle-read', [AdminController::class, 'toggleMessageRead'])->name('messages.toggle-read');
    Route::delete('/messages/{message}', [AdminController::class, 'deleteMessage'])->name('messages.destroy');

    // Projects CRUD
    Route::get('/projects', [AdminController::class, 'projectsIndex'])->name('projects.index');
    Route::get('/projects/create', [AdminController::class, 'projectCreate'])->name('projects.create');
    Route::post('/projects', [AdminController::class, 'projectStore'])->name('projects.store');
    Route::get('/projects/{project}/edit', [AdminController::class, 'projectEdit'])->name('projects.edit');
    Route::put('/projects/{project}', [AdminController::class, 'projectUpdate'])->name('projects.update');
    Route::delete('/projects/{project}', [AdminController::class, 'projectDestroy'])->name('projects.destroy');

    // Skills CRUD
    Route::get('/skills', [AdminController::class, 'skillsIndex'])->name('skills.index');
    Route::get('/skills/create', [AdminController::class, 'skillCreate'])->name('skills.create');
    Route::post('/skills', [AdminController::class, 'skillStore'])->name('skills.store');
    Route::get('/skills/{skill}/edit', [AdminController::class, 'skillEdit'])->name('skills.edit');
    Route::put('/skills/{skill}', [AdminController::class, 'skillUpdate'])->name('skills.update');
    Route::delete('/skills/{skill}', [AdminController::class, 'skillDestroy'])->name('skills.destroy');

    // Experiences (Journey) CRUD
    Route::get('/experiences', [AdminController::class, 'experiencesIndex'])->name('experiences.index');
    Route::get('/experiences/create', [AdminController::class, 'experienceCreate'])->name('experiences.create');
    Route::post('/experiences', [AdminController::class, 'experienceStore'])->name('experiences.store');
    Route::get('/experiences/{experience}/edit', [AdminController::class, 'experienceEdit'])->name('experiences.edit');
    Route::put('/experiences/{experience}', [AdminController::class, 'experienceUpdate'])->name('experiences.update');
    Route::delete('/experiences/{experience}', [AdminController::class, 'experienceDestroy'])->name('experiences.destroy');

    // Certificates CRUD
    Route::get('/certificates', [AdminController::class, 'certificatesIndex'])->name('certificates.index');
    Route::get('/certificates/create', [AdminController::class, 'certificateCreate'])->name('certificates.create');
    Route::post('/certificates', [AdminController::class, 'certificateStore'])->name('certificates.store');
    Route::get('/certificates/{certificate}/edit', [AdminController::class, 'certificateEdit'])->name('certificates.edit');
    Route::put('/certificates/{certificate}', [AdminController::class, 'certificateUpdate'])->name('certificates.update');
    Route::delete('/certificates/{certificate}', [AdminController::class, 'certificateDestroy'])->name('certificates.destroy');
});

// Hosting Production Sync Route (for InfinityFree / Shared Hosting)
Route::get('/deploy-sync', function () {
    Artisan::call('db:seed', ['--class' => 'PortfolioSeeder', '--force' => true]);
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    $profile = Profile::first();

    return response()->json([
        'status' => 'success',
        'message' => 'Database and cache synced successfully on hosting!',
        'headline' => $profile?->headline,
    ]);
});

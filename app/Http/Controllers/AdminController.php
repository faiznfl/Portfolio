<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Show admin login form.
     */
    public function login(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Authenticate admin user credentials.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Selamat datang kembali di Panel Manajemen Portofolio!');
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
        ])->onlyInput('email');
    }

    /**
     * Logout authenticated admin.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah keluar dari sesi admin.');
    }

    /**
     * Display admin CMS dashboard with metrics, incoming inquiries, and quick settings.
     */
    public function dashboard(): View
    {
        $profile = Profile::first();
        $totalProjects = Project::count();
        $totalSkills = Skill::count();
        $totalExperiences = Experience::count();
        $totalCertificates = Certificate::count();
        $totalMessages = Message::count();
        $unreadMessagesCount = Message::where('is_read', false)->count();

        $messages = Message::orderByDesc('created_at')->paginate(10);
        $projects = Project::orderBy('order_index')->get();
        $skills = Skill::orderBy('order_index')->get();
        $experiences = Experience::orderByDesc('start_date')->get();
        $certificates = Certificate::orderByDesc('issue_date')->get();

        return view('admin.dashboard', compact(
            'profile',
            'totalProjects',
            'totalSkills',
            'totalExperiences',
            'totalCertificates',
            'totalMessages',
            'unreadMessagesCount',
            'messages',
            'projects',
            'skills',
            'experiences',
            'certificates'
        ));
    }

    /**
     * Quick toggle or update availability status on Home banner.
     */
    public function updateAvailability(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'availability_status' => ['required', 'in:available,busy,contract_only'],
            'availability_text' => ['required', 'string', 'max:255'],
        ]);

        $profile = Profile::first();
        if ($profile) {
            $profile->update($validated);
        } else {
            Profile::create(array_merge([
                'full_name' => 'Admin User',
                'headline' => 'Portfolio Owner',
                'bio_about' => 'Selamat datang di portofolio saya.',
            ], $validated));
        }

        return back()->with('success', 'Status ketersediaan kerja berhasil diperbarui.');
    }

    /**
     * Toggle read status of an incoming message.
     */
    public function toggleMessageRead(Message $message): RedirectResponse
    {
        $message->update(['is_read' => ! $message->is_read]);

        return back()->with('success', 'Status pesan diperbarui.');
    }

    /**
     * Delete an incoming inquiry message.
     */
    public function deleteMessage(Message $message): RedirectResponse
    {
        $message->delete();

        return back()->with('success', 'Pesan berhasil dihapus.');
    }

    /**
     * List all projects in CMS.
     */
    public function projectsIndex(): View
    {
        $projects = Project::orderBy('order_index')->paginate(12);

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show form to create new project.
     */
    public function projectCreate(): View
    {
        return view('admin.projects.form', [
            'project' => new Project,
            'isEdit' => false,
        ]);
    }

    /**
     * Store newly created project.
     */
    public function projectStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:100'],
            'summary' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'key_features_raw' => ['nullable', 'string'],
            'problem_statement' => ['nullable', 'string'],
            'solution_details' => ['nullable', 'string'],
            'architecture_details' => ['nullable', 'string'],
            'key_metrics_raw' => ['nullable', 'string'],
            'tech_stacks_raw' => ['nullable', 'string'],
            'demo_url' => ['nullable', 'url'],
            'repo_url' => ['nullable', 'url'],
            'is_featured' => ['boolean'],
            'is_published' => ['boolean'],
            'order_index' => ['integer'],
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_published'] = $request->boolean('is_published');
        $validated['order_index'] = $request->input('order_index', 0);
        $validated['cover_image'] = ($validated['cover_image'] ?? null) ?: '/assets/projects/project-omnipulse.svg';

        if (! empty($validated['tech_stacks_raw'])) {
            $validated['tech_stacks'] = array_values(array_filter(array_map('trim', explode(',', $validated['tech_stacks_raw']))));
        } else {
            $validated['tech_stacks'] = [];
        }
        unset($validated['tech_stacks_raw']);

        if (! empty($validated['key_features_raw'])) {
            $validated['key_features'] = array_values(array_filter(array_map('trim', explode("\n", $validated['key_features_raw']))));
        } else {
            $validated['key_features'] = [];
        }
        unset($validated['key_features_raw']);

        if (! empty($validated['key_metrics_raw'])) {
            $validated['key_metrics'] = array_values(array_filter(array_map('trim', explode("\n", $validated['key_metrics_raw']))));
        } else {
            $validated['key_metrics'] = [];
        }
        unset($validated['key_metrics_raw']);

        Project::create($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Proyek baru berhasil ditambahkan.');
    }

    /**
     * Show form to edit existing project.
     */
    public function projectEdit(Project $project): View
    {
        return view('admin.projects.form', [
            'project' => $project,
            'isEdit' => true,
        ]);
    }

    /**
     * Update project in storage.
     */
    public function projectUpdate(Request $request, Project $project): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'category' => ['required', 'string', 'max:100'],
            'summary' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'key_features_raw' => ['nullable', 'string'],
            'problem_statement' => ['nullable', 'string'],
            'solution_details' => ['nullable', 'string'],
            'architecture_details' => ['nullable', 'string'],
            'key_metrics_raw' => ['nullable', 'string'],
            'tech_stacks_raw' => ['nullable', 'string'],
            'demo_url' => ['nullable', 'url'],
            'repo_url' => ['nullable', 'url'],
            'is_featured' => ['boolean'],
            'is_published' => ['boolean'],
            'order_index' => ['integer'],
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_published'] = $request->boolean('is_published');
        $validated['order_index'] = $request->input('order_index', $project->order_index);
        $validated['cover_image'] = ($validated['cover_image'] ?? null) ?: ($project->cover_image ?: '/assets/projects/project-omnipulse.svg');

        if (! empty($validated['tech_stacks_raw'])) {
            $validated['tech_stacks'] = array_values(array_filter(array_map('trim', explode(',', $validated['tech_stacks_raw']))));
        } else {
            $validated['tech_stacks'] = [];
        }
        unset($validated['tech_stacks_raw']);

        if (! empty($validated['key_features_raw'])) {
            $validated['key_features'] = array_values(array_filter(array_map('trim', explode("\n", $validated['key_features_raw']))));
        } else {
            $validated['key_features'] = [];
        }
        unset($validated['key_features_raw']);

        if (! empty($validated['key_metrics_raw'])) {
            $validated['key_metrics'] = array_values(array_filter(array_map('trim', explode("\n", $validated['key_metrics_raw']))));
        } else {
            $validated['key_metrics'] = [];
        }
        unset($validated['key_metrics_raw']);

        $project->update($validated);

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil diperbarui.');
    }

    /**
     * Delete project.
     */
    public function projectDestroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyek berhasil dihapus.');
    }

    // =========================================================================
    // SKILLS CRUD
    // =========================================================================

    public function skillsIndex(): View
    {
        $skills = Skill::orderBy('order_index')->paginate(25);

        return view('admin.skills.index', compact('skills'));
    }

    public function skillCreate(): View
    {
        return view('admin.skills.form', [
            'skill' => new Skill,
            'isEdit' => false,
        ]);
    }

    public function skillStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:100'],
            'proficiency_level' => ['required', 'integer', 'min:1', 'max:100'],
            'order_index' => ['nullable', 'integer'],
            'is_featured' => ['boolean'],
            'icon_svg' => ['nullable', 'string'],
        ]);

        $validated['order_index'] = $request->input('order_index', 0);
        $validated['is_featured'] = $request->boolean('is_featured');

        Skill::create($validated);

        return redirect()->route('admin.skills.index')->with('success', 'Keahlian baru berhasil ditambahkan.');
    }

    public function skillEdit(Skill $skill): View
    {
        return view('admin.skills.form', [
            'skill' => $skill,
            'isEdit' => true,
        ]);
    }

    public function skillUpdate(Request $request, Skill $skill): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'category' => ['required', 'string', 'max:100'],
            'proficiency_level' => ['required', 'integer', 'min:1', 'max:100'],
            'order_index' => ['nullable', 'integer'],
            'is_featured' => ['boolean'],
            'icon_svg' => ['nullable', 'string'],
        ]);

        $validated['order_index'] = $request->input('order_index', $skill->order_index);
        $validated['is_featured'] = $request->boolean('is_featured');

        $skill->update($validated);

        return redirect()->route('admin.skills.index')->with('success', 'Keahlian berhasil diperbarui.');
    }

    public function skillDestroy(Skill $skill): RedirectResponse
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('success', 'Keahlian berhasil dihapus.');
    }

    // =========================================================================
    // EXPERIENCES (JOURNEY) CRUD
    // =========================================================================

    public function experiencesIndex(): View
    {
        $experiences = Experience::orderByDesc('start_date')->paginate(15);

        return view('admin.experiences.index', compact('experiences'));
    }

    public function experienceCreate(): View
    {
        return view('admin.experiences.form', [
            'experience' => new Experience,
            'isEdit' => false,
        ]);
    }

    public function experienceStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role_title' => ['required', 'string', 'max:150'],
            'company_name' => ['required', 'string', 'max:150'],
            'company_url' => ['nullable', 'url'],
            'location' => ['required', 'string', 'max:150'],
            'employment_type' => ['required', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'is_current' => ['boolean'],
            'description_points_raw' => ['required', 'string'],
            'tech_used_raw' => ['nullable', 'string'],
            'order_index' => ['nullable', 'integer'],
        ]);

        $validated['is_current'] = $request->boolean('is_current');
        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        $validated['description_points'] = array_values(array_filter(array_map('trim', explode("\n", $validated['description_points_raw']))));
        unset($validated['description_points_raw']);

        if (! empty($validated['tech_used_raw'])) {
            $validated['tech_used'] = array_values(array_filter(array_map('trim', explode(',', $validated['tech_used_raw']))));
        } else {
            $validated['tech_used'] = [];
        }
        unset($validated['tech_used_raw']);

        $validated['order_index'] = $request->input('order_index', 0);

        Experience::create($validated);

        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman karier baru berhasil ditambahkan.');
    }

    public function experienceEdit(Experience $experience): View
    {
        return view('admin.experiences.form', [
            'experience' => $experience,
            'isEdit' => true,
        ]);
    }

    public function experienceUpdate(Request $request, Experience $experience): RedirectResponse
    {
        $validated = $request->validate([
            'role_title' => ['required', 'string', 'max:150'],
            'company_name' => ['required', 'string', 'max:150'],
            'company_url' => ['nullable', 'url'],
            'location' => ['required', 'string', 'max:150'],
            'employment_type' => ['required', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date'],
            'is_current' => ['boolean'],
            'description_points_raw' => ['required', 'string'],
            'tech_used_raw' => ['nullable', 'string'],
            'order_index' => ['nullable', 'integer'],
        ]);

        $validated['is_current'] = $request->boolean('is_current');
        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        $validated['description_points'] = array_values(array_filter(array_map('trim', explode("\n", $validated['description_points_raw']))));
        unset($validated['description_points_raw']);

        if (! empty($validated['tech_used_raw'])) {
            $validated['tech_used'] = array_values(array_filter(array_map('trim', explode(',', $validated['tech_used_raw']))));
        } else {
            $validated['tech_used'] = [];
        }
        unset($validated['tech_used_raw']);

        $validated['order_index'] = $request->input('order_index', $experience->order_index);

        $experience->update($validated);

        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman karier berhasil diperbarui.');
    }

    public function experienceDestroy(Experience $experience): RedirectResponse
    {
        $experience->delete();

        return redirect()->route('admin.experiences.index')->with('success', 'Pengalaman karier berhasil dihapus.');
    }

    // =========================================================================
    // CERTIFICATES CRUD
    // =========================================================================

    public function certificatesIndex(): View
    {
        $certificates = Certificate::orderByDesc('issue_date')->paginate(15);

        return view('admin.certificates.index', compact('certificates'));
    }

    public function certificateCreate(): View
    {
        return view('admin.certificates.form', [
            'certificate' => new Certificate,
            'isEdit' => false,
        ]);
    }

    public function certificateStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'certificate_name' => ['required', 'string', 'max:150'],
            'issuer_organization' => ['required', 'string', 'max:150'],
            'issue_date' => ['required', 'date'],
            'expiration_date' => ['nullable', 'date'],
            'credential_id' => ['nullable', 'string', 'max:100'],
            'credential_url' => ['nullable', 'url'],
            'media_file_path' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'order_index' => ['nullable', 'integer'],
        ]);

        $validated['order_index'] = $request->input('order_index', 0);

        Certificate::create($validated);

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat baru berhasil ditambahkan.');
    }

    public function certificateEdit(Certificate $certificate): View
    {
        return view('admin.certificates.form', [
            'certificate' => $certificate,
            'isEdit' => true,
        ]);
    }

    public function certificateUpdate(Request $request, Certificate $certificate): RedirectResponse
    {
        $validated = $request->validate([
            'certificate_name' => ['required', 'string', 'max:150'],
            'issuer_organization' => ['required', 'string', 'max:150'],
            'issue_date' => ['required', 'date'],
            'expiration_date' => ['nullable', 'date'],
            'credential_id' => ['nullable', 'string', 'max:100'],
            'credential_url' => ['nullable', 'url'],
            'media_file_path' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'order_index' => ['nullable', 'integer'],
        ]);

        $validated['order_index'] = $request->input('order_index', $certificate->order_index);

        $certificate->update($validated);

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function certificateDestroy(Certificate $certificate): RedirectResponse
    {
        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('success', 'Sertifikat berhasil dihapus.');
    }
}

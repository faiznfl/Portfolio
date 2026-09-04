<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PortfolioController extends Controller
{
    /**
     * Display the portfolio showcase page with 7 modular sections.
     */
    public function index(): View
    {
        $profile = Profile::first();
        $skills = Skill::orderBy('order_index')->get();
        $skillsByCategory = $skills->groupBy('category');
        $projects = Project::where('is_published', true)->orderBy('order_index')->get();
        $experiences = Experience::orderBy('order_index')->get();
        $certificates = Certificate::orderBy('order_index')->get();

        return view('portfolio.index', compact(
            'profile',
            'skills',
            'skillsByCategory',
            'projects',
            'experiences',
            'certificates'
        ));
    }

    /**
     * Return JSON details for a specific project or redirect to homepage showcase.
     */
    public function project(Request $request, string $slug): RedirectResponse|JsonResponse
    {
        $project = Project::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($project);
        }

        return redirect()->to(url('/#projects'));
    }

    /**
     * Download the verified developer CV / resume file.
     */
    public function downloadCv(): BinaryFileResponse|RedirectResponse
    {
        $filePath = public_path('assets/resume-faiz-naufal.pdf');

        if (! file_exists($filePath)) {
            return redirect()->route('home')->with('error', 'Berkas resume sedang diperbarui. Silakan hubungi via formulir kontak.');
        }

        return response()->download($filePath, 'CV-Faiz-Naufal-Software-Engineer.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Handle incoming business contact form submissions with anti-spam check.
     */
    public function submitContact(ContactRequest $request): RedirectResponse|JsonResponse
    {
        // Anti-spam honeypot verification
        if (! empty($request->input('website_hp'))) {
            Log::warning('Spam bot submission blocked via honeypot', [
                'ip' => $request->ip(),
                'email' => $request->input('sender_email'),
            ]);

            return redirect()->route('home', ['#contacts'])->with('error', 'Pengiriman terindikasi sebagai spam.');
        }

        $message = Message::create([
            'sender_name' => $request->validated('sender_name'),
            'sender_email' => $request->validated('sender_email'),
            'subject' => $request->validated('subject'),
            'message_body' => $request->validated('message_body'),
            'ip_address' => $request->ip(),
            'is_read' => false,
        ]);

        Log::info('New portfolio contact inquiry received', [
            'id' => $message->id,
            'from' => $message->sender_name,
            'email' => $message->sender_email,
            'subject' => $message->subject,
        ]);

        $successMsg = 'Terima kasih! Pesan dan penawaran kerja sama Anda telah berhasil terkirim. Saya akan segera merespons via email dalam 1x24 jam.';

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $successMsg,
            ]);
        }

        return redirect()->to(url('/#contacts'))->with('success', $successMsg);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Project;
use App\Services\AIService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(private AIService $ai)
    {
    }

    /** Show the user's current active project */
    public function current(Request $request)
    {
        $user = $request->user();
        $project = $user->activeProject();

        if (!$project) {
            return redirect()->route('dashboard')
                ->with('info', 'You have no active project. Generate one from your dashboard!');
        }

        return redirect()->route('projects.show', $project);
    }

    /** Show a specific project */
    public function show(Request $request, Project $project)
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }

        $project->load(['branch.track', 'submission', 'result']);

        return view('projects.show', compact('project'));
    }

    /**
     * Generate a new AI project for the user.
     * Only allowed when user has no active project.
     */
    public function generate(Request $request)
    {
        $user = $request->user();

        // Prevent generating if there's an active project
        if ($user->activeProject()) {
            return redirect()->route('projects.current')
                ->with('error', 'You already have an active project. Complete it first!');
        }

        if (!$user->current_branch_id) {
            return redirect()->route('tracks.index')
                ->with('error', 'Please select a track and branch first.');
        }

        $branch = Branch::with('track')->find($user->current_branch_id);

        // Generate project via AI (with fallback)
        try {
            $data = $this->ai->generateProject($user, $branch);
        } catch (\RuntimeException $e) {
            if (str_starts_with($e->getMessage(), 'RATE_LIMIT')) {
                return redirect()->route('dashboard')
                    ->with('error', '⏳ Gemini AI is rate-limited right now. Please wait 1-2 minutes and try again. Your API quota resets shortly.');
            }
            $data = [];
        }

        if (empty($data)) {
            return redirect()->route('dashboard')
                ->with('error', 'Could not generate a project. Please try again.');
        }

        $project = Project::create([
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'requirements' => $data['requirements'] ?? [],
            'constraints' => $data['constraints'] ?? [],
            'expected_features' => $data['expected_features'] ?? [],
            'difficulty' => $data['difficulty'] ?? $user->level,
            'deadline' => now()->addDays(7), // 7-day simulated deadline
            'status' => 'active',
            'ai_generated_data' => $data,
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Your new project has been generated! Good luck! 🎯');
    }

    /**
     * Abandon the current active project and generate a fresh AI one.
     * Useful when the current project was generated with fallback data.
     */
    public function abandon(Request $request, Project $project)
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }

        // Only allow abandoning active projects
        if ($project->status !== 'active') {
            return back()->with('error', 'Only active projects can be abandoned.');
        }

        // Mark as failed (abandoned)
        $project->update(['status' => 'failed']);

        return redirect()->route('projects.generate.force')
            ->with('info', 'Project abandoned. Generating a new AI project...');
    }

    /**
     * Force-generate a new project (skips the active project check).
     * Used after abandoning a project.
     */
    public function generateForce(Request $request)
    {
        $user = $request->user();

        if (!$user->current_branch_id) {
            return redirect()->route('tracks.index')
                ->with('error', 'Please select a track and branch first.');
        }

        $branch = Branch::with('track')->find($user->current_branch_id);

        // Generate project via AI (with fallback)
        try {
            $data = $this->ai->generateProject($user, $branch);
        } catch (\RuntimeException $e) {
            if (str_starts_with($e->getMessage(), 'RATE_LIMIT')) {
                return redirect()->route('dashboard')
                    ->with('error', '⏳ Gemini API is rate-limited. Please wait 1-2 minutes and click "Generate My Project" again from the dashboard.');
            }
            $data = [];
        }

        if (empty($data)) {
            return redirect()->route('dashboard')
                ->with('error', 'Could not generate a project. Please try again.');
        }

        $project = Project::create([
            'user_id' => $user->id,
            'branch_id' => $branch->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'requirements' => $data['requirements'] ?? [],
            'constraints' => $data['constraints'] ?? [],
            'expected_features' => $data['expected_features'] ?? [],
            'difficulty' => $data['difficulty'] ?? $user->level,
            'deadline' => now()->addDays(7),
            'status' => 'active',
            'ai_generated_data' => $data,
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', '✨ New AI project generated! Good luck! 🎯');
    }
}

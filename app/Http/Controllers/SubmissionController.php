<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function store(Request $request, Project $project)
    {
        // Authorization check
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }
        if ($project->status !== 'active') {
            return back()->with('error', 'This project is not active and cannot be submitted.');
        }
        $request->validate([
            'github_url' => ['required', 'url', 'regex:/github\.com/'],
            'notes'      => ['nullable', 'string', 'max:1000'],
        ], [
            'github_url.regex' => 'Please provide a valid GitHub repository URL.',
        ]);

        Submission::updateOrCreate(
            ['project_id' => $project->id, 'user_id' => $request->user()->id],
            [
                'github_url'   => $request->github_url,
                'notes'        => $request->notes,
                'submitted_at' => now(),
            ]
        );
        $project->update(['status' => 'submitted']);
        return redirect()->route('quiz.show', $project)
            ->with('success', 'Project submitted! Now it\'s time for the quiz. 🧠');
    }
}

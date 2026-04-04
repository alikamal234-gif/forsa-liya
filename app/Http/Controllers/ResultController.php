<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /** Show the evaluation result for a project */
    public function show(Request $request, Project $project)
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }

        // Must have a result to view
        if (!$project->result) {
            return redirect()->route('quiz.show', $project)
                ->with('info', 'Please complete the quiz first.');
        }

        $project->load(['branch.track', 'submission', 'result', 'quizQuestions']);
        $result = $project->result;

        return view('results.show', compact('project', 'result'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\QuizQuestion;
use App\Models\Result;
use App\Models\SkillProgress;
use App\Services\AIService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(private AIService $ai) {}

    /** Show quiz for a project (generate questions if needed) */
    public function show(Request $request, Project $project)
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }

        // Project must be submitted to take quiz
        if ($project->status === 'active') {
            return redirect()->route('projects.show', $project)
                ->with('error', 'Please submit your project before taking the quiz.');
        }

        // If already evaluated, redirect to result
        if ($project->result) {
            return redirect()->route('results.show', $project);
        }

        // Generate quiz questions if they don't exist yet
        if ($project->quizQuestions()->count() === 0) {
            $questionsData = $this->ai->generateQuiz($project);
            foreach ($questionsData as $index => $q) {
                QuizQuestion::create([
                    'project_id'     => $project->id,
                    'question'       => $q['question'],
                    'type'           => $q['type'] ?? 'multiple_choice',
                    'options'        => $q['options'],
                    'correct_answer' => $q['correct_answer'],
                    'explanation'    => $q['explanation'] ?? null,
                    'order'          => $index + 1,
                ]);
            }
        }

        $questions = $project->quizQuestions;
        $project->load('branch');

        return view('quiz.show', compact('project', 'questions'));
    }

    /** Submit quiz answers and calculate score */
    public function submit(Request $request, Project $project)
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($project->result) {
            return redirect()->route('results.show', $project);
        }

        $questions = $project->quizQuestions;

        $request->validate([
            'answers' => ['required', 'array'],
        ]);

        $answers = $request->input('answers', []);
        $correctCount = 0;

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? '';
            if ($question->isCorrect($userAnswer)) {
                $correctCount++;
            }
        }

        // Calculate score as percentage
        $score = $questions->count() > 0
            ? ($correctCount / $questions->count()) * 100
            : 0;

        $passed = $score >= 60; // Pass threshold: 60%

        // Check submission exists (required for passing)
        $submission = $project->submission;
        if (!$submission) {
            $passed = false;
        }

        // Create result record
        $result = Result::create([
            'project_id'   => $project->id,
            'user_id'      => $request->user()->id,
            'submission_id'=> $submission?->id ?? 0,
            'quiz_score'   => round($score, 1),
            'quiz_answers' => $answers,
            'passed'       => $passed,
            'evaluated_at' => now(),
        ]);

        // Update project status
        $project->update(['status' => $passed ? 'passed' : 'failed']);

        $user = $request->user();

        // Update user stats
        $user->increment('projects_completed');
        if ($passed) {
            $user->increment('projects_passed');
            $user->increment('xp_points', 100);

            // Update or escalate user level
            $this->updateUserLevel($user);
        }

        // Update skill progress
        $this->updateSkillProgress($user, $project, $passed);

        // Generate action plan for failures
        if (!$passed) {
            $actionPlan = $this->ai->generateActionPlan($project, $result);
            $result->update(['action_plan' => $actionPlan]);
        }

        return redirect()->route('results.show', $project)
            ->with('success', $passed ? 'Congratulations! You passed! 🎉' : 'Keep going! Review the action plan.');
    }

    /** Escalate user level based on completed projects */
    private function updateUserLevel($user): void
    {
        $passed = $user->projects_passed;

        if ($passed >= 10 && $user->level === 'intermediate') {
            $user->update(['level' => 'advanced']);
        } elseif ($passed >= 3 && $user->level === 'beginner') {
            $user->update(['level' => 'intermediate']);
        }
    }

    /** Update or create skill progress record */
    private function updateSkillProgress($user, Project $project, bool $passed): void
    {
        $progress = SkillProgress::firstOrCreate(
            ['user_id' => $user->id, 'branch_id' => $project->branch_id],
            ['projects_completed' => 0, 'projects_passed' => 0, 'is_validated' => false]
        );

        $progress->increment('projects_completed');
        if ($passed) {
            $progress->increment('projects_passed');
            $progress->update(['is_validated' => true]);
        }
    }
}

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

    /** Show quiz */
    public function show(Request $request, Project $project)
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($project->status === 'active') {
            return redirect()->route('projects.show', $project)
                ->with('error', 'Please submit your project first.');
        }

        if ($project->result) {
            return redirect()->route('results.show', $project);
        }

        // Generate questions if not exists
        if ($project->quizQuestions()->count() === 0) {
            $questionsData = $this->ai->generateQuiz($project);

            foreach ($questionsData as $index => $q) {
                QuizQuestion::create([
                    'project_id' => $project->id,
                    'question' => $q['question'],
                    'type' => $q['type'] ?? 'multiple_choice',
                    'options' => $q['options'],
                    'correct_answer' => $q['correct_answer'],
                    'explanation' => $q['explanation'] ?? null,
                    'order' => $index + 1,
                ]);
            }
        }

        $questions = $project->quizQuestions;
        $project->load('branch');

        return view('quiz.show', compact('project', 'questions'));
    }

    /** Submit quiz */
    public function submit(Request $request, Project $project)
    {
        if ($project->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($project->result) {
            return redirect()->route('results.show', $project);
        }

        $questions = $project->quizQuestions;

        // ✅ validation
        $request->validate([
            'answers' => ['required', 'array'],
            'code' => ['nullable', 'string'],
        ]);

        $answers = $request->input('answers', []);
        $code = $request->input('code');
        // ✅ quiz scoring
        $correctCount = 0;

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? '';

            if ($question->isCorrect($userAnswer)) {
                $correctCount++;
            }
        }

        // 🎯 quiz = 80%
        $score = $questions->count() > 0
            ? ($correctCount / $questions->count()) * 80
            : 0;

        // 🤖 code evaluation = 20%
        $codeScore = 0;

        $codeScore = 0;
        $codeFeedback = null;

        if ($code) {
            try {
                $analysis = $this->ai->analyzeCodeWithContext($project, $code);
                $codeScore = $analysis['score'] ?? 0;
                $codeFeedback = $analysis ?? [
                    'score' => 0,
                    'feedback' => 'No feedback',
                    'mistakes' => [],
                    'improvements' => [],
                ];

            } catch (\Exception $e) {
                $codeScore = 0;
            }
        }
        $score = $score + $codeScore;

        $passed = $score >= 60;
        // Submission check
        $submission = $project->submission;
        if (! $submission) {
            $passed = false;
        }
        // ✅ save result
        $result = Result::create([
            'project_id' => $project->id,
            'user_id' => $request->user()->id,
            'submission_id' => $submission?->id ?? 0,
            'quiz_answers' => array_merge($answers, [
                'code' => $code,
            ]),
            'passed' => $passed,
            'evaluated_at' => now(),
            'quiz_score' =>  round($score, 1),
            'code_feedback' => $codeFeedback,
        ]);
        // dd($result);
        // update project
        $project->update([
            'status' => $passed ? 'passed' : 'failed',
        ]);

        $user = $request->user();

        // stats
        $user->increment('projects_completed');

        if ($passed) {
            $user->increment('projects_passed');
            $user->increment('xp_points', 100);
            $this->updateUserLevel($user);
        }

        // skill progress
        $this->updateSkillProgress($user, $project, $passed);

        // action plan
        if (! $passed) {
            $actionPlan = $this->ai->generateActionPlan($project, $result);
            $result->update(['action_plan' => $actionPlan]);
        }

        return redirect()->route('results.show', [$project, $result])
            ->with('success', $passed
                ? 'Congratulations! You passed!'
                : 'Keep going! Check your action plan.');
    }

    /** Update level */
    private function updateUserLevel($user): void
    {
        $passed = $user->projects_passed;

        if ($passed >= 10 && $user->level === 'intermediate') {
            $user->update(['level' => 'advanced']);
        } elseif ($passed >= 3 && $user->level === 'beginner') {
            $user->update(['level' => 'intermediate']);
        }
    }

    /** Skill progress */
    private function updateSkillProgress($user, Project $project, bool $passed): void
    {
        $progress = SkillProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'branch_id' => $project->branch_id,
            ],
            [
                'projects_completed' => 0,
                'projects_passed' => 0,
                'is_validated' => false,
            ]
        );

        $progress->increment('projects_completed');

        if ($passed) {
            $progress->increment('projects_passed');
            $progress->update(['is_validated' => true]);
        }
    }
}

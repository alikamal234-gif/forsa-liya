<?php

namespace App\Services;

use App\Models\Branch;
use App\Models\Project;
use App\Models\Result;
use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * AIService — Handles all AI-powered features via Google Gemini API.
 * Falls back to static data if API is unavailable or key not set.
 */
class AIService
{
    private Client $client;
    private string $apiKey;
    // Primary model — gemini-2.0-flash-lite has higher free quota limits
    private array $models = [
        'mistralai/mistral-7b-instruct'
    ];
    private string $baseUrl = 'https://openrouter.ai';

    public function __construct()
    {
        $this->client = new Client(['timeout' => 30]);
        $this->apiKey = env('OPENROUTER_API_KEY');
    }

    // ─── Public Methods ───────────────────────────────────────────────────────
    public function generateProject(User $user, Branch $branch): array
    {
        $prompt = $this->buildProjectPrompt($user, $branch);
        // dd($prompt);
        try {
            $response = $this->callAI($prompt);
            $data = $this->parseJson($response);

            if (!empty($data) && isset($data['title'])) {
                return $data;
            }

            return $this->fallbackProject($user, $branch);

        } catch (\Exception $e) {
            dd("makhdemch");
            Log::error('AI Error: ' . $e->getMessage());
            return $this->fallbackProject($user, $branch);
        }
    }
    /**
     * Generate a project brief for the user based on their track, branch, and level.
     */
    private function callAI(string $prompt): string
    {
        if (empty($this->apiKey)) {
            throw new \RuntimeException('OpenRouter API key not configured.');
        }

        Log::info("AI CALLED (OpenRouter)");

        try {
            $response = $this->client->post('https://openrouter.ai/api/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'google/gemma-2-9b-it',
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'temperature' => 0.7,
                ],
            ]);
            $body = json_decode($response->getBody()->getContents(), true);

            // حاول جميع formats الممكنة
            $text =
                $body['choices'][0]['message']['content'] ??
                $body['choices'][0]['text'] ??
                $body['choices'][0]['message']['content'][0]['text'] ??
                '';
            if (empty($text)) {
                Log::error("EMPTY RESPONSE BODY:", ['body' => $body]);
                throw new \RuntimeException('Empty AI response');
            }

            return $text;

        } catch (\Exception $e) {
            dd($e);
            Log::error("OpenRouter Error: " . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Generate 3–5 quiz questions based on the project details.
     */
    public function generateQuiz(Project $project): array
    {
        $prompt = $this->buildQuizPrompt($project);

        try {
            $response = $this->callAI($prompt);
            $data = $this->parseJson($response);
            $questions = $data['questions'] ?? $data ?? [];
            return !empty($questions) ? $questions : $this->fallbackQuiz($project);
        } catch (\Exception $e) {
            Log::warning('AI quiz generation failed: ' . $e->getMessage());
            return $this->fallbackQuiz($project);
        }
    }

    /**
     * Generate a personalized action plan for a failed project.
     */
    public function generateActionPlan(Project $project, Result $result): array
    {
        $prompt = $this->buildActionPlanPrompt($project, $result);

        try {
            $response = $this->callAI($prompt);
            $data = $this->parseJson($response);
            return $data ?: $this->fallbackActionPlan($project);
        } catch (\Exception $e) {
            Log::warning('AI action plan generation failed: ' . $e->getMessage());
            return $this->fallbackActionPlan($project);
        }
    }

    // ─── Prompt Builders ──────────────────────────────────────────────────────

    private function buildProjectPrompt(User $user, Branch $branch): string
    {
        $level = $user->level;
        $track = $branch->track->name;
        $branchName = $branch->name;

        return <<<PROMPT
You are an expert software education AI. Generate a practical, real-world web development project brief.

User Profile:
- Learning Track: {$track}
- Current Branch: {$branchName}
- Skill Level: {$level}
- Projects Completed: {$user->projects_completed}

Generate a project that is appropriate for a {$level} developer learning {$branchName}.
The project must be challenging but achievable within 7 days.

Return ONLY valid JSON in this exact format (no markdown, no extra text):
{
  "title": "Project title here",
  "description": "2-3 sentence description of what the user will build",
  "requirements": ["requirement 1", "requirement 2", "requirement 3", "requirement 4"],
  "constraints": ["constraint 1", "constraint 2"],
  "expected_features": ["feature 1", "feature 2", "feature 3", "feature 4"],
  "difficulty": "{$level}"
}
PROMPT;
    }

    private function buildQuizPrompt(Project $project): string
    {
        $branch = $project->branch->name;
        $title = $project->title;
        $desc = $project->description;
        $level = $project->difficulty;

        return <<<PROMPT
You are a technical interviewer. Generate 4 quiz questions to evaluate understanding of this project.

Project: {$title}
Branch: {$branch}
Level: {$level}
Description: {$desc}

Requirements:
- 3 multiple_choice questions
- 1 scenario question
- Questions test understanding of concepts used in the project
- Difficulty should match the {$level} level

Return ONLY valid JSON (no markdown, no extra text):
{
  "questions": [
    {
      "question": "Question text here?",
      "type": "multiple_choice",
      "options": ["Option A", "Option B", "Option C", "Option D"],
      "correct_answer": "Option A",
      "explanation": "Why this answer is correct"
    },
    {
      "question": "Scenario question here...",
      "type": "scenario",
      "options": ["Option A", "Option B", "Option C", "Option D"],
      "correct_answer": "Option B",
      "explanation": "Why this answer is correct"
    }
  ]
}
PROMPT;
    }

    private function buildActionPlanPrompt(Project $project, Result $result): string
    {
        $branch = $project->branch->name;
        $score = $result->quiz_score;
        $title = $project->title;

        return <<<PROMPT
You are a coding mentor. A student failed their project evaluation.

Project: {$title}
Branch: {$branch}
Quiz Score: {$score}%

Generate a personalized action plan to help them improve.

Return ONLY valid JSON (no markdown, no extra text):
{
  "what_went_wrong": "Clear explanation of what the student likely struggled with",
  "concepts_to_review": ["concept 1", "concept 2", "concept 3"],
  "mini_tasks": [
    {"task": "Mini task 1", "estimated_time": "30 min"},
    {"task": "Mini task 2", "estimated_time": "1 hour"},
    {"task": "Mini task 3", "estimated_time": "2 hours"}
  ],
  "resources": [
    {"title": "Resource name", "type": "article"},
    {"title": "Resource name", "type": "video"}
  ],
  "encouragement": "Short motivational message"
}
PROMPT;
    }


    /**
     * Parse JSON from AI response (handles potential markdown code blocks).
     */
    private function parseJson(string $text): ?array
    {
        // Strip markdown code fences if present
        $text = preg_replace('/^```(?:json)?\s*/m', '', $text);
        $text = preg_replace('/\s*```$/m', '', $text);
        $text = trim($text);

        $data = json_decode($text, true);
        return json_last_error() === JSON_ERROR_NONE ? $data : null;
    }

    // ─── Static Fallbacks ─────────────────────────────────────────────────────

    private function fallbackProject(User $user, Branch $branch): array
    {
        $fallbacks = [
            'html' => [
                'title' => 'Personal Portfolio Page',
                'description' => 'Build a professional portfolio page using HTML. Include sections for about, skills, projects, and contact information.',
                'requirements' => ['Use semantic HTML5 elements', 'Include a navigation bar', 'Build at least 4 sections', 'Add a contact form'],
                'constraints' => ['No CSS frameworks allowed', 'Must be valid HTML5'],
                'expected_features' => ['Header with navigation', 'About section with bio', 'Skills list', 'Contact section'],
                'difficulty' => $user->level,
            ],
            'css' => [
                'title' => 'Responsive Landing Page',
                'description' => 'Create a visually appealing landing page for a fictional SaaS product with responsive design.',
                'requirements' => ['Mobile-first responsive layout', 'CSS Grid or Flexbox', 'Custom animations', 'Color scheme variable'],
                'constraints' => ['No CSS frameworks', 'No JavaScript'],
                'expected_features' => ['Hero section', 'Features grid', 'Pricing cards', 'Footer'],
                'difficulty' => $user->level,
            ],
            'javascript' => [
                'title' => 'Task Manager App',
                'description' => 'Build a to-do list application with vanilla JavaScript. Users can add, complete, and delete tasks.',
                'requirements' => ['Add/remove tasks', 'Mark tasks complete', 'Filter by status', 'Persist to localStorage'],
                'constraints' => ['No frameworks or libraries', 'Vanilla JS only'],
                'expected_features' => ['Task input form', 'Task list with actions', 'Filter buttons', 'Task counter'],
                'difficulty' => $user->level,
            ],
            'php' => [
                'title' => 'Blog CRUD Application',
                'description' => 'Build a simple blog system with PHP where users can create, read, update, and delete posts.',
                'requirements' => ['Create, read, update, delete posts', 'Basic input validation', 'MySQL database', 'Simple session-based login'],
                'constraints' => ['No frameworks', 'Use PDO for DB access'],
                'expected_features' => ['Post list page', 'Create post form', 'Edit post form', 'Delete confirmation'],
                'difficulty' => $user->level,
            ],
            'laravel' => [
                'title' => 'Product Catalog API',
                'description' => 'Build a RESTful API for a product catalog system with authentication using Laravel.',
                'requirements' => ['CRUD endpoints for products', 'Laravel Sanctum authentication', 'Request validation', 'Pagination'],
                'constraints' => ['Must use Eloquent ORM', 'Must follow RESTful conventions'],
                'expected_features' => ['Product listing with filters', 'CRUD endpoints', 'Authenticated routes', 'Proper HTTP status codes'],
                'difficulty' => $user->level,
            ],
        ];

        $key = $branch->slug;
        // Strip -fs suffix for fullstack variants
        $key = str_replace(['-fs'], [''], $key);

        return $fallbacks[$key] ?? [
            'title' => "{$branch->name} Practice Project",
            'description' => "A hands-on project to practice your {$branch->name} skills at the {$user->level} level.",
            'requirements' => ['Complete the main feature', 'Write clean code', 'Add comments', 'Test your work'],
            'constraints' => ['Follow best practices', 'Keep code organized'],
            'expected_features' => ['Core functionality', 'Error handling', 'User-friendly interface', 'Documentation'],
            'difficulty' => $user->level,
        ];
    }

    private function fallbackQuiz(Project $project): array
    {
        $branch = $project->branch->name;

        return [
            [
                'question' => "What is the primary purpose of {$branch} in web development?",
                'type' => 'multiple_choice',
                'options' => [
                    "To style web pages",
                    "To structure, style, or add logic to web pages depending on the technology",
                    "To manage databases",
                    "To configure servers",
                ],
                'correct_answer' => "To structure, style, or add logic to web pages depending on the technology",
                'explanation' => "{$branch} plays a core role in web development by providing essential capabilities to build functional applications.",
            ],
            [
                'question' => "Which of the following is a best practice when working with {$branch}?",
                'type' => 'multiple_choice',
                'options' => [
                    "Write all code in one file",
                    "Keep code modular and well-organized",
                    "Avoid using comments",
                    "Skip error handling",
                ],
                'correct_answer' => "Keep code modular and well-organized",
                'explanation' => "Modular, well-organized code is easier to maintain, debug, and share with others.",
            ],
            [
                'question' => "In your project '{$project->title}', what was the main technical challenge you solved?",
                'type' => 'scenario',
                'options' => [
                    "Making the design responsive",
                    "Handling user input and data persistence",
                    "Connecting to external APIs",
                    "Optimizing performance",
                ],
                'correct_answer' => "Handling user input and data persistence",
                'explanation' => "Core web projects typically focus on handling user interactions and storing/retrieving data effectively.",
            ],
            [
                'question' => "Which approach is most important for code quality?",
                'type' => 'multiple_choice',
                'options' => [
                    "Writing code as fast as possible",
                    "Testing and refactoring regularly",
                    "Copying code from tutorials without understanding",
                    "Using as many libraries as possible",
                ],
                'correct_answer' => "Testing and refactoring regularly",
                'explanation' => "Regular testing and refactoring ensures your code is maintainable and bug-free over time.",
            ],
        ];
    }

    private function fallbackActionPlan(Project $project): array
    {
        return [
            'what_went_wrong' => "Your quiz score suggests some gaps in understanding {$project->branch->name} fundamentals. Don't worry — this is a learning opportunity!",
            'concepts_to_review' => [
                "Core {$project->branch->name} concepts",
                "Best practices and conventions",
                "Problem-solving approach",
            ],
            'mini_tasks' => [
                ['task' => "Review the official {$project->branch->name} documentation", 'estimated_time' => '1 hour'],
                ['task' => "Complete 3 practice exercises on the core concepts", 'estimated_time' => '2 hours'],
                ['task' => "Rebuild the project from scratch with fresh understanding", 'estimated_time' => '3 hours'],
            ],
            'resources' => [
                ['title' => "MDN Web Docs — {$project->branch->name}", 'type' => 'article'],
                ['title' => "YouTube: {$project->branch->name} Crash Course", 'type' => 'video'],
            ],
            'encouragement' => "Every expert was once a beginner. This setback is just a stepping stone to mastery. You've got this! 💪",
        ];
    }
}

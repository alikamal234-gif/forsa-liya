@extends('layouts.app')

@section('title', 'Result — ' . $project->title)
@section('page-title', 'Project Result')
@section('page-subtitle', $project->branch->name . ' — ' . $project->title)

@section('content')
<div class="max-w-3xl fade-in">

    {{-- Result Hero --}}
    <div class="card p-8 mb-6 text-center" style="border-color: {{ $result->passed ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)' }}; background: {{ $result->passed ? 'rgba(16,185,129,0.05)' : 'rgba(239,68,68,0.05)' }}">
        <div class="text-6xl mb-4">{{ $result->passed ? '🎉' : '💪' }}</div>
        <h1 class="text-3xl font-black mb-2" style="color: {{ $result->passed ? '#10B981' : '#EF4444' }}">
            {{ $result->passed ? 'Project Passed!' : 'Project Failed' }}
        </h1>
        <p class="mb-6" style="color: var(--text-muted)">
            {{ $result->passed
                ? 'Excellent work! You demonstrated solid understanding of ' . $project->branch->name . '.'
                : 'Keep going! Review the action plan below to improve and try again.' }}
        </p>

        {{-- Score Ring --}}
        <div class="inline-flex flex-col items-center justify-center w-28 h-28 rounded-full mb-4" style="background: {{ $result->passed ? 'rgba(16,185,129,0.15)' : 'rgba(239,68,68,0.15)' }}; border: 3px solid {{ $result->passed ? '#10B981' : '#EF4444' }}">
            <span class="text-3xl font-black" style="color: {{ $result->passed ? '#10B981' : '#EF4444' }}">{{ number_format($result->quiz_score) }}%</span>
            <span class="text-xs" style="color: var(--text-muted)">quiz score</span>
        </div>

        <div class="flex items-center justify-center gap-6 text-sm" style="color: var(--text-muted)">
            <span>Pass threshold: <strong>60%</strong></span>
            <span>•</span>
            <span>Evaluated: <strong>{{ $result->evaluated_at?->format('M d, Y H:i') }}</strong></span>
        </div>
    </div>

    {{-- Quiz Review --}}
    <div class="card p-6 mb-6">
        <h2 class="font-bold mb-4">📋 Quiz Review</h2>
        <div class="space-y-3">
            @php $userAnswers = $result->quiz_answers ?? []; @endphp
            @foreach($project->quizQuestions as $i => $q)
            @php
                $given = $userAnswers[$q->id] ?? null;
                $correct = $q->isCorrect($given ?? '');
            @endphp
            <div class="rounded-xl p-4" style="background: var(--bg-surface); border: 1px solid {{ $correct ? 'rgba(16,185,129,0.2)' : 'rgba(239,68,68,0.2)' }}">
                <div class="flex items-start gap-2 mb-2">
                    <span class="mt-0.5">{{ $correct ? '✅' : '❌' }}</span>
                    <p class="text-sm font-medium">{{ $q->question }}</p>
                </div>
                <div class="ml-6 space-y-1 text-xs" style="color: var(--text-muted)">
                    <p>Your answer: <span class="{{ $correct ? 'text-green-400' : 'text-red-400' }}">{{ $given ?? 'Not answered' }}</span></p>
                    @if(!$correct)
                    <p>Correct: <span class="text-green-400">{{ $q->correct_answer }}</span></p>
                    @endif
                    @if($q->explanation)
                    <p class="mt-1 italic">{{ $q->explanation }}</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Action Plan (on failure) --}}
    @if(!$result->passed && $result->action_plan)
    @php $plan = $result->action_plan; @endphp
    <div class="card p-6 mb-6" style="border-color: rgba(245,158,11,0.3);">
        <h2 class="font-bold mb-5 flex items-center gap-2">
            <span class="text-xl">🗺️</span> Personalized Action Plan
        </h2>

        {{-- What went wrong --}}
        <div class="rounded-xl p-4 mb-4" style="background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.15);">
            <h4 class="font-semibold text-sm mb-2" style="color: #EF4444">What Went Wrong</h4>
            <p class="text-sm" style="color: var(--text-muted)">{{ $plan['what_went_wrong'] ?? '' }}</p>
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            {{-- Concepts to review --}}
            @if(!empty($plan['concepts_to_review']))
            <div class="rounded-xl p-4" style="background: var(--bg-surface);">
                <h4 class="font-semibold text-sm mb-3">📚 Concepts to Review</h4>
                <ul class="space-y-1">
                    @foreach($plan['concepts_to_review'] as $concept)
                    <li class="text-sm flex items-center gap-2" style="color: var(--text-muted)">
                        <span style="color: #6366F1">→</span> {{ $concept }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Mini tasks --}}
            @if(!empty($plan['mini_tasks']))
            <div class="rounded-xl p-4" style="background: var(--bg-surface);">
                <h4 class="font-semibold text-sm mb-3">✅ Mini Tasks</h4>
                <ul class="space-y-2">
                    @foreach($plan['mini_tasks'] as $task)
                    <li class="text-sm">
                        <span style="color: var(--text-muted)">{{ $task['task'] ?? $task }}</span>
                        @if(isset($task['estimated_time']))
                        <span class="text-xs ml-1" style="color: #22D3EE">• {{ $task['estimated_time'] }}</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        {{-- Encouragement --}}
        @if(!empty($plan['encouragement']))
        <div class="rounded-xl p-4 mt-4 text-center" style="background: rgba(99,102,241,0.08); border: 1px solid rgba(99,102,241,0.2);">
            <p class="text-sm font-medium italic" style="color: #6366F1">💬 {{ $plan['encouragement'] }}</p>
        </div>
        @endif
    </div>
    @endif

    {{-- Submission info --}}
    @if($project->submission)
    <div class="card p-5 mb-6">
        <h3 class="font-bold mb-3 text-sm" style="color: var(--text-muted)">SUBMISSION</h3>
        <a href="{{ $project->submission->github_url }}" target="_blank" class="flex items-center gap-2 text-sm font-medium mb-2" style="color: #6366F1">
            🔗 {{ $project->submission->github_url }}
        </a>
        @if($project->submission->notes)
        <p class="text-sm" style="color: var(--text-muted)">{{ $project->submission->notes }}</p>
        @endif
    </div>
    @endif

    {{-- CTA --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('dashboard') }}" class="btn-secondary">← Dashboard</a>
        @if($result->passed)
        <form method="POST" action="{{ route('projects.generate') }}">
            @csrf
            <button type="submit" class="btn-primary">✨ Generate Next Project →</button>
        </form>
        @else
        <form method="POST" action="{{ route('projects.generate') }}">
            @csrf
            <button type="submit" class="btn-primary">🔄 Try Again →</button>
        </form>
        @endif
    </div>
</div>
@endsection

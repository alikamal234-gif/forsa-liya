@extends('layouts.app')

@section('title', $project->title)
@section('page-title', 'My Project')
@section('page-subtitle', $project->branch->track->name . ' → ' . $project->branch->name)

@section('content')
<div class="max-w-4xl fade-in">

    {{-- Project Header --}}
    <div class="card p-6 mb-6">
        <div class="flex items-start justify-between gap-4 mb-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-lg">{{ $project->branch->icon }}</span>
                    <span class="text-sm font-medium" style="color: var(--text-muted)">{{ $project->branch->name }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium
                        @if($project->status === 'passed') badge-passed
                        @elseif($project->status === 'failed') badge-failed
                        @elseif($project->status === 'submitted') badge-submitted
                        @else badge-active @endif">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>
                <h1 class="text-2xl font-black mb-2">{{ $project->title }}</h1>
                <p style="color: var(--text-muted); line-height: 1.7;">{{ $project->description }}</p>
            </div>
            <div class="text-right flex-shrink-0">
                <div class="text-sm font-medium px-3 py-1.5 rounded-lg mb-2" style="background: rgba(99,102,241,0.1); color: #6366F1;">
                    {{ ucfirst($project->difficulty) }}
                </div>
                @if($project->deadline)
                <p class="text-sm {{ $project->daysRemaining() <= 1 ? 'text-red-400' : '' }}" style="color: var(--text-muted)">
                    ⏰ {{ $project->daysRemaining() }} days left
                </p>
                <p class="text-xs" style="color: var(--text-muted)">Due: {{ $project->deadline->format('M d, Y') }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-5 mb-6">
        {{-- Requirements --}}
        <div class="card p-5">
            <h3 class="font-bold mb-4 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg flex items-center justify-center text-sm" style="background: rgba(99,102,241,0.1); color:#6366F1;">📋</span>
                Requirements
            </h3>
            <ul class="space-y-2">
                @foreach($project->requirements ?? [] as $req)
                <li class="flex items-start gap-2 text-sm" style="color: var(--text-muted)">
                    <span class="mt-1 w-4 h-4 rounded-full flex-shrink-0 flex items-center justify-center text-xs" style="background: rgba(99,102,241,0.2); color: #6366F1;">✓</span>
                    {{ $req }}
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Expected Features --}}
        <div class="card p-5">
            <h3 class="font-bold mb-4 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg flex items-center justify-center text-sm" style="background: rgba(34,211,238,0.1); color:#22D3EE;">⭐</span>
                Expected Features
            </h3>
            <ul class="space-y-2">
                @foreach($project->expected_features ?? [] as $feat)
                <li class="flex items-start gap-2 text-sm" style="color: var(--text-muted)">
                    <span class="mt-1" style="color: #22D3EE;">→</span>
                    {{ $feat }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- Constraints --}}
    @if(!empty($project->constraints))
    <div class="card p-5 mb-6" style="border-color: rgba(245,158,11,0.3);">
        <h3 class="font-bold mb-3 flex items-center gap-2" style="color: #F59E0B;">
            ⚠️ Constraints
        </h3>
        <ul class="space-y-1">
            @foreach($project->constraints as $con)
            <li class="text-sm" style="color: var(--text-muted)">• {{ $con }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Action Area --}}
    @if($project->status === 'active')
    <div class="card p-6 mb-4">
        <h3 class="font-bold mb-2">📤 Submit Your Project</h3>
        <p class="text-sm mb-5" style="color: var(--text-muted)">Push your code to GitHub and paste the repository link below.</p>
        <form method="POST" action="{{ route('submissions.store', $project) }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium mb-2">GitHub Repository URL *</label>
                <input type="url" name="github_url" id="github_url" class="input"
                    placeholder="https://github.com/yourusername/your-repo"
                    value="{{ old('github_url') }}" required>
                @error('github_url') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Notes (optional)</label>
                <textarea name="notes" id="notes" class="input" rows="3"
                    placeholder="What did you learn? Any challenges you faced?">{{ old('notes') }}</textarea>
            </div>
            <button type="submit" class="btn-primary">
                🚀 Submit Project & Take Quiz
            </button>
        </form>
    </div>

    {{-- Abandon option to regenerate with AI --}}
    <div class="rounded-xl p-4" style="background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.15);">
        <div class="flex items-center justify-between gap-4">
            <div>
                <p class="text-sm font-medium" style="color: #EF4444;">🔄 Get a different project?</p>
                <p class="text-xs mt-1" style="color: var(--text-muted)">Abandon this project and generate a fresh one with AI. This counts as a failure.</p>
            </div>
            <form method="POST" action="{{ route('projects.abandon', $project) }}" onsubmit="return confirm('Abandon this project and generate a new one?')">
                @csrf
                <button type="submit" class="btn-secondary" style="font-size:12px; padding: 8px 16px; border-color: rgba(239,68,68,0.3); color: #EF4444;">
                    Abandon & Regenerate →
                </button>
            </form>
        </div>
    </div>

    @elseif($project->status === 'submitted')
    <div class="card p-6 text-center">
        <div class="text-5xl mb-3">🧠</div>
        <h3 class="font-bold text-lg mb-2">Project Submitted!</h3>
        <p class="text-sm mb-5" style="color: var(--text-muted)">Your project has been submitted. Now complete the quiz to get your result.</p>
        <a href="{{ route('quiz.show', $project) }}" class="btn-primary">Start the Quiz →</a>
    </div>

    @elseif(in_array($project->status, ['passed', 'failed']))
    <div class="card p-6 text-center" style="border-color: {{ $project->status === 'passed' ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)' }}">
        <div class="text-5xl mb-3">{{ $project->status === 'passed' ? '🎉' : '💪' }}</div>
        <h3 class="font-bold text-lg mb-2">{{ $project->status === 'passed' ? 'Project Passed!' : 'Project Failed' }}</h3>
        <p class="text-sm mb-5" style="color: var(--text-muted)">
            @if($project->status === 'passed')
                Congratulations! You have validated this skill.
            @else
                Don't give up! Review your action plan and try again.
            @endif
        </p>
        <div class="flex items-center justify-center gap-4">
            <a href="{{ route('results.show', $project) }}" class="btn-primary">View Result →</a>
            @if($project->status === 'failed')
            <form method="POST" action="{{ route('projects.generate') }}">
                @csrf
                <button type="submit" class="btn-secondary">Try Again with New Project</button>
            </form>
            @endif
        </div>
    </div>
    @endif

</div>
@endsection

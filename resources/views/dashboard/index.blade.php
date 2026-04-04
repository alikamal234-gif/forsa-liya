@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Your learning progress at a glance')

@section('content')
<div class="space-y-6 fade-in">

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach([
            ['label' => 'Projects Done', 'value' => $stats['total'], 'icon' => '📁', 'color' => '#6366F1'],
            ['label' => 'Passed', 'value' => $stats['passed'], 'icon' => '✅', 'color' => '#10B981'],
            ['label' => 'Failed', 'value' => $stats['failed'], 'icon' => '❌', 'color' => '#EF4444'],
            ['label' => 'Skills Validated', 'value' => $stats['skills'], 'icon' => '🏆', 'color' => '#22D3EE'],
        ] as $stat)
        <div class="card p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-2xl">{{ $stat['icon'] }}</span>
                <span class="text-xs font-medium px-2 py-1 rounded-lg" style="background: rgba(99,102,241,0.1); color: #6366F1;">this month</span>
            </div>
            <div class="text-3xl font-black mb-1" style="color: {{ $stat['color'] }}">{{ $stat['value'] }}</div>
            <div class="text-sm" style="color: var(--text-muted)">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid lg:grid-cols-3 gap-6">

        {{-- Active Project Card --}}
        <div class="lg:col-span-2">
            <div class="card p-6 h-full">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-bold">Active Project</h2>
                    @if(!$activeProject)
                    <form method="POST" action="{{ route('projects.generate') }}">
                        @csrf
                        <button type="submit" class="btn-primary" style="padding: 8px 20px; font-size:13px;">
                            ✨ Generate Project
                        </button>
                    </form>
                    @endif
                </div>

                @if($activeProject)
                <div class="rounded-xl p-5 mb-4" style="background: rgba(99,102,241,0.05); border: 1px solid rgba(99,102,241,0.2);">
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div>
                            <h3 class="font-bold text-lg mb-1">{{ $activeProject->title }}</h3>
                            <p class="text-sm" style="color: var(--text-muted)">{{ Str::limit($activeProject->description, 120) }}</p>
                        </div>
                        <span class="badge-active text-xs px-3 py-1 rounded-full font-medium flex-shrink-0">Active</span>
                    </div>
                    <div class="flex items-center gap-4 text-sm" style="color: var(--text-muted)">
                        <span>📚 {{ $activeProject->branch->name }}</span>
                        <span>⚡ {{ ucfirst($activeProject->difficulty) }}</span>
                        @if($activeProject->deadline)
                        <span class="{{ $activeProject->daysRemaining() <= 1 ? 'text-red-400' : '' }}">
                            ⏰ {{ $activeProject->daysRemaining() }} days left
                        </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('projects.show', $activeProject) }}" class="btn-primary w-full justify-center">
                    View Project →
                </a>
                @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🎯</div>
                    <h3 class="font-bold text-lg mb-2">No Active Project</h3>
                    <p class="text-sm mb-6" style="color: var(--text-muted)">Generate your first AI-powered project and start building!</p>
                    @if(!$user->current_branch_id)
                    <a href="{{ route('tracks.index') }}" class="btn-secondary">Select a Track First →</a>
                    @else
                    <form method="POST" action="{{ route('projects.generate') }}">
                        @csrf
                        <button type="submit" class="btn-primary">✨ Generate My Project</button>
                    </form>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- Right Column --}}
        <div class="space-y-4">
            {{-- Current Track --}}
            <div class="card p-5">
                <h3 class="font-semibold mb-4 text-sm" style="color: var(--text-muted)">CURRENT TRACK</h3>
                @if($user->currentTrack)
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-2xl">{{ $user->currentTrack->icon }}</span>
                    <div>
                        <p class="font-bold">{{ $user->currentTrack->name }}</p>
                        <p class="text-xs" style="color: var(--text-muted)">{{ $user->currentBranch?->name ?? 'No branch selected' }}</p>
                    </div>
                </div>
                <a href="{{ route('tracks.index') }}" class="text-xs font-medium" style="color: var(--primary)">Change Track →</a>
                @else
                <p class="text-sm mb-3" style="color: var(--text-muted)">No track selected yet</p>
                <a href="{{ route('tracks.index') }}" class="btn-primary" style="padding: 8px 16px; font-size:13px; width:100%; justify-content: center;">Choose Track →</a>
                @endif
            </div>

            {{-- Level & XP --}}
            <div class="card p-5">
                <h3 class="font-semibold mb-4 text-sm" style="color: var(--text-muted)">LEVEL & XP</h3>
                <div class="flex items-center justify-between mb-3">
                    <span class="font-bold text-lg gradient-text">{{ $user->levelLabel() }}</span>
                    <span class="text-sm font-bold" style="color: #22D3EE">⚡ {{ $user->xp_points }} XP</span>
                </div>
                @php
                    $levelProgress = $user->level === 'beginner' ? min(100, ($user->projects_passed / 3) * 100) :
                                     ($user->level === 'intermediate' ? min(100, (($user->projects_passed - 3) / 7) * 100) : 100);
                @endphp
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $levelProgress }}%"></div>
                </div>
                <p class="text-xs mt-2" style="color: var(--text-muted)">
                    @if($user->level === 'beginner') {{ 3 - min(3, $user->projects_passed) }} passes to Intermediate
                    @elseif($user->level === 'intermediate') {{ max(0, 10 - $user->projects_passed) }} passes to Advanced
                    @else Max level reached! 🏆
                    @endif
                </p>
            </div>

            {{-- Skills Progress --}}
            <div class="card p-5">
                <h3 class="font-semibold mb-4 text-sm" style="color: var(--text-muted)">SKILLS PROGRESS</h3>
                @forelse($skillsProgress as $sp)
                <div class="flex items-center justify-between py-2">
                    <div class="flex items-center gap-2">
                        <span class="text-lg">{{ $sp->branch->icon }}</span>
                        <span class="text-sm font-medium">{{ $sp->branch->name }}</span>
                    </div>
                    @if($sp->is_validated)
                    <span class="text-xs badge-passed px-2 py-0.5 rounded-full">✓ Validated</span>
                    @else
                    <span class="text-xs" style="color: var(--text-muted)">{{ $sp->projects_passed }}/1 to validate</span>
                    @endif
                </div>
                @empty
                <p class="text-sm" style="color: var(--text-muted)">Complete projects to track skill progress.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Recent Results --}}
    @if($recentResults->count() > 0)
    <div class="card p-6">
        <h2 class="text-lg font-bold mb-4">Recent Results</h2>
        <div class="space-y-3">
            @foreach($recentResults as $result)
            <div class="flex items-center justify-between rounded-xl p-4" style="background: var(--bg-surface);">
                <div class="flex items-center gap-3">
                    <span class="{{ $result->passed ? 'badge-passed' : 'badge-failed' }} text-xs px-2 py-0.5 rounded-full font-medium">
                        {{ $result->passed ? '✓ Passed' : '✗ Failed' }}
                    </span>
                    <div>
                        <p class="text-sm font-medium">{{ $result->project->title }}</p>
                        <p class="text-xs" style="color: var(--text-muted)">{{ $result->project->branch->name }} • {{ $result->evaluated_at?->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="font-bold" style="color: {{ $result->passed ? 'var(--success)' : 'var(--danger)' }}">{{ $result->scoreLabel() }}</p>
                    <a href="{{ route('results.show', $result->project) }}" class="text-xs" style="color: var(--primary)">View →</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

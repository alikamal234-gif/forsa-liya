@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'My Profile')
@section('page-subtitle', 'Track your learning journey and skills')

@section('content')
<div class="max-w-4xl fade-in">

    {{-- Profile Header --}}
    <div class="card p-6 mb-6">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-white text-2xl font-black flex-shrink-0" style="background: linear-gradient(135deg, #6366F1, #22D3EE);">
                {{ $user->initials() }}
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-black mb-1">{{ $user->name }}</h1>
                <p class="text-sm mb-2" style="color: var(--text-muted)">{{ $user->email }}</p>
                <div class="flex items-center gap-3">
                    <span class="text-xs px-3 py-1 rounded-full font-medium gradient-text" style="background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.2);">
                        {{ $user->levelLabel() }}
                    </span>
                    @if($user->currentTrack)
                    <span class="text-xs px-3 py-1 rounded-full font-medium" style="background: rgba(34,211,238,0.1); color: #22D3EE; border: 1px solid rgba(34,211,238,0.2);">
                        {{ $user->currentTrack->icon }} {{ $user->currentTrack->name }}
                    </span>
                    @endif
                    <span class="text-xs px-3 py-1 rounded-full font-medium" style="background: rgba(245,158,11,0.1); color: #F59E0B; border: 1px solid rgba(245,158,11,0.2);">
                        ⚡ {{ $user->xp_points }} XP
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @foreach([
            ['value' => $stats['total'], 'label' => 'Projects Done', 'color' => '#6366F1'],
            ['value' => $stats['passed'], 'label' => 'Passed', 'color' => '#10B981'],
            ['value' => $stats['failed'], 'label' => 'Failed', 'color' => '#EF4444'],
            ['value' => $stats['skills'], 'label' => 'Skills Validated', 'color' => '#22D3EE'],
        ] as $s)
        <div class="card p-4 text-center">
            <div class="text-3xl font-black mb-1" style="color: {{ $s['color'] }}">{{ $s['value'] }}</div>
            <div class="text-xs" style="color: var(--text-muted)">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        {{-- Skills Progress --}}
        <div class="card p-6">
            <h2 class="font-bold mb-4">🏆 Skills Progress</h2>
            @forelse($user->skillsProgress as $sp)
            <div class="mb-4 last:mb-0">
                <div class="flex items-center justify-between mb-1">
                    <div class="flex items-center gap-2">
                        <span>{{ $sp->branch->icon }}</span>
                        <span class="text-sm font-medium">{{ $sp->branch->name }}</span>
                    </div>
                    @if($sp->is_validated)
                    <span class="badge-passed text-xs px-2 py-0.5 rounded-full">✓ Validated</span>
                    @else
                    <span class="text-xs" style="color: var(--text-muted)">{{ $sp->projects_passed }} passed</span>
                    @endif
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $sp->is_validated ? 100 : min(100, $sp->projects_passed * 100) }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-sm" style="color: var(--text-muted)">Complete projects to track your skills.</p>
            @endforelse
        </div>

        {{-- Change Branch --}}
        @if($user->currentTrack)
        <div class="card p-6">
            <h2 class="font-bold mb-4">🔀 Switch Branch</h2>
            <p class="text-sm mb-4" style="color: var(--text-muted)">Change your current focus within the {{ $user->currentTrack->name }} track. Only available when no active project.</p>
            @if($user->activeProject())
            <div class="rounded-xl p-3 mb-4" style="background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.2);">
                <p class="text-sm" style="color: #F59E0B;">⚠️ Complete your active project before switching branches.</p>
            </div>
            @else
            <form method="POST" action="{{ route('profile.branch') }}">
                @csrf
                <div class="space-y-2 mb-4">
                    @foreach($user->currentTrack->branches as $branch)
                    <label class="flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all" style="border: 1px solid var(--border);">
                        <input type="radio" name="branch_id" value="{{ $branch->id }}" class="accent-indigo-500"
                            {{ $user->current_branch_id == $branch->id ? 'checked' : '' }}>
                        <span>{{ $branch->icon }}</span>
                        <div>
                            <p class="text-sm font-medium">{{ $branch->name }}</p>
                        </div>
                        @if($user->current_branch_id == $branch->id)
                        <span class="ml-auto text-xs badge-active px-2 py-0.5 rounded-full">Current</span>
                        @endif
                    </label>
                    @endforeach
                </div>
                <button type="submit" class="btn-primary" style="font-size:13px; padding: 8px 20px;">Update Branch</button>
            </form>
            @endif
        </div>
        @endif
    </div>

    {{-- Project History --}}
    @if($user->projects->count() > 0)
    <div class="card p-6 mt-6">
        <h2 class="font-bold mb-4">📁 Project History</h2>
        <div class="space-y-3">
            @foreach($user->projects as $proj)
            <div class="flex items-center justify-between rounded-xl p-4" style="background: var(--bg-surface);">
                <div class="flex items-center gap-3">
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium
                        @if($proj->status === 'passed') badge-passed
                        @elseif($proj->status === 'failed') badge-failed
                        @elseif($proj->status === 'submitted') badge-submitted
                        @else badge-active @endif">
                        {{ ucfirst($proj->status) }}
                    </span>
                    <div>
                        <p class="text-sm font-medium">{{ $proj->title }}</p>
                        <p class="text-xs" style="color: var(--text-muted)">{{ $proj->branch->name }} • {{ ucfirst($proj->difficulty) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if($proj->result)
                    <span class="text-sm font-bold" style="color: {{ $proj->result->passed ? '#10B981' : '#EF4444' }}">{{ $proj->result->scoreLabel() }}</span>
                    @endif
                    <a href="{{ route('projects.show', $proj) }}" class="text-xs" style="color: var(--primary)">View →</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'Choose Your Track')
@section('page-title', 'Learning Tracks')
@section('page-subtitle', 'Choose your path and pick a skill to master')

@section('content')
<div class="fade-in">

    {{-- Current Selection Banner --}}
    @if($user->current_track_id)
    <div class="rounded-xl p-4 mb-6 flex items-center justify-between" style="background: rgba(99,102,241,0.08); border: 1px solid rgba(99,102,241,0.2);">
        <div class="flex items-center gap-3">
            <span class="text-2xl">{{ $user->currentTrack?->icon }}</span>
            <div>
                <p class="font-medium text-sm">Currently learning: <strong>{{ $user->currentBranch?->name }}</strong> in <strong>{{ $user->currentTrack?->name }}</strong></p>
                <p class="text-xs" style="color: var(--text-muted)">Select a different track or branch below to switch</p>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('tracks.select') }}" id="track-form">
        @csrf

        {{-- Tracks --}}
        <div class="grid md:grid-cols-3 gap-5 mb-8">
            @foreach($tracks as $track)
            <label class="cursor-pointer block">
                <input type="radio" name="track_id" value="{{ $track->id }}" class="hidden track-radio"
                    {{ $user->current_track_id == $track->id ? 'checked' : '' }}
                    onchange="selectTrack({{ $track->id }})">
                <div class="card p-6 track-card-ui transition-all duration-200 hover:border-purple-500" data-track="{{ $track->id }}"
                     style="{{ $user->current_track_id == $track->id ? 'border-color:'.$track->color.'; background: rgba(99,102,241,0.05)' : '' }}">
                    <div class="text-4xl mb-3">{{ $track->icon }}</div>
                    <h3 class="text-xl font-bold mb-2">{{ $track->name }}</h3>
                    <p class="text-sm mb-4" style="color: var(--text-muted)">{{ $track->description }}</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($track->branches as $branch)
                        <span class="text-xs px-2 py-1 rounded-lg font-medium" style="background: var(--bg-surface); color: var(--text-muted);">
                            {{ $branch->icon }} {{ $branch->name }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </label>
            @endforeach
        </div>

        {{-- Branch Selection --}}
        @foreach($tracks as $track)
        <div id="branches-{{ $track->id }}" class="mb-6 branches-panel" style="{{ $user->current_track_id == $track->id ? '' : 'display:none' }}">
            <h3 class="text-lg font-bold mb-4">{{ $track->icon }} {{ $track->name }} — Choose a Branch</h3>
            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($track->branches as $branch)
                <label class="cursor-pointer">
                    <input type="radio" name="branch_id" value="{{ $branch->id }}" class="hidden"
                        {{ $user->current_branch_id == $branch->id ? 'checked' : '' }}>
                    <div class="card p-4 branch-card-ui hover:border-purple-500 transition-all duration-200 rounded-xl"
                         data-branch="{{ $branch->id }}"
                         style="{{ $user->current_branch_id == $branch->id ? 'border-color: #6366F1; background: rgba(99,102,241,0.05)' : '' }}">
                        <span class="text-2xl">{{ $branch->icon }}</span>
                        <p class="font-semibold mt-2">{{ $branch->name }}</p>
                        <p class="text-xs mt-1" style="color: var(--text-muted)">{{ $branch->description }}</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        @error('track_id') <p class="text-red-400 text-sm mb-4">{{ $message }}</p> @enderror
        @error('branch_id') <p class="text-red-400 text-sm mb-4">{{ $message }}</p> @enderror

        <div class="flex gap-4">
            <button type="submit" class="btn-primary">
                🚀 Save & Continue →
            </button>
            <a href="{{ route('dashboard') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
function selectTrack(trackId) {
    // Hide all branch panels
    document.querySelectorAll('.branches-panel').forEach(p => p.style.display = 'none');
    // Show selected
    document.getElementById('branches-' + trackId).style.display = 'block';

    // Update track card styles
    document.querySelectorAll('.track-card-ui').forEach(c => {
        c.style.borderColor = '';
        c.style.background = '';
    });
    const selected = document.querySelector('.track-card-ui[data-track="' + trackId + '"]');
    if (selected) {
        selected.style.borderColor = '#6366F1';
        selected.style.background = 'rgba(99,102,241,0.05)';
    }
    // Clear branch selection
    document.querySelectorAll('.branch-card-ui').forEach(c => {
        c.style.borderColor = '';
        c.style.background = '';
    });
}

// Branch selection highlight
document.querySelectorAll('input[name="branch_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.branch-card-ui').forEach(c => {
            c.style.borderColor = '';
            c.style.background = '';
        });
        const card = document.querySelector('.branch-card-ui[data-branch="' + this.value + '"]');
        if (card) {
            card.style.borderColor = '#6366F1';
            card.style.background = 'rgba(99,102,241,0.05)';
        }
    });
});
</script>
@endsection

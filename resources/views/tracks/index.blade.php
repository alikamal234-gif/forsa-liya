@extends('layouts.app')

@section('title', 'Choose Your Track')
@section('page-title', 'Learning Tracks')
@section('page-subtitle', 'Choose your path and pick a skill to master')

@section('content')
<div class="fade-in max-w-7xl mx-auto">

    {{-- Current Selection Banner --}}
    @if($user->current_track_id)
    <div class="rounded-2xl p-6 mb-8 relative overflow-hidden group hover:shadow-lg transition-all duration-300"
         style="background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(34,211,238,0.08)); border: 1px solid rgba(99,102,241,0.2);">
        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-indigo-500/10 to-cyan-500/10 rounded-full blur-3xl"></div>
        <div class="relative flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl transition-all duration-300 group-hover:scale-110 group-hover:rotate-6"
                     style="background: linear-gradient(135deg, #6366F1, #22D3EE);">
                    {{ $user->currentTrack?->icon }}
                </div>
                <div>
                    <p class="font-semibold text-base mb-1">Currently learning</p>
                    <div class="flex items-center gap-2">
                        <span class="text-lg font-bold bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">
                            {{ $user->currentBranch?->name }}
                        </span>
                        <span class="text-sm" style="color: #94A3B8;">in</span>
                        <span class="text-lg font-bold" style="color: #6366F1;">{{ $user->currentTrack?->name }}</span>
                    </div>
                    <p class="text-xs mt-1" style="color: #94A3B8;">Select a different track or branch below to switch</p>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-110"
                     style="background: rgba(99,102,241,0.1);">
                    <svg class="w-6 h-6" style="color: #6366F1;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    @endif

    <form method="POST" action="{{ route('tracks.select') }}" id="track-form">
        @csrf

        {{-- Tracks --}}
        <div class="grid md:grid-cols-3 gap-6 mb-10">
            @foreach($tracks as $track)
            <label class="cursor-pointer block group">
                <input type="radio" name="track_id" value="{{ $track->id }}" class="hidden track-radio"
                    {{ $user->current_track_id == $track->id ? 'checked' : '' }}
                    onchange="selectTrack({{ $track->id }})">
                <div class="card p-6 track-card-ui transition-all duration-300 relative overflow-hidden"
                     data-track="{{ $track->id }}"
                     style="{{ $user->current_track_id == $track->id ? 'border-color: #6366F1; background: linear-gradient(135deg, rgba(99,102,241,0.05), rgba(34,211,238,0.05));' : '' }}">
                    <div class="absolute top-0 right-0 w-32 h-32 rounded-full blur-2xl opacity-0 transition-opacity duration-300 group-hover:opacity-20"
                         style="background: linear-gradient(135deg, #6366F1, #22D3EE);"></div>

                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center text-3xl mb-4 transition-all duration-300 group-hover:scale-110 group-hover:rotate-6"
                             style="background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(34,211,238,0.1));">
                            {{ $track->icon }}
                        </div>

                        <h3 class="text-xl font-bold mb-3 transition-colors duration-300 group-hover:text-indigo-400">
                            {{ $track->name }}
                        </h3>

                        <p class="text-sm mb-4 leading-relaxed" style="color: #94A3B8;">{{ $track->description }}</p>

                        <div class="flex flex-wrap gap-2">
                            @foreach($track->branches as $branch)
                            <span class="text-xs px-3 py-1.5 rounded-xl font-medium transition-all duration-300 hover:scale-105"
                                  style="background: var(--bg-surface); color: #64748B; border: 1px solid rgba(148,163,184,0.1);">
                                {{ $branch->icon }} {{ $branch->name }}
                            </span>
                            @endforeach
                        </div>

                        <div class="mt-4 flex items-center gap-2 text-xs font-medium" style="color: #94A3B8;">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $track->branches->count() }} branches available</span>
                        </div>
                    </div>

                    {{-- Selection indicator --}}
                    <div class="absolute top-4 right-4 w-6 h-6 rounded-full border-2 border-indigo-500 flex items-center justify-center transition-all duration-300 scale-0"
                         style="background: #6366F1;">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </label>
            @endforeach
        </div>

        {{-- Branch Selection --}}
        @foreach($tracks as $track)
        <div id="branches-{{ $track->id }}" class="mb-8 branches-panel transition-all duration-500"
             style="{{ $user->current_track_id == $track->id ? 'opacity: 1; transform: translateY(0);' : 'display: none; opacity: 0; transform: translateY(20px);' }}">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl"
                     style="background: linear-gradient(135deg, #6366F1, #22D3EE);">
                    {{ $track->icon }}
                </div>
                <div>
                    <h3 class="text-xl font-bold">Choose Your Branch</h3>
                    <p class="text-sm" style="color: #94A3B8;">Select a specialization within {{ $track->name }}</p>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($track->branches as $branch)
                <label class="cursor-pointer block group/branch">
                    <input type="radio" name="branch_id" value="{{ $branch->id }}" class="hidden"
                        {{ $user->current_branch_id == $branch->id ? 'checked' : '' }}>
                    <div class="card p-5 branch-card-ui transition-all duration-300 relative overflow-hidden rounded-xl"
                         data-branch="{{ $branch->id }}"
                         style="{{ $user->current_branch_id == $branch->id ? 'border-color: #6366F1; background: linear-gradient(135deg, rgba(99,102,241,0.05), rgba(34,211,238,0.05));' : '' }}">
                        <div class="absolute top-0 right-0 w-24 h-24 rounded-full blur-xl opacity-0 transition-opacity duration-300 group-hover/branch:opacity-20"
                             style="background: linear-gradient(135deg, #6366F1, #22D3EE);"></div>

                        <div class="relative">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-3 transition-all duration-300 group-hover/branch:scale-110 group-hover/branch:rotate-6"
                                 style="background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(34,211,238,0.1));">
                                {{ $branch->icon }}
                            </div>

                            <p class="font-semibold text-base mb-2 transition-colors duration-300 group-hover/branch:text-indigo-400">
                                {{ $branch->name }}
                            </p>

                            <p class="text-xs leading-relaxed" style="color: #94A3B8;">{{ $branch->description }}</p>

                            <div class="mt-3 flex items-center gap-1.5 text-xs" style="color: #94A3B8;">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Advanced level</span>
                            </div>
                        </div>

                        {{-- Selection indicator --}}
                        <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-indigo-500 flex items-center justify-center transition-all duration-300 scale-0"
                             style="background: #6366F1;">
                            <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        @error('track_id')
        <div class="rounded-xl p-4 mb-6 flex items-center gap-3" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2);">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-red-400">{{ $message }}</p>
        </div>
        @enderror
        @error('branch_id')
        <div class="rounded-xl p-4 mb-6 flex items-center gap-3" style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2);">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-red-400">{{ $message }}</p>
        </div>
        @enderror

        <div class="flex items-center gap-4 pt-6 border-t" style="border-color: rgba(148,163,184,0.1);">
            <button type="submit" class="btn-primary relative overflow-hidden group">
                <span class="relative z-10 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save & Continue
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-indigo-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
            </button>
            <a href="{{ route('dashboard') }}" class="btn-secondary flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function selectTrack(trackId) {
    // Hide all branch panels with animation
    document.querySelectorAll('.branches-panel').forEach(p => {
        p.style.opacity = '0';
        p.style.transform = 'translateY(20px)';
        setTimeout(() => p.style.display = 'none', 300);
    });

    // Show selected with animation
    const selectedPanel = document.getElementById('branches-' + trackId);
    if (selectedPanel) {
        setTimeout(() => {
            selectedPanel.style.display = 'block';
            setTimeout(() => {
                selectedPanel.style.opacity = '1';
                selectedPanel.style.transform = 'translateY(0)';
            }, 50);
        }, 300);
    }

    // Update track card styles
    document.querySelectorAll('.track-card-ui').forEach(c => {
        c.style.borderColor = '';
        c.style.background = '';
        c.querySelector('.absolute.top-4.right-4').style.transform = 'scale(0)';
    });

    const selected = document.querySelector('.track-card-ui[data-track="' + trackId + '"]');
    if (selected) {
        selected.style.borderColor = '#6366F1';
        selected.style.background = 'linear-gradient(135deg, rgba(99,102,241,0.05), rgba(34,211,238,0.05))';
        selected.querySelector('.absolute.top-4.right-4').style.transform = 'scale(1)';
    }

    // Clear branch selection
    document.querySelectorAll('.branch-card-ui').forEach(c => {
        c.style.borderColor = '';
        c.style.background = '';
        const indicator = c.querySelector('.absolute.top-3.right-3');
        if (indicator) indicator.style.transform = 'scale(0)';
    });
}

// Branch selection highlight
document.querySelectorAll('input[name="branch_id"]').forEach(radio => {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.branch-card-ui').forEach(c => {
            c.style.borderColor = '';
            c.style.background = '';
            const indicator = c.querySelector('.absolute.top-3.right-3');
            if (indicator) indicator.style.transform = 'scale(0)';
        });

        const card = document.querySelector('.branch-card-ui[data-branch="' + this.value + '"]');
        if (card) {
            card.style.borderColor = '#6366F1';
            card.style.background = 'linear-gradient(135deg, rgba(99,102,241,0.05), rgba(34,211,238,0.05))';
            const indicator = card.querySelector('.absolute.top-3.right-3');
            if (indicator) indicator.style.transform = 'scale(1)';
        }
    });
});

// Initialize selection indicators on page load
document.addEventListener('DOMContentLoaded', function() {
    // Show selected track indicator
    const selectedTrackRadio = document.querySelector('input[name="track_id"]:checked');
    if (selectedTrackRadio) {
        const trackId = selectedTrackRadio.value;
        const selectedTrack = document.querySelector('.track-card-ui[data-track="' + trackId + '"]');
        if (selectedTrack) {
            const indicator = selectedTrack.querySelector('.absolute.top-4.right-4');
            if (indicator) indicator.style.transform = 'scale(1)';
        }
    }

    // Show selected branch indicator
    const selectedBranchRadio = document.querySelector('input[name="branch_id"]:checked');
    if (selectedBranchRadio) {
        const branchId = selectedBranchRadio.value;
        const selectedBranch = document.querySelector('.branch-card-ui[data-branch="' + branchId + '"]');
        if (selectedBranch) {
            const indicator = selectedBranch.querySelector('.absolute.top-3.right-3');
            if (indicator) indicator.style.transform = 'scale(1)';
        }
    }
});
</script>
@endsection

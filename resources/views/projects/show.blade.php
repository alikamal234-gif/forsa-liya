@extends('layouts.app')

@section('title', $project->title)
@section('page-title', 'My Project')
@section('page-subtitle', $project->branch->track->name . ' → ' . $project->branch->name)

@section('content')
    <div class="max-w-4xl fade-in">

        {{-- Project Header --}}
        <div class="card p-6 mb-6 relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/5 to-cyan-500/5 rounded-full blur-2xl">
            </div>
            <div class="relative">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg"
                                style="background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(34,211,238,0.1));">
                                {!! $project->branch->icon !!}
                            </div>
                            <span class="text-sm font-medium px-3 py-1 rounded-lg"
                                style="background: rgba(99,102,241,0.1); color: #6366F1;">
                                {{ $project->branch->name }}
                            </span>
                            <span class="text-xs px-3 py-1 rounded-full font-medium transition-all duration-300
                                @if($project->status === 'passed') badge-passed
                                @elseif($project->status === 'failed') badge-failed
                                @elseif($project->status === 'submitted') badge-submitted
                                @else badge-active @endif">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                        <h1
                            class="text-3xl font-black mb-3 bg-gradient-to-r from-white to-gray-300 bg-clip-text text-transparent">
                            {{ $project->title }}
                        </h1>
                        <p class="text-base leading-relaxed" style="color: #94A3B8;">{{ $project->description }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <div class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2 rounded-xl mb-3 transition-all duration-300 hover:scale-105"
                            style="background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(34,211,238,0.15)); color: #6366F1; border: 1px solid rgba(99,102,241,0.2);">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            {{ ucfirst($project->difficulty) }}
                        </div>
                        @if($project->deadline)
                            <div class="text-right">
                                <p class="text-sm font-medium {{ $project->daysRemaining() <= 1 ? 'text-red-400 animate-pulse' : '' }}"
                                    style="color: #64748B;">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $project->daysRemaining() }} days left
                                </p>
                                <p class="text-xs mt-1" style="color: #64748B;">Due: {{ $project->deadline->format('M d, Y') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-5 mb-6">
            {{-- Requirements --}}
            <div class="card p-5 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110"
                        style="background: linear-gradient(135deg, #6366F1, #8B5CF6);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg">Requirements</h3>
                </div>
                <ul class="space-y-3">
                    @foreach($project->requirements ?? [] as $req)
                        <li class="flex items-start gap-3 text-sm group/item" style="color: #94A3B8;">
                            <span
                                class="mt-0.5 w-5 h-5 rounded-full flex-shrink-0 flex items-center justify-center text-xs transition-all duration-300 group-hover/item:scale-110"
                                style="background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(139,92,246,0.2)); color: #6366F1;">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                            <span class="leading-relaxed">{{ $req }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Expected Features --}}
            <div class="card p-5 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110"
                        style="background: linear-gradient(135deg, #22D3EE, #06B6D4);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg">Expected Features</h3>
                </div>
                <ul class="space-y-3">
                    @foreach($project->expected_features ?? [] as $feat)
                        <li class="flex items-start gap-3 text-sm group/item" style="color: #94A3B8;">
                            <span
                                class="mt-0.5 w-5 h-5 rounded-full flex-shrink-0 flex items-center justify-center transition-all duration-300 group-hover/item:scale-110"
                                style="background: linear-gradient(135deg, rgba(34,211,238,0.2), rgba(6,182,212,0.2)); color: #22D3EE;">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                            <span class="leading-relaxed">{{ $feat }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Constraints --}}
        @if(!empty($project->constraints))
            <div class="card p-5 mb-6 hover:shadow-lg transition-all duration-300 group"
                style="border-color: rgba(245,158,11,0.3); background: linear-gradient(135deg, rgba(245,158,11,0.05), rgba(251,146,60,0.05));">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110"
                        style="background: linear-gradient(135deg, #F59E0B, #FB923C);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg" style="color: #F59E0B;">Constraints</h3>
                </div>
                <ul class="space-y-2">
                    @foreach($project->constraints as $con)
                        <li class="flex items-start gap-3 text-sm" style="color: #94A3B8;">
                            <span class="mt-0.5 w-2 h-2 rounded-full flex-shrink-0 mt-1.5" style="background: #F59E0B;"></span>
                            <span class="leading-relaxed">{{ $con }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Action Area --}}
        @if($project->status === 'active')
            <div class="card p-6 mb-4 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-indigo-500/10 to-cyan-500/10 rounded-full blur-3xl">
                </div>
                <div class="relative">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center"
                            style="background: linear-gradient(135deg, #6366F1, #22D3EE);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-xl">Submit Your Project</h3>
                            <p class="text-sm mt-1" style="color: #94A3B8;">Push your code to GitHub and paste the repository
                                link below</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('submissions.store', $project) }}" class="space-y-4">
                        @csrf
                        <div class="relative">
                            <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                GitHub Repository URL *
                            </label>
                            <div class="relative">
                                <input type="url" name="github_url" id="github_url" class="input pr-10"
                                    placeholder="https://github.com/yourusername/your-repo" value="{{ old('github_url') }}"
                                    required>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-5 h-5" style="color: #64748B;" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                    </svg>
                                </div>
                            </div>
                            @error('github_url')
                                <p class="text-red-400 text-xs mt-2 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Notes (optional)
                            </label>
                            <textarea name="notes" id="notes" class="input resize-none" rows="3"
                                placeholder="What did you learn? Any challenges you faced?">{{ old('notes') }}</textarea>
                        </div>
                        <button type="submit"
                            class="btn-primary w-full text-base font-medium py-3 transition-all duration-300 hover:scale-[1.02] active:scale-[0.98]">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Submit Project & Take Quiz
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Abandon option to regenerate with AI --}}
            <div class="rounded-xl p-5 hover:shadow-lg transition-all duration-300 group"
                style="background: linear-gradient(135deg, rgba(239,68,68,0.05), rgba(248,113,113,0.05)); border: 1px solid rgba(239,68,68,0.15);">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110"
                            style="background: linear-gradient(135deg, #EF4444, #F87171);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium" style="color: #EF4444;">Get a different project?</p>
                            <p class="text-xs mt-1" style="color: #94A3B8;">Abandon this project and generate a fresh one with
                                AI. This counts as a failure.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('projects.abandon', $project) }}"
                        onsubmit="return confirm('Abandon this project and generate a new one?')">
                        @csrf
                        <button type="submit" class="btn-secondary transition-all duration-300 hover:scale-105 active:scale-95"
                            style="font-size:12px; padding: 10px 20px; border-color: rgba(239,68,68,0.3); color: #EF4444;">
                            <span class="flex items-center gap-2">
                                Abandon & Regenerate
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                            </span>
                        </button>
                    </form>
                </div>
            </div>

        @elseif($project->status === 'submitted')
            <div class="card p-8 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-cyan-500/5"></div>
                <div class="relative">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-2xl flex items-center justify-center"
                        style="background: linear-gradient(135deg, #6366F1, #22D3EE); box-shadow: 0 10px 25px rgba(99,102,241,0.3);">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </path>
                        </svg>
                    </div>
                    <h3
                        class="font-bold text-2xl mb-3 bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">
                        Project Submitted!
                    </h3>
                    <p class="text-base mb-6" style="color: #94A3B8;">Your project has been submitted. Now complete the quiz to
                        get your result.</p>
                    <a href="{{ route('quiz.show', $project) }}"
                        class="btn-primary inline-flex items-center gap-2 text-base font-medium py-3 px-8 transition-all duration-300 hover:scale-105 active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Start the Quiz
                    </a>
                </div>
            </div>

        @elseif(in_array($project->status, ['passed', 'failed']))
            <div class="card p-8 text-center relative overflow-hidden hover:shadow-xl transition-all duration-300"
                style="border-color: {{ $project->status === 'passed' ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)' }};
                        background: {{ $project->status === 'passed' ? 'linear-gradient(135deg, rgba(16,185,129,0.05), rgba(34,197,94,0.05))' : 'linear-gradient(135deg, rgba(239,68,68,0.05), rgba(248,113,113,0.05))' }};">
                <div class="absolute inset-0"
                    style="background: {{ $project->status === 'passed' ? 'radial-gradient(circle at 50% 0%, rgba(16,185,129,0.1) 0%, transparent 70%)' : 'radial-gradient(circle at 50% 0%, rgba(239,68,68,0.1) 0%, transparent 70%)' }};">
                </div>
                <div class="relative">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-2xl flex items-center justify-center transition-all duration-300 hover:scale-110"
                        style="background: {{ $project->status === 'passed' ? 'linear-gradient(135deg, #10B981, #22C55E)' : 'linear-gradient(135deg, #EF4444, #F87171)' }};
                                box-shadow: 0 10px 25px {{ $project->status === 'passed' ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)' }};">
                        @if($project->status === 'passed')
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        @endif
                    </div>
                    <h3 class="font-bold text-2xl mb-3"
                        style="color: {{ $project->status === 'passed' ? '#10B981' : '#EF4444' }};">
                        {{ $project->status === 'passed' ? '🎉 Project Passed!' : '💪 Project Failed' }}
                    </h3>
                    <p class="text-base mb-6" style="color: #94A3B8;">
                        @if($project->status === 'passed')
                            Congratulations! You have validated this skill and earned XP.
                        @else
                            Don't give up! Review your action plan and try again with a new project.
                        @endif
                    </p>
                    <div class="flex items-center justify-center gap-4 flex-wrap">
                        <a href="{{ route('results.show', $project) }}"
                            class="btn-primary inline-flex items-center gap-2 transition-all duration-300 hover:scale-105 active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                            View Result
                        </a>
                        @if($project->status === 'failed')
                            <form method="POST" action="{{ route('projects.generate') }}">
                                @csrf
                                <button type="submit"
                                    class="btn-secondary inline-flex items-center gap-2 transition-all duration-300 hover:scale-105 active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                    Try Again with New Project
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection

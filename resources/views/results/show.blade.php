@extends('layouts.app')

@section('title', 'Result — ' . $project->title)
@section('page-title', 'Project Result')
@section('page-subtitle', $project->branch->name . ' — ' . $project->title)

@section('content')
    <div class="max-w-3xl fade-in">

        {{-- Result Hero --}}
        <div class="card p-8 mb-6 text-center relative overflow-hidden group hover:shadow-xl transition-all duration-500"
             style="border-color: {{ $result->passed ? 'rgba(16,185,129,0.3)' : 'rgba(239,68,68,0.3)' }};
                    background: linear-gradient(135deg, {{ $result->passed ? 'rgba(16,185,129,0.05)' : 'rgba(239,68,68,0.05)' }}, {{ $result->passed ? 'rgba(34,197,94,0.02)' : 'rgba(248,113,113,0.02)' }});">

            {{-- Background decoration --}}
            <div class="absolute top-0 right-0 w-64 h-64 rounded-full blur-3xl opacity-20 group-hover:scale-110 transition-transform duration-700"
                 style="background: radial-gradient(circle, {{ $result->passed ? '#10B981' : '#EF4444' }}, transparent);"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl mb-4 transition-all duration-500 group-hover:scale-110 group-hover:rotate-12"
                     style="background: linear-gradient(135deg, {{ $result->passed ? '#10B981' : '#EF4444' }}, {{ $result->passed ? '#22C55E' : '#F87171' }}); box-shadow: 0 12px 24px rgba({{ $result->passed ? '16,185,129' : '239,68,68' }}, 0.25);">
                    @if($result->passed)
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @else
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    @endif
                </div>

                <h1 class="text-4xl font-black mb-3 bg-gradient-to-r {{ $result->passed ? 'from-green-400 to-emerald-400' : 'from-red-400 to-pink-400' }} bg-clip-text text-transparent">
                    {{ $result->passed ? 'Project Passed!' : 'Project Failed' }}
                </h1>

                <p class="mb-6 text-base leading-relaxed max-w-lg mx-auto" style="color: #94A3B8;">
                    {{ $result->passed
    ? 'Excellent work! You demonstrated solid understanding of ' . $project->branch->name . '.'
    : 'Keep going! Review the action plan below to improve and try again.' }}
                </p>

                {{-- Score Ring --}}
                <div class="inline-flex flex-col items-center justify-center w-32 h-32 rounded-full mb-4 relative transition-all duration-500 group-hover:scale-105"
                     style="background: linear-gradient(135deg, {{ $result->passed ? 'rgba(16,185,129,0.15)' : 'rgba(239,68,68,0.15)' }}, {{ $result->passed ? 'rgba(34,197,94,0.08)' : 'rgba(248,113,113,0.08)' }});
                            border: 3px solid {{ $result->passed ? '#10B981' : '#EF4444' }}; box-shadow: 0 8px 24px rgba({{ $result->passed ? '16,185,129' : '239,68,68' }}, 0.15);">
                    <div class="text-4xl font-black" style="color: {{ $result->passed ? '#10B981' : '#EF4444' }}">{{ number_format($result->quiz_score) }}%</div>
                    <div class="text-xs font-medium uppercase tracking-wider" style="color: #94A3B8;">quiz score</div>
                </div>

                <div class="flex items-center justify-center gap-6 text-sm" style="color: #94A3B8;">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Pass threshold: <strong class="text-indigo-400">60%</strong></span>
                    </div>
                    <span class="w-1 h-1 rounded-full" style="background: #CBD5E1;"></span>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Evaluated: <strong class="text-indigo-400">{{ $result->evaluated_at?->format('M d, Y H:i') }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
        @if($result->code_feedback)
            <div class="card p-5 mt-6 border border-indigo-200 rounded-xl bg-indigo-50/30">

                <h3 class="font-bold text-lg mb-4 flex items-center gap-2 text-indigo-500">
                    🤖 AI Code Review
                </h3>

                {{-- Score --}}
                <div class="mb-4">
                    <p class="text-sm text-gray-500">Code Score</p>
                    <div class="text-2xl font-bold text-indigo-600">
                        {{ $result->code_feedback['score'] }}/20
                    </div>
                </div>

                {{-- Feedback --}}
                <div class="mb-4">
                    <p class="text-sm font-semibold text-gray-600">Feedback</p>
                    <p class="text-sm text-gray-500">
                        {{ $result->code_feedback['feedback'] }}
                    </p>
                </div>
                
                {{-- Mistakes --}}
                @if(!empty($result->code_feedback['mistakes']))
                    <div class="mb-4">
                        <p class="text-sm font-semibold text-red-500 mb-2">❌ Mistakes</p>
                        <ul class="space-y-1 text-sm text-gray-600">
                            @foreach($result->code_feedback['mistakes'] as $m)
                                <li>• {{ $m }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Improvements --}}
                @if(!empty($result->code_feedback['improvements']))
                    <div>
                        <p class="text-sm font-semibold text-green-500 mb-2">💡 Improvements</p>
                        <ul class="space-y-1 text-sm text-gray-600">
                            @foreach($result->code_feedback['improvements'] as $i)
                                <li>• {{ $i }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        @endif
        {{-- Quiz Review --}}
        <div class="card p-6 mb-6 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/5 to-cyan-500/5 rounded-full blur-2xl"></div>
            <div class="relative">
                <h2 class="font-bold text-lg mb-5 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:rotate-6"
                         style="background: linear-gradient(135deg, #6366F1, #22D3EE);">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    Quiz Review
                </h2>
                <div class="space-y-3">
                    @php $userAnswers = $result->quiz_answers ?? []; @endphp
                    @foreach($project->quizQuestions as $i => $q)
                    @php
    $given = $userAnswers[$q->id] ?? null;
    $correct = $q->isCorrect($given ?? '');
                    @endphp
                    <div class="rounded-xl p-4 relative overflow-hidden transition-all duration-300 hover:shadow-md"
                         style="background: var(--bg-surface); border: 1px solid {{ $correct ? 'rgba(16,185,129,0.2)' : 'rgba(239,68,68,0.2)' }};">
                        <div class="absolute top-0 right-0 w-20 h-20 rounded-full blur-xl opacity-10"
                             style="background: {{ $correct ? '#10B981' : '#EF4444' }};"></div>
                        <div class="relative">
                            <div class="flex items-start gap-3 mb-2">
                                <div class="w-6 h-6 rounded-full flex items-center justify-center flex-shrink-0 transition-all duration-300"
                                     style="background: {{ $correct ? 'rgba(16,185,129,0.15)' : 'rgba(239,68,68,0.15)' }};">
                                    @if($correct)
                                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <p class="text-sm font-medium leading-relaxed">{{ $q->question }}</p>
                            </div>
                            <div class="ml-9 space-y-2 text-sm" style="color: #94A3B8;">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-medium uppercase tracking-wider">Your answer:</span>
                                    <span class="{{ $correct ? 'text-green-400 font-medium' : 'text-red-400 font-medium' }}">{{ $given ?? 'Not answered' }}</span>
                                </div>
                                @if(!$correct)
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-medium uppercase tracking-wider">Correct:</span>
                                    <span class="text-green-400 font-medium">{{ $q->correct_answer }}</span>
                                </div>
                                @endif
                                @if($q->explanation)
                                <div class="mt-2 p-3 rounded-lg" style="background: rgba(99,102,241,0.05); border-left: 3px solid #6366F1;">
                                    <p class="text-xs italic leading-relaxed">{{ $q->explanation }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Action Plan (on failure) --}}
        @if(!$result->passed && $result->action_plan)
            @php $plan = $result->action_plan; @endphp
            <div class="card p-6 mb-6 relative overflow-hidden group hover:shadow-lg transition-all duration-300"
                 style="border-color: rgba(245,158,11,0.3); background: linear-gradient(135deg, rgba(245,158,11,0.02), rgba(251,191,36,0.02));">
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-amber-500/5 to-yellow-500/5 rounded-full blur-3xl"></div>
                <div class="relative">
                    <h2 class="font-bold text-lg mb-5 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 group-hover:scale-110 group-hover:rotate-6"
                             style="background: linear-gradient(135deg, #F59E0B, #FBBf24);">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                        </div>
                        Personalized Action Plan
                    </h2>
                    <h1>hhhhhhhhhhhhhhhhhhhhhhhhhhhh</h1>
                    {{-- What went wrong --}}
                    <div class="rounded-xl p-4 mb-4 relative overflow-hidden transition-all duration-300 hover:shadow-md"
                         style="background: rgba(239,68,68,0.05); border: 1px solid rgba(239,68,68,0.15);">
                        <div class="absolute top-0 right-0 w-16 h-16 bg-red-500/10 rounded-full blur-xl"></div>
                        <div class="relative">
                            <h4 class="font-semibold text-sm mb-2 flex items-center gap-2" style="color: #EF4444;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                What Went Wrong
                            </h4>
                            <p class="text-sm leading-relaxed" style="color: #94A3B8;">{{ $plan['what_went_wrong'] ?? '' }}</p>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        {{-- Concepts to review --}}
                        @if(!empty($plan['concepts_to_review']))
                        <div class="rounded-xl p-4 relative overflow-hidden transition-all duration-300 hover:shadow-md"
                             style="background: var(--bg-surface); border: 1px solid rgba(148,163,184,0.2);">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-indigo-500/10 rounded-full blur-xl"></div>
                            <div class="relative">
                                <h4 class="font-semibold text-sm mb-3 flex items-center gap-2" style="color: #6366F1;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    Concepts to Review
                                </h4>
                                <ul class="space-y-2">
                                    @foreach($plan['concepts_to_review'] as $concept)
                                    <li class="text-sm flex items-start gap-2 leading-relaxed" style="color: #94A3B8;">
                                        <span class="w-1.5 h-1.5 rounded-full mt-1.5 flex-shrink-0" style="background: #6366F1;"></span>
                                        <span>{{ $concept }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif

                        {{-- Mini tasks --}}
                        @if(!empty($plan['mini_tasks']))
                        <div class="rounded-xl p-4 relative overflow-hidden transition-all duration-300 hover:shadow-md"
                             style="background: var(--bg-surface); border: 1px solid rgba(148,163,184,0.2);">
                            <div class="absolute top-0 right-0 w-16 h-16 bg-green-500/10 rounded-full blur-xl"></div>
                            <div class="relative">
                                <h4 class="font-semibold text-sm mb-3 flex items-center gap-2" style="color: #10B981;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                    Mini Tasks
                                </h4>
                                <ul class="space-y-2">
                                    @foreach($plan['mini_tasks'] as $task)
                                    <li class="text-sm leading-relaxed">
                                        <div class="flex items-start gap-2">
                                            <div class="w-4 h-4 rounded border-2 border-green-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                                                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                            </div>
                                            <div class="flex-1">
                                                <span style="color: #94A3B8;">{{ $task['task'] ?? $task }}</span>
                                                @if(isset($task['estimated_time']))
                                                <span class="text-xs ml-2 px-2 py-0.5 rounded-full" style="background: rgba(16,185,129,0.1); color: #10B981;">{{ $task['estimated_time'] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Encouragement --}}
                    @if(!empty($plan['encouragement']))
                    <div class="rounded-xl p-4 mt-4 text-center relative overflow-hidden transition-all duration-300 hover:shadow-md"
                         style="background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(34,211,238,0.08)); border: 1px solid rgba(99,102,241,0.2);">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-500/10 to-cyan-500/10 rounded-full blur-2xl"></div>
                        <div class="relative">
                            <svg class="w-5 h-5 mx-auto mb-2" style="color: #6366F1;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <p class="text-sm font-medium italic leading-relaxed" style="color: #6366F1;">{{ $plan['encouragement'] }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Submission info --}}
        @if($project->submission)
        <div class="card p-6 mb-6 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-gray-500/5 to-slate-500/5 rounded-full blur-2xl"></div>
            <div class="relative">
                <h3 class="font-bold mb-4 text-sm uppercase tracking-wider flex items-center gap-2" style="color: #94A3B8;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    Submission
                </h3>
                <a href="{{ $project->submission->github_url }}" target="_blank"
                   class="inline-flex items-center gap-2 text-sm font-medium mb-3 px-3 py-2 rounded-lg transition-all duration-200 hover:scale-105 group/link"
                   style="background: rgba(99,102,241,0.05); border: 1px solid rgba(99,102,241,0.2); color: #6366F1;">
                    <svg class="w-4 h-4 transition-transform duration-200 group-hover/link:translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                    </svg>
                    <span class="group-hover/link:underline">{{ $project->submission->github_url }}</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
                @if($project->submission->notes)
                <div class="p-3 rounded-lg" style="background: var(--bg-surface); border-left: 3px solid #CBD5E1;">
                    <p class="text-sm leading-relaxed" style="color: #94A3B8;">{{ $project->submission->notes }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        {{-- CTA --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard') }}"
               class="btn-secondary relative overflow-hidden group flex items-center gap-2">
                <svg class="w-4 h-4 transition-transform duration-200 group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Dashboard
            </a>
            @if($result->passed)
            <form method="POST" action="{{ route('projects.generate') }}">
                @csrf
                <button type="submit" class="btn-primary relative overflow-hidden group">
                    <span class="relative z-10 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Generate Next Project
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-indigo-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                </button>
            </form>
            @else
            <form method="POST" action="{{ route('projects.generate') }}">
                @csrf
                <button type="submit" class="btn-primary relative overflow-hidden group">
                    <span class="relative z-10 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Try Again
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-amber-500 to-orange-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                </button>
            </form>
            @endif
        </div>
    </div>
@endsection

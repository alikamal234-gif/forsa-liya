@extends('layouts.app')

@section('title', 'Quiz — ' . $project->title)
@section('page-title', 'Project Quiz')
@section('page-subtitle', 'Test your understanding of what you built')

@section('content')
    <div class="max-w-3xl fade-in">

        {{-- Quiz header --}}
        <div class="card p-6 mb-6 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/10 to-cyan-500/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-500">
            </div>
            <div class="relative flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 rounded-full" style="background: linear-gradient(135deg, #6366F1, #22D3EE);">
                        </div>
                        <p class="text-sm font-medium" style="color: #94A3B8;">{{ $project->branch->name }}</p>
                    </div>
                    <h2 class="font-bold text-xl">{{ $project->title }}</h2>
                </div>
                <div class="text-center relative">
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-2 transition-all duration-300 group-hover:scale-110"
                        style="background: linear-gradient(135deg, #6366F1, #22D3EE); box-shadow: 0 8px 20px rgba(99,102,241,0.25);">
                        <span class="text-2xl font-black text-white">{{ $questions->count() }}</span>
                    </div>
                    <p class="text-xs font-medium" style="color: #94A3B8;">Questions</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl p-6 mb-6 relative overflow-hidden group hover:shadow-lg transition-all duration-300"
            style="background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(34,211,238,0.08)); border: 1px solid rgba(99,102,241,0.2);">
            <div
                class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-indigo-500/5 to-cyan-500/5 rounded-full blur-3xl">
            </div>
            <div class="relative flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 transition-all duration-300 group-hover:scale-110 group-hover:rotate-6"
                    style="background: linear-gradient(135deg, #6366F1, #22D3EE);">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                        </path>
                    </svg>
                </div>
                <div>
                    <p
                        class="font-bold text-base mb-2 bg-gradient-to-r from-indigo-400 to-cyan-400 bg-clip-text text-transparent">
                        Quiz Instructions</p>
                    <p class="text-sm leading-relaxed" style="color: #94A3B8;">Answer all questions honestly. You need
                        <strong class="text-indigo-400">60% or higher</strong> to pass. These questions test whether you
                        understood the project — not just whether AI wrote it for you.</p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('quiz.submit', $project) }}" id="quiz-form">
            @csrf
            <div class="space-y-5">
                @foreach($questions as $i => $question)
                    <div class="card p-6 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                        <div
                            class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-indigo-500/5 to-cyan-500/5 rounded-full blur-2xl">
                        </div>
                        <div class="relative">
                            <div class="flex items-start gap-4 mb-5">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold flex-shrink-0 transition-all duration-300 group-hover:scale-110"
                                    style="background: linear-gradient(135deg, rgba(99,102,241,0.15), rgba(34,211,238,0.15)); color: #6366F1; border: 1px solid rgba(99,102,241,0.2);">
                                    {{ $i + 1 }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        @if($question->type === 'scenario')
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium"
                                                style="background: linear-gradient(135deg, rgba(168,85,247,0.15), rgba(139,92,246,0.15)); color: #A855F7; border: 1px solid rgba(168,85,247,0.2);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                                    </path>
                                                </svg>
                                                Scenario
                                            </div>
                                        @else
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium"
                                                style="background: linear-gradient(135deg, rgba(34,211,238,0.15), rgba(6,182,212,0.15)); color: #22D3EE; border: 1px solid rgba(34,211,238,0.2);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                Multiple Choice
                                            </div>
                                        @endif
                                    </div>
                                    <p class="font-medium text-base leading-relaxed">{{ $question->question }}</p>
                                </div>
                            </div>

                            <div class="space-y-2 ml-14">
                                @foreach($question->options as $opt)
                                    <label
                                        class="flex items-center gap-3 p-4 rounded-xl cursor-pointer transition-all duration-200 quiz-option group/option relative overflow-hidden"
                                        style="border: 1px solid rgba(148,163,184,0.2); background: rgba(248,250,252,0.5);">
                                        <div class="relative">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $opt }}"
                                                class="w-4 h-4 accent-indigo-500 opacity-0 absolute" onchange="selectOption(this)">
                                            <div class="radio-custom w-5 h-5 rounded-full border-2 transition-all duration-200 flex items-center justify-center"
                                                style="border-color: #CBD5E1;">
                                                <div class="radio-dot w-2.5 h-2.5 rounded-full transition-all duration-200 scale-0"
                                                    style="background: linear-gradient(135deg, #6366F1, #22D3EE);"></div>
                                            </div>
                                        </div>
                                        <span class="text-sm leading-relaxed flex-1" style="color: #475569;">{{ $opt }}</span>
                                        <div class="check-icon opacity-0 transition-all duration-200">
                                            <svg class="w-5 h-5" style="color: #6366F1;" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                            @error("answers.{$question->id}")
                                <div class="flex items-center gap-2 mt-3 ml-14">
                                    <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="text-red-400 text-xs">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 p-6 rounded-xl relative overflow-hidden"
                style="background: linear-gradient(135deg, rgba(99,102,241,0.05), rgba(34,211,238,0.05)); border: 1px solid rgba(99,102,241,0.1);">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-indigo-500/10 to-cyan-500/10 rounded-full blur-3xl">
                </div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <button type="submit" class="btn-primary relative overflow-hidden group" id="submit-quiz">
                            <span class="relative z-10 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Submit Quiz
                            </span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-indigo-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300">
                            </div>
                        </button>
                        <p class="text-sm" style="color: #94A3B8;">
                            <span class="inline-flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Make sure to answer all {{ $questions->count() }} questions.
                            </span>
                        </p>
                    </div>
                    <div class="flex items-center gap-2 text-sm" style="color: #94A3B8;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>~5 min</span>
                    </div>
                </div>
            </div>

            <div style="margin-top:30px">
                <label style="font-weight:600;margin-bottom:10px;display:block">
                    💻 Code Challenge
                </label>

                <div id="editor" style="
                                height:300px;
                                border:1px solid #e5e7eb;
                                border-radius:8px;
                                overflow:hidden;
                            "></div>

                <input type="hidden" name="code" id="code_output">
            </div>

            @if(isset($result) && $result->code_feedback)
                <div class="card p-4 mt-4">
                    <h3>🤖 AI Code Review</h3>

                    <p>Score: {{ $result->code_feedback['score'] }}/20</p>

                    <p>{{ $result->code_feedback['feedback'] }}</p>

                    <ul>
                        @foreach($result->code_feedback['mistakes'] as $m)
                            <li>❌ {{ $m }}</li>
                        @endforeach
                    </ul>

                    <ul>
                        @foreach($result->code_feedback['improvements'] as $i)
                            <li>💡 {{ $i }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>

    <style>
        .quiz-option {
            position: relative;
        }

        .quiz-option:hover {
            border-color: rgba(99, 102, 241, 0.3) !important;
            background: rgba(99, 102, 241, 0.03) !important;
            transform: translateX(2px);
        }

        .quiz-option:has(input:checked) {
            border-color: #6366F1 !important;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.08), rgba(34, 211, 238, 0.08)) !important;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1);
        }

        .quiz-option:has(input:checked) .radio-custom {
            border-color: #6366F1;
        }

        .quiz-option:has(input:checked) .radio-dot {
            transform: scale(1);
        }

        .quiz-option:has(input:checked) .check-icon {
            opacity: 1;
            animation: checkBounce 0.3s ease-out;
        }

        @keyframes checkBounce {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        #editor {
            position: relative;
            z-index: 1;
        }

        .radio-custom {
            position: relative;
            cursor: pointer;
        }

        .quiz-option input[type="radio"]:checked+.radio-custom::before {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(34, 211, 238, 0.2));
            animation: pulse 1.5s ease-out;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.8);
                opacity: 1;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }
    </style>

    <script>
        function selectOption(radio) {
            // Add ripple effect
            const label = radio.closest('.quiz-option');
            const ripple = document.createElement('div');
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(99,102,241,0.3)';
            ripple.style.width = '20px';
            ripple.style.height = '20px';
            ripple.style.left = radio.offsetLeft - 10 + 'px';
            ripple.style.top = radio.offsetTop - 10 + 'px';
            ripple.style.animation = 'ripple 0.6s ease-out';
            ripple.style.pointerEvents = 'none';

            label.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        }

        document.getElementById('quiz-form').addEventListener('submit', function (e) {
            const btn = document.getElementById('submit-quiz');
            const originalContent = btn.innerHTML;

            btn.innerHTML = `
                    <span class="relative z-10 flex items-center gap-2">
                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Submitting...
                    </span>
                `;
            btn.disabled = true;
            btn.classList.add('opacity-75', 'cursor-not-allowed');

            // Reset after 10 seconds in case of error
            setTimeout(() => {
                if (btn.disabled) {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                    btn.classList.remove('opacity-75', 'cursor-not-allowed');
                }
            }, 10000);
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
        document.head.appendChild(style);
    </script>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (typeof window.initCodeEditor === "function") {
                window.initCodeEditor();
            }
        });

        document.getElementById('quiz-form').addEventListener('submit', function () {
                if (window.editorInstance) {
                    document.getElementById('code_output').value = window.editorInstance.getValue();
                }
            });
    </script>
@endpush


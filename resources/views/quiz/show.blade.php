@extends('layouts.app')

@section('title', 'Quiz — ' . $project->title)
@section('page-title', 'Project Quiz')
@section('page-subtitle', 'Test your understanding of what you built')

@section('content')
<div class="max-w-3xl fade-in">

    {{-- Quiz header --}}
    <div class="card p-5 mb-6 flex items-center justify-between">
        <div>
            <p class="text-sm font-medium" style="color: var(--text-muted)">{{ $project->branch->name }}</p>
            <h2 class="font-bold">{{ $project->title }}</h2>
        </div>
        <div class="text-center">
            <p class="text-2xl font-black gradient-text">{{ $questions->count() }}</p>
            <p class="text-xs" style="color: var(--text-muted)">Questions</p>
        </div>
    </div>

    <div class="rounded-xl p-4 mb-6 flex items-start gap-3" style="background: rgba(99,102,241,0.08); border: 1px solid rgba(99,102,241,0.2);">
        <span class="text-xl mt-0.5">🧠</span>
        <div>
            <p class="font-medium text-sm">Quiz Instructions</p>
            <p class="text-sm mt-1" style="color: var(--text-muted)">Answer all questions honestly. You need <strong>60% or higher</strong> to pass. These questions test whether you understood the project — not just whether AI wrote it for you.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('quiz.submit', $project) }}" id="quiz-form">
        @csrf
        <div class="space-y-5">
            @foreach($questions as $i => $question)
            <div class="card p-6">
                <div class="flex items-start gap-3 mb-5">
                    <span class="w-8 h-8 rounded-xl flex items-center justify-center text-sm font-bold flex-shrink-0" style="background: rgba(99,102,241,0.15); color: #6366F1;">{{ $i + 1 }}</span>
                    <div>
                        <p class="text-xs mb-2 font-medium" style="color: var(--text-muted)">{{ $question->type === 'scenario' ? '📖 Scenario' : '❓ Multiple Choice' }}</p>
                        <p class="font-medium leading-relaxed">{{ $question->question }}</p>
                    </div>
                </div>

                <div class="space-y-2 ml-11">
                    @foreach($question->options as $opt)
                    <label class="flex items-center gap-3 p-3 rounded-xl cursor-pointer transition-all duration-150 quiz-option" style="border: 1px solid var(--border);">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $opt }}"
                            class="w-4 h-4 accent-indigo-500"
                            onchange="selectOption(this)">
                        <span class="text-sm">{{ $opt }}</span>
                    </label>
                    @endforeach
                </div>

                @error("answers.{$question->id}")
                <p class="text-red-400 text-xs mt-2 ml-11">{{ $message }}</p>
                @enderror
            </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="btn-primary" id="submit-quiz">
                📤 Submit Quiz
            </button>
            <p class="text-sm" style="color: var(--text-muted)">Make sure to answer all {{ $questions->count() }} questions.</p>
        </div>
    </form>
</div>

<style>
.quiz-option:has(input:checked) {
    border-color: #6366F1 !important;
    background: rgba(99,102,241,0.08);
}
.quiz-option:hover { border-color: rgba(99,102,241,0.4); }
</style>

<script>
document.getElementById('quiz-form').addEventListener('submit', function(e) {
    const btn = document.getElementById('submit-quiz');
    btn.textContent = 'Submitting...';
    btn.disabled = true;
});
</script>
@endsection

<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

// ─── Welcome (Landing) ────────────────────────────────────────────────────────
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

// ─── Authenticated Routes ─────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Tracks & Branch selection
    Route::get('/tracks', [TrackController::class, 'index'])->name('tracks.index');
    Route::post('/tracks/select', [TrackController::class, 'select'])->name('tracks.select');

    // Projects
    Route::get('/project/current', [ProjectController::class, 'current'])->name('projects.current');
    Route::post('/project/generate', [ProjectController::class, 'generate'])->name('projects.generate');
    Route::post('/project/generate/force', [ProjectController::class, 'generateForce'])->name('projects.generate.force');
    Route::post('/project/{project}/abandon', [ProjectController::class, 'abandon'])->name('projects.abandon');
    Route::get('/project/{project}', [ProjectController::class, 'show'])->name('projects.show');

    // Submission
    Route::post('/project/{project}/submit', [SubmissionController::class, 'store'])->name('submissions.store');

    // Quiz
    Route::get('/project/{project}/quiz', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/project/{project}/quiz', [QuizController::class, 'submit'])->name('quiz.submit');

    // Results
    Route::get('/project/{project}/result', [ResultController::class, 'show'])->name('results.show');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/branch', [ProfileController::class, 'changeBranch'])->name('profile.branch');
});

// ─── Auth Routes (Breeze) ─────────────────────────────────────────────────────
require __DIR__ . '/auth.php';

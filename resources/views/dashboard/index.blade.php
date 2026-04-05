@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Your learning progress at a glance')

@push('styles')
<style>
    /* Custom animations and transitions */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    .card-hover {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .progress-fill {
        transition: width 1s ease-out;
    }

    .btn-hover {
        transition: all 0.2s ease;
    }

    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .stat-icon {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Dark mode support */
    @media (prefers-color-scheme: dark) {
        ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
    }
</style>
@endpush

@section('content')
<div style="background: rgba(10,10,15,0.8); backdrop-filter: blur(12px);" class="min-h-screen  dark:bg-gray-900 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="space-y-8 fade-in">

            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Dashboard</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Your learning progress at a glance</p>
                </div>
                <div class="mt-4 sm:mt-0">
                    <button class="btn-hover inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        New Project
                    </button>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach([
                    ['label' => 'Projects Done', 'value' => $stats['total'], 'icon' => 'folder', 'color' => 'indigo'],
                    ['label' => 'Passed', 'value' => $stats['passed'], 'icon' => 'check-circle', 'color' => 'green'],
                    ['label' => 'Failed', 'value' => $stats['failed'], 'icon' => 'x-circle', 'color' => 'red'],
                    ['label' => 'Skills Validated', 'value' => $stats['skills'], 'icon' => 'trophy', 'color' => 'yellow'],
                ] as $index => $stat)
                <div class="card-hover bg-gray-900 dark:bg-gray-800 overflow-hidden rounded-lg shadow-md" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ $stat['label'] }}</p>
                                <p class="mt-2 text-3xl font-semibold text-white dark:text-white">{{ $stat['value'] }}</p>
                            </div>
                            <div class="ml-5 flex-shrink-0">
                                <div class="stat-icon flex items-center justify-center h-12 w-12 rounded-md bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900">
                                    <!-- Heroicon for the icon -->
                                    @switch($stat['icon'])
                                        @case('folder')
                                            <svg class="h-6 w-6 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                            </svg>
                                            @break
                                        @case('check-circle')
                                            <svg class="h-6 w-6 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            @break
                                        @case('x-circle')
                                            <svg class="h-6 w-6 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            @break
                                        @case('trophy')
                                            <svg class="h-6 w-6 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                            </svg>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $stat['color'] }}-100 text-{{ $stat['color'] }}-800 dark:bg-{{ $stat['color'] }}-900 dark:text-{{ $stat['color'] }}-200">
                                    This month
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Active Project Card -->
                <div class="lg:col-span-2">
                    <div class="bg-gray-900 dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Active Project</h2>
                                @if(!$activeProject)
                                <form method="POST" action="{{ route('projects.generate') }}">
                                    @csrf
                                    <button type="submit" class="btn-hover inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Generate Project
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>

                        <div class="p-6">
                            @if($activeProject)
                            <div class="bg-gray-900 dark:bg-indigo-900/20 rounded-xl p-5 mb-6 border border-indigo-200 dark:border-indigo-800">
                                <div class="flex items-start justify-between gap-3 mb-4">
                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $activeProject->title }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($activeProject->description, 120) }}</p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        Active
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        {{ $activeProject->branch->name }}
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        {{ ucfirst($activeProject->difficulty) }}
                                    </div>
                                    @if($activeProject->deadline)
                                    <div class="flex items-center {{ $activeProject->daysRemaining() <= 1 ? 'text-red-500 dark:text-red-400' : '' }}">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $activeProject->daysRemaining() }} days left
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('projects.show', $activeProject) }}" class="btn-hover w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                View Project
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                            @else
                            <div class="text-center py-12">
                                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Active Project</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Generate your first AI-powered project and start building!</p>
                                @if(!$user->current_branch_id)
                                <a href="{{ route('tracks.index') }}" class="btn-hover inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-600">
                                    Select a Track First
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                                @else
                                <form method="POST" action="{{ route('projects.generate') }}">
                                    @csrf
                                    <button type="submit" class="btn-hover inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Generate My Project
                                    </button>
                                </form>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Current Track -->
                    <div class="bg-gray-900 dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Current Track</h3>
                        </div>
                        <div class="p-6">
                            @if($user->currentTrack)
                            <div class="flex items-center gap-3 mb-4">
                                <div class="flex-shrink-0 h-12 w-12 rounded-lg bg-gray-900 dark:bg-indigo-900 flex items-center justify-center">
                                    <span class="text-2xl">{{ $user->currentTrack->icon }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $user->currentTrack->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ $user->currentBranch?->name ?? 'No branch selected' }}</p>
                                </div>
                            </div>
                            <a href="{{ route('tracks.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                Change Track
                                <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                            @else
                            <div class="text-center py-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">No track selected yet</p>
                                <a href="{{ route('tracks.index') }}" class="btn-hover inline-flex justify-center items-center w-full px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Choose Track
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Level & XP -->
                    <div class="bg-gray-900 dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Level & XP</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-lg font-semibold text-transparent bg-clip-text bg-gradient-to-r from-indigo-500 to-purple-600">
                                    {{ $user->levelLabel() }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-cyan-100 text-cyan-800 dark:bg-cyan-900 dark:text-cyan-200">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $user->xp_points }} XP
                                </span>
                            </div>
                            @php
                                $levelProgress = $user->level === 'beginner' ? min(100, ($user->projects_passed / 3) * 100) :
                                                 ($user->level === 'intermediate' ? min(100, (($user->projects_passed - 3) / 7) * 100) : 100);
                            @endphp
                            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mb-3">
                                <div class="progress-fill bg-gradient-to-r from-indigo-500 to-purple-600 h-2.5 rounded-full" style="width: {{ $levelProgress }}%"></div>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                @if($user->level === 'beginner')
                                    {{ 3 - min(3, $user->projects_passed) }} passes to Intermediate
                                @elseif($user->level === 'intermediate')
                                    {{ max(0, 10 - $user->projects_passed) }} passes to Advanced
                                @else
                                    Max level reached! 🏆
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Skills Progress -->
                    <div class="bg-gray-900 dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Skills Progress</h3>
                        </div>
                        <div class="p-6">
                            @forelse($skillsProgress as $sp)
                            <div class="flex items-center justify-between py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                <div class="flex items-center gap-3">
                                    <div class="flex-shrink-0 h-8 w-8 rounded-md bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                        <span class="text-sm">{{ $sp->branch->icon }}</span>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $sp->branch->name }}</span>
                                </div>
                                @if($sp->is_validated)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Validated
                                </span>
                                @else
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $sp->projects_passed }}/1 to validate</span>
                                @endif
                            </div>
                            @empty
                            <div class="text-center py-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Complete projects to track skill progress.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Results -->
            @if($recentResults->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-white">Recent Results</h2>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentResults as $result)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-150">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    @if($result->passed)
                                    <div class="h-10 w-10 rounded-full bg-green-100 dark:bg-green-900 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    @else
                                    <div class="h-10 w-10 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center">
                                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $result->project->title }}</p>
                                    <div class="flex items-center mt-1">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $result->project->branch->name }}</p>
                                        <span class="mx-2 text-gray-300 dark:text-gray-600">•</span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $result->evaluated_at?->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="text-right">
                                    <p class="text-sm font-semibold {{ $result->passed ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $result->scoreLabel() }}
                                    </p>
                                </div>
                                <a href="{{ route('results.show', $result->project) }}" class="btn-hover inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    View
                                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

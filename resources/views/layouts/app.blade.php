<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Forsa-Liya — AI-powered software development learning platform">
    <title>{{ config('app.name', 'Forsa-Liya') }} — @yield('title', 'Dashboard')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { font-family: 'Inter', sans-serif; }
        :root {
            --bg-primary: #0A0A0F;
            --bg-surface: #111118;
            --bg-card: #16161F;
            --border: #1E1E2E;
            --primary: #6366F1;
            --primary-dark: #4F46E5;
            --accent: #22D3EE;
            --success: #10B981;
            --danger: #EF4444;
            --warning: #F59E0B;
            --text-primary: #F1F5F9;
            --text-muted: #64748B;
            --text-subtle: #334155;
        }
        body { background-color: var(--bg-primary); color: var(--text-primary); }
        .sidebar { width: 260px; min-height: 100vh; background: var(--bg-surface); border-right: 1px solid var(--border); }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 10px 16px; border-radius: 10px; color: var(--text-muted); font-size: 14px; font-weight: 500; transition: all 0.2s; text-decoration: none; }
        .nav-link:hover, .nav-link.active { background: rgba(99,102,241,0.1); color: var(--primary); }
        .nav-link.active { border-left: 3px solid var(--primary); }
        .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 16px; }
        .badge-passed { background: rgba(16,185,129,0.15); color: #10B981; border: 1px solid rgba(16,185,129,0.3); }
        .badge-failed { background: rgba(239,68,68,0.15); color: #EF4444; border: 1px solid rgba(239,68,68,0.3); }
        .badge-active { background: rgba(99,102,241,0.15); color: #6366F1; border: 1px solid rgba(99,102,241,0.3); }
        .badge-submitted { background: rgba(245,158,11,0.15); color: #F59E0B; border: 1px solid rgba(245,158,11,0.3); }
        .btn-primary { background: linear-gradient(135deg, #6366F1, #4F46E5); color: white; padding: 10px 24px; border-radius: 10px; font-weight: 600; font-size: 14px; border: none; cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 25px rgba(99,102,241,0.4); }
        .btn-secondary { background: var(--bg-card); color: var(--text-primary); padding: 10px 24px; border-radius: 10px; font-weight: 500; font-size: 14px; border: 1px solid var(--border); cursor: pointer; transition: all 0.2s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-secondary:hover { border-color: var(--primary); color: var(--primary); }
        .input { background: var(--bg-surface); border: 1px solid var(--border); border-radius: 10px; color: var(--text-primary); padding: 12px 16px; width: 100%; font-size: 14px; outline: none; transition: border-color 0.2s; }
        .input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .gradient-text { background: linear-gradient(135deg, #6366F1, #22D3EE); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .progress-bar { height: 6px; background: var(--border); border-radius: 99px; overflow: hidden; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, var(--primary), var(--accent)); border-radius: 99px; transition: width 0.8s ease; }
        .alert-success { background: rgba(16,185,129,0.1); border: 1px solid rgba(16,185,129,0.3); color: #10B981; padding: 12px 16px; border-radius: 10px; }
        .alert-error { background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.3); color: #EF4444; padding: 12px 16px; border-radius: 10px; }
        .alert-info { background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.3); color: #6366F1; padding: 12px 16px; border-radius: 10px; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
        .fade-in { animation: fadeIn 0.4s ease forwards; }
    </style>
</head>
<body class="h-full" style="background-color: var(--bg-primary);">
<div class="flex h-full min-h-screen">

    <!-- Sidebar -->
    <aside class="sidebar fixed top-0 left-0 h-screen flex flex-col z-20" style="width:260px">
        <!-- Logo -->
        <div class="p-6 border-b" style="border-color: var(--border);">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm" style="background: linear-gradient(135deg, #6366F1, #22D3EE);">FL</div>
                <span class="text-lg font-bold" style="color: var(--text-primary)">Forsa-Liya</span>
            </a>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <a href="{{ route('projects.current') }}" class="nav-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                My Project
            </a>
            <a href="{{ route('tracks.index') }}" class="nav-link {{ request()->routeIs('tracks.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Learning Tracks
            </a>
            <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Profile
            </a>
        </nav>

        <!-- User Info -->
        <div class="p-4 border-t" style="border-color: var(--border);">
            @auth
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-sm font-bold flex-shrink-0" style="background: linear-gradient(135deg, #6366F1, #22D3EE);">
                    {{ auth()->user()->initials() }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate" style="color: var(--text-primary)">{{ auth()->user()->name }}</p>
                    <p class="text-xs truncate" style="color: var(--text-muted)">{{ auth()->user()->levelLabel() }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs hover:text-red-400 transition-colors" style="color: var(--text-muted)" title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
            @endauth
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col" style="margin-left: 260px;">
        <!-- Top Bar -->
        <header class="sticky top-0 z-10 border-b px-6 py-4 flex items-center justify-between" style="background: rgba(10,10,15,0.8); backdrop-filter: blur(12px); border-color: var(--border);">
            <div>
                <h1 class="text-xl font-bold" style="color: var(--text-primary)">@yield('page-title', 'Dashboard')</h1>
                <p class="text-sm" style="color: var(--text-muted)">@yield('page-subtitle', '')</p>
            </div>
            <div class="flex items-center gap-3">
                @auth
                @if(auth()->user()->current_track_id)
                <span class="text-xs px-3 py-1.5 rounded-lg font-medium" style="background: rgba(99,102,241,0.1); color: #6366F1; border: 1px solid rgba(99,102,241,0.2);">
                    {{ auth()->user()->currentTrack?->icon }} {{ auth()->user()->currentTrack?->name }}
                </span>
                @endif
                <span class="text-xs px-3 py-1.5 rounded-lg font-medium" style="background: rgba(34,211,238,0.1); color: #22D3EE; border: 1px solid rgba(34,211,238,0.2);">
                    ⚡ {{ auth()->user()->xp_points }} XP
                </span>
                @endauth
            </div>
        </header>

        <!-- Flash Messages -->
        <div class="px-6 pt-4">
            @if(session('success'))
            <div class="alert-success fade-in mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert-error fade-in mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                {{ session('error') }}
            </div>
            @endif
            @if(session('info'))
            <div class="alert-info fade-in mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('info') }}
            </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="flex-1 p-6">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>

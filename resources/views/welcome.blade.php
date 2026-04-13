<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forsa-Liya — AI-Powered Developer Learning</title>
    <meta name="description" content="Replace traditional education with AI-guided, practice-based learning. Build real projects, get evaluated, level up.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0F0F14; color: #F1F5F9; overflow-x: hidden; }
        .hero-glow { position: absolute; width: 800px; height: 800px; background: radial-gradient(circle, rgba(99,102,241,0.08) 0%, transparent 70%); top: -300px; left: 50%; transform: translateX(-50%); pointer-events: none; }
        .gradient-text { background: linear-gradient(135deg, #6366F1, #22D3EE); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .btn-primary { background: linear-gradient(135deg, #6366F1, #4F46E5); color: white; padding: 14px 32px; border-radius: 12px; font-weight: 600; font-size: 16px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s; border: none; cursor: pointer; position: relative; overflow: hidden; }
        .btn-primary::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s; }
        .btn-primary:hover::before { left: 100%; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 20px 40px rgba(99,102,241,0.3); }
        .btn-ghost { background: transparent; color: #F1F5F9; padding: 14px 32px; border-radius: 12px; font-weight: 500; font-size: 16px; text-decoration: none; border: 1px solid #1E1E2E; transition: all 0.3s; display: inline-flex; align-items: center; gap: 10px; }
        .btn-ghost:hover { border-color: #6366F1; color: #6366F1; background: rgba(99,102,241,0.05); }
        .card-feature { background: #1A1A23; border: 1px solid #1E1E2E; border-radius: 20px; padding: 32px; transition: all 0.3s; position: relative; overflow: hidden; }
        .card-feature::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 1px; background: linear-gradient(90deg, transparent, rgba(99,102,241,0.5), transparent); opacity: 0; transition: opacity 0.3s; }
        .card-feature:hover::before { opacity: 1; }
        .card-feature:hover { border-color: rgba(99,102,241,0.3); transform: translateY(-4px); box-shadow: 0 20px 60px rgba(99,102,241,0.1); }
        .track-card { background: #1A1A23; border: 1px solid #1E1E2E; border-radius: 20px; padding: 32px 24px; text-align: center; transition: all 0.3s; position: relative; overflow: hidden; }
        .track-card::after { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, var(--track-color), transparent); transform: scaleX(0); transition: transform 0.3s; }
        .track-card:hover::after { transform: scaleX(1); }
        .track-card:hover { transform: translateY(-4px); border-color: rgba(99,102,241,0.3); box-shadow: 0 20px 60px rgba(99,102,241,0.1); }
        nav { position: fixed; top: 0; left: 0; right: 0; z-index: 50; padding: 20px 48px; display: flex; align-items: center; justify-content: space-between; background: rgba(15,15,20,0.8); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.05); }
        .step-number { width: 48px; height: 48px; border-radius: 50%; background: linear-gradient(135deg, #6366F1, #22D3EE); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 20px; flex-shrink: 0; box-shadow: 0 10px 30px rgba(99,102,241,0.3); }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .float { animation: float 3s ease-in-out infinite; }
        @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.7; } }
        .pulse { animation: pulse 2s ease-in-out infinite; }
        .stat-number { font-variant-numeric: tabular-nums; }
        .badge-new { background: linear-gradient(135deg, #10B981, #059669); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; }
        .scroll-indicator { position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%); animation: bounce 2s infinite; }
        @keyframes bounce { 0%,100% { transform: translateX(-50%) translateY(0); } 50% { transform: translateX(-50%) translateY(-10px); } }
    </style>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7781525594935553"
     crossorigin="anonymous"></script>
</head>
<body>
<!-- Navbar -->
<nav>
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm bg-gradient-to-br from-indigo-500 to-cyan-500 shadow-lg">
            FL
        </div>
        <span class="text-xl font-bold">Forsa-Liya</span>
    </div>
    <div class="flex items-center gap-4">
        @auth
        <a href="{{ route('dashboard') }}" class="btn-primary" style="padding: 12px 28px; font-size:14px;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Go to Dashboard
        </a>
        @else
        <a href="{{ route('login') }}" class="btn-ghost" style="padding: 12px 28px; font-size:14px;">Sign In</a>
        <a href="{{ route('register') }}" class="btn-primary" style="padding: 12px 28px; font-size:14px;">
            Get Started Free
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
            </svg>
        </a>
        @endauth
    </div>
</nav>

<!-- Hero Section -->
<section class="relative pt-48 pb-32 px-6 text-center overflow-hidden">
    <div class="hero-glow"></div>
    <div class="relative z-10 max-w-5xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium mb-8" style="background: rgba(99,102,241,0.1); color: #6366F1; border: 1px solid rgba(99,102,241,0.2);">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
            </svg>
            AI-Powered Learning Platform
        </div>
        <h1 class="text-6xl md:text-7xl font-black leading-tight mb-6">
            Learn by<br><span class="gradient-text">Building Real Things</span>
        </h1>
        <p class="text-xl text-slate-400 max-w-3xl mx-auto mb-10 leading-relaxed">
            Stop watching tutorials. Start building. Forsa-Liya generates personalized projects, evaluates your code understanding, and adapts to your skill level — all powered by AI.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="btn-primary text-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                Start Learning Free
            </a>
            <a href="{{ route('login') }}" class="btn-ghost">
                Sign In
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <!-- Stats bar -->
        <div class="flex items-center justify-center gap-12 mt-20 pt-10 border-t" style="border-color: rgba(255,255,255,0.05);">
            <div class="text-center">
                <div class="text-4xl font-black gradient-text stat-number">3</div>
                <div class="text-sm mt-2" style="color: #64748B;">Learning Tracks</div>
            </div>
            <div class="w-px h-12" style="background: rgba(255,255,255,0.05);"></div>
            <div class="text-center">
                <div class="text-4xl font-black gradient-text stat-number">10+</div>
                <div class="text-sm mt-2" style="color: #64748B;">Skills to Master</div>
            </div>
            <div class="w-px h-12" style="background: rgba(255,255,255,0.05);"></div>
            <div class="text-center">
                <div class="text-4xl font-black gradient-text stat-number">AI</div>
                <div class="text-sm mt-2" style="color: #64748B;">Adaptive Engine</div>
            </div>
            <div class="w-px h-12" style="background: rgba(255,255,255,0.05);"></div>
            <div class="text-center">
                <div class="text-4xl font-black gradient-text stat-number">∞</div>
                <div class="text-sm mt-2" style="color: #64748B;">Projects Generated</div>
            </div>
        </div>
    </div>
    <div class="scroll-indicator">
        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
        </svg>
    </div>
</section>

<!-- How It Works -->
<section class="py-24 px-6" style="background: #0A0A0F;">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black mb-4">How It Works</h2>
            <p class="text-lg" style="color: #64748B;">From zero to validated developer in 4 simple steps</p>
        </div>
        <div class="space-y-6">
            <!-- Step 1 -->
            <div class="flex items-start gap-6 card-feature">
                <div class="step-number">01</div>
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-xl bg-indigo-500/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold">Choose Your Track</h3>
                    </div>
                    <p style="color: #64748B; line-height: 1.7;">Select Frontend, Backend, or Fullstack. Then pick the specific skill you want to master — from HTML to Laravel.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="flex items-start gap-6 card-feature">
                <div class="step-number">02</div>
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-xl bg-cyan-500/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold">Get an AI Project</h3>
                    </div>
                    <p style="color: #64748B; line-height: 1.7;">Our AI generates a real-world project brief tailored to your level. No cookie-cutter exercises — actual things you can show employers.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="flex items-start gap-6 card-feature">
                <div class="step-number">03</div>
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold">Submit Your GitHub</h3>
                    </div>
                    <p style="color: #64748B; line-height: 1.7;">Build the project, push it to GitHub, and submit the link. Add notes about your approach and what you learned.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="flex items-start gap-6 card-feature">
                <div class="step-number">04</div>
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-xl bg-green-500/10 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold">Pass the Quiz & Level Up</h3>
                    </div>
                    <p style="color: #64748B; line-height: 1.7;">The AI quizzes you on your own project. Score 60%+ to pass, earn XP, and unlock harder challenges. Fail? Get a personalized recovery plan.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tracks Preview -->
<section class="py-24 px-6">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black mb-4">Learning Tracks</h2>
            <p class="text-lg" style="color: #64748B;">Choose your path and master the skills employers want</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Frontend Track -->
            <div class="track-card" style="--track-color: #6366F1;">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3">Frontend</h3>
                <div class="space-y-2 text-sm" style="color: #64748B;">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        HTML
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        CSS
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Tailwind
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        JavaScript
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        React
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Vue.js
                    </div>
                </div>
            </div>

            <!-- Backend Track -->
            <div class="track-card" style="--track-color: #22D3EE;">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-cyan-500 to-cyan-600 flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3">Backend</h3>
                <div class="space-y-2 text-sm" style="color: #64748B;">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        PHP
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        SQL
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Laravel
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-cyan-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        API Development
                    </div>
                </div>
            </div>

            <!-- Fullstack Track -->
            <div class="track-card" style="--track-color: #10B981;">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-3">Fullstack</h3>
                <div class="space-y-2 text-sm" style="color: #64748B;">
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        HTML/CSS/JS
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        PHP
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Laravel
                    </div>
                    <div class="flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        APIs
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="py-24 px-6" style="background: #0A0A0F;">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black mb-4">Why Forsa-Liya?</h2>
            <p class="text-lg" style="color: #64748B;">The smartest way to become a developer</p>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Feature 1 -->
            <div class="card-feature">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Adaptive Difficulty</h3>
                <p class="text-sm leading-relaxed" style="color: #64748B;">Projects get harder as you improve. The AI tracks your performance and adjusts accordingly.</p>
            </div>

            <!-- Feature 2 -->
            <div class="card-feature">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-cyan-500 to-cyan-600 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">AI-Generated Projects</h3>
                <p class="text-sm leading-relaxed" style="color: #64748B;">Every project is unique and tailored to your current level and chosen technology.</p>
            </div>

            <!-- Feature 3 -->
            <div class="card-feature">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Smart Evaluation</h3>
                <p class="text-sm leading-relaxed" style="color: #64748B;">The AI quiz tests whether you truly understood your project — not just copied code.</p>
            </div>

            <!-- Feature 4 -->
            <div class="card-feature">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Action Plans</h3>
                <p class="text-sm leading-relaxed" style="color: #64748B;">Failed a quiz? Get a personalized recovery plan with mini-tasks and resources.</p>
            </div>

            <!-- Feature 5 -->
            <div class="card-feature">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-pink-500 to-pink-600 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Progress Tracking</h3>
                <p class="text-sm leading-relaxed" style="color: #64748B;">Dashboard shows XP, skills validated, pass rate, and current level at a glance.</p>
            </div>

            <!-- Feature 6 -->
            <div class="card-feature">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-amber-500 to-amber-600 flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Real Projects</h3>
                <p class="text-sm leading-relaxed" style="color: #64748B;">Build things you can add to your portfolio. Not toy exercises — real applications.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-24 px-6 text-center relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/10 to-cyan-600/10"></div>
    <div class="relative z-10 max-w-3xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium mb-6" style="background: rgba(99,102,241,0.1); color: #6366F1; border: 1px solid rgba(99,102,241,0.2);">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
            </svg>
            Start Your Journey Today
        </div>
        <h2 class="text-5xl font-black mb-6">Ready to <span class="gradient-text">Level Up?</span></h2>
        <p class="text-xl mb-10" style="color: #64748B;">Join Forsa-Liya and start your AI-powered learning journey today. Free forever.</p>
        <a href="{{ route('register') }}" class="btn-primary text-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Create Free Account
        </a>
        <p class="text-sm mt-6" style="color: #64748B;">No credit card required • Cancel anytime</p>
    </div>
</section>

<!-- Footer -->
<footer class="py-12 text-center border-t" style="border-color: rgba(255,255,255,0.05); background: #0A0A0F;">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-center justify-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white font-bold text-sm bg-gradient-to-br from-indigo-500 to-cyan-500">
                FL
            </div>
            <span class="text-xl font-bold">Forsa-Liya</span>
        </div>
        <p class="text-sm" style="color: #64748B;">© {{ date('Y') }} Forsa-Liya — AI-Powered Developer Learning Platform</p>
        <div class="flex items-center justify-center gap-6 mt-6">
            <a href="#" class="text-sm hover:text-indigo-400 transition-colors" style="color: #64748B;">Privacy</a>
            <a href="#" class="text-sm hover:text-indigo-400 transition-colors" style="color: #64748B;">Terms</a>
            <a href="#" class="text-sm hover:text-indigo-400 transition-colors" style="color: #64748B;">Contact</a>
        </div>
    </div>
</footer>
</body>
</html>

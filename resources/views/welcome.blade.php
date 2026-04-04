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
        body { background: #0A0A0F; color: #F1F5F9; overflow-x: hidden; }
        .hero-glow { position: absolute; width: 600px; height: 600px; background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%); top: -200px; left: 50%; transform: translateX(-50%); pointer-events: none; }
        .gradient-text { background: linear-gradient(135deg, #6366F1, #22D3EE); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .btn-primary { background: linear-gradient(135deg, #6366F1, #4F46E5); color: white; padding: 14px 32px; border-radius: 12px; font-weight: 700; font-size: 16px; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s; border: none; cursor: pointer; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 12px 40px rgba(99,102,241,0.5); }
        .btn-ghost { background: transparent; color: #F1F5F9; padding: 14px 32px; border-radius: 12px; font-weight: 600; font-size: 16px; text-decoration: none; border: 1px solid #1E1E2E; transition: all 0.3s; display: inline-flex; align-items: center; gap: 10px; }
        .btn-ghost:hover { border-color: #6366F1; color: #6366F1; }
        .card-feature { background: #16161F; border: 1px solid #1E1E2E; border-radius: 20px; padding: 32px; transition: all 0.3s; }
        .card-feature:hover { border-color: rgba(99,102,241,0.4); transform: translateY(-4px); box-shadow: 0 20px 60px rgba(99,102,241,0.1); }
        .track-card { background: #16161F; border: 1px solid #1E1E2E; border-radius: 16px; padding: 24px; text-align: center; transition: all 0.3s; }
        .track-card:hover { transform: translateY(-4px); }
        nav { position: fixed; top: 0; left: 0; right: 0; z-index: 50; padding: 16px 48px; display: flex; align-items: center; justify-content: space-between; background: rgba(10,10,15,0.8); backdrop-filter: blur(12px); border-bottom: 1px solid #1E1E2E; }
        .step-number { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #6366F1, #22D3EE); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 18px; flex-shrink: 0; }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .float { animation: float 3s ease-in-out infinite; }
    </style>
</head>
<body>
<!-- Navbar -->
<nav>
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white font-bold text-sm" style="background: linear-gradient(135deg, #6366F1, #22D3EE);">FL</div>
        <span class="text-lg font-bold">Forsa-Liya</span>
    </div>
    <div class="flex items-center gap-4">
        @auth
        <a href="{{ route('dashboard') }}" class="btn-primary" style="padding: 10px 24px; font-size:14px;">Go to Dashboard →</a>
        @else
        <a href="{{ route('login') }}" class="btn-ghost" style="padding: 10px 24px; font-size:14px;">Sign In</a>
        <a href="{{ route('register') }}" class="btn-primary" style="padding: 10px 24px; font-size:14px;">Get Started Free →</a>
        @endauth
    </div>
</nav>

<!-- Hero Section -->
<section class="relative pt-40 pb-24 px-6 text-center overflow-hidden">
    <div class="hero-glow"></div>
    <div class="relative z-10 max-w-5xl mx-auto">
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium mb-8" style="background: rgba(99,102,241,0.1); color: #6366F1; border: 1px solid rgba(99,102,241,0.3);">
            ✨ AI-Powered Learning Platform
        </div>
        <h1 class="text-6xl md:text-7xl font-black leading-tight mb-6">
            Learn by<br><span class="gradient-text">Building Real Things</span>
        </h1>
        <p class="text-xl text-slate-400 max-w-2xl mx-auto mb-10 leading-relaxed">
            Stop watching tutorials. Start building. Forsa-Liya generates personalized projects, evaluates your code understanding, and adapts to your skill level — all powered by AI.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="btn-primary text-lg">
                🚀 Start Learning Free
            </a>
            <a href="{{ route('login') }}" class="btn-ghost">
                Sign In →
            </a>
        </div>
        <!-- Stats bar -->
        <div class="flex items-center justify-center gap-12 mt-16 pt-8 border-t" style="border-color: #1E1E2E;">
            <div>
                <div class="text-3xl font-black gradient-text">3</div>
                <div class="text-sm mt-1" style="color: #64748B;">Learning Tracks</div>
            </div>
            <div class="w-px h-10" style="background: #1E1E2E;"></div>
            <div>
                <div class="text-3xl font-black gradient-text">10+</div>
                <div class="text-sm mt-1" style="color: #64748B;">Skills to Master</div>
            </div>
            <div class="w-px h-10" style="background: #1E1E2E;"></div>
            <div>
                <div class="text-3xl font-black gradient-text">AI</div>
                <div class="text-sm mt-1" style="color: #64748B;">Adaptive Engine</div>
            </div>
            <div class="w-px h-10" style="background: #1E1E2E;"></div>
            <div>
                <div class="text-3xl font-black gradient-text">∞</div>
                <div class="text-sm mt-1" style="color: #64748B;">Projects Generated</div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-24 px-6" style="background: #111118;">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black mb-4">How It Works</h2>
            <p class="text-lg" style="color: #64748B;">From zero to validated developer in 4 simple steps</p>
        </div>
        <div class="space-y-6">
            @foreach([
                ['01', '🎯', 'Choose Your Track', 'Select Frontend, Backend, or Fullstack. Then pick the specific skill you want to master — from HTML to Laravel.'],
                ['02', '🤖', 'Get an AI Project', 'Our AI generates a real-world project brief tailored to your level. No cookie-cutter exercises — actual things you can show employers.'],
                ['03', '🔗', 'Submit Your GitHub', 'Build the project, push it to GitHub, and submit the link. Add notes about your approach and what you learned.'],
                ['04', '🧠', 'Pass the Quiz & Level Up', 'The AI quizzes you on your own project. Score 60%+ to pass, earn XP, and unlock harder challenges. Fail? Get a personalized recovery plan.'],
            ] as [$num, $icon, $title, $desc])
            <div class="flex items-start gap-6 card-feature">
                <div class="step-number flex-shrink-0">{{ $num }}</div>
                <div>
                    <h3 class="text-xl font-bold mb-2">{{ $icon }} {{ $title }}</h3>
                    <p style="color: #64748B; line-height: 1.7;">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
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
            @foreach([
                ['🎨', 'Frontend', 'HTML → CSS → Tailwind → JavaScript → React → Vue.js', '#6366F1'],
                ['⚙️', 'Backend', 'PHP → SQL → Laravel → API Development', '#22D3EE'],
                ['🚀', 'Fullstack', 'HTML → CSS → JavaScript → PHP → Laravel → APIs', '#10B981'],
            ] as [$icon, $name, $skills, $color])
            <div class="track-card" style="border-top: 3px solid {{ $color }};">
                <div class="text-4xl mb-4">{{ $icon }}</div>
                <h3 class="text-xl font-bold mb-3">{{ $name }}</h3>
                <p class="text-sm leading-relaxed" style="color: #64748B;">{{ $skills }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Grid -->
<section class="py-24 px-6" style="background: #111118;">
    <div class="max-w-5xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black mb-4">Why Forsa-Liya?</h2>
        </div>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                ['🎯', 'Adaptive Difficulty', 'Projects get harder as you improve. The AI tracks your performance and adjusts accordingly.'],
                ['🤖', 'AI-Generated Projects', 'Every project is unique and tailored to your current level and chosen technology.'],
                ['🧠', 'Smart Evaluation', 'The AI quiz tests whether you truly understood your project — not just copied code.'],
                ['📋', 'Action Plans', 'Failed a quiz? Get a personalized recovery plan with mini-tasks and resources.'],
                ['📈', 'Progress Tracking', 'Dashboard shows XP, skills validated, pass rate, and current level at a glance.'],
                ['💻', 'Real Projects', 'Build things you can add to your portfolio. Not toy exercises — real applications.'],
            ] as [$icon, $title, $desc])
            <div class="card-feature">
                <div class="text-3xl mb-4">{{ $icon }}</div>
                <h3 class="font-bold mb-2">{{ $title }}</h3>
                <p class="text-sm leading-relaxed" style="color: #64748B;">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-24 px-6 text-center">
    <div class="max-w-2xl mx-auto">
        <h2 class="text-5xl font-black mb-6">Ready to <span class="gradient-text">Level Up?</span></h2>
        <p class="text-lg mb-10" style="color: #64748B;">Join Forsa-Liya and start your AI-powered learning journey today. Free forever.</p>
        <a href="{{ route('register') }}" class="btn-primary text-lg">
            🚀 Create Free Account →
        </a>
    </div>
</section>

<!-- Footer -->
<footer class="py-8 text-center border-t text-sm" style="border-color: #1E1E2E; color: #64748B;">
    <p>© {{ date('Y') }} Forsa-Liya — AI-Powered Developer Learning Platform</p>
</footer>
</body>
</html>

<x-guest-layout>
    <h2 style="font-size:22px;font-weight:800;margin-bottom:6px;">Welcome back 👋</h2>
    <p style="color:#64748B;font-size:14px;margin-bottom:24px;">Sign in to continue your learning journey</p>

    <!-- Session Status -->
    @if(session('status'))
    <div style="background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.3);color:#10B981;padding:12px 16px;border-radius:10px;font-size:13px;margin-bottom:16px;">
        {{ session('status') }}
    </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" class="input" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="you@example.com">
            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="input" required autocomplete="current-password" placeholder="••••••••">
            @error('password') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;">
            <label style="display:flex;align-items:center;gap:8px;margin:0;font-size:13px;color:#94A3B8;cursor:pointer;">
                <input type="checkbox" name="remember" id="remember_me" style="accent-color:#6366F1;">
                Remember me
            </label>
            @if(Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="auth-link">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn-primary">Sign In →</button>

        <p style="text-align:center;font-size:13px;color:#64748B;margin-top:16px;">
            Don't have an account? <a href="{{ route('register') }}" class="auth-link">Create one free →</a>
        </p>
    </form>
</x-guest-layout>

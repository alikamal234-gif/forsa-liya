<x-guest-layout>
    <h2 style="font-size:22px;font-weight:800;margin-bottom:6px;">Create your account 🚀</h2>
    <p style="color:#64748B;font-size:14px;margin-bottom:24px;">Start your AI-powered learning journey today</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name">Full Name</label>
            <input id="name" type="text" name="name" class="input" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Your full name">
            @error('name') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email">Email Address</label>
            <input id="email" type="email" name="email" class="input" value="{{ old('email') }}" required autocomplete="username" placeholder="you@example.com">
            @error('email') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="input" required autocomplete="new-password" placeholder="Min 8 characters">
            @error('password') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="input" required autocomplete="new-password" placeholder="Repeat password">
            @error('password_confirmation') <p class="error-msg">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn-primary">Create Account →</button>

        <p style="text-align:center;font-size:13px;color:#64748B;margin-top:16px;">
            Already have an account? <a href="{{ route('login') }}" class="auth-link">Sign in →</a>
        </p>
    </form>
</x-guest-layout>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Forsa-Liya') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }
        body { background: #0A0A0F; color: #F1F5F9; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .auth-card { background: #111118; border: 1px solid #1E1E2E; border-radius: 20px; padding: 40px; width: 100%; max-width: 420px; }
        .input { background: #0A0A0F; border: 1px solid #1E1E2E; border-radius: 10px; color: #F1F5F9; padding: 12px 16px; width: 100%; font-size: 14px; outline: none; transition: border-color 0.2s; }
        .input:focus { border-color: #6366F1; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
        .btn-primary { background: linear-gradient(135deg, #6366F1, #4F46E5); color: white; padding: 12px 24px; border-radius: 10px; font-weight: 700; font-size: 14px; border: none; cursor: pointer; width: 100%; transition: all 0.2s; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-1px); box-shadow: 0 8px 25px rgba(99,102,241,0.4); }
        label { display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px; color: #94A3B8; }
        .auth-link { color: #6366F1; text-decoration: none; font-size: 13px; font-weight: 500; }
        .auth-link:hover { text-decoration: underline; }
        .error-msg { color: #EF4444; font-size: 12px; margin-top: 4px; }
        .glow { position: fixed; width: 400px; height: 400px; background: radial-gradient(circle, rgba(99,102,241,0.1) 0%, transparent 70%); top: -100px; left: 50%; transform: translateX(-50%); pointer-events: none; z-index: 0; }
    </style>
</head>
<body>
<div class="glow"></div>
<div style="position: relative; z-index: 1; width: 100%; max-width: 480px; padding: 20px;">
    <!-- Logo -->
    <div class="text-center mb-8">
        <a href="{{ route('welcome') }}" class="inline-flex items-center gap-3">
            <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#6366F1,#22D3EE);display:flex;align-items:center;justify-content:center;font-weight:800;font-size:16px;color:white;">FL</div>
            <span style="font-size:20px;font-weight:800;">Forsa-Liya</span>
        </a>
        <p style="color:#64748B;font-size:13px;margin-top:8px;">AI-Powered Developer Learning</p>
    </div>
    <div class="auth-card">
        {{ $slot }}
    </div>
</div>
</body>
</html>

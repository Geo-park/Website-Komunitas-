<!DOCTYPE html>
<html lang="id" data-theme="{{ session('theme','dark') }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Login Admin — HIMA IF</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Sans:wght@400;500&family=JetBrains+Mono:wght@400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="login-page">
  <div class="hero-bg">
    <div class="hero-grid"></div>
    <div class="hero-orb orb1"></div>
    <div class="hero-orb orb2"></div>
  </div>
  <div class="login-card">
    <div class="login-brand">
      <span class="logo-icon" style="font-size:2.5rem;color:var(--accent)">⬡</span>
      <h2 style="font-family:var(--font-display);font-weight:800;letter-spacing:-1px">HIMA IF</h2>
    </div>
    <div class="login-icon">🔐</div>
    <h3>Login Admin</h3>
    <p style="color:var(--text-secondary);font-size:.88rem;margin-bottom:24px">Masukkan kredensial untuk mengakses panel admin</p>

    @if($errors->any())
    <div class="alert alert-error" style="margin-bottom:16px">{{ $errors->first('login') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <label class="admin-label">Username</label>
      <input type="text" name="username" class="admin-input" placeholder="admin" value="{{ old('username') }}" required autofocus>

      <label class="admin-label">Password</label>
      <input type="password" name="password" class="admin-input" placeholder="••••••••" required>

      <button type="submit" class="btn-primary full-width" style="margin-top:8px">Masuk →</button>
    </form>

    <p class="login-hint">Demo: <code>admin</code> / <code>hima2024</code></p>

    <a href="{{ route('home') }}" style="display:block;text-align:center;margin-top:20px;font-size:.83rem;color:var(--text-muted)">← Kembali ke Website</a>
  </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="id" data-theme="{{ session('theme','dark') }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Admin — @yield('title','Dashboard') | HIMA IF</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">

<div class="admin-layout">
  {{-- Sidebar --}}
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-brand">
      <span class="logo-icon">⬡</span>
      <span>HIMA IF Admin</span>
    </div>
    <nav class="sidebar-nav">
      <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span>📊</span> Dashboard
      </a>
      <a href="{{ route('admin.kegiatan.create') }}" class="sidebar-link {{ request()->routeIs('admin.kegiatan.*') ? 'active' : '' }}">
        <span>📅</span> Kegiatan
      </a>
      <a href="{{ route('admin.produk.create') }}" class="sidebar-link {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
        <span>🛒</span> Produk
      </a>
      <a href="{{ route('admin.galeri.create') }}" class="sidebar-link {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
        <span>🖼</span> Galeri
      </a>
      <a href="{{ route('admin.struktur.create') }}" class="sidebar-link {{ request()->routeIs('admin.struktur.*') ? 'active' : '' }}">
        <span>👥</span> Pengurus
      </a>
      <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
        <span>⚙</span> Pengaturan
      </a>
    </nav>
    <div class="sidebar-footer">
      <a href="{{ route('home') }}" class="sidebar-link">
        <span>🌐</span> Lihat Website
      </a>
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="sidebar-link sidebar-logout">
          <span>🚪</span> Logout
        </button>
      </form>
    </div>
  </aside>

  {{-- Main --}}
  <div class="admin-main">
    <header class="admin-topbar">
      <button class="sidebar-toggle" id="sidebarToggle">☰</button>
      <h1 class="admin-page-title">@yield('title','Dashboard')</h1>
      <div class="topbar-right">
        <form method="POST" action="{{ route('theme.toggle') }}" style="display:inline">
          @csrf
          <button type="submit" class="theme-toggle">
            <span>{{ session('theme','dark')==='dark' ? '☀' : '🌙' }}</span>
          </button>
        </form>
        <span class="admin-user">👤 Administrator</span>
      </div>
    </header>

    @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-error">
      <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="admin-content-wrap">
      @yield('content')
    </div>
  </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script>
document.getElementById('sidebarToggle')?.addEventListener('click', () => {
  document.getElementById('adminSidebar').classList.toggle('open');
});
</script>
@stack('scripts')
</body>
</html>

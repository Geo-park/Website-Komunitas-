<!DOCTYPE html>
<html lang="id" data-theme="{{ session('theme', 'dark') }}" x-data="{ theme: '{{ session('theme', 'dark') }}' }">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', 'HIMA Informatika') — {{ $settings['hima_nama'] ?? 'HIMA IF' }}</title>
<meta name="description" content="@yield('meta_desc', 'Website resmi Himpunan Mahasiswa Informatika')">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stack('styles')
</head>
<body>

{{-- NAVBAR CORPORATE --}}
<nav class="navbar navbar-corporate" id="navbar">
  <div class="nav-container">
    <a href="{{ route('home') }}" class="nav-logo corporate-logo">
      <div class="logo-icon">⬡</div>
      <div class="logo-text-stack">
        <span class="logo-title">HIMA IF</span>
        <span class="logo-subtitle">Universitas</span>
      </div>
    </a>

    <ul class="nav-menu" id="navMenu">
      <li class="nav-item has-dropdown">
        <a href="{{ route('visi-misi') }}" class="nav-link corporate-link @yield('nav_tentang')">
          Tentang <span class="arrow">▾</span>
        </a>
        <div class="dropdown corporate-dropdown">
          <a href="{{ route('visi-misi') }}">Visi &amp; Misi</a>
          <a href="{{ route('struktur.index') }}">Struktur Organisasi</a>
        </div>
      </li>
      <li class="nav-item">
        <a href="{{ route('pengumuman.index') }}" class="nav-link corporate-link @yield('nav_pengumuman')">Pengumuman</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('kegiatan.index') }}" class="nav-link corporate-link @yield('nav_kegiatan')">Program</a>
      </li>
      <li class="nav-item">
        <a href="{{ route('marketplace.index') }}" class="nav-link corporate-link @yield('nav_marketplace')">
          Marketplace
          @php $cartCount = array_sum(array_column(session('cart', []), 'qty')) @endphp
          @if($cartCount > 0)
            <span class="cart-badge">{{ $cartCount }}</span>
          @endif
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('galeri.index') }}" class="nav-link corporate-link @yield('nav_galeri')">Galeri</a>
      </li>
      <li class="nav-item has-dropdown">
        <a href="#" class="nav-link corporate-link">Sosial <span class="arrow">▾</span></a>
        <div class="dropdown corporate-dropdown">
          <a href="{{ $settings['instagram_url'] ?? '#' }}" target="_blank">Instagram</a>
          <a href="{{ $settings['tiktok_url'] ?? '#' }}" target="_blank">TikTok</a>
          <a href="{{ $settings['youtube_url'] ?? '#' }}" target="_blank">YouTube</a>
        </div>
      </li>
    </ul>

    <div class="nav-actions">
      <form method="POST" action="{{ route('theme.toggle') }}" style="display:inline">
        @csrf
        <button type="submit" class="theme-toggle corporate-toggle" title="Ganti tema">
          <span class="theme-icon">{{ session('theme','dark') === 'dark' ? '☀' : '🌙' }}</span>
        </button>
      </form>
      <a href="{{ route('admin.login') }}" class="nav-link nav-admin corporate-btn-outline">Admin</a>
      <button class="hamburger" id="hamburger" aria-label="Menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</nav>

{{-- FLASH MESSAGES --}}
@if(session('success'))
  <div class="toast-server show" id="serverToast">{{ session('success') }}</div>
@endif

{{-- MAIN CONTENT --}}
<main>
  @yield('content')
</main>

{{-- FOOTER CORPORATE --}}
<footer class="footer corporate-footer">
  <div class="container">
    <div class="footer-top">
      <div class="footer-brand">
        <div class="footer-logo corporate-logo">
          <span class="logo-icon-sm">⬡</span>
          <span class="logo-title">{{ $settings['hima_nama'] ?? 'HIMA Informatika' }}</span>
        </div>
        <p class="brand-desc">Komunitas mahasiswa yang berdedikasi menciptakan inovasi tanpa batas.</p>
      </div>
      <div class="footer-social-corp">
        <span>Connect with us</span>
        <div class="social-links">
          <a href="{{ $settings['instagram_url'] ?? '#' }}" target="_blank">IG</a>
          <a href="{{ $settings['tiktok_url'] ?? '#' }}" target="_blank">TK</a>
          <a href="{{ $settings['youtube_url'] ?? '#' }}" target="_blank">YT</a>
        </div>
      </div>
    </div>
    
    <div class="footer-grid corporate-footer-grid">
      <div class="footer-links">
        <h5>Quick Links</h5>
        <ul>
          <li><a href="{{ route('home') }}">Beranda</a></li>
          <li><a href="{{ route('visi-misi') }}">Visi &amp; Misi</a></li>
          <li><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
        </ul>
      </div>
      <div class="footer-links">
        <h5>Explore</h5>
        <ul>
          <li><a href="{{ route('kegiatan.index') }}">Program</a></li>
          <li><a href="{{ route('marketplace.index') }}">Marketplace</a></li>
          <li><a href="{{ route('galeri.index') }}">Galeri</a></li>
        </ul>
      </div>
      <div class="footer-links">
        <h5>Organization</h5>
        <ul>
          <li><a href="{{ route('struktur.index') }}">Struktur Pengurus</a></li>
          <li><a href="{{ route('admin.login') }}">Admin Login</a></li>
        </ul>
      </div>
      <div class="footer-contact">
        <h5>Contact Us</h5>
        <p>{{ $settings['hima_alamat'] ?? 'UIN SMH BANTEN' }}</p>
        <p>{{ $settings['hima_email'] ?? 'hima.if@universitas.ac.id' }}</p>
        <p>+{{ $settings['whatsapp_number'] ?? '62812xxxxxxxx' }}</p>
      </div>
    </div>
    
    <div class="footer-bottom corporate-footer-bottom">
      <p>© {{ date('Y') }} {{ $settings['hima_nama'] ?? 'HIMA Informatika' }}. All Rights Reserved.</p>
      <div class="footer-legal">
        <a href="#">Terms of Use</a>
        <a href="#">Privacy Policy</a>
      </div>
    </div>
  </div>
</footer>

{{-- FLOATING CART PANEL --}}
@php $globalCartItems = session('cart', []); $globalCartTotal = array_sum(array_map(fn($i)=>$i['harga']*$i['qty'], $globalCartItems)); @endphp
<div class="floating-cart-wrapper" x-data="{ open: {{ session('cart_open', 'false') }} }">
  <!-- The toggle button -->
  <button @click="open = !open" class="floating-cart-btn" aria-label="Toggle Cart">
    🛒
    @if(count($globalCartItems) > 0)
      <span class="bubble">{{ array_sum(array_column($globalCartItems,'qty')) }}</span>
    @endif
  </button>

  <!-- The sliding panel -->
  <div class="floating-cart-panel" :class="{ 'open': open }">
    <div class="cart-panel-header">
      <h4>Keranjang Belanja</h4>
      <button @click="open = false" class="cart-close">✕</button>
    </div>
    
    <div class="cart-panel-body">
      @if(count($globalCartItems) > 0)
        @foreach($globalCartItems as $key => $item)
          <div class="cart-item">
            <div class="cart-item-info">
              <span class="cart-item-name">{{ $item['emoji'] }} {{ $item['nama'] }} @if($item['qty']>1)(x{{ $item['qty'] }})@endif</span>
              <span class="cart-item-price">Rp {{ number_format($item['harga']*$item['qty'],0,',','.') }}</span>
            </div>
            <form method="POST" action="{{ route('cart.remove') }}" class="cart-remove-form">
              @csrf 
              <input type="hidden" name="produk_id" value="{{ $item['id'] }}">
              <!-- Hack to keep cart open after deletion -->
              <input type="hidden" name="keep_open" value="1">
              <button type="submit" class="cart-item-remove" title="Hapus">✕</button>
            </form>
          </div>
        @endforeach
      @else
        <div class="cart-empty">
          <p>Keranjang masih kosong.</p>
        </div>
      @endif
    </div>

    @if(count($globalCartItems) > 0)
      <div class="cart-panel-footer">
        <div class="cart-panel-total">
          <span>Total:</span>
          <strong>Rp {{ number_format($globalCartTotal,0,',','.') }}</strong>
        </div>
        <form method="POST" action="{{ route('cart.checkout') }}" class="checkout-form">
          @csrf
          <button type="submit" class="btn-checkout-telegram">Checkout ke Telegram →</button>
        </form>
      </div>
    @endif
  </div>
</div>

<div class="toast" id="toast"></div>

<!-- Alpine.js is needed for state management x-data -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>

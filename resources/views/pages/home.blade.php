@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

{{-- HERO CORPORATE --}}
<section class="hero-corporate" id="home">
  <div class="hero-corporate-bg">
    <!-- Optional real image background instead of abstract colors to match corporate vibe -->
    <div class="hero-corporate-overlay"></div>
  </div>
  <div class="container hero-container-corp">
    <div class="hero-corporate-content">
      <div class="hero-corporate-badge">
        <span class="badge-dot"></span>
        {{ $settings['hima_nama'] ?? 'Himpunan Mahasiswa Informatika' }}
      </div>
      <h1 class="hero-corporate-title">
        Pioneering Progress,<br>
        Building the Digital Future
      </h1>
      <p class="hero-corporate-desc">
        A Progressive Community Partner Enriching Lives for a Sustainable Digital Future, Berinovasi Tanpa Batas.
      </p>
      <div class="hero-corporate-cta">
        <a href="{{ route('kegiatan.index') }}" class="btn-primary">Discover Programs</a>
        <a href="{{ route('marketplace.index') }}" class="btn-outline btn-outline-white">Marketplace</a>
      </div>
    </div>
  </div>
</section>

{{-- PENGUMUMAN CAROUSEL (LATEST UPDATES MOVED UP) --}}
@if(isset($pengumuman) && $pengumuman->count() > 0)
<section class="section latest-updates-section">
  <div class="container">
    <div class="section-header-left">
      <h2>Latest Updates</h2>
      <a href="{{ route('pengumuman.index') }}" class="link-arrow">View All Updates →</a>
    </div>
    <div class="announcement-carousel-wrapper corporate-carousel">
      <div class="announcement-carousel" id="announcementCarousel">
        @foreach($pengumuman as $index => $p)
          <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">
            <div class="carousel-bg" style="background-image: url('{{ $p->gambar_url ?? 'https://images.unsplash.com/photo-1540317580384-e5d43616b9aa?q=80&w=1200' }}');"></div>
            <div class="carousel-content corporate-carousel-content">
              <span class="badge badge-corporate">Top Update</span>
              <h3>{{ $p->judul }}</h3>
              <p>{{ Str::limit($p->deskripsi, 100) }}</p>
              @if($p->link_tujuan && $p->link_tujuan !== '#')
                <a href="{{ $p->link_tujuan }}" class="btn-primary btn-sm">Read More</a>
              @endif
            </div>
          </div>
        @endforeach
      </div>
      
      @if($pengumuman->count() > 1)
        <div class="carousel-controls-corporate">
          <button class="carousel-control prev" aria-label="Previous">❮</button>
          <button class="carousel-control next" aria-label="Next">❯</button>
        </div>
        <div class="carousel-indicators">
          @foreach($pengumuman as $index => $p)
            <span class="indicator {{ $index === 0 ? 'active' : '' }}" data-target="{{ $index }}"></span>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</section>
@endif

{{-- FEATURED KEGIATAN --}}
@if($kegiatan->count())
<section class="section kegiatan-preview">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Program Unggulan</span>
      <h2>Kegiatan Terkini</h2>
      <p>Aktivitas dan program yang bisa kamu ikuti bersama HIMA IF</p>
    </div>
    <div class="program-grid">
      @foreach($kegiatan as $item)
      <div class="program-card {{ $item->featured ? 'featured' : '' }}">
        @if($item->featured)
          <div class="program-badge">Featured</div>
        @endif
        <div class="program-img">
          <div class="program-emoji">{{ $item->emoji }}</div>
        </div>
        <div class="program-body">
          <span class="program-tag">{{ ucfirst($item->kategori) }}</span>
          <h4>{{ $item->nama }}</h4>
          <p>{{ Str::limit($item->deskripsi, 100) }}</p>
          <div class="program-meta">
            @if($item->jadwal)<span>📅 {{ $item->jadwal }}</span>@endif
            @if($item->peserta)<span>👥 {{ $item->peserta }}</span>@endif
          </div>
        </div>
        <a href="{{ route('kegiatan.show', $item->slug) }}" class="program-arrow">→</a>
      </div>
      @endforeach
    </div>
    <div class="section-cta">
      <a href="{{ route('kegiatan.index') }}" class="btn-outline">Lihat Semua Program →</a>
    </div>
  </div>
</section>
@endif

{{-- FEATURED PRODUK --}}
@if($produk->count())
<section class="section marketplace-preview">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">HIMA Store</span>
      <h2>Produk Pilihan</h2>
      <p>Merchandise eksklusif dan produk digital karya HIMA IF</p>
    </div>
    <div class="market-grid">
      @foreach($produk as $item)
      <div class="market-card">
        <div class="market-img">
          <div class="market-emoji">{{ $item->emoji }}</div>
          @if($item->is_new)<div class="market-badge-new">New</div>@endif
        </div>
        <div class="market-info">
          <h4>{{ $item->nama }}</h4>
          <p>{{ Str::limit($item->deskripsi, 70) }}</p>
          <div class="market-price">
            <span class="price">{{ $item->harga_format }}</span>
            <form method="POST" action="{{ route('cart.add') }}" style="display:inline">
              @csrf
              <input type="hidden" name="produk_id" value="{{ $item->id }}">
              <button type="submit" class="btn-cart">+ Keranjang</button>
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="section-cta">
      <a href="{{ route('marketplace.index') }}" class="btn-outline">Lihat Semua Produk →</a>
    </div>
  </div>
</section>
@endif

{{-- GALERI PREVIEW --}}
@if($galeri->count())
<section class="section galeri-preview">
  <div class="container">
    <div class="section-header">
      <span class="section-tag">Momen Kami</span>
      <h2>Galeri Terbaru</h2>
      <p>Dokumentasi perjalanan dan kenangan bersama HIMA IF</p>
    </div>
    <div class="galeri-grid">
      @foreach($galeri as $i => $item)
      <div class="gal-item {{ $i === 0 || $i === 4 ? 'large' : '' }}" data-gal-cat="{{ $item->kategori }}">
        <div class="gal-placeholder">{{ $item->emoji }}</div>
        <div class="gal-overlay">
          <span>{{ $item->judul }}</span>
          <small>{{ ucfirst($item->kategori) }}</small>
        </div>
      </div>
      @endforeach
    </div>
    <div class="section-cta">
      <a href="{{ route('galeri.index') }}" class="btn-outline">Lihat Semua Foto →</a>
    </div>
  </div>
</section>
@endif


{{-- SOSMED BANNER --}}
<section class="section sosmed-section">
  <div class="container">
    <div class="sosmed-banner">
      <div class="sosmed-text">
        <span class="section-tag">Ikuti Kami</span>
        <h3>Tetap Terhubung dengan HIMA IF</h3>
        <p>Dapatkan update kegiatan, info lomba, dan konten inspiratif di media sosial kami</p>
      </div>
      <div class="sosmed-cards">
        <a href="{{ $settings['instagram_url'] ?? '#' }}" target="_blank" class="sosmed-card instagram">
          <div class="sosmed-icon">📷</div>
          <div>
            <span class="sosmed-name">Instagram</span>
            <span class="sosmed-handle">@hima.if</span>
          </div>
          <span class="sosmed-follow">Follow →</span>
        </a>
        <a href="{{ $settings['tiktok_url'] ?? '#' }}" target="_blank" class="sosmed-card tiktok">
          <div class="sosmed-icon">🎵</div>
          <div>
            <span class="sosmed-name">TikTok</span>
            <span class="sosmed-handle">@hima.if</span>
          </div>
          <span class="sosmed-follow">Follow →</span>
        </a>
        <a href="{{ $settings['youtube_url'] ?? '#' }}" target="_blank" class="sosmed-card youtube">
          <div class="sosmed-icon">▶</div>
          <div>
            <span class="sosmed-name">YouTube</span>
            <span class="sosmed-handle">HIMA Informatika</span>
          </div>
          <span class="sosmed-follow">Subscribe →</span>
        </a>
      </div>
    </div>
  </div>
</section>

@endsection

{{-- resources/views/pages/pengumuman.blade.php --}}
@extends('layouts.app')
@section('title', 'Pengumuman')
@section('nav_pengumuman', 'active')

@section('content')
<div class="page-hero">
  <div class="container text-center">
    <h1 class="page-title fade-up">Pengumuman & Berita</h1>
    <p class="page-subtitle fade-up" style="animation-delay: 0.1s">Informasi terbaru, lomba, dan pemberitahuan penting seputar HIMA Informatika.</p>
  </div>
</div>

<section class="section">
  <div class="container">
    @if($pengumuman->isEmpty())
      <div class="empty-state">
        <div class="empty-icon">📢</div>
        <h3>Belum Ada Pengumuman</h3>
        <p>Akan segera ada informasi menarik. Pantau terus ya!</p>
      </div>
    @else
      <div class="grid grid-3">
        @foreach($pengumuman as $p)
        <div class="card reveal" style="display: flex; flex-direction: column; justify-content: space-between;">
          @if($p->gambar_url)
            <img src="{{ $p->gambar_url }}" alt="{{ $p->judul }}" style="width: 100%; height: 200px; object-fit: cover; border-radius: var(--radius) var(--radius) 0 0;">
          @endif
          <div style="padding: 20px;">
            <div style="font-size: 0.8rem; color: var(--accent); margin-bottom: 8px;">{{ \Carbon\Carbon::parse($p->created_at)->translatedFormat('d F Y') }}</div>
            <h3 style="margin-bottom: 10px; font-size: 1.25rem;">{{ $p->judul }}</h3>
            <p style="color: var(--text-light); font-size: 0.95rem; margin-bottom: 15px; line-height: 1.5;">{{ Str::limit($p->deskripsi, 120) }}</p>
            @if($p->link_tujuan && $p->link_tujuan !== '#')
              <a href="{{ $p->link_tujuan }}" class="btn-primary" style="width: 100%; text-align: center;" target="_blank">Selengkapnya →</a>
            @endif
          </div>
        </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection

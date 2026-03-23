{{-- resources/views/pages/kegiatan-detail.blade.php --}}
@extends('layouts.app')
@section('title', $kegiatan->nama)
@section('nav_kegiatan','active-nav')
@section('content')

<div class="page-hero">
  <div class="container">
    <a href="{{ route('kegiatan.index') }}" style="color:var(--text-muted);font-size:.85rem;font-family:var(--font-mono)">← Kembali ke Program</a>
    <div style="font-size:3.5rem;margin:16px 0 8px">{{ $kegiatan->emoji }}</div>
    <span class="section-tag">{{ ucfirst($kegiatan->kategori) }}</span>
    <h1>{{ $kegiatan->nama }}</h1>
    <div style="display:flex;gap:16px;margin-top:12px;flex-wrap:wrap">
      @if($kegiatan->jadwal)
      <span style="font-size:.85rem;color:var(--text-muted);font-family:var(--font-mono)">📅 {{ $kegiatan->jadwal }}</span>
      @endif
      @if($kegiatan->peserta)
      <span style="font-size:.85rem;color:var(--text-muted);font-family:var(--font-mono)">👥 {{ $kegiatan->peserta }}</span>
      @endif
    </div>
  </div>
</div>

<section class="section">
  <div class="container" style="max-width:860px">
    <div class="vm-card" style="margin-bottom:40px">
      <p style="font-size:1.05rem;line-height:1.8;color:var(--text-secondary)">{{ $kegiatan->deskripsi }}</p>
    </div>

    @if($related->count())
    <h3 style="font-family:var(--font-display);font-size:1.2rem;font-weight:700;margin-bottom:20px">Program Terkait</h3>
    <div class="program-grid">
      @foreach($related as $item)
      <div class="program-card">
        <div class="program-img"><div class="program-emoji">{{ $item->emoji }}</div></div>
        <div class="program-body">
          <span class="program-tag">{{ ucfirst($item->kategori) }}</span>
          <h4>{{ $item->nama }}</h4>
          <p>{{ Str::limit($item->deskripsi, 90) }}</p>
        </div>
        <a href="{{ route('kegiatan.show', $item->slug) }}" class="program-arrow">→</a>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>
@endsection

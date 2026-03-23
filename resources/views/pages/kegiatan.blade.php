{{-- resources/views/pages/kegiatan.blade.php --}}
@extends('layouts.app')
@section('title','Program & Kegiatan')
@section('nav_kegiatan','active-nav')
@section('content')
<div class="page-hero">
  <div class="container">
    <span class="section-tag">Aktivitas</span>
    <h1>Kegiatan &amp; Program</h1>
    <p>Rangkaian program unggulan yang dirancang untuk mengakselerasi potensimu</p>
  </div>
</div>
<section class="section">
  <div class="container">
    <div class="filter-tabs">
      <a href="{{ route('kegiatan.index') }}" class="filter-btn {{ !request('kategori') ? 'active' : '' }}">Semua</a>
      <a href="{{ route('kegiatan.index', ['kategori'=>'akademik']) }}" class="filter-btn {{ request('kategori')==='akademik' ? 'active' : '' }}">Akademik</a>
      <a href="{{ route('kegiatan.index', ['kategori'=>'kreativitas']) }}" class="filter-btn {{ request('kategori')==='kreativitas' ? 'active' : '' }}">Kreativitas</a>
      <a href="{{ route('kegiatan.index', ['kategori'=>'sosial']) }}" class="filter-btn {{ request('kategori')==='sosial' ? 'active' : '' }}">Sosial</a>
    </div>
    <div class="program-grid">
      @forelse($kegiatan as $item)
      <div class="program-card {{ $item->featured ? 'featured' : '' }}">
        @if($item->featured)<div class="program-badge">Featured</div>@endif
        <div class="program-img"><div class="program-emoji">{{ $item->emoji }}</div></div>
        <div class="program-body">
          <span class="program-tag">{{ ucfirst($item->kategori) }}</span>
          <h4>{{ $item->nama }}</h4>
          <p>{{ Str::limit($item->deskripsi, 110) }}</p>
          <div class="program-meta">
            @if($item->jadwal)<span>📅 {{ $item->jadwal }}</span>@endif
            @if($item->peserta)<span>👥 {{ $item->peserta }}</span>@endif
          </div>
        </div>
        <a href="{{ route('kegiatan.show', $item->slug) }}" class="program-arrow">→</a>
      </div>
      @empty
      <div class="empty-state"><p>Belum ada kegiatan dalam kategori ini.</p></div>
      @endforelse
    </div>
    <div class="pagination-wrap">{{ $kegiatan->links() }}</div>
  </div>
</section>
@endsection

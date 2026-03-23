{{-- resources/views/pages/galeri.blade.php --}}
@extends('layouts.app')
@section('title','Galeri')
@section('nav_galeri','active-nav')
@section('content')
<div class="page-hero">
  <div class="container">
    <span class="section-tag">Momen Kami</span>
    <h1>Galeri</h1>
    <p>Dokumentasi perjalanan dan kenangan bersama HIMA Informatika</p>
  </div>
</div>
<section class="section">
  <div class="container">
    <div class="galeri-filter">
      <a href="{{ route('galeri.index') }}" class="gal-btn {{ !request('kategori') ? 'active' : '' }}">Semua</a>
      <a href="{{ route('galeri.index',['kategori'=>'event']) }}" class="gal-btn {{ request('kategori')==='event' ? 'active' : '' }}">Event</a>
      <a href="{{ route('galeri.index',['kategori'=>'kegiatan']) }}" class="gal-btn {{ request('kategori')==='kegiatan' ? 'active' : '' }}">Kegiatan</a>
      <a href="{{ route('galeri.index',['kategori'=>'prestasi']) }}" class="gal-btn {{ request('kategori')==='prestasi' ? 'active' : '' }}">Prestasi</a>
    </div>
    <div class="galeri-grid">
      @forelse($galeri as $i => $item)
      <div class="gal-item {{ $i % 5 === 0 ? 'large' : '' }}" onclick="openLightbox('{{ $item->emoji }} {{ $item->judul }}', '{{ $item->deskripsi }}')">
        <div class="gal-placeholder">{{ $item->emoji }}</div>
        <div class="gal-overlay">
          <span>{{ $item->judul }}</span>
          <small>{{ ucfirst($item->kategori) }}{{ $item->tanggal ? ' · '.$item->tanggal->format('d M Y') : '' }}</small>
        </div>
      </div>
      @empty
      <div class="empty-state"><p>Belum ada foto di galeri.</p></div>
      @endforelse
    </div>
    <div class="pagination-wrap">{{ $galeri->links() }}</div>
  </div>
</section>

{{-- Lightbox --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
  <button class="lightbox-close" onclick="closeLightbox()">✕</button>
  <div class="lightbox-content" onclick="event.stopPropagation()">
    <div class="lightbox-img" id="lightboxImg"></div>
    <div class="lightbox-caption" id="lightboxCaption"></div>
  </div>
</div>
@endsection
@push('scripts')
<script>
function openLightbox(title, desc) {
  document.getElementById('lightboxImg').textContent = title.split(' ')[0];
  document.getElementById('lightboxCaption').innerHTML = '<strong>' + title + '</strong>' + (desc ? '<br><small style="color:#aaa">' + desc + '</small>' : '');
  document.getElementById('lightbox').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeLightbox() {
  document.getElementById('lightbox').classList.remove('open');
  document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if(e.key==='Escape') closeLightbox(); });
</script>
@endpush

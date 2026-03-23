{{-- resources/views/pages/produk-detail.blade.php --}}
@extends('layouts.app')
@section('title', $produk->nama)
@section('nav_marketplace','active-nav')
@section('content')

<div class="page-hero">
  <div class="container">
    <a href="{{ route('marketplace.index') }}" style="color:var(--text-muted);font-size:.85rem;font-family:var(--font-mono)">← Kembali ke Marketplace</a>
    <div style="font-size:4rem;margin:16px 0 8px">{{ $produk->emoji }}</div>
    <span class="section-tag">{{ ucfirst($produk->kategori) }}</span>
    <h1>{{ $produk->nama }}</h1>
    <div style="display:flex;align-items:center;gap:16px;margin-top:12px;flex-wrap:wrap">
      <span style="font-family:var(--font-display);font-size:1.6rem;font-weight:800;color:var(--accent)">{{ $produk->harga_format }}</span>
      @if($produk->is_new)<span class="market-badge-new" style="position:static">New</span>@endif
      @if($produk->stok > 0)
      <span style="font-size:.82rem;color:#4ade80;font-family:var(--font-mono)">✓ Stok tersedia ({{ $produk->stok }})</span>
      @else
      <span style="font-size:.82rem;color:#ef4444;font-family:var(--font-mono)">✗ Habis</span>
      @endif
    </div>
  </div>
</div>

<section class="section">
  <div class="container" style="max-width:860px">
    <div class="vm-card" style="margin-bottom:32px">
      <p style="font-size:1.05rem;line-height:1.8;color:var(--text-secondary)">{{ $produk->deskripsi }}</p>
      @if($produk->tersedia && $produk->stok > 0)
      <form method="POST" action="{{ route('cart.add') }}" style="margin-top:24px">
        @csrf
        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
        <button type="submit" class="btn-primary">🛒 Tambah ke Keranjang</button>
      </form>
      @endif
    </div>

    @if($related->count())
    <h3 style="font-family:var(--font-display);font-size:1.2rem;font-weight:700;margin-bottom:20px">Produk Lainnya</h3>
    <div class="market-grid">
      @foreach($related as $item)
      <div class="market-card">
        <div class="market-img"><div class="market-emoji">{{ $item->emoji }}</div></div>
        <div class="market-info">
          <h4>{{ $item->nama }}</h4>
          <p>{{ Str::limit($item->deskripsi,70) }}</p>
          <div class="market-price">
            <span class="price">{{ $item->harga_format }}</span>
            <a href="{{ route('marketplace.show',$item->slug) }}" class="btn-cart">Lihat →</a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</section>
@endsection

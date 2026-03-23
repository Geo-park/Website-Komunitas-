{{-- resources/views/pages/marketplace.blade.php --}}
@extends('layouts.app')
@section('title','HIMA Store — Marketplace')
@section('nav_marketplace','active-nav')
@section('content')
<div class="page-hero">
  <div class="container">
    <span class="section-tag">Marketplace</span>
    <h1>HIMA Store</h1>
    <p>Merchandise eksklusif dan produk digital karya anggota HIMA Informatika</p>
  </div>
</div>
<section class="section">
  <div class="container">
    {{-- Note: Cart features have been moved to the floating component in layouts/app.blade.php --}}

    <div class="market-tabs">
      <a href="{{ route('marketplace.index') }}" class="market-tab {{ !request('kategori') ? 'active' : '' }}">Semua</a>
      <a href="{{ route('marketplace.index',['kategori'=>'merchandise']) }}" class="market-tab {{ request('kategori')==='merchandise' ? 'active' : '' }}">Merchandise</a>
      <a href="{{ route('marketplace.index',['kategori'=>'digital']) }}" class="market-tab {{ request('kategori')==='digital' ? 'active' : '' }}">Produk Digital</a>
      <a href="{{ route('marketplace.index',['kategori'=>'jasa']) }}" class="market-tab {{ request('kategori')==='jasa' ? 'active' : '' }}">Jasa</a>
    </div>

    <div class="market-grid">
      @forelse($produk as $item)
      <div class="market-card">
        <div class="market-img">
          <div class="market-emoji">{{ $item->emoji }}</div>
          @if($item->is_new)<div class="market-badge-new">New</div>@endif
        </div>
        <div class="market-info">
          <h4>{{ $item->nama }}</h4>
          <p>{{ Str::limit($item->deskripsi,80) }}</p>
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
      @empty
      <div class="empty-state"><p>Belum ada produk tersedia.</p></div>
      @endforelse
    </div>
    <div class="pagination-wrap">{{ $produk->links() }}</div>
  </div>
</section>
@endsection

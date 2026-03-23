@extends('layouts.admin')
@section('title', isset($produk->id) ? 'Edit Produk' : 'Tambah Produk')
@section('content')
<div class="admin-form-card">
  <h3>{{ isset($produk->id) ? 'Edit Produk' : 'Tambah Produk Baru' }}</h3>
  <form method="POST" action="{{ isset($produk->id) ? route('admin.produk.update',$produk) : route('admin.produk.store') }}">
    @csrf
    @if(isset($produk->id)) @method('PUT') @endif

    <label class="admin-label">Nama Produk *</label>
    <input type="text" name="nama" class="admin-input" value="{{ old('nama',$produk->nama) }}" required>

    <label class="admin-label">Kategori *</label>
    <select name="kategori" class="admin-input" required>
      <option value="merchandise" {{ old('kategori',$produk->kategori)==='merchandise'?'selected':'' }}>Merchandise</option>
      <option value="digital" {{ old('kategori',$produk->kategori)==='digital'?'selected':'' }}>Produk Digital</option>
      <option value="jasa" {{ old('kategori',$produk->kategori)==='jasa'?'selected':'' }}>Jasa</option>
    </select>

    <label class="admin-label">Deskripsi *</label>
    <textarea name="deskripsi" class="admin-input" rows="3" required>{{ old('deskripsi',$produk->deskripsi) }}</textarea>

    <div class="form-row">
      <div style="flex:1">
        <label class="admin-label">Harga (Rp) *</label>
        <input type="number" name="harga" class="admin-input" value="{{ old('harga',$produk->harga) }}" min="0" required>
      </div>
      <div style="flex:1">
        <label class="admin-label">Stok *</label>
        <input type="number" name="stok" class="admin-input" value="{{ old('stok',$produk->stok ?? 0) }}" min="0" required>
      </div>
    </div>

    <label class="admin-label">Emoji Icon</label>
    <input type="text" name="emoji" class="admin-input" value="{{ old('emoji',$produk->emoji ?? '📦') }}" maxlength="10" placeholder="📦">

    <div class="form-row">
      <label class="admin-check">
        <input type="checkbox" name="is_new" value="1" {{ old('is_new',$produk->is_new) ? 'checked' : '' }}>
        <span>Tampilkan badge "New"</span>
      </label>
      <label class="admin-check">
        <input type="checkbox" name="tersedia" value="1" {{ old('tersedia', $produk->tersedia ?? true) ? 'checked' : '' }}>
        <span>Tersedia dijual</span>
      </label>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-primary">{{ isset($produk->id) ? 'Simpan Perubahan' : 'Tambah Produk' }}</button>
      <a href="{{ route('admin.dashboard') }}" class="btn-outline">Batal</a>
    </div>
  </form>
</div>
@endsection

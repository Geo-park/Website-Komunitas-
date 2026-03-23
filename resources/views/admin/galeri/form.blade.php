@extends('layouts.admin')
@section('title', isset($galeri->id) ? 'Edit Galeri' : 'Tambah Galeri')
@section('content')
<div class="admin-form-card">
  <h3>{{ isset($galeri->id) ? 'Edit Item Galeri' : 'Tambah Item Galeri Baru' }}</h3>
  <form method="POST" action="{{ isset($galeri->id) ? route('admin.galeri.update',$galeri) : route('admin.galeri.store') }}">
    @csrf
    @if(isset($galeri->id)) @method('PUT') @endif

    <label class="admin-label">Judul Foto/Dokumentasi *</label>
    <input type="text" name="judul" class="admin-input" value="{{ old('judul',$galeri->judul) }}" required>

    <label class="admin-label">Kategori *</label>
    <select name="kategori" class="admin-input" required>
      <option value="event" {{ old('kategori',$galeri->kategori)==='event'?'selected':'' }}>Event</option>
      <option value="kegiatan" {{ old('kategori',$galeri->kategori)==='kegiatan'?'selected':'' }}>Kegiatan</option>
      <option value="prestasi" {{ old('kategori',$galeri->kategori)==='prestasi'?'selected':'' }}>Prestasi</option>
    </select>

    <label class="admin-label">Deskripsi</label>
    <textarea name="deskripsi" class="admin-input" rows="3">{{ old('deskripsi',$galeri->deskripsi) }}</textarea>

    <label class="admin-label">Emoji Placeholder</label>
    <input type="text" name="emoji" class="admin-input" value="{{ old('emoji',$galeri->emoji ?? '📷') }}" maxlength="10" placeholder="📷">

    <label class="admin-label">Tanggal</label>
    <input type="date" name="tanggal" class="admin-input" value="{{ old('tanggal', optional($galeri->tanggal)->format('Y-m-d')) }}">

    <label class="admin-check">
      <input type="checkbox" name="tampil" value="1" {{ old('tampil', $galeri->tampil ?? true) ? 'checked' : '' }}>
      <span>Tampilkan di galeri publik</span>
    </label>

    <div class="form-actions" style="margin-top:20px">
      <button type="submit" class="btn-primary">{{ isset($galeri->id) ? 'Simpan Perubahan' : 'Tambah ke Galeri' }}</button>
      <a href="{{ route('admin.dashboard') }}" class="btn-outline">Batal</a>
    </div>
  </form>
</div>
@endsection

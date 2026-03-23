{{-- resources/views/admin/pengumuman/form.blade.php --}}
@extends('layouts.admin')
@section('title', $pengumuman->exists ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')
<div class="admin-header">
  <h2>{{ $pengumuman->exists ? 'Edit Pengumuman' : 'Tambah Pengumuman' }}</h2>
  <a href="{{ route('admin.dashboard') }}" class="btn-secondary">Kembali</a>
</div>

<div class="admin-form-card">
  <form action="{{ $pengumuman->exists ? route('admin.pengumuman.update', $pengumuman) : route('admin.pengumuman.store') }}" method="POST">
    @csrf
    @if($pengumuman->exists) @method('PUT') @endif

    <div class="form-group">
      <label class="admin-label">Judul Pengumuman</label>
      <input type="text" name="judul" class="admin-input" value="{{ old('judul', $pengumuman->judul) }}" required>
    </div>

    <div class="form-group">
      <label class="admin-label">Deskripsi Lengkap</label>
      <textarea name="deskripsi" class="admin-input" rows="5" required>{{ old('deskripsi', $pengumuman->deskripsi) }}</textarea>
    </div>

    <div class="form-group">
      <label class="admin-label">URL Gambar (Opsional)</label>
      <input type="url" name="gambar_url" class="admin-input" value="{{ old('gambar_url', $pengumuman->gambar_url) }}" placeholder="https://...">
    </div>

    <div class="form-group">
      <label class="admin-label">Link Tujuan Tombol (Opsional)</label>
      <input type="text" name="link_tujuan" class="admin-input" value="{{ old('link_tujuan', $pengumuman->link_tujuan) }}" placeholder="https://... atau #">
    </div>

    <div class="form-group" style="margin-top: 20px;">
      <label class="admin-label" style="display:flex; align-items:center; gap:10px;">
        <input type="checkbox" name="is_aktif" value="1" {{ old('is_aktif', $pengumuman->is_aktif ?? true) ? 'checked' : '' }}>
        Tampilkan Pengumuman (Aktif)
      </label>
    </div>

    <div style="margin-top: 30px;">
      <button type="submit" class="btn-primary">Simpan Pengumuman</button>
    </div>
  </form>
</div>
@endsection

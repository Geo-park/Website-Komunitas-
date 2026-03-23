@extends('layouts.admin')
@section('title', isset($kegiatan->id) ? 'Edit Kegiatan' : 'Tambah Kegiatan')
@section('content')
<div class="admin-form-card">
  <h3>{{ isset($kegiatan->id) ? 'Edit Kegiatan' : 'Tambah Kegiatan Baru' }}</h3>
  <form method="POST" action="{{ isset($kegiatan->id) ? route('admin.kegiatan.update',$kegiatan) : route('admin.kegiatan.store') }}">
    @csrf
    @if(isset($kegiatan->id)) @method('PUT') @endif

    <label class="admin-label">Nama Kegiatan *</label>
    <input type="text" name="nama" class="admin-input" value="{{ old('nama',$kegiatan->nama) }}" required>

    <label class="admin-label">Kategori *</label>
    <select name="kategori" class="admin-input" required>
      <option value="akademik" {{ old('kategori',$kegiatan->kategori)==='akademik'?'selected':'' }}>Akademik</option>
      <option value="kreativitas" {{ old('kategori',$kegiatan->kategori)==='kreativitas'?'selected':'' }}>Kreativitas</option>
      <option value="sosial" {{ old('kategori',$kegiatan->kategori)==='sosial'?'selected':'' }}>Sosial</option>
    </select>

    <label class="admin-label">Deskripsi *</label>
    <textarea name="deskripsi" class="admin-input" rows="4" required>{{ old('deskripsi',$kegiatan->deskripsi) }}</textarea>

    <label class="admin-label">Jadwal</label>
    <input type="text" name="jadwal" class="admin-input" value="{{ old('jadwal',$kegiatan->jadwal) }}" placeholder="Contoh: Setiap Sabtu">

    <label class="admin-label">Estimasi Peserta</label>
    <input type="text" name="peserta" class="admin-input" value="{{ old('peserta',$kegiatan->peserta) }}" placeholder="Contoh: 50+ Peserta">

    <label class="admin-label">Emoji Icon</label>
    <input type="text" name="emoji" class="admin-input" value="{{ old('emoji',$kegiatan->emoji ?? '📚') }}" maxlength="10" placeholder="📚">

    <div class="form-row">
      <label class="admin-check">
        <input type="checkbox" name="featured" value="1" {{ old('featured',$kegiatan->featured) ? 'checked' : '' }}>
        <span>Featured (tampil di beranda)</span>
      </label>
      <label class="admin-check">
        <input type="checkbox" name="aktif" value="1" {{ old('aktif', $kegiatan->aktif ?? true) ? 'checked' : '' }}>
        <span>Aktif</span>
      </label>
    </div>

    <div class="form-actions">
      <button type="submit" class="btn-primary">{{ isset($kegiatan->id) ? 'Simpan Perubahan' : 'Tambah Kegiatan' }}</button>
      <a href="{{ route('admin.dashboard') }}" class="btn-outline">Batal</a>
    </div>
  </form>
</div>
@endsection

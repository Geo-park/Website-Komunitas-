@extends('layouts.admin')
@section('title', isset($pengurus->id) ? 'Edit Pengurus' : 'Tambah Pengurus')
@section('content')
<div class="admin-form-card">
  <h3>{{ isset($pengurus->id) ? 'Edit Data Pengurus' : 'Tambah Pengurus Baru' }}</h3>
  <form method="POST" action="{{ isset($pengurus->id) ? route('admin.struktur.update',$pengurus) : route('admin.struktur.store') }}">
    @csrf
    @if(isset($pengurus->id)) @method('PUT') @endif

    <div class="form-row">
      <div style="flex:2">
        <label class="admin-label">Nama Lengkap *</label>
        <input type="text" name="nama" class="admin-input" value="{{ old('nama',$pengurus->nama) }}" required>
      </div>
      <div style="flex:1">
        <label class="admin-label">NIM *</label>
        <input type="text" name="nim" class="admin-input" value="{{ old('nim',$pengurus->nim) }}" required>
      </div>
    </div>

    <label class="admin-label">Jabatan *</label>
    <input type="text" name="jabatan" class="admin-input" value="{{ old('jabatan',$pengurus->jabatan) }}" required placeholder="Contoh: Ketua Umum">

    <div class="form-row">
      <div style="flex:1">
        <label class="admin-label">Level *</label>
        <select name="level" class="admin-input" required>
          @foreach(['ketua','wakil','sekretaris','bendahara','divisi','anggota'] as $level)
          <option value="{{ $level }}" {{ old('level',$pengurus->level)===$level?'selected':'' }}>{{ ucfirst($level) }}</option>
          @endforeach
        </select>
      </div>
      <div style="flex:1">
        <label class="admin-label">Divisi (jika ada)</label>
        <input type="text" name="divisi" class="admin-input" value="{{ old('divisi',$pengurus->divisi) }}" placeholder="Akademik / IT / dll">
      </div>
    </div>

    <div class="form-row">
      <div style="flex:1">
        <label class="admin-label">Angkatan</label>
        <input type="text" name="angkatan" class="admin-input" value="{{ old('angkatan',$pengurus->angkatan) }}" placeholder="2022/2023">
      </div>
      <div style="flex:1">
        <label class="admin-label">Urutan Tampil</label>
        <input type="number" name="urutan" class="admin-input" value="{{ old('urutan',$pengurus->urutan ?? 0) }}" min="0">
      </div>
    </div>

    @if(isset($pengurus->id))
    <label class="admin-check">
      <input type="checkbox" name="aktif" value="1" {{ old('aktif', $pengurus->aktif ?? true) ? 'checked' : '' }}>
      <span>Pengurus Aktif</span>
    </label>
    @endif

    <div class="form-actions" style="margin-top:20px">
      <button type="submit" class="btn-primary">{{ isset($pengurus->id) ? 'Simpan Perubahan' : 'Tambah Pengurus' }}</button>
      <a href="{{ route('admin.dashboard') }}" class="btn-outline">Batal</a>
    </div>
  </form>
</div>
@endsection

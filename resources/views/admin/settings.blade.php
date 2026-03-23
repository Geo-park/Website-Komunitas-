{{-- resources/views/admin/settings.blade.php --}}
@extends('layouts.admin')
@section('title','Pengaturan')
@section('content')
<div class="admin-form-card">
  <h3>Pengaturan Website</h3>
  <form method="POST" action="{{ route('admin.settings.save') }}">
    @csrf
    <div class="form-section">
      <h4 class="form-section-title">🔗 Sosial Media</h4>
      <label class="admin-label">Instagram URL</label>
      <input type="url" name="instagram_url" class="admin-input" value="{{ $settings['instagram_url'] ?? '' }}" placeholder="https://instagram.com/hima.if">
      <label class="admin-label">TikTok URL</label>
      <input type="url" name="tiktok_url" class="admin-input" value="{{ $settings['tiktok_url'] ?? '' }}" placeholder="https://tiktok.com/@hima.if">
      <label class="admin-label">YouTube URL</label>
      <input type="url" name="youtube_url" class="admin-input" value="{{ $settings['youtube_url'] ?? '' }}" placeholder="https://youtube.com/@himainformatika">
      <label class="admin-label">Nomor WhatsApp (format: 628xx)</label>
      <input type="text" name="whatsapp_number" class="admin-input" value="{{ $settings['whatsapp_number'] ?? '' }}" placeholder="6281200000000">
    </div>
    <div class="form-section">
      <h4 class="form-section-title">🏛 Informasi Organisasi</h4>
      <label class="admin-label">Nama HIMA</label>
      <input type="text" name="hima_nama" class="admin-input" value="{{ $settings['hima_nama'] ?? 'HIMA Informatika' }}">
      <label class="admin-label">Universitas</label>
      <input type="text" name="hima_universitas" class="admin-input" value="{{ $settings['hima_universitas'] ?? '' }}">
      <label class="admin-label">Email</label>
      <input type="email" name="hima_email" class="admin-input" value="{{ $settings['hima_email'] ?? '' }}">
      <label class="admin-label">Alamat</label>
      <input type="text" name="hima_alamat" class="admin-input" value="{{ $settings['hima_alamat'] ?? '' }}">
    </div>
    <div class="form-section">
      <h4 class="form-section-title">◎ Visi</h4>
      <label class="admin-label">Teks Visi</label>
      <textarea name="visi" class="admin-input" rows="4">{{ $settings['visi'] ?? '' }}</textarea>
    </div>
    <div class="form-section">
      <h4 class="form-section-title">📢 Popup Pengumuman (Beranda)</h4>
      <label class="admin-label">Tampilkan Popup?</label>
      <select name="popup_show" class="admin-input">
        <option value="true" {{ ($settings['popup_show'] ?? 'true') === 'true' ? 'selected' : '' }}>Ya (Tampilkan)</option>
        <option value="false" {{ ($settings['popup_show'] ?? 'true') === 'false' ? 'selected' : '' }}>Tidak (Sembunyikan)</option>
      </select>
      <label class="admin-label mt-3">Judul Popup</label>
      <input type="text" name="popup_title" class="admin-input" value="{{ $settings['popup_title'] ?? '' }}" placeholder="Contoh: Info Lomba!">
      <label class="admin-label mt-3">URL Gambar (Opsional)</label>
      <input type="url" name="popup_image_url" class="admin-input" value="{{ $settings['popup_image_url'] ?? '' }}" placeholder="https:// ...">
      <label class="admin-label mt-3">Deskripsi</label>
      <textarea name="popup_description" class="admin-input" rows="3">{{ $settings['popup_description'] ?? '' }}</textarea>
      <label class="admin-label mt-3">Link Tujuan Tombol (Opsional)</label>
      <input type="text" name="popup_link" class="admin-input" value="{{ $settings['popup_link'] ?? '' }}" placeholder="https://... atau #">
    </div>
    <button type="submit" class="btn-primary mt-4">Simpan Semua Perubahan</button>
  </form>
</div>
@endsection


{{-- resources/views/admin/kegiatan/form.blade.php saved separately below --}}

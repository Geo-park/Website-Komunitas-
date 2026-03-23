@extends('layouts.admin')
@section('title','Dashboard')
@section('content')

<div class="dashboard-stats">
  <div class="stat-card">
    <div class="stat-card-icon">📅</div>
    <div class="stat-card-info">
      <span class="stat-card-num">{{ $stats['kegiatan'] }}</span>
      <span class="stat-card-label">Total Kegiatan</span>
    </div>
    <a href="{{ route('admin.kegiatan.create') }}" class="stat-card-action">+ Tambah</a>
  </div>
  <div class="stat-card">
    <div class="stat-card-icon">🛒</div>
    <div class="stat-card-info">
      <span class="stat-card-num">{{ $stats['produk'] }}</span>
      <span class="stat-card-label">Total Produk</span>
    </div>
    <a href="{{ route('admin.produk.create') }}" class="stat-card-action">+ Tambah</a>
  </div>
  <div class="stat-card">
    <div class="stat-card-icon">🖼</div>
    <div class="stat-card-info">
      <span class="stat-card-num">{{ $stats['galeri'] }}</span>
      <span class="stat-card-label">Total Galeri</span>
    </div>
    <a href="{{ route('admin.galeri.create') }}" class="stat-card-action">+ Tambah</a>
  </div>
  <div class="stat-card">
    <div class="stat-card-icon">👥</div>
    <div class="stat-card-info">
      <span class="stat-card-num">{{ $stats['pengurus'] }}</span>
      <span class="stat-card-label">Total Pengurus</span>
    </div>
    <a href="{{ route('admin.struktur.create') }}" class="stat-card-action">+ Tambah</a>
  </div>
  <div class="stat-card">
    <div class="stat-card-icon">📢</div>
    <div class="stat-card-info">
      <span class="stat-card-num">{{ $stats['pengumuman'] }}</span>
      <span class="stat-card-label">Pengumuman</span>
    </div>
    <a href="{{ route('admin.pengumuman.create') }}" class="stat-card-action">+ Tambah</a>
  </div>
</div>

<div class="dashboard-grid">
  {{-- Kegiatan --}}
  <div class="admin-table-card">
    <div class="table-card-header">
      <h3>Kegiatan Terbaru</h3>
      <a href="{{ route('admin.kegiatan.create') }}" class="btn-primary" style="padding:8px 16px;font-size:.82rem">+ Tambah</a>
    </div>
    <table class="admin-table">
      <thead><tr><th>Nama</th><th>Kategori</th><th>Featured</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($kegiatan as $item)
        <tr>
          <td><span class="t-emoji">{{ $item->emoji }}</span> {{ $item->nama }}</td>
          <td><span class="badge badge-{{ $item->kategori }}">{{ ucfirst($item->kategori) }}</span></td>
          <td>{{ $item->featured ? '✅' : '—' }}</td>
          <td class="table-actions">
            <a href="{{ route('admin.kegiatan.edit', $item) }}" class="action-btn edit">✏</a>
            <form method="POST" action="{{ route('admin.kegiatan.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Hapus kegiatan ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="action-btn delete">🗑</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center;color:var(--text-muted)">Belum ada kegiatan</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pengumuman --}}
  <div class="admin-table-card">
    <div class="table-card-header">
      <h3>Pengumuman</h3>
      <a href="{{ route('admin.pengumuman.create') }}" class="btn-primary" style="padding:8px 16px;font-size:.82rem">+ Tambah</a>
    </div>
    <table class="admin-table">
      <thead><tr><th>Judul</th><th>Status</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($pengumuman as $item)
        <tr>
          <td>{{ $item->judul }}</td>
          <td>{!! $item->is_aktif ? '<span class="badge" style="background:var(--success)">Aktif</span>' : '<span class="badge">Draft</span>' !!}</td>
          <td class="table-actions">
            <a href="{{ route('admin.pengumuman.edit', $item) }}" class="action-btn edit">✏</a>
            <form method="POST" action="{{ route('admin.pengumuman.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Hapus pengumuman ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="action-btn delete">🗑</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="3" style="text-align:center;color:var(--text-muted)">Belum ada pengumuman</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Produk --}}
  <div class="admin-table-card">
    <div class="table-card-header">
      <h3>Produk Terbaru</h3>
      <a href="{{ route('admin.produk.create') }}" class="btn-primary" style="padding:8px 16px;font-size:.82rem">+ Tambah</a>
    </div>
    <table class="admin-table">
      <thead><tr><th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($produk as $item)
        <tr>
          <td><span class="t-emoji">{{ $item->emoji }}</span> {{ $item->nama }}</td>
          <td style="color:var(--accent);font-weight:700">{{ $item->harga_format }}</td>
          <td>{{ $item->stok }}</td>
          <td class="table-actions">
            <a href="{{ route('admin.produk.edit', $item) }}" class="action-btn edit">✏</a>
            <form method="POST" action="{{ route('admin.produk.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Hapus produk ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="action-btn delete">🗑</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center;color:var(--text-muted)">Belum ada produk</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Galeri --}}
  <div class="admin-table-card">
    <div class="table-card-header">
      <h3>Galeri Terbaru</h3>
      <a href="{{ route('admin.galeri.create') }}" class="btn-primary" style="padding:8px 16px;font-size:.82rem">+ Tambah</a>
    </div>
    <table class="admin-table">
      <thead><tr><th>Judul</th><th>Kategori</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($galeri as $item)
        <tr>
          <td><span class="t-emoji">{{ $item->emoji }}</span> {{ $item->judul }}</td>
          <td><span class="badge badge-{{ $item->kategori }}">{{ ucfirst($item->kategori) }}</span></td>
          <td class="table-actions">
            <a href="{{ route('admin.galeri.edit', $item) }}" class="action-btn edit">✏</a>
            <form method="POST" action="{{ route('admin.galeri.destroy', $item) }}" style="display:inline" onsubmit="return confirm('Hapus item galeri ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="action-btn delete">🗑</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="3" style="text-align:center;color:var(--text-muted)">Belum ada galeri</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pengurus --}}
  <div class="admin-table-card">
    <div class="table-card-header">
      <h3>Pengurus</h3>
      <a href="{{ route('admin.struktur.create') }}" class="btn-primary" style="padding:8px 16px;font-size:.82rem">+ Tambah</a>
    </div>
    <table class="admin-table">
      <thead><tr><th>Nama</th><th>Jabatan</th><th>Level</th><th>Aksi</th></tr></thead>
      <tbody>
        @forelse($pengurus as $p)
        <tr>
          <td>{{ $p->nama }}</td>
          <td>{{ $p->jabatan }}</td>
          <td><span class="badge">{{ ucfirst($p->level) }}</span></td>
          <td class="table-actions">
            <a href="{{ route('admin.struktur.edit', $p) }}" class="action-btn edit">✏</a>
            <form method="POST" action="{{ route('admin.struktur.destroy', $p) }}" style="display:inline" onsubmit="return confirm('Hapus pengurus ini?')">
              @csrf @method('DELETE')
              <button type="submit" class="action-btn delete">🗑</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" style="text-align:center;color:var(--text-muted)">Belum ada pengurus</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection

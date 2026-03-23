{{-- resources/views/pages/struktur.blade.php --}}
@extends('layouts.app')
@section('title','Struktur Organisasi')
@section('nav_tentang','active-nav')
@section('content')
<div class="page-hero">
  <div class="container">
    <span class="section-tag">Tim Kami</span>
    <h1>Struktur Organisasi</h1>
    <p>Pengurus terpilih yang siap melayani dan bergerak bersama</p>
  </div>
</div>
<section class="section struktur">
  <div class="container">
    <div class="org-chart">
      {{-- Ketua --}}
      @if($ketua)
      <div class="org-level top-level">
        <div class="org-card ketua">
          <div class="org-avatar">{{ strtoupper(substr($ketua->nama,0,1)) }}</div>
          <div class="org-info">
            <h4>{{ $ketua->nama }}</h4>
            <span class="org-role">{{ $ketua->jabatan }}</span>
            <span class="org-nim">NIM: {{ $ketua->nim }}</span>
          </div>
        </div>
      </div>
      @endif

      {{-- Sekretaris & Bendahara --}}
      @if($inti->count())
      <div class="org-level mid-level">
        @foreach($inti as $p)
        <div class="org-card">
          <div class="org-avatar">{{ strtoupper(substr($p->nama,0,1)) }}</div>
          <div class="org-info">
            <h4>{{ $p->nama }}</h4>
            <span class="org-role">{{ $p->jabatan }}</span>
            <span class="org-nim">NIM: {{ $p->nim }}</span>
          </div>
        </div>
        @endforeach
      </div>
      @endif

      {{-- Divisi --}}
      @if($divisi->count())
      <div class="divisi-label">Divisi</div>
      <div class="org-level divisi-level">
        @php $divisiEmoji = ['Akademik'=>'📚','Kreatif'=>'🎨','Humas'=>'📢','IT'=>'💻','Sosmas'=>'🤝'] @endphp
        @foreach($divisi as $p)
        <div class="org-card divisi">
          <div class="divisi-icon">{{ $divisiEmoji[$p->divisi] ?? '⚙' }}</div>
          <h4>Divisi {{ $p->divisi }}</h4>
          <span class="org-role">{{ $p->nama }}</span>
          <span class="org-nim" style="font-size:.72rem;margin-top:2px">{{ $p->nim }}</span>
        </div>
        @endforeach
      </div>
      @endif
    </div>

    {{-- Anggota --}}
    @if($anggota->count())
    <div class="anggota-section">
      <h3 class="anggota-title">Seluruh Anggota Aktif</h3>
      <div class="anggota-grid">
        @foreach($anggota as $i => $a)
        <div class="anggota-card" style="--i:{{ $i+1 }}">
          <div class="anggota-avatar">{{ strtoupper(substr($a->nama,0,1)) }}</div>
          <span>{{ $a->nama }}</span>
          <small>{{ $a->nim }}</small>
        </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</section>
@endsection

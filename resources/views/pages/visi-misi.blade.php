{{-- resources/views/pages/visi-misi.blade.php --}}
@extends('layouts.app')
@section('title','Visi & Misi')
@section('nav_tentang','active-nav')
@section('content')
<div class="page-hero">
  <div class="container">
    <span class="section-tag">Fondasi Kami</span>
    <h1>Visi &amp; Misi</h1>
    <p>Landasan yang mengarahkan setiap langkah dan keputusan HIMA Informatika</p>
  </div>
</div>
<section class="section visi-misi">
  <div class="container">
    <div class="vm-grid">
      <div class="vm-card visi-card">
        <div class="vm-icon">◎</div>
        <h3>Visi</h3>
        <p class="vm-main">"{{ $settings['visi'] ?? 'Menjadi himpunan mahasiswa informatika yang unggul, inovatif, dan berdampak dalam pengembangan teknologi informasi untuk kemajuan bangsa.' }}"</p>
        <div class="vm-pillars">
          <span>Unggul</span><span>Inovatif</span><span>Berdampak</span>
        </div>
      </div>
      <div class="vm-missions">
        <h3>Misi</h3>
        @php
          $misi = [
            ['num'=>'01','judul'=>'Mengembangkan Kompetensi','desc'=>'Memfasilitasi pengembangan hard skill dan soft skill anggota melalui program terstruktur dan berkelanjutan.'],
            ['num'=>'02','judul'=>'Mendorong Inovasi','desc'=>'Menciptakan ekosistem yang mendukung lahirnya ide-ide segar dan solusi teknologi kreatif.'],
            ['num'=>'03','judul'=>'Membangun Jejaring','desc'=>'Menjalin kerjasama dengan industri, alumni, dan komunitas teknologi nasional maupun internasional.'],
            ['num'=>'04','judul'=>'Pengabdian Masyarakat','desc'=>'Berkontribusi nyata kepada masyarakat melalui teknologi dan program sosial yang bermakna.'],
          ];
        @endphp
        @foreach($misi as $m)
        <div class="mission-item">
          <div class="mission-num">{{ $m['num'] }}</div>
          <div class="mission-text">
            <h4>{{ $m['judul'] }}</h4>
            <p>{{ $m['desc'] }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>
@endsection

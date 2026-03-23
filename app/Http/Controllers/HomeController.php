<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Kegiatan;
use App\Models\Pengumuman;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB; // Added for DB facade

class HomeController extends Controller
{
    /** Dummy data untuk tampil saat DB belum ada */
    private function dummyKegiatan(): Collection
    {
        return collect([
            (object)['id'=>1,'slug'=>'workshop-ui-ux','nama'=>'Workshop UI/UX Design','kategori'=>'akademik','deskripsi'=>'Belajar desain antarmuka modern bersama praktisi industri terkemuka.','jadwal'=>'April 2025','peserta'=>'100 Peserta','emoji'=>'🎨','featured'=>true,'aktif'=>true],
            (object)['id'=>2,'slug'=>'hackathon-if','nama'=>'Hackathon HIMA IF 2025','kategori'=>'kreativitas','deskripsi'=>'Kompetisi coding 24 jam untuk menciptakan solusi inovatif berbasis teknologi.','jadwal'=>'Mei 2025','peserta'=>'200 Peserta','emoji'=>'💻','featured'=>false,'aktif'=>true],
            (object)['id'=>3,'slug'=>'bakti-sosial','nama'=>'Bakti Sosial Digital','kategori'=>'sosial','deskripsi'=>'Program literasi digital untuk masyarakat sekitar kampus bersama HIMA IF.','jadwal'=>'Juni 2025','peserta'=>'50 Volunteer','emoji'=>'🤝','featured'=>false,'aktif'=>true],
        ]);
    }

    private function dummyProduk(): Collection
    {
        return collect([
            (object)['id'=>1,'slug'=>'kaos-hima','nama'=>'Kaos HIMA IF 2025','kategori'=>'merchandise','deskripsi'=>'Kaos eksklusif dengan desain HIMA IF terbaru, bahan premium.','harga'=>85000,'harga_format'=>'Rp 85.000','emoji'=>'👕','is_new'=>true,'tersedia'=>true,'stok'=>50],
            (object)['id'=>2,'slug'=>'mug-coding','nama'=>'Mug Coding','kategori'=>'merchandise','deskripsi'=>'Mug keramik dengan quote programmer yang inspiratif.','harga'=>55000,'harga_format'=>'Rp 55.000','emoji'=>'☕','is_new'=>false,'tersedia'=>true,'stok'=>30],
            (object)['id'=>3,'slug'=>'sticker-pack','nama'=>'Sticker Pack Dev','kategori'=>'digital','deskripsi'=>'Bundle sticker digital koding siap cetak.','harga'=>15000,'harga_format'=>'Rp 15.000','emoji'=>'🎯','is_new'=>true,'tersedia'=>true,'stok'=>999],
        ]);
    }

    private function dummyGaleri(): Collection
    {
        return collect([
            (object)['id'=>1,'judul'=>'Workshop UI/UX Season 3','kategori'=>'event','emoji'=>'🎨','deskripsi'=>'Workshop desain terbesar tahun ini','tanggal'=>null],
            (object)['id'=>2,'judul'=>'Hackathon 2024','kategori'=>'kegiatan','emoji'=>'💻','deskripsi'=>'24 jam coding marathon','tanggal'=>null],
            (object)['id'=>3,'judul'=>'Juara 1 Nasional','kategori'=>'prestasi','emoji'=>'🏆','deskripsi'=>'Meraih juara nasional olimpiade informatika','tanggal'=>null],
            (object)['id'=>4,'judul'=>'Bakti Sosial','kategori'=>'kegiatan','emoji'=>'🤝','deskripsi'=>'Program literasi digital','tanggal'=>null],
            (object)['id'=>5,'judul'=>'Tech Talk Seri 5','kategori'=>'event','emoji'=>'🎤','deskripsi'=>'Seminar teknologi bersama alumni','tanggal'=>null],
            (object)['id'=>6,'judul'=>'Open Rekrutmen 2025','kategori'=>'kegiatan','emoji'=>'📋','deskripsi'=>'Pendaftaran anggota baru HIMA IF','tanggal'=>null],
        ]);
    }

    public function index()
    {
        $settings = Setting::getAll();

        try {
            $kegiatan = \App\Models\Kegiatan::aktif()->where('featured', true)->take(3)->get();
            if ($kegiatan->isEmpty()) $kegiatan = $this->dummyKegiatan();
        } catch (\Exception $e) {
            $kegiatan = $this->dummyKegiatan();
        }

        try {
            $produk = \App\Models\Produk::tersedia()->latest()->take(3)->get();
            if ($produk->isEmpty()) $produk = $this->dummyProduk();
        } catch (\Exception $e) {
            $produk = $this->dummyProduk();
        }

        try {
            $galeri = \App\Models\Galeri::tampil()->latest()->take(6)->get();
            if ($galeri->isEmpty()) $galeri = $this->dummyGaleri();
        } catch (\Exception $e) {
            $galeri = $this->dummyGaleri();
        }

        try {
            $pengumuman = Pengumuman::aktif()->latest()->take(5)->get();
            if ($pengumuman->isEmpty()) throw new \Exception('empty');
        } catch (\Exception $e) {
            $pengumuman = \App\Http\Controllers\PengumumanController::dummyPengumuman();
        }

        try {
            $stats = [
                'anggota' => \DB::table('pengurus')->where('aktif', true)->count() ?: 500,
                'program' => \App\Models\Kegiatan::aktif()->count() ?: 30,
            ];
        } catch (\Exception $e) {
            $stats = ['anggota' => 500, 'program' => 30];
        }

        return view('pages.home', compact('settings', 'kegiatan', 'produk', 'galeri', 'pengumuman', 'stats'));
    }

    public function visiMisi()
    {
        $settings = Setting::getAll();
        return view('pages.visi-misi', compact('settings'));
    }
}

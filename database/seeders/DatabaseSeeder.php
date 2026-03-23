<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Kegiatan
        $kegiatan = [
            ['nama' => 'Study Group & Mentoring', 'kategori' => 'akademik', 'deskripsi' => 'Sesi belajar mingguan bersama kakak tingkat berprestasi untuk mata kuliah inti informatika.', 'jadwal' => 'Setiap Sabtu', 'peserta' => '50+ Peserta', 'emoji' => '💻', 'featured' => false],
            ['nama' => 'Hackathon HIMA IF 2024', 'kategori' => 'akademik', 'deskripsi' => 'Kompetisi 48 jam membangun solusi digital inovatif untuk masalah nyata di masyarakat.', 'jadwal' => 'Semester Genap', 'peserta' => '200+ Peserta', 'emoji' => '🏆', 'featured' => true],
            ['nama' => 'UI/UX Design Workshop', 'kategori' => 'kreativitas', 'deskripsi' => 'Workshop intensif desain antarmuka menggunakan Figma dan prinsip human-centered design.', 'jadwal' => 'Bulanan', 'peserta' => '30+ Peserta', 'emoji' => '🎨', 'featured' => false],
            ['nama' => 'Tech for Community', 'kategori' => 'sosial', 'deskripsi' => 'Program pengabdian masyarakat dengan pelatihan literasi digital kepada masyarakat sekitar.', 'jadwal' => 'Semester Ganjil', 'peserta' => '100+ Penerima', 'emoji' => '🌱', 'featured' => false],
            ['nama' => 'Tech Talk Series', 'kategori' => 'kreativitas', 'deskripsi' => 'Seminar rutin menghadirkan praktisi industri teknologi untuk berbagi pengalaman dan insight.', 'jadwal' => '2x / Semester', 'peserta' => '150+ Peserta', 'emoji' => '🎤', 'featured' => false],
            ['nama' => 'OSPEK & Mabim', 'kategori' => 'sosial', 'deskripsi' => 'Program orientasi dan masa bimbingan mahasiswa baru untuk transisi ke kehidupan kampus.', 'jadwal' => 'Awal Semester', 'peserta' => 'Seluruh Maba', 'emoji' => '🤝', 'featured' => false],
        ];
        foreach ($kegiatan as $item) {
            DB::table('kegiatan')->insert([
                'nama' => $item['nama'],
                'slug' => Str::slug($item['nama']),
                'kategori' => $item['kategori'],
                'deskripsi' => $item['deskripsi'],
                'jadwal' => $item['jadwal'],
                'peserta' => $item['peserta'],
                'emoji' => $item['emoji'],
                'featured' => $item['featured'],
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Produk
        $produk = [
            ['nama' => 'Kaos HIMA IF 2024', 'kategori' => 'merchandise', 'deskripsi' => 'Kaos eksklusif edisi terbatas dengan desain kolaborasi tim kreatif HIMA IF.', 'harga' => 85000, 'stok' => 50, 'emoji' => '👕', 'is_new' => true],
            ['nama' => 'Totebag HIMA IF', 'kategori' => 'merchandise', 'deskripsi' => 'Totebag canvas premium dengan logo HIMA Informatika.', 'harga' => 45000, 'stok' => 30, 'emoji' => '🎒', 'is_new' => false],
            ['nama' => 'Notebook HIMA IF', 'kategori' => 'merchandise', 'deskripsi' => 'Notebook hardcover A5 dengan desain eksklusif HIMA IF.', 'harga' => 35000, 'stok' => 40, 'emoji' => '📓', 'is_new' => false],
            ['nama' => 'Template CV Informatika', 'kategori' => 'digital', 'deskripsi' => 'Pack 5 template CV profesional untuk mahasiswa IT siap kerja.', 'harga' => 25000, 'stok' => 999, 'emoji' => '📦', 'is_new' => false],
            ['nama' => 'Modul Belajar Python', 'kategori' => 'digital', 'deskripsi' => 'E-book panduan belajar Python dari dasar hingga mahir dengan contoh project.', 'harga' => 30000, 'stok' => 999, 'emoji' => '🎓', 'is_new' => false],
            ['nama' => 'Jasa Desain Website', 'kategori' => 'jasa', 'deskripsi' => 'Pembuatan landing page profesional oleh tim HIMA IF berpengalaman.', 'harga' => 500000, 'stok' => 10, 'emoji' => '🖥', 'is_new' => false],
        ];
        foreach ($produk as $item) {
            DB::table('produk')->insert([
                'nama' => $item['nama'],
                'slug' => Str::slug($item['nama']),
                'kategori' => $item['kategori'],
                'deskripsi' => $item['deskripsi'],
                'harga' => $item['harga'],
                'stok' => $item['stok'],
                'emoji' => $item['emoji'],
                'tersedia' => true,
                'is_new' => $item['is_new'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Pengurus
        $pengurus = [
            ['nama' => 'Nama Ketua Umum', 'nim' => '2021001', 'jabatan' => 'Ketua Umum', 'level' => 'ketua', 'divisi' => null, 'urutan' => 1],
            ['nama' => 'Nama Sekretaris', 'nim' => '2021002', 'jabatan' => 'Sekretaris I', 'level' => 'sekretaris', 'divisi' => null, 'urutan' => 2],
            ['nama' => 'Nama Bendahara', 'nim' => '2021003', 'jabatan' => 'Bendahara', 'level' => 'bendahara', 'divisi' => null, 'urutan' => 3],
            ['nama' => 'Kepala Div. Akademik', 'nim' => '2022001', 'jabatan' => 'Kepala Divisi', 'level' => 'divisi', 'divisi' => 'Akademik', 'urutan' => 4],
            ['nama' => 'Kepala Div. Kreatif', 'nim' => '2022002', 'jabatan' => 'Kepala Divisi', 'level' => 'divisi', 'divisi' => 'Kreatif', 'urutan' => 5],
            ['nama' => 'Kepala Div. Humas', 'nim' => '2022003', 'jabatan' => 'Kepala Divisi', 'level' => 'divisi', 'divisi' => 'Humas', 'urutan' => 6],
            ['nama' => 'Kepala Div. IT', 'nim' => '2022004', 'jabatan' => 'Kepala Divisi', 'level' => 'divisi', 'divisi' => 'IT', 'urutan' => 7],
            ['nama' => 'Kepala Div. Sosmas', 'nim' => '2022005', 'jabatan' => 'Kepala Divisi', 'level' => 'divisi', 'divisi' => 'Sosmas', 'urutan' => 8],
        ];
        foreach ($pengurus as $item) {
            DB::table('pengurus')->insert(array_merge($item, [
                'angkatan' => '2021/2022',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Galeri
        $galeri = [
            ['judul' => 'Hackathon HIMA IF 2024', 'kategori' => 'event', 'emoji' => '🏆', 'deskripsi' => 'Dokumentasi Hackathon tahunan HIMA Informatika 2024.'],
            ['judul' => 'Study Group Mingguan', 'kategori' => 'kegiatan', 'emoji' => '💻', 'deskripsi' => 'Sesi study group rutin setiap Sabtu bersama kakak tingkat.'],
            ['judul' => 'Wisuda & Prestasi 2024', 'kategori' => 'prestasi', 'emoji' => '🎓', 'deskripsi' => 'Wisuda anggota HIMA IF periode 2024.'],
            ['judul' => 'Tech Talk Series #3', 'kategori' => 'event', 'emoji' => '🎤', 'deskripsi' => 'Seminar Tech Talk bersama praktisi industri teknologi.'],
            ['judul' => 'Tech for Community', 'kategori' => 'kegiatan', 'emoji' => '🌱', 'deskripsi' => 'Pengabdian masyarakat melalui pelatihan literasi digital.'],
            ['judul' => 'Juara Lomba Nasional', 'kategori' => 'prestasi', 'emoji' => '🏅', 'deskripsi' => 'Anggota HIMA IF meraih juara di kompetisi tingkat nasional.'],
        ];
        foreach ($galeri as $item) {
            DB::table('galeri')->insert(array_merge($item, [
                'slug' => Str::slug($item['judul']),
                'tanggal' => now()->subDays(rand(1, 90)),
                'tampil' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        // Settings default
        $settings = [
            'instagram_url' => 'https://instagram.com/hima.if',
            'tiktok_url'    => 'https://tiktok.com/@hima.if',
            'youtube_url'   => 'https://youtube.com/@himainformatika',
            'whatsapp_number' => '6281200000000',
            'visi' => 'Menjadi himpunan mahasiswa informatika yang unggul, inovatif, dan berdampak dalam pengembangan teknologi informasi untuk kemajuan bangsa.',
            'hima_nama' => 'HIMA Informatika',
            'hima_universitas' => 'Universitas ...',
            'hima_email' => 'hima.if@universitas.ac.id',
            'hima_alamat' => 'Gedung Informatika, Lantai 2',
        ];
        foreach ($settings as $key => $value) {
            DB::table('settings')->insert([
                'key' => $key, 'value' => $value,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }
}

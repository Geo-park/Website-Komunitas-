<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PengumumanController extends Controller
{
    /** Dummy data jika database belum ada */
    public static function dummyPengumuman(): Collection
    {
        return collect([
            (object)[
                'id' => 1,
                'judul' => 'Pendaftaran Lomba Hackathon Nasional 2026 Dibuka!',
                'deskripsi' => 'Ikuti lomba Hackathon Nasional tingkat mahasiswa. Raih hadiah jutaan rupiah dan pengalaman berharga! Segera daftarkan tim Anda sebelum kuota penuh.',
                'gambar_url' => 'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?q=80&w=800&auto=format&fit=crop',
                'link_tujuan' => '#',
                'is_aktif' => true,
                'created_at' => now(),
            ],
            (object)[
                'id' => 2,
                'judul' => 'Open Recruitment Pengurus HIMA IF 2026/2027',
                'deskripsi' => 'Mari berkontribusi memajukan mahasiswa Informatika melalui organisasi. Buka untuk seluruh mahasiswa angkatan 2024 & 2025. Jadilah bagian dari perubahan besar!',
                'gambar_url' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=800&auto=format&fit=crop',
                'link_tujuan' => '#',
                'is_aktif' => true,
                'created_at' => now()->subDays(2),
            ],
            (object)[
                'id' => 3,
                'judul' => 'Libur Perkuliahan Semester Ganjil',
                'deskripsi' => 'Pemberitahuan bahwa kegiatan akademik dan kesekretariatan akan libur mulai tanggal 20 Desember hingga awal tahun. Selamat berlibur semuanya!',
                'gambar_url' => 'https://images.unsplash.com/photo-1493606371202-6275d2753b7bc?q=80&w=800&auto=format&fit=crop',
                'link_tujuan' => null,
                'is_aktif' => true,
                'created_at' => now()->subDays(5),
            ],
        ]);
    }

    // Public Page
    public function index()
    {
        $settings = Setting::getAll();
        
        try {
            $pengumuman = Pengumuman::aktif()->latest()->get();
            if ($pengumuman->isEmpty()) throw new \Exception('empty');
        } catch (\Exception $e) {
            $pengumuman = self::dummyPengumuman();
        }

        return view('pages.pengumuman', compact('pengumuman', 'settings'));
    }

    // Admin CRUD
    public function create()
    {
        return view('admin.pengumuman.form', ['pengumuman' => new Pengumuman(), 'settings' => Setting::getAll()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'gambar_url'  => 'nullable|url',
            'link_tujuan' => 'nullable|string',
        ]);
        
        $data['is_aktif'] = $request->boolean('is_aktif', true);
        Pengumuman::create($data);
        return redirect()->route('admin.dashboard')->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function edit(Pengumuman $pengumuman)
    {
        return view('admin.pengumuman.form', compact('pengumuman') + ['settings' => Setting::getAll()]);
    }

    public function update(Request $request, Pengumuman $pengumuman)
    {
        $data = $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'required|string',
            'gambar_url'  => 'nullable|url',
            'link_tujuan' => 'nullable|string',
        ]);
        
        $data['is_aktif'] = $request->boolean('is_aktif', true);
        $pengumuman->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'Pengumuman diperbarui!');
    }

    public function destroy(Pengumuman $pengumuman)
    {
        $pengumuman->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Pengumuman dihapus.');
    }
}

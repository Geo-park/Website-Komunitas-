<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class KegiatanController extends Controller
{
    private function dummyKegiatan(): Collection
    {
        return collect([
            (object)['id'=>1,'slug'=>'workshop-ui-ux','nama'=>'Workshop UI/UX Design','kategori'=>'akademik','deskripsi'=>'Belajar desain antarmuka modern bersama praktisi industri terkemuka. Peserta akan mendapat hands-on experience menggunakan Figma dan tools desain terkini.','jadwal'=>'April 2025','peserta'=>'100 Peserta','emoji'=>'🎨','featured'=>true,'aktif'=>true],
            (object)['id'=>2,'slug'=>'hackathon-if','nama'=>'Hackathon HIMA IF 2025','kategori'=>'kreativitas','deskripsi'=>'Kompetisi coding 24 jam untuk menciptakan solusi inovatif berbasis teknologi. Tim terbaik berkesempatan meraih hadiah total 15 juta rupiah.','jadwal'=>'Mei 2025','peserta'=>'200 Peserta','emoji'=>'💻','featured'=>false,'aktif'=>true],
            (object)['id'=>3,'slug'=>'bakti-sosial-digital','nama'=>'Bakti Sosial Digital','kategori'=>'sosial','deskripsi'=>'Program literasi digital untuk masyarakat sekitar kampus bersama HIMA IF. Mengajarkan penggunaan teknologi untuk UMKM lokal.','jadwal'=>'Juni 2025','peserta'=>'50 Volunteer','emoji'=>'🤝','featured'=>false,'aktif'=>true],
            (object)['id'=>4,'slug'=>'seminar-ai','nama'=>'Seminar AI & Machine Learning','kategori'=>'akademik','deskripsi'=>'Seminar mengenai perkembangan terkini AI dan Machine Learning di industri, dipandu oleh pakar dari perusahaan teknologi terkemuka.','jadwal'=>'Juli 2025','peserta'=>'300 Peserta','emoji'=>'🤖','featured'=>false,'aktif'=>true],
            (object)['id'=>5,'slug'=>'foto-kreatif','nama'=>'Lomba Foto Kreatif','kategori'=>'kreativitas','deskripsi'=>'Lomba foto bertemakan "Teknologi & Kehidupan" terbuka untuk seluruh mahasiswa informatika.','jadwal'=>'Agustus 2025','peserta'=>'80 Peserta','emoji'=>'📸','featured'=>false,'aktif'=>true],
            (object)['id'=>6,'slug'=>'pelatihan-web','nama'=>'Pelatihan Web Development','kategori'=>'akademik','deskripsi'=>'Belajar membuat website dari nol menggunakan teknologi terkini seperti React, Laravel, dan Tailwind CSS.','jadwal'=>'Maret 2025','peserta'=>'60 Peserta','emoji'=>'🌐','featured'=>false,'aktif'=>true],
        ]);
    }

    private function makePaginator(Collection $items, int $perPage, Request $request): LengthAwarePaginator
    {
        $page  = $request->get('page', 1);
        $slice = $items->forPage($page, $perPage);
        return new LengthAwarePaginator($slice, $items->count(), $perPage, $page, [
            'path' => $request->url(),
            'query' => $request->query(),
        ]);
    }

    // Public
    public function index(Request $request)
    {
        $settings = Setting::getAll();

        try {
            $query = Kegiatan::aktif();
            if ($request->kategori && $request->kategori !== 'all') {
                $query->where('kategori', $request->kategori);
            }
            $kegiatan = $query->latest()->paginate(9);
            if ($kegiatan->total() === 0) throw new \Exception('empty');
        } catch (\Exception $e) {
            $all = $this->dummyKegiatan();
            if ($request->kategori && $request->kategori !== 'all') {
                $all = $all->where('kategori', $request->kategori)->values();
            }
            $kegiatan = $this->makePaginator($all, 9, $request);
        }

        return view('pages.kegiatan', compact('kegiatan', 'settings'));
    }

    public function show(Kegiatan $kegiatan)
    {
        $settings = Setting::getAll();
        try {
            $related = Kegiatan::aktif()->where('kategori', $kegiatan->kategori)->where('id', '!=', $kegiatan->id)->take(3)->get();
        } catch (\Exception $e) {
            $related = collect();
        }
        return view('pages.kegiatan-detail', compact('kegiatan', 'related', 'settings'));
    }

    // Admin CRUD
    public function create()
    {
        return view('admin.kegiatan.form', ['kegiatan' => new Kegiatan(), 'settings' => Setting::getAll()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|in:akademik,kreativitas,sosial',
            'deskripsi' => 'required|string',
            'jadwal'    => 'nullable|string',
            'peserta'   => 'nullable|string',
            'emoji'     => 'nullable|string|max:10',
            'featured'  => 'boolean',
            'aktif'     => 'boolean',
        ]);
        $data['slug']     = Str::slug($data['nama']);
        $data['featured'] = $request->boolean('featured');
        $data['aktif']    = $request->boolean('aktif', true);
        Kegiatan::create($data);
        return redirect()->route('admin.dashboard')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function edit(Kegiatan $kegiatan)
    {
        return view('admin.kegiatan.form', compact('kegiatan') + ['settings' => Setting::getAll()]);
    }

    public function update(Request $request, Kegiatan $kegiatan)
    {
        $data = $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|in:akademik,kreativitas,sosial',
            'deskripsi' => 'required|string',
            'jadwal'    => 'nullable|string',
            'peserta'   => 'nullable|string',
            'emoji'     => 'nullable|string|max:10',
        ]);
        $data['featured'] = $request->boolean('featured');
        $data['aktif']    = $request->boolean('aktif', true);
        $kegiatan->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Kegiatan $kegiatan)
    {
        $kegiatan->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Kegiatan dihapus.');
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class GaleriController extends Controller
{
    private function dummyGaleri(): Collection
    {
        return collect([
            (object)['id'=>1,'judul'=>'Workshop UI/UX Season 3','kategori'=>'event','emoji'=>'🎨','deskripsi'=>'Workshop desain UI/UX terbesar tahun ini, dihadiri 100+ peserta.','tampil'=>true,'tanggal'=>null,'slug'=>'workshop-uiux'],
            (object)['id'=>2,'judul'=>'Hackathon 2024','kategori'=>'kegiatan','emoji'=>'💻','deskripsi'=>'24 jam coding marathon menghasilkan 20 solusi inovatif.','tampil'=>true,'tanggal'=>null,'slug'=>'hackathon-2024'],
            (object)['id'=>3,'judul'=>'Juara 1 Nasional Olimpiade','kategori'=>'prestasi','emoji'=>'🏆','deskripsi'=>'Tim HIMA IF meraih juara 1 olimpiade informatika tingkat nasional.','tampil'=>true,'tanggal'=>null,'slug'=>'juara-nasional'],
            (object)['id'=>4,'judul'=>'Bakti Sosial Digital','kategori'=>'kegiatan','emoji'=>'🤝','deskripsi'=>'Program literasi digital untuk masyarakat sekitar kampus.','tampil'=>true,'tanggal'=>null,'slug'=>'baksos-digital'],
            (object)['id'=>5,'judul'=>'Tech Talk Seri 5','kategori'=>'event','emoji'=>'🎤','deskripsi'=>'Seminar bersama alumni yang kini bekerja di Google dan Gojek.','tampil'=>true,'tanggal'=>null,'slug'=>'tech-talk-5'],
            (object)['id'=>6,'judul'=>'Open Rekrutmen 2025','kategori'=>'kegiatan','emoji'=>'📋','deskripsi'=>'Rekrutmen anggota baru HIMA IF periode 2025/2026.','tampil'=>true,'tanggal'=>null,'slug'=>'rekrutmen-2025'],
            (object)['id'=>7,'judul'=>'Juara Favorit Hackathon Regional','kategori'=>'prestasi','emoji'=>'🥈','deskripsi'=>'Meraih juara favorit pada ajang hackathon tingkat regional.','tampil'=>true,'tanggal'=>null,'slug'=>'juara-regional'],
            (object)['id'=>8,'judul'=>'Malam Keakraban 2025','kategori'=>'event','emoji'=>'🌙','deskripsi'=>'Acara keakraban dan perkenalan anggota baru HIMA IF.','tampil'=>true,'tanggal'=>null,'slug'=>'malam-keakraban'],
        ]);
    }

    private function makePaginator(Collection $items, int $perPage, Request $request): LengthAwarePaginator
    {
        $page  = $request->get('page', 1);
        $slice = $items->forPage($page, $perPage);
        return new LengthAwarePaginator($slice, $items->count(), $perPage, $page, [
            'path' => $request->url(), 'query' => $request->query(),
        ]);
    }

    public function index(Request $request)
    {
        $settings = Setting::getAll();
        try {
            $query = Galeri::tampil();
            if ($request->kategori && $request->kategori !== 'all') {
                $query->where('kategori', $request->kategori);
            }
            $galeri = $query->latest()->paginate(12);
            if ($galeri->total() === 0) throw new \Exception('empty');
        } catch (\Exception $e) {
            $all = $this->dummyGaleri();
            if ($request->kategori && $request->kategori !== 'all') {
                $all = $all->where('kategori', $request->kategori)->values();
            }
            $galeri = $this->makePaginator($all, 12, $request);
        }
        return view('pages.galeri', compact('galeri', 'settings'));
    }

    public function create() { return view('admin.galeri.form', ['galeri' => new Galeri(), 'settings' => Setting::getAll()]); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|in:event,kegiatan,prestasi',
            'deskripsi' => 'nullable|string',
            'emoji'     => 'nullable|string|max:10',
            'tanggal'   => 'nullable|date',
        ]);
        $data['slug']   = Str::slug($data['judul'] . '-' . time());
        $data['tampil'] = true;
        Galeri::create($data);
        return redirect()->route('admin.dashboard')->with('success', 'Item galeri ditambahkan!');
    }

    public function edit(Galeri $galeri) { return view('admin.galeri.form', compact('galeri') + ['settings' => Setting::getAll()]); }

    public function update(Request $request, Galeri $galeri)
    {
        $data = $request->validate([
            'judul'     => 'required|string|max:255',
            'kategori'  => 'required|in:event,kegiatan,prestasi',
            'deskripsi' => 'nullable|string',
            'emoji'     => 'nullable|string|max:10',
            'tanggal'   => 'nullable|date',
        ]);
        $data['tampil'] = $request->boolean('tampil', true);
        $galeri->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'Galeri diperbarui!');
    }

    public function destroy(Galeri $galeri)
    {
        $galeri->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Item galeri dihapus.');
    }
}

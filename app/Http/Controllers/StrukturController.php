<?php
namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class StrukturController extends Controller
{
    private function dummyKetua(): object
    {
        return (object)['id'=>1,'nama'=>'Ahmad Rasyid','nim'=>'231401001','jabatan'=>'Ketua Umum','level'=>'ketua','divisi'=>null,'angkatan'=>'2023','aktif'=>true,'emoji'=>'👨‍💼'];
    }

    private function dummyInti(): Collection
    {
        return collect([
            (object)['id'=>2,'nama'=>'Siti Nurhaliza','nim'=>'231401002','jabatan'=>'Wakil Ketua','level'=>'wakil','divisi'=>null,'angkatan'=>'2023','aktif'=>true],
            (object)['id'=>3,'nama'=>'Budi Santoso','nim'=>'231401003','jabatan'=>'Sekretaris','level'=>'sekretaris','divisi'=>null,'angkatan'=>'2023','aktif'=>true],
            (object)['id'=>4,'nama'=>'Dewi Rahayu','nim'=>'231401004','jabatan'=>'Bendahara','level'=>'bendahara','divisi'=>null,'angkatan'=>'2023','aktif'=>true],
        ]);
    }

    private function dummyDivisi(): Collection
    {
        return collect([
            (object)['id'=>5,'nama'=>'Tim Akademik','nim'=>'-','jabatan'=>'Divisi Akademik','level'=>'divisi','divisi'=>'Akademik','angkatan'=>'2023','aktif'=>true],
            (object)['id'=>6,'nama'=>'Tim Kreatif','nim'=>'-','jabatan'=>'Divisi Kreativitas','level'=>'divisi','divisi'=>'Kreativitas','angkatan'=>'2023','aktif'=>true],
            (object)['id'=>7,'nama'=>'Tim IT','nim'=>'-','jabatan'=>'Divisi IT','level'=>'divisi','divisi'=>'IT','angkatan'=>'2023','aktif'=>true],
            (object)['id'=>8,'nama'=>'Tim Sosial','nim'=>'-','jabatan'=>'Divisi Sosial','level'=>'divisi','divisi'=>'Sosial','angkatan'=>'2023','aktif'=>true],
        ]);
    }

    private function dummyAnggota(): Collection
    {
        $anggota = [];
        for ($i = 1; $i <= 16; $i++) {
            $anggota[] = (object)['id'=>100+$i,'nama'=>"Anggota $i",'nim'=>"23140" . str_pad($i+10, 4, '0', STR_PAD_LEFT),'jabatan'=>'Anggota','level'=>'anggota','divisi'=>null,'angkatan'=>'2023','aktif'=>true];
        }
        return collect($anggota);
    }

    public function index()
    {
        $settings = Setting::getAll();
        try {
            $ketua   = Pengurus::aktif()->level('ketua')->first();
            $inti    = Pengurus::aktif()->whereIn('level', ['wakil','sekretaris','bendahara'])->get();
            $divisi  = Pengurus::aktif()->level('divisi')->get();
            $anggota = Pengurus::aktif()->level('anggota')->get();
            if (!$ketua) throw new \Exception('empty');
        } catch (\Exception $e) {
            $ketua   = $this->dummyKetua();
            $inti    = $this->dummyInti();
            $divisi  = $this->dummyDivisi();
            $anggota = $this->dummyAnggota();
        }
        return view('pages.struktur', compact('settings','ketua','inti','divisi','anggota'));
    }

    public function create() { return view('admin.struktur.form', ['pengurus' => new Pengurus(), 'settings' => Setting::getAll()]); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:255',
            'nim'      => 'required|string|max:20',
            'jabatan'  => 'required|string|max:100',
            'level'    => 'required|in:ketua,wakil,sekretaris,bendahara,divisi,anggota',
            'divisi'   => 'nullable|string|max:100',
            'angkatan' => 'nullable|string|max:20',
            'urutan'   => 'integer|min:0',
        ]);
        $data['aktif'] = true;
        Pengurus::create($data);
        return redirect()->route('admin.dashboard')->with('success', 'Pengurus ditambahkan!');
    }

    public function edit(Pengurus $struktur) { return view('admin.struktur.form', ['pengurus' => $struktur, 'settings' => Setting::getAll()]); }

    public function update(Request $request, Pengurus $struktur)
    {
        $data = $request->validate([
            'nama'     => 'required|string|max:255',
            'nim'      => 'required|string|max:20',
            'jabatan'  => 'required|string|max:100',
            'level'    => 'required|in:ketua,wakil,sekretaris,bendahara,divisi,anggota',
            'divisi'   => 'nullable|string|max:100',
            'angkatan' => 'nullable|string|max:20',
            'urutan'   => 'integer|min:0',
        ]);
        $data['aktif'] = $request->boolean('aktif', true);
        $struktur->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'Data pengurus diperbarui!');
    }

    public function destroy(Pengurus $struktur)
    {
        $struktur->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Pengurus dihapus.');
    }
}

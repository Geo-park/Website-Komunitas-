<?php
// app/Models/Kegiatan.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kegiatan extends Model
{
    protected $table = 'kegiatan';
    protected $fillable = ['nama','slug','kategori','deskripsi','jadwal','peserta','emoji','gambar','featured','aktif'];
    protected $casts = ['featured' => 'boolean', 'aktif' => 'boolean'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama);
            }
        });
    }

    public function getRouteKeyName() { return 'slug'; }
    public function scopeAktif($q) { return $q->where('aktif', true); }
    public function scopeKategori($q, $kat) { return $q->where('kategori', $kat); }
}

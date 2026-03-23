<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Galeri extends Model
{
    protected $fillable = ['judul','slug','kategori','deskripsi','gambar','emoji','tanggal','tampil'];
    protected $casts = ['tampil' => 'boolean', 'tanggal' => 'date'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->slug = $m->slug ?: Str::slug($m->judul));
    }

    public function getRouteKeyName() { return 'slug'; }
    public function scopeTampil($q) { return $q->where('tampil', true); }
}

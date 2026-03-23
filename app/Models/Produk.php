<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Produk extends Model
{
    protected $table = 'produk'; 
    protected $fillable = ['nama','slug','kategori','deskripsi','harga','stok','emoji','gambar','tersedia','is_new'];
    protected $casts = ['tersedia' => 'boolean', 'is_new' => 'boolean', 'harga' => 'decimal:2'];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->slug = $m->slug ?: Str::slug($m->nama));
    }

    public function getRouteKeyName() { return 'slug'; }
    public function getHargaFormatAttribute() { return 'Rp ' . number_format($this->harga, 0, ',', '.'); }
    public function scopeTersedia($q) { return $q->where('tersedia', true); }
}

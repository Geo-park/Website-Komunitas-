<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;
    protected $table = 'pengumuman';
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar_url',
        'link_tujuan',
        'is_aktif',
    ];

    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }
}

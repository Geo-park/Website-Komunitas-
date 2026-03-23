<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    protected $fillable = ['nama','nim','jabatan','level','divisi','foto','angkatan','urutan','aktif'];
    protected $casts = ['aktif' => 'boolean'];

    public function scopeAktif($q) { return $q->where('aktif', true)->orderBy('urutan'); }
    public function scopeLevel($q, $level) { return $q->where('level', $level); }
}

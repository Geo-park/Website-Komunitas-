<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Default settings jika DB belum ada */
    protected static array $defaults = [
        'hima_nama'         => 'HIMA Informatika',
        'hima_universitas'  => 'Universitas',
        'hima_email'        => 'hima.if@universitas.ac.id',
        'hima_alamat'       => 'Gedung Informatika, Lt. 2',
        'whatsapp_number'   => '6281200000000',
        'instagram_url'     => '#',
        'tiktok_url'        => '#',
        'youtube_url'       => '#',
        'visi'              => 'Menjadi himpunan mahasiswa informatika yang unggul, inovatif, dan berdampak dalam pengembangan teknologi informasi untuk kemajuan bangsa.',
        'popup_show'        => 'true',
        'popup_title'       => 'Pendaftaran Lomba 2026 Dibuka!',
        'popup_image_url'   => 'https://images.unsplash.com/photo-1540317580384-e5d43616b9aa?q=80&w=800&auto=format&fit=crop',
        'popup_description' => 'Ikuti lomba Hackathon Nasional tingkat mahasiswa. Raih hadiah jutaan rupiah dan pengalaman berharga!',
        'popup_link'        => '#',
    ];

    public static function get(string $key, $default = null)
    {
        try {
            if (!Schema::hasTable('settings')) return $default ?? static::$defaults[$key] ?? null;
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : ($default ?? static::$defaults[$key] ?? null);
        } catch (\Exception $e) {
            return $default ?? static::$defaults[$key] ?? null;
        }
    }

    public static function set(string $key, $value): void
    {
        try {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        } catch (\Exception $e) {
            // silently fail if DB not ready
        }
    }

    public static function getAll(): array
    {
        try {
            if (!Schema::hasTable('settings')) return static::$defaults;
            $db = static::all()->pluck('value', 'key')->toArray();
            return array_merge(static::$defaults, $db);
        } catch (\Exception $e) {
            return static::$defaults;
        }
    }
}

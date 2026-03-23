<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Use Bootstrap pagination styling (or Tailwind — pick one)
        Paginator::useBootstrapFive();

        // Share $settings with ALL views so layouts can access it
        View::composer('*', function ($view) {
            try {
                $settings = Setting::getAll();
            } catch (\Exception $e) {
                // During migration / fresh install, table may not exist yet
                $settings = [
                    'hima_nama'        => 'HIMA Informatika',
                    'instagram_url'    => '#',
                    'tiktok_url'       => '#',
                    'youtube_url'      => '#',
                    'whatsapp_number'  => '6281200000000',
                    'hima_alamat'      => 'Gedung Informatika, Lt. 2',
                    'hima_email'       => 'hima.if@universitas.ac.id',
                    'visi'             => 'Menjadi himpunan mahasiswa informatika yang unggul, inovatif, dan berdampak.',
                ];
            }
            $view->with('settings', $settings);
        });
    }
}

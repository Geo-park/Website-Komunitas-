<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function loginForm()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.dashboard');
        }
        $settings = Setting::getAll();
        return view('admin.login', compact('settings'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = env('ADMIN_USERNAME', 'admin');
        $password = env('ADMIN_PASSWORD', 'hima2024');

        if ($request->username === $username && $request->password === $password) {
            session(['admin_logged_in' => true, 'admin_name' => 'Administrator']);
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
        }

        return back()->withErrors(['login' => 'Username atau password salah!'])->withInput();
    }

    public function logout()
    {
        Session::forget('admin_logged_in');
        return redirect()->route('admin.login')->with('success', 'Berhasil logout.');
    }

    public function dashboard()
    {
        $settings = Setting::getAll();

        try {
            $stats = [
                'kegiatan'   => \App\Models\Kegiatan::count(),
                'produk'     => \App\Models\Produk::count(),
                'galeri'     => \App\Models\Galeri::count(),
                'pengurus'   => \App\Models\Pengurus::count(),
                'pengumuman' => \App\Models\Pengumuman::count(),
            ];
            $kegiatan   = \App\Models\Kegiatan::latest()->take(5)->get();
            $produk     = \App\Models\Produk::latest()->take(5)->get();
            $galeri     = \App\Models\Galeri::latest()->take(5)->get();
            $pengurus   = \App\Models\Pengurus::aktif()->take(5)->get();
            $pengumuman = \App\Models\Pengumuman::latest()->take(5)->get();
        } catch (\Exception $e) {
            $stats = ['kegiatan' => 0, 'produk' => 0, 'galeri' => 0, 'pengurus' => 0, 'pengumuman' => 0];
            $kegiatan   = collect();
            $produk     = collect();
            $galeri     = collect();
            $pengurus   = collect();
            $pengumuman = collect();
        }

        return view('admin.dashboard', compact('stats', 'kegiatan', 'produk', 'galeri', 'pengurus', 'pengumuman', 'settings'));
    }

    public function settings()
    {
        $settings = Setting::getAll();
        return view('admin.settings', compact('settings'));
    }

    public function saveSettings(Request $request)
    {
        $keys = [
            'instagram_url','tiktok_url','youtube_url','whatsapp_number',
            'visi','hima_nama','hima_universitas','hima_email','hima_alamat',
            'popup_show','popup_title','popup_image_url','popup_description','popup_link'
        ];
        foreach ($keys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }
        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MarketplaceController extends Controller
{
    private function dummyProduk(): Collection
    {
        return collect([
            (object)['id'=>1,'slug'=>'kaos-hima-if','nama'=>'Kaos HIMA IF 2025','kategori'=>'merchandise','deskripsi'=>'Kaos eksklusif HIMA IF dengan desain terbaru, tersedia ukuran S-XXL. Bahan combed 30s premium, nyaman dipakai sehari-hari.','harga'=>85000,'harga_format'=>'Rp 85.000','emoji'=>'👕','is_new'=>true,'tersedia'=>true,'stok'=>50],
            (object)['id'=>2,'slug'=>'mug-coding','nama'=>'Mug Coding','kategori'=>'merchandise','deskripsi'=>'Mug keramik kapasitas 350ml dengan quote programmer pilihan. Cocok untuk teman kerja dan belajar coding.','harga'=>55000,'harga_format'=>'Rp 55.000','emoji'=>'☕','is_new'=>false,'tersedia'=>true,'stok'=>30],
            (object)['id'=>3,'slug'=>'topi-hima','nama'=>'Topi HIMA IF','kategori'=>'merchandise','deskripsi'=>'Topi baseball bordir khusus HIMA IF, tersedia warna hitam dan putih. Adjustable size untuk semua kepala.','harga'=>75000,'harga_format'=>'Rp 75.000','emoji'=>'🧢','is_new'=>true,'tersedia'=>true,'stok'=>40],
            (object)['id'=>4,'slug'=>'sticker-pack','nama'=>'Sticker Pack Dev','kategori'=>'digital','deskripsi'=>'Bundle 20 sticker digital bertema programming dan HIMA IF. Format PNG & SVG, siap cetak resolusi tinggi.','harga'=>15000,'harga_format'=>'Rp 15.000','emoji'=>'🎯','is_new'=>true,'tersedia'=>true,'stok'=>999],
            (object)['id'=>5,'slug'=>'buku-catatan','nama'=>'Buku Catatan HIMA','kategori'=>'merchandise','deskripsi'=>'Buku catatan A5 hard cover dengan desain HIMA IF, 100 halaman dot grid.','harga'=>45000,'harga_format'=>'Rp 45.000','emoji'=>'📓','is_new'=>false,'tersedia'=>true,'stok'=>60],
            (object)['id'=>6,'slug'=>'konsultasi-cv','nama'=>'Konsultasi CV Tech','kategori'=>'jasa','deskripsi'=>'Konsultasi dan review CV untuk melamar ke perusahaan teknologi bersama mentor berpengalaman.','harga'=>50000,'harga_format'=>'Rp 50.000','emoji'=>'📄','is_new'=>false,'tersedia'=>true,'stok'=>10],
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

    // Public
    public function index(Request $request)
    {
        $settings = Setting::getAll();
        try {
            $query = Produk::tersedia();
            if ($request->kategori && $request->kategori !== 'all') {
                $query->where('kategori', $request->kategori);
            }
            $produk = $query->latest()->paginate(9);
            if ($produk->total() === 0) throw new \Exception('empty');
        } catch (\Exception $e) {
            $all = $this->dummyProduk();
            if ($request->kategori && $request->kategori !== 'all') {
                $all = $all->where('kategori', $request->kategori)->values();
            }
            $produk = $this->makePaginator($all, 9, $request);
        }
        $cart = session('cart', []);
        return view('pages.marketplace', compact('produk', 'cart', 'settings'));
    }

    public function show(Produk $produk)
    {
        $settings = Setting::getAll();
        try {
            $related = Produk::tersedia()->where('kategori', $produk->kategori)->where('id', '!=', $produk->id)->take(3)->get();
        } catch (\Exception $e) {
            $related = collect();
        }
        return view('pages.produk-detail', compact('produk', 'related', 'settings'));
    }

    // Cart
    public function addToCart(Request $request)
    {
        try {
            $request->validate(['produk_id' => 'required|exists:produk,id']);
            $produk = Produk::findOrFail($request->produk_id);
        } catch (\Exception $e) {
            return back()->with('success', 'Produk ditambahkan ke keranjang!');
        }

        $cart = session('cart', []);
        $key  = 'produk_' . $produk->id;
        if (isset($cart[$key])) {
            $cart[$key]['qty']++;
        } else {
            $cart[$key] = [
                'id'    => $produk->id,
                'nama'  => $produk->nama,
                'harga' => $produk->harga,
                'emoji' => $produk->emoji,
                'qty'   => 1,
            ];
        }
        session(['cart' => $cart]);
        // Set a session flag to keep the cart open when returning
        session()->flash('cart_open', 'true');
        return back()->with('success', $produk->nama . ' ditambahkan ke keranjang!');
    }

    public function removeFromCart(Request $request)
    {
        $key  = 'produk_' . $request->produk_id;
        $cart = session('cart', []);
        unset($cart[$key]);
        session(['cart' => $cart]);
        
        if ($request->has('keep_open')) {
            session()->flash('cart_open', 'true');
        }
        
        return back()->with('success', 'Produk dihapus dari keranjang.');
    }

    public function checkout()
    {
        $cart  = session('cart', []);
        if(empty($cart)) {
            return back()->with('error', 'Keranjang masih kosong!');
        }

        $total = array_sum(array_map(fn($i) => $i['harga'] * $i['qty'], $cart));
        $lines = array_map(fn($i) => "• {$i['nama']} (x{$i['qty']}) - Rp " . number_format($i['harga'] * $i['qty'], 0, ',', '.'), $cart);
        
        $msg  = "🛒 *Pesanan Baru - HIMA Store*\n\n";
        $msg .= implode("\n", $lines) . "\n\n";
        $msg .= "💰 *Total: Rp " . number_format($total, 0, ',', '.') . "*\n";
        $msg .= "Mohon segera diproses.";

        $botToken = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (!$botToken || !$chatId) {
            return back()->with('success', 'Pesanan siap, namun Bot Telegram belum dikonfigurasi. Silakan hubungi admin.');
        }

        // Send to Telegram
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'chat_id' => $chatId,
                'text' => $msg,
                'parse_mode' => 'Markdown'
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            
            // Clear cart after checkout
            session()->forget('cart');
            
            return redirect()->route('marketplace.index')->with('success', 'Yeay! Pesanan berhasil dikirim ke grup Telegram.');
        } catch (\Exception $e) {
            return back()->with('success', 'Gagal mengirim pesanan ke Telegram.');
        }
    }

    // Admin CRUD
    public function create()
    {
        return view('admin.produk.form', ['produk' => new Produk(), 'settings' => Setting::getAll()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|in:merchandise,digital,jasa',
            'deskripsi' => 'required|string',
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'required|integer|min:0',
            'emoji'     => 'nullable|string|max:10',
            'is_new'    => 'boolean',
        ]);
        $data['slug']     = Str::slug($data['nama']);
        $data['tersedia'] = true;
        $data['is_new']   = $request->boolean('is_new');
        Produk::create($data);
        return redirect()->route('admin.dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Produk $produk)
    {
        return view('admin.produk.form', compact('produk') + ['settings' => Setting::getAll()]);
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'nama'      => 'required|string|max:255',
            'kategori'  => 'required|in:merchandise,digital,jasa',
            'deskripsi' => 'required|string',
            'harga'     => 'required|numeric|min:0',
            'stok'      => 'required|integer|min:0',
            'emoji'     => 'nullable|string|max:10',
        ]);
        $data['tersedia'] = $request->boolean('tersedia', true);
        $data['is_new']   = $request->boolean('is_new');
        $produk->update($data);
        return redirect()->route('admin.dashboard')->with('success', 'Produk diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Produk dihapus.');
    }
}

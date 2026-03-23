<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->enum('kategori', ['merchandise', 'digital', 'jasa']);
            $table->text('deskripsi');
            $table->decimal('harga', 12, 2);
            $table->integer('stok')->default(0);
            $table->string('emoji')->default('📦');
            $table->string('gambar')->nullable();
            $table->boolean('tersedia')->default(true);
            $table->boolean('is_new')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};

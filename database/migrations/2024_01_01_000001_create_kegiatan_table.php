<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->enum('kategori', ['akademik', 'kreativitas', 'sosial']);
            $table->text('deskripsi');
            $table->string('jadwal')->nullable();
            $table->string('peserta')->nullable();
            $table->string('emoji')->default('📚');
            $table->string('gambar')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};

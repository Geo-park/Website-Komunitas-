<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim');
            $table->string('jabatan');
            $table->enum('level', ['ketua', 'wakil', 'sekretaris', 'bendahara', 'divisi', 'anggota'])->default('anggota');
            $table->string('divisi')->nullable();
            $table->string('foto')->nullable();
            $table->string('angkatan')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('kategori', ['event', 'kegiatan', 'prestasi']);
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->string('emoji')->default('📷');
            $table->date('tanggal')->nullable();
            $table->boolean('tampil')->default(true);
            $table->timestamps();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengurus');
        Schema::dropIfExists('galeri');
        Schema::dropIfExists('settings');
    }
};

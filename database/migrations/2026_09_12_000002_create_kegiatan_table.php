<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->text('deskripsi');
            $table->enum('kategori', [
                'kerja_bakti',
                'ronda',
                'rapat',
                'sosial',
                'olahraga',
                'keagamaan',
                'lainnya'
            ])->default('lainnya');
            $table->date('tanggal_kegiatan');
            $table->string('waktu_mulai', 50);
            $table->string('lokasi');
            $table->string('penanggung_jawab')->nullable();
            $table->enum('status', [
                'mendatang',
                'berlangsung',
                'selesai',
                'dibatalkan'
            ])->default('mendatang');
            $table->string('foto')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};

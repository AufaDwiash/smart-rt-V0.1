<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengajuan_surat', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('surat_template_id')
                ->constrained('surat_templates')
                ->onDelete('cascade');

            $table->string('nomor_surat')->nullable();

            $table->text('keperluan');

            $table->string('file_pendukung')->nullable();

            $table->enum('status', [
                'pending',
                'diproses',
                'disetujui',
                'ditolak',
                'selesai'
            ])->default('pending');

            $table->text('catatan_rt')->nullable();

            $table->dateTime('tanggal_pengajuan')
                ->useCurrent();

            $table->dateTime('tanggal_selesai')
                ->nullable();

            $table->string('file_hasil_surat')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat');
    }
};

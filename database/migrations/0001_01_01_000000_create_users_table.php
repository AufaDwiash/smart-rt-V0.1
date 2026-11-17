<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('users', function (Blueprint $table) {
        $table->id();

        $table->string('nik', 20)->unique();
        $table->string('no_kk', 20)->nullable();

        $table->string('nama_lengkap');
        $table->string('email')->unique()->nullable();
        $table->string('no_hp', 20)->nullable();

        $table->string('password');

        $table->enum('role', ['admin', 'rt', 'sekretaris', 'bendahara', 'warga'])
              ->default('warga');

        $table->enum('jenis_kelamin', ['L', 'P'])->nullable();

        $table->string('tempat_lahir')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->string('agama', 30)->nullable();
        $table->string('pekerjaan')->nullable();

        $table->text('alamat')->nullable();

        $table->string('rt', 10)->default('03');
        $table->string('rw', 10)->default('02');

        $table->enum('status_keluarga', ['Kepala Keluarga', 'Istri', 'Anak', 'Anggota Lain'])->nullable();
        $table->enum('status_warga', ['tetap', 'kontrak', 'pindah'])->default('tetap');

        $table->string('foto_profil')->nullable();

        $table->enum('status_akun', ['aktif', 'nonaktif'])
              ->default('aktif');

        $table->rememberToken();
        $table->timestamps();
    });

    Schema::create('password_reset_tokens', function (Blueprint $table) {
        $table->string('email')->primary();
        $table->string('token');
        $table->timestamp('created_at')->nullable();
    });

    Schema::create('sessions', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->foreignId('user_id')->nullable()->index();
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};

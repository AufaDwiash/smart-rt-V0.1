<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nik',
        'no_kk',
        'nama_lengkap',
        'email',
        'no_hp',
        'password',
        'role',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'pekerjaan',
        'alamat',
        'rt',
        'rw',
        'status_keluarga',
        'status_warga',
        'foto_profil',
        'status_akun',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
        ];
    }

    /**
     * Relasi ke Pengajuan Surat
     */
    public function pengajuanSurat(): HasMany
    {
        return $this->hasMany(PengajuanSurat::class, 'user_id');
    }

    /**
     * Relasi ke Aduan
     */
    public function aduan(): HasMany
    {
        return $this->hasMany(Aduan::class, 'user_id');
    }

    /**
     * Relasi ke Notifikasi
     */
    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }

    /**
     * Relasi ke Transaksi Keuangan yang diinput
     */
    public function transaksiKeuangan(): HasMany
    {
        return $this->hasMany(TransaksiKeuangan::class, 'user_id');
    }

    /**
     * Relasi ke Kartu Keluarga berdasarkan nomor KK
     */
    public function kartuKeluarga(): BelongsTo
    {
        return $this->belongsTo(KartuKeluarga::class, 'no_kk', 'no_kk');
    }

    // Role helper methods
    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'rt']);
    }

    public function isSekretaris(): bool
    {
        return $this->role === 'sekretaris';
    }

    public function isBendahara(): bool
    {
        return $this->role === 'bendahara';
    }

    public function isWarga(): bool
    {
        return $this->role === 'warga';
    }

    public function isPengurus(): bool
    {
        return in_array($this->role, ['admin', 'rt', 'sekretaris', 'bendahara']);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin', 'rt' => 'Ketua RT / Admin',
            'sekretaris' => 'Sekretaris RT',
            'bendahara' => 'Bendahara RT',
            default => 'Warga',
        };
    }
}

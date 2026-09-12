<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KartuKeluarga extends Model
{
    use HasFactory;

    protected $table = 'kartu_keluarga';

    protected $fillable = [
        'no_kk',
        'kepala_keluarga_nama',
        'alamat',
        'rt',
        'rw',
        'kode_pos',
    ];

    public function anggota(): HasMany
    {
        return $this->hasMany(User::class, 'no_kk', 'no_kk');
    }
}

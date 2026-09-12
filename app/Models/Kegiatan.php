<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'deskripsi',
        'kategori',
        'tanggal_kegiatan',
        'waktu_mulai',
        'lokasi',
        'penanggung_jawab',
        'status',
        'foto',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kegiatan' => 'date',
        ];
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'mendatang' => 'bg-blue-100 text-blue-800 border-blue-200',
            'berlangsung' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'selesai' => 'bg-gray-100 text-gray-800 border-gray-200',
            'dibatalkan' => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}

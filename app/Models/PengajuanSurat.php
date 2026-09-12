<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengajuanSurat extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_surat';

    protected $fillable = [
        'user_id',
        'surat_template_id',
        'nomor_surat',
        'keperluan',
        'file_pendukung',
        'status',
        'catatan_rt',
        'tanggal_pengajuan',
        'tanggal_selesai',
        'file_hasil_surat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengajuan' => 'datetime',
            'tanggal_selesai' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function suratTemplate(): BelongsTo
    {
        return $this->belongsTo(SuratTemplate::class, 'surat_template_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
            'diproses' => 'bg-blue-100 text-blue-800 border-blue-200',
            'disetujui' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'ditolak' => 'bg-red-100 text-red-800 border-red-200',
            'selesai' => 'bg-green-100 text-green-800 border-green-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}

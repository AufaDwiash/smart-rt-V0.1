<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiKeuangan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_keuangan';

    protected $fillable = [
        'kode_transaksi',
        'jenis',
        'kategori',
        'nominal',
        'tanggal_transaksi',
        'keterangan',
        'bukti_transaksi',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_transaksi' => 'date',
            'nominal' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function getTotalPemasukan(): float
    {
        return (float) static::where('jenis', 'pemasukan')->sum('nominal');
    }

    public static function getTotalPengeluaran(): float
    {
        return (float) static::where('jenis', 'pengeluaran')->sum('nominal');
    }

    public static function getSaldo(): float
    {
        return static::getTotalPemasukan() - static::getTotalPengeluaran();
    }
}

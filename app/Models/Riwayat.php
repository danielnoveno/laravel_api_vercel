<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;

    protected $table = 'riwayats';

    protected $primaryKey = 'id_riwayat';

    protected $fillable = [
        'id_detail_transaksi',
        'id_layanan',
        'tanggal_riwayat',
        'jenis_layanan',
    ];

    /**
     * Relasi ke DetailTransaksi.
     */
    public function detailTransaksi()
    {
        return $this->belongsTo(DetailTransaksi::class, 'id_detail_transaksi');
    }

    /**
     * Relasi ke Layanan.
     */
    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'pelanggans';
    protected $primaryKey = 'id_pelanggan';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'umur',
        'alamat',
        'no_telepon',
        'email',
        'password',
        'tanggal_daftar',
    ];


    public function membership()
    {
        return $this->hasOne(Membership::class, 'id_pelanggan');
    }

    public function personalTrainer()
    {
        return $this->hasOne(PersonalTrainer::class, 'id_pelanggan');
    }

    public function alatGym()
    {
        return $this->hasMany(AlatGym::class, 'id_pelanggan');
    }

    public function kelasOlahraga()
    {
        return $this->hasMany(KelasOlahraga::class, 'id_pelanggan');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_pelanggan');
    }

    public function reviewTrainer()
    {
        return $this->hasMany(ReviewTrainer::class, 'id_pelanggan');
    }

    public function riwayat()
    {
        return $this->hasMany(Riwayat::class, 'id_pelanggan');
    }
}

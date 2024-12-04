<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisMembership extends Model
{
    use HasFactory;

    protected $table = 'jenis_memberships';
    protected $primaryKey = 'id_jenis_membership';

    protected $fillable = [
        'nama_jenis_membership',
        'harga_membership',
        'jadwal',
        'durasi',
        'deskripsi',
    ];

    public function memberships()
    {
        return $this->hasMany(Membership::class, 'id_jenis_membership');
    }
}

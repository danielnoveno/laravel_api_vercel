<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanans';
    protected $primaryKey = 'id_layanan';
    public $timestamps = false;

    protected $fillable = [
        'nama_layanan'
    ];

    public function kelasOlahraga()
    {
        return $this->hasMany(KelasOlahraga::class, 'id_layanan');
    }

    public function alatGym()
    {
        return $this->hasMany(AlatGym::class, 'id_layanan');
    }

    public function membership()
    {
        return $this->hasMany(Membership::class, 'id_layanan');
    }

    public function personalTrainer()
    {
        return $this->hasMany(PersonalTrainer::class, 'id_layanan');
    }
}

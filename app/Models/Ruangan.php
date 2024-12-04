<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;

    protected $table = 'ruangans';

    protected $primaryKey = 'id_ruangan';

    protected $fillable = [
        'id_ruangan',
        'kapasitas',
    ];

    public function kelasOlahraga()
    {
        return $this->hasOne(KelasOlahraga::class, 'id_ruangan');
    }
}

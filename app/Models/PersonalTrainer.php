<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalTrainer extends Model
{
    use HasFactory;

    protected $table = 'personal_trainers';

    protected $primaryKey = 'id_paket_personal_trainer';

    protected $fillable = [
        'nama_paket',
        'harga',
        'deskripsi'
    ];

    public function trainers()
    {
        return $this->hasMany(Trainer::class, 'id_paket_personal_trainer');
    }
}

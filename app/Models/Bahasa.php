<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahasa extends Model
{
    /** @use HasFactory<\Database\Factories\BahasaFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function frekuensi()
    {
        return $this->hasMany(Frekuensi::class, 'language_prefix', 'kode_bahasa');
    }

    public function bibliografi()
    {
        return $this->hasMany(Bibliografi::class, 'bahasa_id', 'kode_bahasa');
    }
}

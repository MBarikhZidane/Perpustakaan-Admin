<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frekuensi extends Model
{
    /** @use HasFactory<\Database\Factories\FrekuensiFactory> */
    use HasFactory;
    protected $guarded = ['id'];
     public function bahasa()
    {
        return $this->belongsTo(Bahasa::class, 'language_prefix', 'kode_bahasa');
    }

    public function bibliografi()
    {
        return $this->hasMany(Bibliografi::class, 'frekuensi_id');
    }
}

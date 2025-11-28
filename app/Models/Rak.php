<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    /** @use HasFactory<\Database\Factories\RakFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'kode_lokasi');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'rak_id');
    }
}

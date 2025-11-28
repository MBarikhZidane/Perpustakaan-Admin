<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    /** @use HasFactory<\Database\Factories\LokasiFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'is_sgd' => 'boolean',
    ];
    public function rak()
    {
        return $this->hasMany(Rak::class, 'lokasi_id', 'kode_lokasi');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'lokasi_id', 'kode_lokasi');
    }
}

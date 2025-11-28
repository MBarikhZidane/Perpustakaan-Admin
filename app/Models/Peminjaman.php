<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    /** @use HasFactory<\Database\Factories\PeminjamanFactory> */
    use HasFactory;
    protected $table = 'peminjamen';
    protected $guarded = ['id'];
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'member_id', 'member_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'kode_item', 'kode_item');
    }
}

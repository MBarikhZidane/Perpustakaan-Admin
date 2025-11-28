<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeKoleksi extends Model
{
    protected $table = 'tipe_koleksis';
    /** @use HasFactory<\Database\Factories\TipeKoleksiFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function bibliografi()
    {
        return $this->hasMany(Bibliografi::class, 'tipe_koleksi_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'tipe_koleksi_id');
    }

    public function aturanPeminjaman()
    {
        return $this->hasMany(AturanPeminjaman::class, 'coll_type_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPemesanan extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiPemesananFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'member_id', 'member_id');
    }

    public function bibliografi()
    {
        return $this->belongsTo(Bibliografi::class, 'bibliografi_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'kode_item', 'kode_item');
    }

    public function tipeAnggota()
    {
        return $this->belongsTo(TipeAnggota::class, 'tipe_member_id');
    }
}

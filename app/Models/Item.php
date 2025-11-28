<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /** @use HasFactory<\Database\Factories\ItemFactory> */
    use HasFactory;
    protected $primaryKey = 'kode_item';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = ['id'];
    protected $casts = [
        'tgl_order' => 'date',
        'tgl_penerimaan' => 'date',
    ];


    public function bibliografi()
    {
        return $this->belongsTo(Bibliografi::class, 'bibliografi_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'kode_lokasi');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }

    public function tipeKoleksi()
    {
        return $this->belongsTo(TipeKoleksi::class, 'tipe_koleksi_id');
    }

    public function status()
    {
        return $this->belongsTo(StatusItem::class, 'status_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'kode_item', 'kode_item');
    }

    public function transaksiPemesanan()
    {
        return $this->hasMany(TransaksiPemesanan::class, 'kode_item', 'kode_item');
    }
}

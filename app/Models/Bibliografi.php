<?php

namespace App\Models;

use App\Models\Penerbit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bibliografi extends Model
{
    /** @use HasFactory<\Database\Factories\BibliografiFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
    'is_etalase_hide' => 'boolean',
    'is_promosi' => 'boolean',
];

    public function gmd()
    {
        return $this->belongsTo(Gmd::class, 'gmd_id');
    }

    public function bahasa()
    {
        return $this->belongsTo(Bahasa::class, 'bahasa_id', 'kode_bahasa');
    }
    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id');
    }

    public function tipeKoleksi()
    {
        return $this->belongsTo(TipeKoleksi::class, 'tipe_koleksi_id');
    }

    public function frekuensi()
    {
        return $this->belongsTo(Frekuensi::class, 'frekuensi_id');
    }

    public function lampiran()
    {
        return $this->hasMany(Lampiran::class, 'bibliografi_id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'bibliografi_id');
    }

    public function bibliografiPenulis()
    {
        return $this->hasMany(BibliografiPenulis::class, 'bibliografi_id');
    }

    public function bibliografiTopik()
    {
        return $this->hasMany(BibliografiTopik::class, 'bibliografi_id');
    }

    public function penulis()
    {
        return $this->belongsToMany(Penulis::class, 'bibliografi_penulis', 'bibliografi_id', 'penulis_id')
            ->withPivot('tipe', 'level', 'kategori')
            ->withTimestamps();
    }

    public function topik()
    {
        return $this->belongsToMany(Topik::class, 'bibliografi_topiks', 'bibliografi_id', 'topik_id')
            ->withPivot('tipe', 'level', 'kategori')
            ->withTimestamps();
    }
}

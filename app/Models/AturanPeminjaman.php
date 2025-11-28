<?php

namespace App\Models;

use App\Models\Gmd;
use App\Models\TipeAnggota;
use App\Models\TipeKoleksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AturanPeminjaman extends Model
{
    /** @use HasFactory<\Database\Factories\AturanPeminjamanFactory> */
    use HasFactory;
    protected $table = 'aturan_peminjamen';
    protected $guarded = ['id'];
    public function memberType()
    {
        return $this->belongsTo(TipeAnggota::class, 'member_type_id');
    }

    public function collType()
    {
        return $this->belongsTo(TipeKoleksi::class, 'coll_type_id');
    }

    public function gmd()
    {
        return $this->belongsTo(Gmd::class, 'gmd_id');
    }
}

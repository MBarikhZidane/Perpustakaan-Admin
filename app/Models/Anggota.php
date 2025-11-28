<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    /** @use HasFactory<\Database\Factories\AnggotaFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'is_pending' => 'boolean',
    ];

    public function tipeAnggota()
    {
        return $this->belongsTo(TipeAnggota::class, 'tipe_anggota_id');
    }

    /**
     * Get the borrowings for the member.
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'member_id', 'member_id');
    }

    /**
     * Get the reservation transactions for the member.
     */
    public function transaksiPemesanan()
    {
        return $this->hasMany(TransaksiPemesanan::class, 'member_id', 'member_id');
    }

    /**
     * Get the fine transactions for the member.
     */
    public function transaksiDenda()
    {
        return $this->hasMany(TransaksiDenda::class, 'member_id', 'member_id');
    }

    /**
     * Get the clearance letters for the member.
     */
    public function suratBebasPerpustakaan()
    {
        return $this->hasMany(SuratBebasPerpustakaan::class, 'member_id', 'member_id');
    }
}

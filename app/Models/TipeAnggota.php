<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipeAnggota extends Model
{
    protected $table = 'tipe_anggotas';
    /** @use HasFactory<\Database\Factories\TipeAnggotaFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    protected $casts = [
        'is_siswa' => 'boolean',
        'is_guru' => 'boolean',
        'is_karyawan' => 'boolean',
        'is_external' => 'boolean',
    ];
    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'tipe_anggota_id');
    }

    /**
     * Get the pemesanan transactions for the member type.
     */
    public function transaksiPemesanan()
    {
        return $this->hasMany(TransaksiPemesanan::class, 'tipe_member_id');
    }

    /**
     * Get the loan rules associated with the member type.
     */
    public function aturanPeminjaman()
    {
        return $this->hasMany(AturanPeminjaman::class, 'member_type_id');
    }
}

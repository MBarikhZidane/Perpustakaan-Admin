<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratBebasPerpustakaan extends Model
{
    /** @use HasFactory<\Database\Factories\SuratBebasPerpustakaanFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'member_id', 'member_id');
    }

    public function tujuan()
    {
        return $this->belongsTo(TujuanBebasPerpustakaan::class, 'tujuan_id');
    }
}

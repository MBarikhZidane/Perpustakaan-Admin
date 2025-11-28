<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gmd extends Model
{
    /** @use HasFactory<\Database\Factories\GmdFactory> */
    use HasFactory;
    protected $guarded = ['id'];
     public function bibliografi()
    {
        return $this->hasMany(Bibliografi::class, 'gmd_id');
    }

    public function aturanPeminjaman()
    {
        return $this->hasMany(AturanPeminjaman::class, 'gmd_id');
    }
}

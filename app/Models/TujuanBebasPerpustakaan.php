<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanBebasPerpustakaan extends Model
{
    /** @use HasFactory<\Database\Factories\TujuanBebasPerpustakaanFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function suratBebasPerpustakaan()
    {
        return $this->hasMany(SuratBebasPerpustakaan::class, 'tujuan_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penulis extends Model
{
    /** @use HasFactory<\Database\Factories\PenulisFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function bibliografiPenulis()
    {
        return $this->hasMany(BibliografiPenulis::class, 'penulis_id');
    }

    public function bibliografi()
    {
        return $this->belongsToMany(Bibliografi::class, 'bibliografi_penulis', 'penulis_id', 'bibliografi_id')
            ->withPivot('tipe', 'level', 'kategori')
            ->withTimestamps();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topik extends Model
{
    /** @use HasFactory<\Database\Factories\TopikFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function bibliografiTopik()
    {
        return $this->hasMany(BibliografiTopik::class, 'topik_id');
    }

    public function bibliografi()
    {
        return $this->belongsToMany(Bibliografi::class, 'bibliografi_topik', 'topik_id', 'bibliografi_id')
            ->withPivot('tipe', 'level', 'kategori')
            ->withTimestamps();
    }
}

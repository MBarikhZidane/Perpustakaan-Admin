<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BibliografiPenulis extends Model
{
    /** @use HasFactory<\Database\Factories\BibliografiPenulisFactory> */
    use HasFactory;
    protected $guarded = ['id'];
     public function bibliografi()
    {
        return $this->belongsTo(Bibliografi::class, 'bibliografi_id');
    }

    public function penulis()
    {
        return $this->belongsTo(Penulis::class, 'penulis_id');
    }
}

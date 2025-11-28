<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    /** @use HasFactory<\Database\Factories\LampiranFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function bibliografi()
    {
        return $this->belongsTo(Bibliografi::class, 'bibliografi_id');
    }
}

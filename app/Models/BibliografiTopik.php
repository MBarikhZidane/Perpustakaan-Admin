<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BibliografiTopik extends Model
{
    /** @use HasFactory<\Database\Factories\BibliografiTopikFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function bibliografi()
    {
        return $this->belongsTo(Bibliografi::class, 'bibliografi_id');
    }

    public function topik()
    {
        return $this->belongsTo(Topik::class, 'topik_id');
    }
}

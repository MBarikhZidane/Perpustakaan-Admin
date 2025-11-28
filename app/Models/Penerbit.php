<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerbit extends Model
{
    /** @use HasFactory<\Database\Factories\PenerbitFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function tempat()
    {
        return $this->belongsTo(TempatPenerbit::class, 'tempat_id');
    }
}

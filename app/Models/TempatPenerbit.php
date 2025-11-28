<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempatPenerbit extends Model
{
    /** @use HasFactory<\Database\Factories\TempatPenerbitFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function penerbit()
    {
        return $this->hasMany(Penerbit::class, 'tempat_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfigurasiPenomoran extends Model
{
    /** @use HasFactory<\Database\Factories\KonfigurasiPenomoranFactory> */
    use HasFactory;
    protected $guarded = ['id'];
}

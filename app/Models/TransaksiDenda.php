<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDenda extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiDendaFactory> */
    use HasFactory;
    protected $guarded = ['id'];
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'member_id', 'member_id');
    }
}

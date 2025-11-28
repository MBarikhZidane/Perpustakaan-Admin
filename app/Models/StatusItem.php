<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusItem extends Model
{
    /** @use HasFactory<\Database\Factories\StatusItemFactory> */
    use HasFactory;
    protected $guarded = ['id'];
     protected $casts = [
        'is_not_dipinjamkan' => 'boolean',
        'is_skip_stockopname' => 'boolean',
    ];
    public function items()
    {
        return $this->hasMany(Item::class, 'status_id');
    }
}

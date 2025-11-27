<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panchayat extends Model
{
    protected $fillable = ['block_id', 'panchayat_name'];

    public function block()
    {
        return $this->belongsTo(Block::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}

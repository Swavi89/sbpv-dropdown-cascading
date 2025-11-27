<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = ['state_id', 'block_name'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function panchayats()
    {
        return $this->hasMany(Panchayat::class);
    }
}

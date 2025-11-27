<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['state_name'];

    public function blocks()
    {
        return $this->hasMany(Block::class);
    }
}

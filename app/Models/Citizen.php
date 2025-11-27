<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    protected $fillable = [
        'village_id',
        'citizen_name',
        'citizen_phone',
        'citizen_email',
        'gender'
    ];

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}

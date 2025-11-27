<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = ['panchayat_id', 'village_name'];

    public function panchayat()
    {
        return $this->belongsTo(Panchayat::class);
    }

    public function citizens()
    {
        return $this->hasMany(Citizen::class);
    }
}

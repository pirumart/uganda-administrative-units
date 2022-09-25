<?php

namespace Pirumart\Uganda\Locale\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'region',
        'sub_region',
        'district_code',
        'district_name',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function counties()
    {
        return $this->hasMany(County::class);
    }

    public function sub_counties()
    {
        return $this->hasMany(SubCounty::class);
    }

    public function parishes()
    {
        return $this->hasMany(Parish::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}

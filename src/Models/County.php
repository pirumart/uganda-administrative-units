<?php

namespace Pirumart\Uganda\Locale\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    public $timestamps = false;

    protected $fillable = ['district_code', 'county_code', 'county_name'];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'district_code');
    }

    public function sub_counties()
    {
        return $this->hasMany(SubCounty::class, 'county_code', 'county_code');
    }

    public function parishes()
    {
        return $this->hasMany(Parish::class, 'county_code', 'county_code');
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'county_code', 'county_code');
    }
}

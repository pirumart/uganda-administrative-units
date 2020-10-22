<?php

namespace PiruPius\Uganda\Locale\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    public $timestamps = false;

    protected $fillable = ['district_code', 'county_code', 'county_name'];

    public function district()
    {
        return $this->belongsTo(District::class);
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

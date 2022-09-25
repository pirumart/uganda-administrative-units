<?php

namespace Pirumart\Uganda\Locale\Models;

use Illuminate\Database\Eloquent\Model;

class SubCounty extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'district_code',
        'county_code',
        'sub_county_code',
        'sub_county_name'
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function county()
    {
        return $this->belongsTo(County::class);
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

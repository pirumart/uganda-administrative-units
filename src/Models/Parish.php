<?php

namespace Pirumart\Uganda\Locale\Models;

use Illuminate\Database\Eloquent\Model;

class Parish extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'district_code',
        'county_code',
        'sub_county_code',
        'parish_code',
        'parish_name'
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'district_code');
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'county_code', 'county_code');
    }

    public function sub_county()
    {
        return $this->belongsTo(SubCounty::class, 'sub_county_code', 'sub_county_code');
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'parish_code', 'parish_code');
    }
}

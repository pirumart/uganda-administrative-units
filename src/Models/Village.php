<?php

namespace Pirumart\Uganda\Locale\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'district_code',
        'county_code',
        'sub_county_code',
        'parish_code',
        'village_code',
        'village_name',
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

    public function parish()
    {
        return $this->belongsTo(Parish::class, 'parish_code', 'parish_code');
    }
}

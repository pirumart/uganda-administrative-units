<?php

namespace PiruPius\Uganda\Locale\Models;

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
        return $this->belongsTo(District::class);
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    public function sub_county()
    {
        return $this->belongsTo(SubCounty::class);
    }

    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }
}

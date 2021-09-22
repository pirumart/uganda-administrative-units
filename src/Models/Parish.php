<?php

namespace PiruPius\Uganda\Locale\Models;

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

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}

<?php

namespace Pirumart\Uganda\Locale\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCounty extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'district_code',
        'county_code',
        'sub_county_code',
        'sub_county_name',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_code', 'district_code');
    }

    public function county()
    {
        return $this->belongsTo(County::class, 'county_code', 'county_code');
    }

    public function parishes()
    {
        return $this->hasMany(Parish::class, 'sub_county_code', 'sub_county_code');
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'sub_county_code', 'sub_county_code');
    }
}

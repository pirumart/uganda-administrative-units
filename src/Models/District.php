<?php

namespace Pirumart\Uganda\Locale\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'region',
        'sub_region',
        'district_code',
        'district_name',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region', 'region');
    }

    public function counties()
    {
        return $this->hasMany(County::class, 'district_code', 'district_code');
    }

    public function sub_counties()
    {
        return $this->hasMany(SubCounty::class, 'district_code', 'district_code');
    }

    public function parishes()
    {
        return $this->hasMany(Parish::class, 'district_code', 'district_code');
    }

    public function villages()
    {
        return $this->hasMany(Village::class, 'district_code', 'district_code');
    }
}

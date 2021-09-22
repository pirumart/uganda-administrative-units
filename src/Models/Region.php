<?php

namespace PiruPius\Uganda\Locale\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $timestamps = false;

    protected $fillable = ['region', 'sub_region'];

    public function counties()
    {
        return $this->hasMany(District::class);
    }
}
